<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /* =====================================================
     | SHOW LOGIN PAGE
     ===================================================== */
    public function showLogin()
    {
        return view('auth.login');
    }

    /* =====================================================
     | PROCESS LOGIN
     ===================================================== */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        $remember = $request->boolean('remember-me');

        if (!Auth::attempt($credentials, $remember)) {
            throw ValidationException::withMessages([
                'email' => 'Email atau kata sandi salah.',
            ]);
        }

        $request->session()->regenerate();

        $user = $request->user();

        // 🔒 Cek status aktif
        if (!$user->is_active) {
            Auth::logout();

            return back()->withErrors([
                'email' => 'Akun Anda tidak aktif. Silakan hubungi admin.',
            ]);
        }

        // 🔀 Redirect berdasarkan role
        if ($user->hasRole('admin') || $user->hasRole('karyawan')) {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->route('home');
    }

    /* =====================================================
     | SHOW REGISTER PAGE
     ===================================================== */
    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name'                  => ['required', 'string', 'max:255'],
            'email'                 => ['required', 'email', 'unique:users,email'],
            'password'              => ['required', 'confirmed', 'min:8'],
        ]);

        $user = User::create([
            'name'      => $validated['name'],
            'email'     => $validated['email'],
            'password'  => Hash::make($validated['password']),
            'is_active' => true,
        ]);

        // Assign role pelanggan
        $user->roles()->attach(
            \App\Models\Role::where('name', 'pelanggan')->value('id')
        );

        return redirect()
            ->route('login')
            ->with('success', 'Registrasi berhasil. Silakan login.');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Anda berhasil logout.');
    }
}
