<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StockMovement;
use App\Services\StockService;
use Illuminate\Http\Request;

class StockController extends Controller
{
    public function openingForm()
    {
        $products = Product::orderBy('name')->get();
        return view('stock.opening', compact('products'));
    }

    public function openingStore(Request $request, StockService $stock)
    {
        $data = $request->validate([
            'product_id' => ['required','exists:products,id'],
            'qty' => ['required','integer','min:0'],
            'notes' => ['nullable','string','max:255'],
        ]);

        $stock->setOpeningStock((int)$data['product_id'], (int)$data['qty'], $request->user()->id, $data['notes'] ?? null);
        return back()->with('success','Stok awal berhasil diinput.');
    }

    public function inForm()
    {
        $products = Product::orderBy('name')->get();
        return view('stock.in', compact('products'));
    }

    public function inStore(Request $request, StockService $stock)
    {
        $data = $request->validate([
            'product_id' => ['required','exists:products,id'],
            'qty' => ['required','integer','min:1'],
            'notes' => ['nullable','string','max:255'],
        ]);

        $stock->createMovement([
            'product_id' => (int)$data['product_id'],
            'type' => 'IN',
            'ref_type' => 'MANUAL',
            'qty_in' => (int)$data['qty'],
            'qty_out' => 0,
            'notes' => $data['notes'] ?? 'Stok masuk manual',
            'created_by' => $request->user()->id,
        ]);

        return back()->with('success','Stok masuk berhasil.');
    }

    public function outForm()
    {
        $products = Product::orderBy('name')->get();
        return view('stock.out', compact('products'));
    }

    public function outStore(Request $request, StockService $stock)
    {
        $data = $request->validate([
            'product_id' => ['required','exists:products,id'],
            'qty' => ['required','integer','min:1'],
            'notes' => ['nullable','string','max:255'],
        ]);

        $stock->createMovement([
            'product_id' => (int)$data['product_id'],
            'type' => 'OUT',
            'ref_type' => 'MANUAL',
            'qty_in' => 0,
            'qty_out' => (int)$data['qty'],
            'notes' => $data['notes'] ?? 'Stok keluar manual',
            'created_by' => $request->user()->id,
        ]);

        return back()->with('success','Stok keluar berhasil.');
    }

    public function opnameForm()
    {
        $products = Product::orderBy('name')->get();
        return view('stock.opname', compact('products'));
    }

    public function opnameStore(Request $request, StockService $stock)
    {
        $data = $request->validate([
            'product_id' => ['required','exists:products,id'],
            'actual' => ['required','integer','min:0'],
            'notes' => ['nullable','string','max:255'],
        ]);

        $stock->stockOpname((int)$data['product_id'], (int)$data['actual'], $request->user()->id, $data['notes'] ?? null);
        return back()->with('success','Stock opname tercatat.');
    }

    public function card(Request $request, Product $product)
    {
        $from = $request->query('from');
        $to = $request->query('to');

        $movements = StockMovement::with('user')
            ->where('product_id', $product->id)
            ->when($from, fn($q) => $q->whereDate('created_at','>=',$from))
            ->when($to, fn($q) => $q->whereDate('created_at','<=',$to))
            ->orderBy('created_at','desc')
            ->paginate(20)
            ->withQueryString();

        return view('stock.card', compact('product','movements','from','to'));
    }
}
