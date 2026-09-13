<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\WorkOrder;
use Illuminate\Http\Request;

class ApprovalController extends Controller
{
    public function index()
    {
        // Mengambil work order yang statusnya menunggu persetujuan
        $approvals = WorkOrder::with(['complaint.tenant', 'complaint.propertyUnit', 'technician'])
            ->where('status', 'waiting_approval')
            ->latest()
            ->get();

        return view('owner.approvals.index', compact('approvals'));
    }

    public function update(Request $request, $id)
    {
        $workOrder = WorkOrder::findOrFail($id);

        $request->validate([
            'status'  => 'required|in:approved,rejected',
            'comment' => 'nullable|string',
        ]);

        if ($request->status === 'approved') {
            // Jika di-ACC owner, status work order berubah menjadi in_progress (lampu hijau buat teknisi)
            $workOrder->update([
                'status' => 'in_progress',
                'owner_comment' => $request->comment
            ]);
        } else {
            // Jika ditolak, kembalikan ke status assigned agar teknisi bisa revisi RAB
            $workOrder->update([
                'status' => 'assigned',
                'owner_comment' => $request->comment
            ]);
        }

        return back()->with('success', 'Keputusan berhasil disimpan dan diteruskan ke teknisi!');
    }
}