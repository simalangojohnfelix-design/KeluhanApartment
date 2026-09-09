<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\PropertyUnit;
use App\Models\User;
use Illuminate\Http\Request;

class PropertyUnitController extends Controller {
    public function index() {
        $units = PropertyUnit::with('tenant')->get();
        return view('admin.units.index', compact('units'));
    }
    public function edit($id) {
        $unit = PropertyUnit::findOrFail($id);
        $tenants = User::where('role', 'tenant')->get();
        return view('admin.units.edit', compact('unit', 'tenants'));
    }
    public function update(Request $request, $id) {
        $unit = PropertyUnit::findOrFail($id);
        $unit->update($request->validate([
            'user_id' => 'nullable|exists:users,id',
            'lease_start' => 'nullable|date',
            'lease_end' => 'nullable|date',
            'status' => 'required'
        ]));
        return redirect()->route('admin.units.index')->with('success', 'Unit updated');
    }
}
