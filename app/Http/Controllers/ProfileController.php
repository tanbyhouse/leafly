<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user() ?? (object) [
            'name' => 'John Doe',
            'email' => 'customer@leafly.id',
            'phone' => '081234567890',
            'avatar' => null
        ];

        return view('customer.profile.index', compact('user'));
    }

    /**
     * Update user avatar
     */
    public function updateAvatar(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $request->validate([
            'avatar' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $user = Auth::user();

        $path = $request->file('avatar')->store('avatars', 'public');

        // delete old avatar if exists
        if (!empty($user->avatar) && \Storage::disk('public')->exists($user->avatar)) {
            \Storage::disk('public')->delete($user->avatar);
        }

        $user->avatar = $path;
        $user->save();

        return back()->with('success', 'Avatar berhasil diperbarui.');
    }
}
