<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin() {
        return view('auth.login');
    }

    public function login(Request $request) {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $role = Auth::user()->role;
            if($role == 'admin') return redirect()->route('admin.dashboard');
            if($role == 'tenant') return redirect()->route('tenant.dashboard');
            if($role == 'technician') return redirect()->route('technician.tasks.index');
            if($role == 'owner') return redirect()->route('owner.dashboard');
        }

        return back()->withErrors(['email' => 'Kredensial tidak cocok.']);
    }

    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
