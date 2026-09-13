<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use App\Models\WorkOrder;
use App\Models\User;
use Illuminate\Http\Request;

class ComplaintController extends Controller {
    public function index() {
        $complaints = Complaint::with(['tenant', 'propertyUnit'])->orderBy('created_at', 'desc')->get();
        $technicians = User::where('role', 'technician')->get();
        return view('admin.complaints.index', compact('complaints', 'technicians'));
    }

    public function update(Request $request, $id) {
        $complaint = Complaint::findOrFail($id);
        
        // Jika admin memilih teknisi dan mengarahkan ke status assigned
        if ($request->has('technician_id') && $request->technician_id != '') {
            $complaint->update(['status' => 'assigned']);
            WorkOrder::updateOrCreate(
                ['complaint_id' => $complaint->id],
                [
                    'technician_id' => $request->technician_id,
                    'description' => 'Tindak lanjut keluhan: ' . $complaint->title,
                    'status' => 'pending'
                ]
            );
        } else {
            // Untuk penanganan status lain seperti 'rejected'
            $complaint->update(['status' => $request->status]);
        }
        
        return back()->with('success', 'Status updated');
    }
}