@extends('layouts.admin')

@section('title', 'Laporan Keuangan')
@section('header', 'Laporan & Analisa')

@section('content')

<!-- filter dan toolbar -->
<div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 mb-6 flex flex-col md:flex-row justify-between items-center gap-4">
    <div class="flex items-center gap-2">
        <i class="fa-solid fa-calendar-days text-leafly-dark"></i>
        <span class="font-bold text-gray-700">Periode:</span>
        <select class="border-gray-300 rounded-lg text-sm focus:ring-leafly-green">
            <option>Bulan Ini (November)</option>
            <option>Bulan Lalu (Oktober)</option>
            <option>Tahun Ini (2025)</option>
        </select>
    </div>
    <div class="flex gap-2">
        <button class="bg-green-600 text-white px-4 py-2 rounded-lg text-sm font-bold hover:bg-green-700 transition flex items-center gap-2">
            <i class="fa-solid fa-file-excel"></i> Excel
        </button>
        <button class="bg-red-600 text-white px-4 py-2 rounded-lg text-sm font-bold hover:bg-red-700 transition flex items-center gap-2">
            <i class="fa-solid fa-file-pdf"></i> PDF
        </button>
    </div>
</div>

<!-- navigasi -->
<div class="mb-6 border-b border-gray-200">
    <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="reportTabs">
        <li class="mr-2">
            <button class="inline-block p-4 border-b-2 rounded-t-lg active-tab border-leafly-dark text-leafly-dark font-bold" onclick="switchTab('sales', this)">
                <i class="fa-solid fa-money-bill-trend-up mr-2"></i> Laporan Penjualan
            </button>
        </li>
        <li class="mr-2">
            <button class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 text-gray-500" onclick="switchTab('purchases', this)">
                <i class="fa-solid fa-cart-flatbed mr-2"></i> Pembelian (Benih & Alat)
            </button>
        </li>
    </ul>
</div>

