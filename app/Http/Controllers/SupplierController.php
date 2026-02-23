<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index()
    {
        $items = Supplier::orderBy('name')->paginate(10);
        return view('suppliers.index', compact('items'));
    }

    public function create()
    {
        return view('suppliers.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required','string','max:150'],
            'phone' => ['nullable','string','max:50'],
            'address' => ['nullable','string','max:255'],
        ]);

        Supplier::create($data);
        return redirect()->route('suppliers.index')->with('success','Supplier dibuat.');
    }

    public function edit(Supplier $supplier)
    {
        return view('suppliers.edit', compact('supplier'));
    }

    public function update(Request $request, Supplier $supplier)
    {
        $data = $request->validate([
            'name' => ['required','string','max:150'],
            'phone' => ['nullable','string','max:50'],
            'address' => ['nullable','string','max:255'],
        ]);

        $supplier->update($data);
        return redirect()->route('suppliers.index')->with('success','Supplier diupdate.');
    }

    public function destroy(Supplier $supplier)
    {
        $supplier->delete();
        return redirect()->route('suppliers.index')->with('success','Supplier dihapus.');
    }
}
