@extends('layouts.admin')

@section('title', 'Manajemen Pengguna')

@section('content')
<div class="p-6">
    
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Daftar Pengguna</h1>
            <p class="text-gray-500 text-sm">Kelola semua data pelanggan dan admin.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-leafly-dark text-leafly-dark p-4 mb-4 rounded shadow-sm">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4 rounded shadow-sm">
            {{ session('error') }}
        </div>
    @endif

    <!-- table users -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 text-gray-600 uppercase text-xs font-bold tracking-wider border-b border-gray-200">
                        <th class="p-4">No</th>
                        <th class="p-4">Nama User</th>
                        <th class="p-4">Role</th>
                        <th class="p-4">Email</th>
                        <th class="p-4">Tanggal Bergabung</th>
                        <th class="p-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($users as $key => $user)
                    <tr class="hover:bg-gray-50 transition duration-150">
                        <td class="p-4 text-gray-500 font-medium">
                            {{ $users->firstItem() + $key }}
                        </td>
                        <td class="p-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-leafly-green/10 flex items-center justify-center text-leafly-green font-bold text-lg">
                                    {{ substr($user->name, 0, 1) }}
                                </div>
                                <div>
                                    <p class="font-bold text-gray-800">{{ $user->name }}</p>
                                    <p class="text-xs text-gray-500">ID: #{{ $user->id }}</p>
                                </div>
                            </div>
                        </td>
                        
                        <!-- kolom role -->
                        <td class="p-4">
                            @if($user->role == 'admin')
                                <span class="bg-red-100 text-red-700 border border-red-200 px-3 py-1 rounded-full text-xs font-bold inline-flex items-center gap-1">
                                    <i class="fa-solid fa-user-shield"></i> Admin
                                </span>
                            @elseif($user->role == 'karyawan')
                                <span class="bg-blue-100 text-blue-700 border border-blue-200 px-3 py-1 rounded-full text-xs font-bold inline-flex items-center gap-1">
                                    <i class="fa-solid fa-user-tie"></i> Karyawan
                                </span>
                            @else
                                <span class="bg-green-100 text-green-700 border border-green-200 px-3 py-1 rounded-full text-xs font-bold inline-flex items-center gap-1">
                                    <i class="fa-solid fa-user"></i> Pelanggan
                                </span>
                            @endif
                        </td>

                        <td class="p-4 text-gray-600">
                            {{ $user->email }}
                        </td>
                        <td class="p-4 text-gray-600 text-sm">
                            {{ $user->created_at->format('d M Y') }}
                        </td>
                        <td class="p-4 text-center">
                            @if($user->id != auth()->id() && $user->id != 1) 
                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Hapus user ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700 bg-red-50 hover:bg-red-100 p-2 rounded-lg transition">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            @else
                                <span class="text-xs text-gray-400 italic">No Action</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="p-8 text-center text-gray-400">
                            Belum ada pengguna yang terdaftar.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- pagination -->
        <div class="p-4 border-t border-gray-100">
            {{ $users->links() }}
        </div>
    </div>
</div>
@endsection