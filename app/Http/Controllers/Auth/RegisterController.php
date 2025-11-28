<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Pelanggan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class RegisterController extends Controller
{
    public function index()
    {
        return view('auth.register');
    }

  public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        DB::beginTransaction();
        try {
            // Create User
            $user = User::create([
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'tipe_user' => 'pelanggan',
                'aktif' => true,
            ]);

            // Create Pelanggan
            Pelanggan::create([
                'user_id' => $user->id,
                'nama' => $validated['name'],
            ]);
            DB::commit();

            // Auto login
            auth()->login($user);
            return redirect('/')->with('success', 'Pendaftaran berhasil! Selamat datang di Leafly.');
            }catch (\Exception $e){
            DB::rollback();
            return back()->withErrors(['error' => 'Terjadi kesalahan saat mendaftar.'])->withInput();
        }
    }
}

