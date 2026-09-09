<?php
namespace App\Http\Controllers\Tenant;
use App\Http\Controllers\Controller;
use App\Models\Asset;

class UnitAssetController extends Controller {
    public function index() {
        $unit = auth()->user()->propertyUnit;
        $assets = $unit ? Asset::where('property_unit_id', $unit->id)->get() : collect();
        return view('tenant.assets.index', compact('assets', 'unit'));
    }
}
