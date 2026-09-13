<?php
namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\PropertyUnit;
use App\Models\User;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    public function index()
    {
        $units = PropertyUnit::with('user')->latest()->get();
        return view('owner.units.index', compact('units'));
    }

    public function create()
    {
        $tenants = User::where('role', 'tenant')->get();
        return view('owner.units.create', compact('tenants'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'unit_number' => 'required|string|unique:property_units',
            'type' => 'required|string',
            'status' => 'required|in:available,occupied,maintenance',
            'user_id' => 'nullable|exists:users,id',
        ]);

        PropertyUnit::create($request->all());
        return redirect()->route('owner.units.index')->with('success', 'Unit apartemen berhasil ditambahkan.');
    }

    public function edit(PropertyUnit $unit)
    {
        $tenants = User::where('role', 'tenant')->get();
        return view('owner.units.edit', compact('unit', 'tenants'));
    }

    public function update(Request $request, PropertyUnit $unit)
    {
        $request->validate([
            'unit_number' => 'required|string|unique:property_units,unit_number,'.$unit->id,
            'type' => 'required|string',
            'status' => 'required|in:available,occupied,maintenance',
            'user_id' => 'nullable|exists:users,id',
        ]);

        $unit->update($request->all());
        return redirect()->route('owner.units.index')->with('success', 'Data unit berhasil diperbarui.');
    }

    public function destroy(PropertyUnit $unit)
    {
        $unit->delete();
        return redirect()->route('owner.units.index')->with('success', 'Unit apartemen berhasil dihapus.');
    }
}