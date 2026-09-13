<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\WorkOrder;
use App\Models\Complaint;
use App\Models\User;
use App\Models\PropertyUnit;
use App\Models\Asset;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $now = Carbon::now();

        // Metrik Finansial
        $totalCostMonth = WorkOrder::where('status', 'completed')
            ->whereMonth('updated_at', $now->month)
            ->whereYear('updated_at', $now->year)
            ->sum('cost_estimate');

        $totalCostYear = WorkOrder::where('status', 'completed')
            ->whereYear('updated_at', $now->year)
            ->sum('cost_estimate');

        // Metrik Operasional Keluhan & Persetujuan
        $totalComplaints = Complaint::count();
        $resolvedComplaints = Complaint::where('status', 'completed')->count();
        $pendingApprovals = WorkOrder::where('status', 'waiting_approval')->count();

        // Kategori Keluhan
        $complaintsByCategory = Complaint::select('category', DB::raw('count(*) as total'))
            ->groupBy('category')
            ->get();

        // Metrik Manajemen Properti (Mutlak Owner)
        $totalUsers = User::count();
        $totalUnits = PropertyUnit::count();
        $totalAssets = Asset::count();

        // Kalkulasi kasar kesehatan aset
        $assetHealthPct = $totalAssets > 0 
            ? max(0, 100 - round((($totalComplaints - $resolvedComplaints) / $totalAssets) * 100)) 
            : 100;

        return view('owner.dashboard', compact(
            'totalCostMonth',
            'totalCostYear',
            'assetHealthPct',
            'resolvedComplaints',
            'totalComplaints',
            'pendingApprovals',
            'complaintsByCategory',
            'totalUsers',
            'totalUnits',
            'totalAssets'
        ));
    }
}