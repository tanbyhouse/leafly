<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user() ?? (object) [
            'name' => 'Allyya Novita',
            'email' => 'customer@leafly.id',
            'phone' => '081234567890',
            'avatar' => null
        ];

        return view('customer.profile.index', compact('user'));
    }

    /**
     * Update user biodata
     */
    public function update(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:15',
            'address' => 'nullable|string',
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->address = $request->address;

        // delete old avatar if exists
        if ($request->hasFile('avatar')) {
            // Hapus foto lama jika bukan default (opsional)
            if ($user->avatar && Storage::exists('public/avatars/' . $user->avatar)) {
                Storage::delete('public/avatars/' . $user->avatar);
            }

            // Simpan foto baru
            $file = $request->file('avatar');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/avatars', $filename);

            $user->avatar = $filename;
        }

        $user->save();

        return back()->with('success', 'Profil berhasil diperbarui.');
    }
}
