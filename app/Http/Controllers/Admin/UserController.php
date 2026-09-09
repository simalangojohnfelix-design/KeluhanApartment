<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\PropertyUnit;
use Illuminate\Http\Request;

class UserController extends Controller {
    public function index() {
        $tenants = User::where('role','tenant')->with('propertyUnit')->orderBy('name')->get();
        $technicians = User::where('role','technician')->orderBy('name')->get();
        $admins = User::whereIn('role',['admin','owner'])->orderBy('name')->get();
        return view('admin.users.index', compact('tenants', 'technicians', 'admins'));
    }

    public function edit(User $user) {
        $units = PropertyUnit::all();
        return view('admin.users.edit', compact('user', 'units'));
    }

    public function update(Request $request, User $user) {
        $user->update($request->validate([
            'name'  => 'required|string',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string',
            'role'  => 'required',
        ]));
        // Handle unit assignment for tenants
        if ($user->role === 'tenant' && $request->filled('unit_id')) {
            PropertyUnit::where('user_id', $user->id)->where('id', '!=', $request->unit_id)->update(['user_id' => null, 'status' => 'available']);
            PropertyUnit::find($request->unit_id)?->update([
                'user_id'     => $user->id,
                'status'      => 'occupied',
                'lease_start' => $request->lease_start,
                'lease_end'   => $request->lease_end,
            ]);
        }
        return back()->with('success', 'Data pengguna diperbarui.');
    }
}
