<?php

namespace App\Http\Controllers\Technician;

use App\Http\Controllers\Controller;
use App\Models\WorkOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class WorkOrderController extends Controller
{
    public function index(Request $request)
    {
        $query = WorkOrder::with(['complaint.tenant', 'complaint.propertyUnit'])
            ->where('technician_id', Auth::id());

        // Filter berdasarkan status
        if ($request->filled('status')) {
            $filter = $request->status;
            if ($filter === 'waiting_approval') {
                $query->where('status', 'waiting_approval');
            } elseif ($filter === 'ready') {
                $query->whereIn('status', ['pending', 'assigned', 'in_progress']);
            } elseif ($filter === 'completed') {
                $query->where('status', 'completed');
            }
        }

        // Filter berdasarkan pencarian (judul, deskripsi, atau nomor unit)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('complaint', function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhereHas('propertyUnit', function($uq) use ($search) {
                      $uq->where('unit_number', 'like', "%{$search}%");
                  });
            });
        }

        $tasks = $query->latest()->get();

        return view('technician.tasks.index', compact('tasks'));
    }

    public function show($id)
    {
        $task = WorkOrder::with(['complaint.tenant', 'complaint.propertyUnit', 'technician'])
            ->where('technician_id', Auth::id())
            ->findOrFail($id);

        return view('technician.tasks.show', compact('task'));
    }

    public function update(Request $request, $id)
    {
        // Tambahkan relasi 'complaint' agar bisa langsung diperbarui statusnya
        $task = WorkOrder::with('complaint')->where('technician_id', Auth::id())->findOrFail($id);

        // LOGIKA PENYELESAIAN TUGAS (Dari in_progress -> completed)
        if ($task->status === 'in_progress' && $request->has('complete_task')) {
            $request->validate([
                'photo_after' => 'required|image|max:2048',
            ]);

            if ($task->photo_after) {
                Storage::disk('public')->delete($task->photo_after);
            }
            $photoAfterPath = $request->file('photo_after')->store('work-orders', 'public');

            $task->update([
                'status' => 'completed',
                'photo_after' => $photoAfterPath,
            ]);

            // Tutup tiket keluhan utama di sisi Tenant
            if ($task->complaint) {
                $task->complaint->update(['status' => 'completed']);
            }

            return back()->with('success', 'Kerja bagus! Perbaikan telah selesai dan tiket telah ditutup.');
        }

        // LOGIKA SIMPAN RAB / DATA NORMAL (Jika bukan penyelesaian akhir)
        $request->validate([
            'action_details' => 'nullable|string',
            'spare_parts'    => 'nullable|string',
            'cost_estimate'  => 'nullable|numeric',
            'estimated_days' => 'nullable|integer',
            'status'         => 'required|string',
            'photo_before'   => 'nullable|image|max:2048',
            'photo_after'    => 'nullable|image|max:2048',
        ]);

        $data = [
            'action_details' => $request->action_details,
            'spare_parts'    => $request->spare_parts,
            'cost_estimate'  => $request->cost_estimate,
            'estimated_days' => $request->estimated_days,
            'status'         => $request->status,
        ];

        // Handle upload foto sebelum perbaikan
        if ($request->hasFile('photo_before')) {
            if ($task->photo_before) {
                Storage::disk('public')->delete($task->photo_before);
            }
            $data['photo_before'] = $request->file('photo_before')->store('work-orders', 'public');
        }

        // Handle upload foto sesudah perbaikan (jika diunggah secara manual via form reguler)
        if ($request->hasFile('photo_after')) {
            if ($task->photo_after) {
                Storage::disk('public')->delete($task->photo_after);
            }
            $data['photo_after'] = $request->file('photo_after')->store('work-orders', 'public');
        }

        $task->update($data);

        return back()->with('success', 'Rincian tugas dan estimasi biaya berhasil disimpan!');
    }

    public function invoice($id)
    {
        $task = WorkOrder::with(['complaint.tenant', 'complaint.propertyUnit', 'technician'])
            ->where('technician_id', Auth::id())
            ->findOrFail($id);

        return view('technician.tasks.invoice', compact('task'));
    }
}