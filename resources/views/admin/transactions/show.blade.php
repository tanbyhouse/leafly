@extends('layouts.admin')

@section('title', 'Detail Transaksi')
@section('header', 'Detail Pesanan #' . $transaction->id)

@section('content')

<style>
    @media print {
        body * { visibility: hidden; }
        #printable-area, #printable-area * { visibility: visible; }
        #printable-area { position: absolute; left: 0; top: 0; width: 100%; }
        .no-print { display: none !important; }
        /* Reset layout admin untuk print */
        aside, header { display: none; }
        main { margin: 0; padding: 0; }
    }
</style>

@if(session('success'))
<div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow-sm no-print">
    <p class="font-bold">Berhasil!</p>
    <p>{{ session('success') }}</p>
</div>
@endif

<div class="max-w-6xl mx-auto grid grid-cols-1 lg:grid-cols-3 gap-8">
    
    <div class="lg:col-span-2 space-y-6" id="printable-area">
        
        <div class="hidden print:block mb-8 text-center border-b pb-4">
            <h1 class="text-3xl font-bold text-leafly-dark">Leafly.id</h1>
            <p>Invoice Pesanan #{{ $transaction->id }}</p>
        </div>

        <!-- list produk -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <div class="flex justify-between items-center mb-4 border-b pb-2">
                <h3 class="font-bold text-gray-800">Daftar Produk</h3>
                <button onclick="window.print()" class="text-gray-500 hover:text-leafly-dark no-print" title="Cetak Invoice">
                    <i class="fa-solid fa-print"></i> Cetak
                </button>
            </div>

            <div class="space-y-4">
                @foreach($transaction->items as $item)
                <div class="flex items-center gap-4">
                    <div class="w-16 h-16 bg-gray-100 rounded-lg flex items-center justify-center text-leafly-dark text-2xl no-print">
                        <i class="fa-solid fa-box"></i>
                    </div>
                    <div class="grow">
                        <h4 class="font-bold text-gray-800">{{ $item['name'] }}</h4>
                        <p class="text-sm text-gray-500">{{ $item['qty'] }} x Rp {{ number_format($item['price'], 0, ',', '.') }}</p>
                    </div>
                    <div class="text-right font-bold text-gray-800">
                        Rp {{ number_format($item['price'] * $item['qty'], 0, ',', '.') }}
                    </div>
                </div>
                @endforeach
            </div>
            
            <div class="border-t border-gray-100 mt-4 pt-4 space-y-2 text-sm">
                <div class="flex justify-between">
                    <span class="text-gray-600">Subtotal</span>
                    <span class="font-medium">Rp {{ number_format($transaction->subtotal, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Ongkir ({{ $transaction->courier }})</span>
                    <span class="font-medium">Rp {{ number_format($transaction->shipping_cost, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between text-lg font-bold text-leafly-dark pt-2">
                    <span>Total Bayar</span>
                    <span>Rp {{ number_format($transaction->grand_total, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        <!-- info pengiriman -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="font-bold text-gray-800 mb-4 border-b pb-2">Data Pengiriman</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <p class="text-xs text-gray-500 uppercase font-bold">Penerima</p>
                    <p class="font-medium text-gray-800">{{ $transaction->customer_name }}</p>
                    <p class="text-sm text-gray-600">{{ $transaction->customer_phone }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 uppercase font-bold">Alamat</p>
                    <p class="text-sm text-gray-600 leading-relaxed">{{ $transaction->address }}</p>
                </div>
                <div class="no-print">
                    <p class="text-xs text-gray-500 uppercase font-bold">Kurir & Resi</p>
                    <p class="font-medium text-gray-800">{{ $transaction->courier }}</p>
                    <p class="text-leafly-dark font-bold">{{ $transaction->resi }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 no-print">
            <h3 class="font-bold text-gray-800 mb-4 border-b pb-2">Riwayat Pesanan</h3>
            <ol class="relative border-l border-gray-200 ml-3">                  
                <li class="mb-6 ml-6">
                    <span class="absolute flex items-center justify-center w-6 h-6 bg-green-100 rounded-full -left-3 ring-8 ring-white text-green-600">
                        <i class="fa-solid fa-check text-xs"></i>
                    </span>
                    <h3 class="flex items-center mb-1 text-sm font-semibold text-gray-900">Pesanan Dibuat</h3>
                    <time class="block mb-2 text-xs font-normal text-gray-400">{{ $transaction->date }}</time>
                </li>
                <li class="mb-6 ml-6">
                    <span class="absolute flex items-center justify-center w-6 h-6 {{ $transaction->status != 'Menunggu Pembayaran' ? 'bg-green-100 text-green-600' : 'bg-gray-200 text-gray-500' }} rounded-full -left-3 ring-8 ring-white">
                        <i class="fa-solid fa-money-bill text-xs"></i>
                    </span>
                    <h3 class="mb-1 text-sm font-semibold text-gray-900">Pembayaran Dikonfirmasi</h3>
                </li>
                <li class="ml-6">
                    <span class="absolute flex items-center justify-center w-6 h-6 {{ ($transaction->status == 'Dikirim' || $transaction->status == 'Selesai') ? 'bg-green-100 text-green-600' : 'bg-gray-200 text-gray-500' }} rounded-full -left-3 ring-8 ring-white">
                        <i class="fa-solid fa-truck text-xs"></i>
                    </span>
                    <h3 class="mb-1 text-sm font-semibold text-gray-900">Pesanan Dikirim</h3>
                </li>
            </ol>
        </div>
    </div>

    <div class="lg:col-span-1 space-y-6 no-print">
        
        <!-- bukti bayar -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 text-center">
            <p class="text-sm text-gray-500 mb-2">Status Saat Ini</p>
            @php
                $color = match($transaction->status) {
                    'Menunggu Pembayaran' => 'bg-yellow-100 text-yellow-700',
                    'Dikemas' => 'bg-blue-100 text-blue-700',
                    'Dikirim' => 'bg-purple-100 text-purple-700',
                    'Selesai' => 'bg-green-100 text-green-700',
                    default => 'bg-gray-100 text-gray-700'
                };
            @endphp
            <span class="inline-block px-4 py-2 rounded-full text-sm font-bold {{ $color }} mb-4">
                {{ $transaction->status }}
            </span>

            @if($transaction->payment_method != 'COD')
                <button onclick="showPaymentProof()" class="w-full border border-leafly-dark text-leafly-dark font-bold py-2 rounded-lg hover:bg-leafly-dark hover:text-white transition text-sm flex items-center justify-center gap-2">
                    <i class="fa-regular fa-image"></i> Cek Bukti Transfer
                </button>
            @endif
        </div>

        <!-- form update status -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 border-t-4 border-leafly-dark">
            <h3 class="font-bold text-gray-800 mb-4">Proses Pesanan</h3>
            
            <form action="{{ route('admin.transactions.update', $transaction->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label class="block text-sm font-bold text-gray-700 mb-2">Update Status</label>
                    <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-leafly-green focus:border-leafly-green" id="status-select">
                        <option value="Menunggu Pembayaran" {{ $transaction->status == 'Menunggu Pembayaran' ? 'selected' : '' }}>Menunggu Pembayaran</option>
                        <option value="Dikemas" {{ $transaction->status == 'Dikemas' ? 'selected' : '' }}>Dikemas (Verifikasi)</option>
                        <option value="Dikirim" {{ $transaction->status == 'Dikirim' ? 'selected' : '' }}>Dikirim (Input Resi)</option>
                        <option value="Selesai" {{ $transaction->status == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                        <option value="Dibatalkan" {{ $transaction->status == 'Dibatalkan' ? 'selected' : '' }}>Batalkan Pesanan</option>
                    </select>
                </div>

                <div class="mb-6 {{ $transaction->status == 'Dikirim' ? '' : 'hidden' }}" id="resi-input">
                    <label class="block text-sm font-bold text-gray-700 mb-2">Nomor Resi</label>
                    <input type="text" name="resi" value="{{ $transaction->resi }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-leafly-green focus:border-leafly-green" placeholder="Masukkan resi...">
                </div>

                <button type="submit" class="w-full bg-leafly-dark text-white font-bold py-3 rounded-lg hover:bg-leafly-gold hover:text-leafly-dark transition shadow-lg">
                    Simpan Perubahan
                </button>
            </form>
        </div>

        <!-- chat rdirec whatsapp -->
        @php
            // Format nomor HP (0812... jadi 62812...)
            $phone = $transaction->customer_phone;
            if(substr($phone, 0, 1) == '0') {
                $phone = '62' . substr($phone, 1);
            }
            $message = "Halo kak {$transaction->customer_name}, admin Leafly di sini. Mengenai pesanan #{$transaction->id}...";
        @endphp
        <a href="https://wa.me/{{ $phone }}?text={{ urlencode($message) }}" target="_blank" class="block bg-green-500 text-white text-center font-bold py-3 rounded-lg hover:bg-green-600 transition shadow-md">
            <i class="fa-brands fa-whatsapp mr-2"></i> Chat WhatsApp
        </a>

    </div>
</div>

<script>
    // Show/Hide Resi Input
    const statusSelect = document.getElementById('status-select');
    const resiInput = document.getElementById('resi-input');

    statusSelect.addEventListener('change', function() {
        if(this.value === 'Dikirim') {
            resiInput.classList.remove('hidden');
        } else {
            resiInput.classList.add('hidden');
        }
    });

    // SweetAlert Bukti Bayar
    function showPaymentProof() {
        Swal.fire({
            title: 'Bukti Pembayaran',
            imageUrl: 'https://via.placeholder.com/400x600?text=Bukti+Transfer', 
            imageWidth: 400,
            imageHeight: 500,
            imageAlt: 'Bukti Transfer',
            showCloseButton: true,
            confirmButtonText: 'Tutup',
            confirmButtonColor: '#225D2D'
        });
    }
</script>

@endsection