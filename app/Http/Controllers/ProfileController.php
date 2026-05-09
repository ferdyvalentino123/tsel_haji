<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RoleUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function edit()
    {
        $roleUsers = Auth::user();
        $role = $roleUsers->role;
        
        $view = 'role_users.edit_default';
        if ($role === 'admin') {
            $view = 'role_users.edit_admin';
        } elseif ($role === 'supervisor') {
            $view = 'role_users.edit_supervisor';
        } elseif ($role === 'sales') {
            $view = 'role_users.edit_sales';
        } elseif ($role === 'kasir') {
            $view = 'role_users.edit_kasir';
        }

        return view($view, compact('roleUsers'));
    }

    public function update(Request $request)
    {
        /** @var \App\Models\RoleUsers $user */
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:role_users,email,' . $user->id,
            'phone' => 'nullable|string',
            'pin' => 'nullable|string|min:6',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'pin.min' => 'PIN minimal harus 6 karakter.',
            'photo.image' => 'File harus berupa gambar.',
            'photo.max' => 'Ukuran gambar maksimal 2MB.',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
        ];

        if ($request->filled('pin')) {
            $data['pin'] = $request->pin; // setPinAttribute will bcrypt it
        }

        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($user->photo) {
                Storage::disk('public')->delete($user->photo);
            }
            $path = $request->file('photo')->store('profile_photos', 'public');
            $data['photo'] = $path;
        }

        $user->update($data);

        return back()->with('success', 'Profil berhasil diperbarui.');
    }
}
