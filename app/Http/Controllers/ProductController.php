<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Unit;
use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $q = request('q');
        $categoryId = request('category_id');

        $items = Product::with(['category','unit'])
            ->when($q, fn($s) => $s->where('name','like',"%$q%")->orWhere('code','like',"%$q%"))
            ->when($categoryId, fn($s) => $s->where('category_id',$categoryId))
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        $categories = Category::orderBy('name')->get();

        return view('master.products.index', compact('items','categories','q','categoryId'));
    }

    public function create()
    {
        return view('master.products.create', [
            'categories' => Category::orderBy('name')->get(),
            'units' => Unit::orderBy('name')->get(),
        ]);
    }

    public function store(ProductStoreRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('photo')) {
            $data['photo_path'] = $request->file('photo')->store('products', 'public');
        }

        Product::create($data);
        return redirect()->route('products.index')->with('success','Barang dibuat.');
    }

    public function show(Product $product)
    {
        $product->load(['category','unit']);
        return view('master.products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        return view('master.products.edit', [
            'product' => $product,
            'categories' => Category::orderBy('name')->get(),
            'units' => Unit::orderBy('name')->get(),
        ]);
    }

    public function update(ProductUpdateRequest $request, Product $product)
    {
        $data = $request->validated();

        if ($request->hasFile('photo')) {
            if ($product->photo_path) Storage::disk('public')->delete($product->photo_path);
            $data['photo_path'] = $request->file('photo')->store('products', 'public');
        }

        $product->update($data);
        return redirect()->route('products.index')->with('success','Barang diupdate.');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')->with('success','Barang dihapus (soft delete).');
    }
}
