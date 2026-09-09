<?php
namespace App\Http\Controllers\Technician;
use App\Http\Controllers\Controller;
use App\Models\WorkOrder;
use App\Models\RepairApproval;
use Illuminate\Http\Request;

class WorkOrderController extends Controller {
    public function index() {
        // Join complaints table explicitly so urgency column is reachable in ORDER BY
        $tasks = WorkOrder::with(['complaint.tenant', 'complaint.propertyUnit'])
            ->join('complaints', 'work_orders.complaint_id', '=', 'complaints.id')
            ->whereIn('complaints.status', ['assigned', 'in_progress'])
            ->orderByRaw("CASE WHEN complaints.urgency = 'high' THEN 0 WHEN complaints.urgency = 'medium' THEN 1 ELSE 2 END")
            ->select('work_orders.*')
            ->get();
        return view('technician.tasks.index', compact('tasks'));
    }

    public function show($id) {
        $task = WorkOrder::with(['complaint.tenant', 'complaint.propertyUnit', 'complaint.asset'])->findOrFail($id);
        return view('technician.tasks.show', compact('task'));
    }

    public function update(Request $request, $id) {
        $task = WorkOrder::findOrFail($id);
        $data = $request->validate([
            'status'         => 'required',
            'action_details' => 'nullable|string',
            'spare_parts'    => 'nullable|string',
            'cost_estimate'  => 'nullable|numeric',
            'photo_before'   => 'nullable|image|max:5120',
            'photo_after'    => 'nullable|image|max:5120',
        ]);
        $data['technician_id'] = auth()->id();
        if ($request->hasFile('photo_before')) $data['photo_before'] = $request->file('photo_before')->store('repairs', 'public');
        if ($request->hasFile('photo_after'))  $data['photo_after']  = $request->file('photo_after')->store('repairs', 'public');

        $task->update($data);

        // Sync complaint status
        if ($data['status'] === 'working')    $task->complaint->update(['status' => 'in_progress']);
        if ($data['status'] === 'completed')  $task->complaint->update(['status' => 'resolved']);

        // Auto-create approval if cost exceeds threshold and none exists yet
        if (!empty($data['cost_estimate']) && $data['cost_estimate'] > 1000000 && !$task->approval) {
            RepairApproval::create(['work_order_id' => $task->id, 'status' => 'pending']);
        }

        return back()->with('success', 'Work Order diperbarui.');
    }
}