<!-- laporan pnenjualan -->
<div id="content-sales" class="tab-content animate-fade-in-up">
    
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-leafly-dark text-white p-6 rounded-xl shadow-md">
            <p class="text-sm opacity-80 mb-1">Pendapatan Bersih</p>
            <h3 class="text-2xl font-bold">Rp {{ number_format($salesSummary['income_month'], 0, ',', '.') }}</h3>
            <p class="text-xs mt-2 text-green-300 flex items-center gap-1">
                <i class="fa-solid fa-arrow-trend-up"></i> +{{ $salesSummary['income_growth'] }}% kenaikan
            </p>
        </div>
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <p class="text-sm text-gray-500 mb-1">Total Pesanan</p>
            <h3 class="text-2xl font-bold text-gray-800">{{ $salesSummary['orders_count'] }}</h3>
        </div>
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <p class="text-sm text-gray-500 mb-1">Produk Terjual</p>
            <h3 class="text-2xl font-bold text-gray-800">{{ $salesSummary['products_sold'] }} pcs</h3>
        </div>
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <p class="text-sm text-gray-500 mb-1">Rata-rata Order</p>
            <h3 class="text-2xl font-bold text-gray-800">Rp 30.000</h3>
        </div>
    </div>

    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 mb-8">
        <h3 class="font-bold text-gray-800 mb-4">Grafik Tren Penjualan</h3>
        <canvas id="salesChart" height="100"></canvas>
    </div>

    <!-- tabel riwayat penjualan -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-100">
            <h3 class="font-bold text-gray-800">Transaksi Penjualan Terakhir</h3>
        </div>
        <table class="w-full text-sm text-left text-gray-600">
            <thead class="bg-gray-50 text-gray-700 font-bold uppercase">
                <tr>
                    <th class="px-6 py-3">Tanggal</th>
                    <th class="px-6 py-3">ID Pesanan</th>
                    <th class="px-6 py-3">Pelanggan</th>
                    <th class="px-6 py-3 text-right">Total</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($salesHistory as $sale)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4">{{ $sale['date'] }}</td>
                    <td class="px-6 py-4 font-medium text-leafly-dark">{{ $sale['id'] }}</td>
                    <td class="px-6 py-4">{{ $sale['customer'] }}</td>
                    <td class="px-6 py-4 text-right font-bold">Rp {{ number_format($sale['total'], 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- laporan pembelian -->
<div id="content-purchases" class="tab-content hidden animate-fade-in-up">
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-red-600 text-white p-6 rounded-xl shadow-md">
            <p class="text-sm opacity-80 mb-1">Total Pengeluaran (Benih & Alat)</p>
            <h3 class="text-2xl font-bold">Rp {{ number_format($purchaseSummary['expense_month'], 0, ',', '.') }}</h3>
            <p class="text-xs mt-2 text-red-200">Uang keluar bulan ini</p>
        </div>
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <p class="text-sm text-gray-500 mb-1">Total Item Restock</p>
            <h3 class="text-2xl font-bold text-gray-800">{{ $purchaseSummary['items_restocked'] }} pcs</h3>
        </div>
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <p class="text-sm text-gray-500 mb-1">Pengeluaran Terbesar</p>
            <h3 class="text-lg font-bold text-gray-800">{{ $purchaseSummary['biggest_expense'] }}</h3>
        </div>
    </div>

    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 mb-8">
        <h3 class="font-bold text-gray-800 mb-4">Grafik Pengeluaran Pembelian Stok</h3>
        <canvas id="expenseChart" height="100"></canvas>
    </div>

    <!-- tabel riwayat pembelian -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-100 flex justify-between items-center">
            <h3 class="font-bold text-gray-800">Riwayat Belanja Benih & Alat</h3>
            <button class="text-sm bg-leafly-dark text-white px-3 py-1 rounded hover:bg-leafly-gold hover:text-leafly-dark transition">
                <i class="fa-solid fa-plus mr-1"></i> Catat Pembelian
            </button>
        </div>
        <table class="w-full text-sm text-left text-gray-600">
            <thead class="bg-red-50 text-red-800 font-bold uppercase">
                <tr>
                    <th class="px-6 py-3">Tanggal</th>
                    <th class="px-6 py-3">Nama Barang</th>
                    <th class="px-6 py-3">Kategori</th>
                    <th class="px-6 py-3">Supplier</th>
                    <th class="px-6 py-3 text-right">Biaya</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($purchaseHistory as $purchase)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4">{{ $purchase['date'] }}</td>
                    <td class="px-6 py-4 font-bold text-gray-800">{{ $purchase['item'] }}</td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 rounded text-xs font-bold border 
                            {{ $purchase['category'] == 'Benih' ? 'bg-green-100 text-green-700 border-green-200' : 'bg-gray-100 text-gray-700 border-gray-200' }}">
                            {{ $purchase['category'] }}
                        </span>
                    </td>
                    <td class="px-6 py-4">{{ $purchase['supplier'] }}</td>
                    <td class="px-6 py-4 text-right font-bold text-red-600">Rp {{ number_format($purchase['cost'], 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection

@push('scripts')
<!-- load chart js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    function switchTab(tabName, btn) {
        // Sembunyikan semua konten
        $('.tab-content').addClass('hidden');
        // Tampilkan konten yang dipilih
        $('#content-' + tabName).removeClass('hidden');

        // Reset style tombol
        $('#reportTabs button').removeClass('active-tab border-leafly-dark text-leafly-dark font-bold')
            .addClass('border-transparent text-gray-500 hover:text-gray-600 hover:border-gray-300');
        
        // Set style tombol aktif
        $(btn).removeClass('border-transparent text-gray-500 hover:text-gray-600 hover:border-gray-300')
            .addClass('active-tab border-leafly-dark text-leafly-dark font-bold');
    }


    // === 2. CHART CONFIGURATION ===
    
    // CHART PENJUALAN (HIJAU)
    const ctxSales = document.getElementById('salesChart').getContext('2d');
    new Chart(ctxSales, {
        type: 'line',
        data: {
            labels: {!! json_encode($chartSales['labels']) !!},
            datasets: [{
                label: 'Pemasukan (Rp)',
                data: {!! json_encode($chartSales['data']) !!},
                borderColor: '#225D2D',
                backgroundColor: 'rgba(34, 93, 45, 0.1)',
                borderWidth: 2,
                fill: true,
                tension: 0.3
            }]
        },
        options: { responsive: true, scales: { y: { beginAtZero: true } } }
    });

    // CHART PEMBELIAN (MERAH)
    const ctxExpense = document.getElementById('expenseChart').getContext('2d');
    new Chart(ctxExpense, {
        type: 'bar',
        data: {
            labels: {!! json_encode($chartExpense['labels']) !!},
            datasets: [{
                label: 'Pengeluaran Stok (Rp)',
                data: {!! json_encode($chartExpense['data']) !!},
                backgroundColor: 'rgba(220, 38, 38, 0.7)', // Merah
                borderColor: '#DC2626',
                borderWidth: 1
            }]
        },
        options: { responsive: true, scales: { y: { beginAtZero: true } } }
    });
</script>
@endpush