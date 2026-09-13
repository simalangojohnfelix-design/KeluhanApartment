<?php
namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Asset;
use App\Models\PropertyUnit;
use Illuminate\Http\Request;

class AssetController extends Controller
{
    public function index()
    {
        $assets = Asset::with('propertyUnit')->latest()->get();
        return view('owner.assets.index', compact('assets'));
    }

    public function create()
    {
        $units = PropertyUnit::all();
        return view('owner.assets.create', compact('units'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string',
            'status' => 'required|in:good,damaged,maintenance',
            'property_unit_id' => 'nullable|exists:property_units,id',
        ]);

        Asset::create($request->all());
        return redirect()->route('owner.assets.index')->with('success', 'Aset berhasil ditambahkan.');
    }

    public function edit(Asset $asset)
    {
        $units = PropertyUnit::all();
        return view('owner.assets.edit', compact('asset', 'units'));
    }

    public function update(Request $request, Asset $asset)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string',
            'status' => 'required|in:good,damaged,maintenance',
            'property_unit_id' => 'nullable|exists:property_units,id',
        ]);

        $asset->update($request->all());
        return redirect()->route('owner.assets.index')->with('success', 'Data aset berhasil diperbarui.');
    }

    public function destroy(Asset $asset)
    {
        $asset->delete();
        return redirect()->route('owner.assets.index')->with('success', 'Aset berhasil dihapus.');
    }
}