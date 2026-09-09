<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Asset;
use App\Models\PropertyUnit;
use Illuminate\Http\Request;

class AssetController extends Controller {
    public function index() {
        // Group assets per unit for cleaner display
        $units = PropertyUnit::with(['assets', 'tenant'])->orderBy('unit_number')->get();
        return view('admin.assets.index', compact('units'));
    }

    public function update(Request $request, Asset $asset) {
        $asset->update($request->validate([
            'condition'        => 'required|string',
            'status'           => 'required|string',
            'maintenance_date' => 'nullable|date',
        ]));
        return back()->with('success', 'Aset unit ' . $asset->propertyUnit->unit_number . ' diperbarui.');
    }
}
