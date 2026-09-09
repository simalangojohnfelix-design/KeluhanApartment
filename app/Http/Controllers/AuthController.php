<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function loginTenant(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            if (Auth::user()->role !== 'tenant') {
                Auth::logout();
                return back()->withErrors(['email' => 'Akun ini bukan akun penghuni. Silakan gunakan login Staff.']);
            }
            $request->session()->regenerate();
            return redirect()->route('tenant.dashboard');
        }

        return back()->withErrors(['email' => 'Email atau password salah.'])->withInput();
    }

    public function loginStaff(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $role = Auth::user()->role;
            if ($role === 'tenant') {
                Auth::logout();
                return back()->withErrors(['email' => 'Akun penghuni tidak bisa login di sini. Gunakan login Penghuni.']);
            }
            $request->session()->regenerate();
            if ($role === 'admin') return redirect()->route('admin.dashboard');
            if ($role === 'technician') return redirect()->route('technician.tasks.index');
            if ($role === 'owner') return redirect()->route('owner.dashboard');
        }

        return back()->withErrors(['email' => 'Email atau password salah.'])->withInput();
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
