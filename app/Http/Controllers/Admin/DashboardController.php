<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Complaint;
use App\Models\WorkOrder;
use App\Models\Asset;
use Carbon\Carbon;

class DashboardController extends Controller {
    public function index() {
        $totalComplaints   = Complaint::whereMonth('created_at', Carbon::now()->month)->count();
        $pendingComplaints = Complaint::whereIn('status', ['pending','verified'])->count();
        $totalRepairCost   = WorkOrder::where('status','completed')->sum('cost_estimate');
        $totalAssets       = Asset::count();
        $badAssets         = Asset::whereIn('condition', ['Needs Repair','Broken'])->count();

        return view('admin.dashboard', compact(
            'totalComplaints','pendingComplaints','totalRepairCost','totalAssets','badAssets'
        ));
    }
}
