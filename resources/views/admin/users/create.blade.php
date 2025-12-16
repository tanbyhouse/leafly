@extends('layouts.admin')

@section('title', 'Tambah User')

@section('content')
    <div class="max-w-xl mx-auto bg-white p-6 rounded-xl shadow border">
        <h1 class="text-xl font-bold mb-4">Tambah User</h1>

        <form action="{{ route('admin.users.store') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label class="block text-sm font-medium">Nama</label>
                <input type="text" name="name" required class="w-full border rounded-lg p-2">
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium">Email</label>
                <input type="email" name="email" required class="w-full border rounded-lg p-2">
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium">Password</label>
                <input type="password" name="password" required class="w-full border rounded-lg p-2">
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium">Role</label>
                <select name="role" required class="w-full border rounded-lg p-2">
                    <option value="">-- Pilih Role --</option>
                    <option value="admin">Admin</option>
                    <option value="karyawan">Karyawan</option>
                </select>
            </div>

            <div class="flex justify-end gap-2">
                <a href="{{ route('admin.users.index') }}" class="px-4 py-2 rounded-lg border">Batal</a>
                <button class="bg-leafly-green text-white px-4 py-2 rounded-lg">
                    Simpan
                </button>
            </div>
        </form>
    </div>
@endsection
