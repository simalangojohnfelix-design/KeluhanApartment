<?php
namespace App\Http\Controllers\Owner;
use App\Http\Controllers\Controller;
use App\Models\RepairApproval;
use Illuminate\Http\Request;

class ApprovalController extends Controller {
    public function index() {
        $approvals = RepairApproval::with(['workOrder.complaint.tenant','workOrder.complaint.propertyUnit','workOrder.technician'])->latest()->get();
        return view('owner.approvals.index', compact('approvals'));
    }
    public function update(Request $request, $id) {
        $approval = RepairApproval::findOrFail($id);
        $approval->update([
            'status' => $request->validate(['status' => 'required|in:approved,rejected'])['status'],
            'owner_id' => auth()->id(),
            'comment' => $request->comment
        ]);
        return back()->with('success', 'Keputusan berhasil disimpan.');
    }
}
