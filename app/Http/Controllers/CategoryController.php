<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Http\Requests\CategoryStoreRequest;
use App\Http\Requests\CategoryUpdateRequest;

class CategoryController extends Controller
{
    public function index()
    {
        $items = Category::orderBy('name')->paginate(10);
        return view('master.categories.index', compact('items'));
    }

    public function create()
    {
        return view('master.categories.create');
    }

    public function store(CategoryStoreRequest $request)
    {
        Category::create($request->validated());
        return redirect()->route('categories.index')->with('success','Kategori dibuat.');
    }

    public function edit(Category $category)
    {
        return view('master.categories.edit', compact('category'));
    }

    public function update(CategoryUpdateRequest $request, Category $category)
    {
        $category->update($request->validated());
        return redirect()->route('categories.index')->with('success','Kategori diupdate.');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('categories.index')->with('success','Kategori dihapus.');
    }
}
