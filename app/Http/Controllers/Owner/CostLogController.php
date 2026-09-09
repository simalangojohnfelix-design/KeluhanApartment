<?php
namespace App\Http\Controllers\Owner;
use App\Http\Controllers\Controller;
use App\Models\WorkOrder;
use Carbon\Carbon;

class CostLogController extends Controller {
    public function index() {
        $logs = WorkOrder::with(['complaint.propertyUnit', 'technician'])
            ->where('status', 'completed')
            ->whereNotNull('cost_estimate')
            ->latest('updated_at')->paginate(20);
        $totalCost = WorkOrder::where('status','completed')->sum('cost_estimate');
        return view('owner.cost-log.index', compact('logs', 'totalCost'));
    }
}
