<?php

namespace App\Http\Controllers;

use App\Exports\UsersExport;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $role = $request->query('role');

        $users = User::when($role && in_array($role, ['admin', 'staff']), function ($query) use ($role) {
            $query->where('role', $role);
        })->get();

        return view('users.index', compact('users', 'role'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'role' => 'required|in:admin,staff',
        ]);

        $prefix = substr($request->email, 0, 4);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'password' => bcrypt('temp'),
            'password_changed' => false,
        ]);

        $generatedPassword = $prefix . $user->id;

        $user->update([
            'password' => bcrypt($generatedPassword),
        ]);

        return redirect()->route('users.index', [
            'role' => $request->role
        ])->with('success', 'User berhasil dibuat! Password: ' . $generatedPassword);
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|string|min:6',
            'role' => 'required|in:admin,staff',
        ]);

        $user = User::findOrFail($id);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;

        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
            $user->password_changed = true;
        }

        $user->save();

        return redirect()->route('users.index', [
            'role' => $request->role
        ])->with('success', 'User berhasil diupdate!');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('users.index')
            ->with('success', 'User berhasil dihapus!');
    }

    public function resetPassword(User $user)
    {
        $password = substr($user->email, 0, 4) . $user->id;

        $user->password = bcrypt($password);
        $user->password_changed = false;
        $user->save();

        return redirect()->route('users.index', ['role' => $user->role])
            ->with('success', 'Password berhasil direset. Password baru: ' . $password);
    }

    public function editSelf()
    {
        $user = Auth::user();

        return view('users.edit', [
            'user' => $user,
            'formAction' => route('users.update.self'),
            'cancelRoute' => route('dashboard'),
            'disableRole' => true,
        ]);
    }

    public function export(Request $request)
    {
        $role = $request->query('role');

        if (!in_array($role, ['admin', 'staff'])) {
            abort(404);
        }

        return Excel::download(new UsersExport($role), "users_{$role}.xlsx");
    }

    public function updateSelf(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:6',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
            $user->password_changed = true;
        }

        $user->save();

        return redirect()->route('users.edit.self')->with('success', 'Profile berhasil diupdate!');
    }
}
