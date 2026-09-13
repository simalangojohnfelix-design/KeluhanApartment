<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Ambil data keluhan (urutkan dari yang paling baru)
        // Gunakan eager loading (with) agar tidak berat saat meload relasi tenant & unit
        $complaints = Complaint::with(['tenant', 'propertyUnit'])->latest()->get();

        // 2. Ambil daftar user yang memiliki role 'technician' untuk dropdown pilihan
        $technicians = User::where('role', 'technician')->get();

        // 3. Lempar datanya ke view dasbor baru kita
        return view('admin.dashboard', compact('complaints', 'technicians'));
    }
}