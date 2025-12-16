@extends('layouts.admin')

@section('title', 'Edit User')

@section('content')
    <div class="max-w-xl mx-auto bg-white p-6 rounded-xl shadow border">
        <h1 class="text-xl font-bold mb-4">Edit User</h1>

        <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block text-sm font-medium">Nama</label>
                <input type="text" name="name" value="{{ $user->name }}" required class="w-full border rounded-lg p-2">
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium">Email</label>
                <input type="email" name="email" value="{{ $user->email }}" required class="w-full border rounded-lg p-2">
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium">
                    Password <span class="text-xs text-gray-400">(kosongkan jika tidak diubah)</span>
                </label>
                <input type="password" name="password" class="w-full border rounded-lg p-2">
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium">Role</label>
                <select name="role" class="w-full border rounded-lg p-2">
                    <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="karyawan" {{ $user->role === 'karyawan' ? 'selected' : '' }}>Karyawan</option>
                </select>
            </div>

            <div class="flex justify-end gap-2">
                <a href="{{ route('admin.users.index') }}" class="px-4 py-2 rounded-lg border">Batal</a>
                <button class="bg-leafly-green text-white px-4 py-2 rounded-lg">
                    Update
                </button>
            </div>
        </form>
    </div>
@endsection
