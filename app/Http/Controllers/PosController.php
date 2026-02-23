<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class PosController extends Controller
{
    public function index()
    {
        // tampilkan produk awal (misal 20)
        $products = Product::where('is_active', true)
            ->orderBy('name')
            ->limit(20)
            ->get(['id','code','name','sell_price','current_stock']);

        return view('pos.index', compact('products'));
    }

    public function search(Request $request)
    {
        $q = trim((string)$request->query('q',''));

        $items = Product::where('is_active', true)
            ->when($q, function($s) use ($q){
                $s->where('name','like',"%$q%")
                  ->orWhere('code','like',"%$q%");
            })
            ->orderBy('name')
            ->limit(30)
            ->get(['id','code','name','sell_price','current_stock']);

        return response()->json($items);
    }
}
