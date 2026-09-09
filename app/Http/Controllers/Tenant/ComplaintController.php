<?php
namespace App\Http\Controllers\Tenant;
use App\Http\Controllers\Controller;
use App\Models\Complaint;
use App\Models\Asset;
use Illuminate\Http\Request;

class ComplaintController extends Controller {
    public function index() {
        $complaints = auth()->user()->complaints()->with(['asset', 'workOrder.technician'])->latest()->get();
        return view('tenant.complaints.index', compact('complaints'));
    }

    public function create() {
        $unit = auth()->user()->propertyUnit;
        $assets = $unit ? Asset::where('property_unit_id', $unit->id)->get() : collect();
        // Build categories from the actual asset names/categories in this unit, plus static fallbacks
        $categories = $assets->pluck('category')->filter()->unique()->values();
        if ($categories->isEmpty()) {
            $categories = collect(['Listrik', 'Plumbing', 'AC', 'Konstruksi', 'Perabotan', 'Lainnya']);
        } else {
            // Merge with standard categories and deduplicate
            $categories = $categories->merge(['Listrik', 'Plumbing', 'Konstruksi', 'Lainnya'])->unique()->values();
        }
        return view('tenant.complaints.create', compact('assets', 'categories'));
    }

    public function store(Request $request) {
        $data = $request->validate([
            'title'       => 'required',
            'category'    => 'required',
            'urgency'     => 'required',
            'description' => 'required',
            'asset_id'    => 'nullable|exists:assets,id',
            'photo'       => 'nullable|image|max:5120'
        ]);
        $data['tenant_id']        = auth()->id();
        $data['property_unit_id'] = optional(auth()->user()->propertyUnit)->id ?? 1;
        $data['status']           = 'pending';

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('complaints', 'public');
        }
        Complaint::create($data);
        return redirect()->route('tenant.complaints.index')->with('success', 'Keluhan berhasil dikirim.');
    }

    public function show($id) {
        $complaint = Complaint::with(['workOrder.technician', 'asset'])->findOrFail($id);
        abort_if($complaint->tenant_id !== auth()->id(), 403);
        return view('tenant.complaints.show', compact('complaint'));
    }

    public function rate(Request $request, $id) {
        $complaint = Complaint::findOrFail($id);
        abort_if($complaint->tenant_id !== auth()->id(), 403);
        $complaint->update([
            'rating'       => $request->validate(['rating' => 'required|integer|min:1|max:5'])['rating'],
            'review'       => $request->review,
            'is_confirmed' => true
        ]);
        return back()->with('success', 'Terima kasih atas ulasan Anda!');
    }
}
