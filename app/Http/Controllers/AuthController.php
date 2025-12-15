<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use App\Models\Address;
use App\Models\District;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

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

        if (!$user->is_active) {
            Auth::logout();

            return back()->withErrors([
                'email' => 'Akun Anda tidak aktif. Silakan hubungi admin.',
            ]);
        }

        if ($user->hasRole('admin') || $user->hasRole('karyawan')) {
            return redirect()->route('dashboard');
        }

        return redirect()->route('home');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name'        => ['required', 'string', 'max:255'],
            'email'       => ['required', 'email', 'unique:users,email'],
            'password'    => ['required', 'confirmed', 'min:8'],
            'phone'       => ['required', 'string', 'max:20'],
            'address'     => ['required', 'string'],
            'province_id' => ['required', 'exists:provinces,id'],
            'city_id'     => ['required', 'exists:cities,id'],
            'district'    => ['required', 'string'],
            'postal_code' => ['nullable', 'string', 'max:10'],
        ]);

        DB::transaction(function () use ($validated) {
            $user = User::create([
                'name'      => $validated['name'],
                'email'     => $validated['email'],
                'password'  => Hash::make($validated['password']),
                'is_active' => true,
            ]);

            // role pelanggan
            $roleId = Role::where('name', 'pelanggan')->value('id');
            if ($roleId) {
                $user->roles()->attach($roleId);
            }

            // cari / buat district
            $district = District::firstOrCreate([
                'city_id' => $validated['city_id'],
                'name'    => trim($validated['district']),
            ]);

            // SIMPAN ALAMAT DEFAULT
            Address::create([
                'user_id'         => $user->id,
                'label'           => 'Default',
                'recipient_name'  => $user->name,
                'recipient_phone' => $validated['phone'],
                'address_detail'  => $validated['address'],
                'province_id'     => $validated['province_id'],
                'city_id'         => $validated['city_id'],
                'district_id'     => $district->id,
                'postal_code'     => $validated['postal_code'] ?? '',
                'is_primary'      => true,
            ]);
        });

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
