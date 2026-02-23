<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\Product;
use App\Models\StoreSetting;
use App\Services\InvoiceService;
use App\Services\StockService;
use App\Services\AuditService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class SaleController extends Controller
{
    public function index(Request $request)
    {
        $from = $request->query('from');
        $to = $request->query('to');

        $items = Sale::with('user')
            ->when($from, fn($q) => $q->whereDate('date','>=',$from))
            ->when($to, fn($q) => $q->whereDate('date','<=',$to))
            ->orderBy('date','desc')
            ->orderBy('id','desc')
            ->paginate(10)
            ->withQueryString();

        return view('sales.index', compact('items','from','to'));
    }

    public function show(Sale $sale)
    {
        $sale->load(['items.product','user']);
        return view('sales.show', compact('sale'));
    }

    private function applyRounding(StoreSetting $st, int $amount): int
    {
        if (!$st->rounding_enabled || $st->rounding_mode === 'NONE') return $amount;

        $to = max(1, (int)$st->rounding_to);
        $mod = $amount % $to;

        if ($mod === 0) return $amount;

        return match ($st->rounding_mode) {
            'UP' => $amount + ($to - $mod),
            'DOWN' => $amount - $mod,
            'NEAREST' => ($mod >= ($to/2)) ? ($amount + ($to-$mod)) : ($amount - $mod),
            default => $amount,
        };
    }

    public function checkout(Request $request, InvoiceService $invoice, StockService $stock, AuditService $audit)
    {
        $data = $request->validate([
            'date' => ['required','date'],
            'discount_total' => ['nullable','integer','min:0'],
            'payment_method' => ['required','in:cash,transfer,qris'],
            'paid_amount' => ['required','integer','min:0'],
            'items' => ['required','array','min:1'],
            'items.*.product_id' => ['required','exists:products,id'],
            'items.*.qty' => ['required','integer','min:1'],
        ]);

        $discount = (int)($data['discount_total'] ?? 0);

        $setting = StoreSetting::first();
        if (!$setting) {
            // bila belum ada row settings, buat default
            $setting = StoreSetting::create(['store_name' => 'Toko Bangunan']);
        }

        return DB::transaction(function () use ($request,$data,$discount,$setting,$invoice,$stock,$audit) {
            $invoiceNo = $invoice->next('SAL', $data['date'], 'sales', 'invoice_no');

            // 1) hitung subtotal & cek stok dengan lock per produk
            $subtotal = 0;
            $lineItems = [];

            foreach ($data['items'] as $it) {
                $productId = (int)$it['product_id'];
                $qty = (int)$it['qty'];

                $product = Product::whereKey($productId)->lockForUpdate()->firstOrFail();

                if (!$product->is_active) {
                    throw ValidationException::withMessages(['items' => "Produk {$product->name} nonaktif."]);
                }

                if ($product->current_stock < $qty) {
                    throw ValidationException::withMessages(['items' => "Stok tidak cukup untuk {$product->name}."]);
                }

                $price = (int)$product->sell_price;
                $cost = (int)$product->cost_price; // profit sederhana
                $lineSubtotal = $qty * $price;

                $subtotal += $lineSubtotal;

                $lineItems[] = [
                    'product_id' => $product->id,
                    'name' => $product->name,
                    'qty' => $qty,
                    'price' => $price,
                    'cost' => $cost,
                    'subtotal' => $lineSubtotal,
                ];
            }

            $taxAmount = 0;
            if ($setting->tax_enabled && (int)$setting->tax_percent > 0) {
                $taxAmount = (int) round(($subtotal - $discount) * ((int)$setting->tax_percent / 100));
            }

            $grand = max(0, ($subtotal - $discount) + $taxAmount);

            // pembulatan opsional
            $grandRounded = $this->applyRounding($setting, $grand);

            $paid = (int)$data['paid_amount'];
            if ($data['payment_method'] === 'cash') {
                if ($paid < $grandRounded) {
                    throw ValidationException::withMessages(['paid_amount' => 'Uang dibayar kurang (cash).']);
                }
            } else {
                // transfer/qris: boleh paid_amount = grand_total (umumnya pas)
                if ($paid < $grandRounded) {
                    throw ValidationException::withMessages(['paid_amount' => 'Paid amount kurang untuk metode non-cash.']);
                }
            }
            $change = max(0, $paid - $grandRounded);

            // 2) simpan sale
            $sale = Sale::create([
                'invoice_no' => $invoiceNo,
                'date' => $data['date'],
                'subtotal' => $subtotal,
                'discount_total' => $discount,
                'tax_amount' => $taxAmount,
                'grand_total' => $grandRounded,
                'payment_method' => $data['payment_method'],
                'paid_amount' => $paid,
                'change_amount' => $change,
                'status' => 'PAID',
                'created_by' => $request->user()->id,
            ]);

            // 3) simpan items + kurangi stok via stock_movements
            foreach ($lineItems as $li) {
                SaleItem::create([
                    'sale_id' => $sale->id,
                    'product_id' => $li['product_id'],
                    'qty' => $li['qty'],
                    'price' => $li['price'],
                    'cost' => $li['cost'],
                    'subtotal' => $li['subtotal'],
                ]);

                $stock->createMovement([
                    'product_id' => $li['product_id'],
                    'type' => 'OUT',
                    'ref_type' => 'SALE',
                    'ref_id' => $sale->id,
                    'qty_in' => 0,
                    'qty_out' => $li['qty'],
                    'notes' => "Penjualan $invoiceNo",
                    'created_by' => $request->user()->id,
                ]);
            }

            // 4) audit log
            $audit->log('CREATE_SALE', 'sales', $sale->id, $request->user()->id, [
                'invoice_no' => $invoiceNo,
                'grand_total' => $sale->grand_total,
                'payment_method' => $sale->payment_method,
                'item_count' => count($lineItems),
            ]);

            return redirect()->route('sales.show', $sale)->with('success', 'Penjualan berhasil. Silakan cetak nota.');
        });
    }

    public function print(Sale $sale)
    {
        $sale->load(['items.product','user']);
        $setting = StoreSetting::first();
        return view('sales.print', compact('sale','setting'));
    }

    public function void(Request $request, Sale $sale, StockService $stock, AuditService $audit)
    {
        if (!in_array($request->user()->role, ['owner','admin'], true)) abort(403);

        if ($sale->status === 'VOID') {
            return back()->with('success', 'Transaksi sudah VOID.');
        }

        return DB::transaction(function () use ($request,$sale,$stock,$audit) {
            $sale->load('items');

            $sale->status = 'VOID';
            $sale->save();

            foreach ($sale->items as $it) {
                // pembalikan stok: masuk kembali
                $stock->createMovement([
                    'product_id' => $it->product_id,
                    'type' => 'IN',
                    'ref_type' => 'SALE_VOID',
                    'ref_id' => $sale->id,
                    'qty_in' => (int)$it->qty,
                    'qty_out' => 0,
                    'notes' => "VOID Penjualan {$sale->invoice_no}",
                    'created_by' => $request->user()->id,
                ]);
            }

            $audit->log('VOID_SALE', 'sales', $sale->id, $request->user()->id, [
                'invoice_no' => $sale->invoice_no,
            ]);

            return back()->with('success','Penjualan berhasil di-VOID dan stok dikembalikan.');
        });
    }
}
