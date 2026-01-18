<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Organization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('organization')
            ->orderBy('username')
            ->paginate(10);

        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        $organizations = Organization::orderBy('name')->get();

        return view('admin.users.create', compact('organizations'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:150',
            'username' => 'required|string|max:100|unique:users,username',
            'password' => 'required|min:6',
            'role'     => 'required|in:admin,student',
            'org_id'   => 'nullable|exists:organizations,id',
        ]);

        User::create([
            'name'     => $request->name,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role'     => $request->role,
            'org_id'   => $request->org_id,
        ]);

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User berhasil ditambahkan.');
    }

    public function edit(User $user)
    {
        $organizations = Organization::orderBy('name')->get();

        return view('admin.users.edit', compact('user','organizations'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'     => 'required|string|max:150',
            'username' => 'required|string|max:100|unique:users,username,' . $user->id,
            'role'     => 'required|in:admin,user',
            'org_id'   => 'nullable|exists:organizations,id',
            'password' => 'nullable|min:6',
        ]);

        $data = $request->only('username','role','org_id');

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->withErrors('Tidak bisa menghapus akun sendiri.');
        }

        $user->delete();

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User berhasil dihapus.');
    }
}
