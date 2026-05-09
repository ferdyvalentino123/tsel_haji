<?php

namespace App\Http\Controllers\Admin;

use App\Models\RoleUsers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class RoleUsersController extends Controller
{
    public function index()
    {
        $users = RoleUsers::paginate(15);
        return view("admin.users.index", compact("users"));
    }

    public function create()
    {
        return view("admin.users.form");
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            "name"  => "required|string|max:255",
            "email" => "required|email|unique:role_users,email",
            "pin"   => "required|string|min:6",
            "role"  => "required|in:kasir,sales,admin,pelanggan,travel,supervisor",
            "phone" => "nullable|string",
        ], [
            "pin.min" => "PIN minimal 6 karakter.",
        ]);

        RoleUsers::create($validated);
        return redirect(route("admin.users.index"))->with("success", "User berhasil ditambahkan");
    }

    public function show(RoleUsers $user)
    {
        return view("admin.users.show", compact("user"));
    }

    public function edit(RoleUsers $user)
    {
        return view("admin.users.form", compact("user"));
    }

    public function update(Request $request, RoleUsers $user)
    {
        $validated = $request->validate([
            "name"  => "required|string|max:255",
            "email" => "required|email|unique:role_users,email," . $user->id,
            "pin"   => "nullable|string|min:6",
            "role"  => "required|in:kasir,sales,admin,pelanggan,travel,supervisor",
            "phone" => "nullable|string",
        ], [
            "pin.min" => "PIN minimal 6 karakter.",
        ]);

        // Jika admin sedang edit profil sendiri, pertahankan role yang ada (tidak bisa diubah)
        if (Auth::id() === $user->id) {
            $validated['role'] = $user->role;
        }

        if (empty($validated["pin"])) {
            unset($validated["pin"]);
        }

        $user->update($validated);
        return redirect(route("admin.users.index"))->with("success", "User berhasil diperbarui");
    }

    public function destroy(RoleUsers $user)
    {
        $user->delete();
        return redirect(route("admin.users.index"))->with("success", "User berhasil dihapus");
    }
}