<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use App\Http\Requests\UnitStoreRequest;
use App\Http\Requests\UnitUpdateRequest;

class UnitController extends Controller
{
    public function index()
    {
        $items = Unit::orderBy('name')->paginate(10);
        return view('master.units.index', compact('items'));
    }

    public function create()
    {
        return view('master.units.create');
    }

    public function store(UnitStoreRequest $request)
    {
        Unit::create($request->validated());
        return redirect()->route('units.index')->with('success','Satuan dibuat.');
    }

    public function edit(Unit $unit)
    {
        return view('master.units.edit', compact('unit'));
    }

    public function update(UnitUpdateRequest $request, Unit $unit)
    {
        $unit->update($request->validated());
        return redirect()->route('units.index')->with('success','Satuan diupdate.');
    }

    public function destroy(Unit $unit)
    {
        $unit->delete();
        return redirect()->route('units.index')->with('success','Satuan dihapus.');
    }
}
