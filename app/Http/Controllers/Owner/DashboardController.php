<?php
namespace App\Http\Controllers\Owner;
use App\Http\Controllers\Controller;
use App\Models\Complaint;
use App\Models\WorkOrder;
use App\Models\Asset;
use Carbon\Carbon;

class DashboardController extends Controller {
    public function index() {
        $totalCostMonth = WorkOrder::where('status','completed')
            ->whereMonth('updated_at', Carbon::now()->month)->sum('cost_estimate');
        $totalCostYear = WorkOrder::where('status','completed')
            ->whereYear('updated_at', Carbon::now()->year)->sum('cost_estimate');

        $totalAssets  = Asset::count();
        $goodAssets   = Asset::where('condition','Good')->count();
        $assetHealthPct = $totalAssets > 0 ? round(($goodAssets / $totalAssets) * 100) : 0;

        $pendingApprovals = \App\Models\RepairApproval::where('status','pending')->count();
        $complaintsByCategory = Complaint::selectRaw('category, count(*) as total')
            ->groupBy('category')->orderByDesc('total')->get();
        $totalComplaints = Complaint::count();
        $resolvedComplaints = Complaint::where('status','resolved')->count();

        return view('owner.dashboard', compact(
            'totalCostMonth','totalCostYear','assetHealthPct',
            'pendingApprovals','complaintsByCategory','totalComplaints','resolvedComplaints'
        ));
    }
}
