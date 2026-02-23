<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\PurchaseItem;
use App\Models\Product;
use App\Models\Supplier;
use App\Services\InvoiceService;
use App\Services\StockService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PurchaseController extends Controller
{
    public function index()
    {
        $items = Purchase::with('supplier')
            ->orderBy('date','desc')
            ->orderBy('id','desc')
            ->paginate(10);

        return view('purchases.index', compact('items'));
    }

    public function create()
    {
        return view('purchases.create', [
            'suppliers' => Supplier::orderBy('name')->get(),
            'products' => Product::orderBy('name')->get(),
        ]);
    }

    public function store(Request $request, InvoiceService $invoice, StockService $stock)
    {
        $data = $request->validate([
            'supplier_id' => ['required','exists:suppliers,id'],
            'date' => ['required','date'],
            'discount_total' => ['nullable','integer','min:0'],
            'items' => ['required','array','min:1'],
            'items.*.product_id' => ['required','exists:products,id'],
            'items.*.qty' => ['required','integer','min:1'],
            'items.*.cost' => ['required','integer','min:0'],
        ]);

        $discount = (int)($data['discount_total'] ?? 0);

        return DB::transaction(function () use ($request,$data,$discount,$invoice,$stock) {
            $invoiceNo = $invoice->next('PUR', $data['date'], 'purchases', 'invoice_no');

            $subtotal = 0;
            foreach ($data['items'] as $it) {
                $subtotal += ((int)$it['qty']) * ((int)$it['cost']);
            }
            $grand = max(0, $subtotal - $discount);

            $purchase = Purchase::create([
                'invoice_no' => $invoiceNo,
                'supplier_id' => (int)$data['supplier_id'],
                'date' => $data['date'],
                'subtotal' => $subtotal,
                'discount_total' => $discount,
                'grand_total' => $grand,
                'status' => 'RECEIVED',
                'created_by' => $request->user()->id,
            ]);

            foreach ($data['items'] as $it) {
                $qty = (int)$it['qty'];
                $cost = (int)$it['cost'];
                $lineSubtotal = $qty * $cost;

                PurchaseItem::create([
                    'purchase_id' => $purchase->id,
                    'product_id' => (int)$it['product_id'],
                    'qty' => $qty,
                    'cost' => $cost,
                    'subtotal' => $lineSubtotal,
                ]);

                // optional: update last cost_price
                Product::whereKey((int)$it['product_id'])->update(['cost_price' => $cost]);

                // stok masuk
                $stock->createMovement([
                    'product_id' => (int)$it['product_id'],
                    'type' => 'IN',
                    'ref_type' => 'PURCHASE',
                    'ref_id' => $purchase->id,
                    'qty_in' => $qty,
                    'qty_out' => 0,
                    'notes' => "Pembelian $invoiceNo",
                    'created_by' => $request->user()->id,
                ]);
            }

            return redirect()->route('purchases.show', $purchase)->with('success','Pembelian tersimpan (RECEIVED).');
        });
    }

    public function show(Purchase $purchase)
    {
        $purchase->load(['supplier','items.product','user']);
        return view('purchases.show', compact('purchase'));
    }

    public function void(Request $request, Purchase $purchase, StockService $stock)
    {
        if (!in_array($request->user()->role, ['owner','admin'], true)) abort(403);

        if ($purchase->status === 'VOID') {
            return back()->with('success','Pembelian sudah VOID.');
        }

        return DB::transaction(function () use ($request,$purchase,$stock) {
            $purchase->load('items');

            $purchase->status = 'VOID';
            $purchase->save();

            foreach ($purchase->items as $it) {
                // pembalikan stok: keluar
                $stock->createMovement([
                    'product_id' => $it->product_id,
                    'type' => 'OUT',
                    'ref_type' => 'PURCHASE_VOID',
                    'ref_id' => $purchase->id,
                    'qty_in' => 0,
                    'qty_out' => (int)$it->qty,
                    'notes' => "VOID Pembelian {$purchase->invoice_no}",
                    'created_by' => $request->user()->id,
                ]);
            }

            return back()->with('success','Pembelian berhasil di-VOID dan stok dibalik.');
        });
    }
}
