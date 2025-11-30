@extends('layouts.admin')

@section('title', 'Laporan Penjualan')
@section('header', 'Analisa & Laporan')

@section('content')

<!-- filter periode -->
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
            <i class="fa-solid fa-file-excel"></i> Export Excel
        </button>
        <button class="bg-red-600 text-white px-4 py-2 rounded-lg text-sm font-bold hover:bg-red-700 transition flex items-center gap-2">
            <i class="fa-solid fa-file-pdf"></i> Export PDF
        </button>
    </div>
</div>

<!-- ringkasan keuangan -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <div class="bg-leafly-dark text-white p-6 rounded-xl shadow-md">
        <p class="text-sm opacity-80 mb-1">Pendapatan Bulan Ini</p>
        <h3 class="text-2xl font-bold">Rp {{ number_format($summary['income_this_month'], 0, ',', '.') }}</h3>
        <p class="text-xs mt-2 text-green-300 flex items-center gap-1">
            <i class="fa-solid fa-arrow-trend-up"></i> +18% dari bulan lalu
        </p>
    </div>
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
        <p class="text-sm text-gray-500 mb-1">Pendapatan Bulan Lalu</p>
        <h3 class="text-2xl font-bold text-gray-800">Rp {{ number_format($summary['income_last_month'], 0, ',', '.') }}</h3>
    </div>
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
        <p class="text-sm text-gray-500 mb-1">Total Pesanan</p>
        <h3 class="text-2xl font-bold text-gray-800">{{ $summary['orders_count'] }}</h3>
    </div>
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
        <p class="text-sm text-gray-500 mb-1">Produk Terjual</p>
        <h3 class="text-2xl font-bold text-gray-800">{{ $summary['products_sold'] }} pcs</h3>
    </div>
</div>

<!-- grafik chart js -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
    <!-- chart penjualan -->
    <div class="lg:col-span-2 bg-white p-6 rounded-xl shadow-sm border border-gray-100">
        <h3 class="font-bold text-gray-800 mb-4">Grafik Penjualan 6 Bulan Terakhir</h3>
        <canvas id="salesChart" height="150"></canvas>
    </div>

    <!-- chart kategori -->
    <div class="lg:col-span-1 bg-white p-6 rounded-xl shadow-sm border border-gray-100">
        <h3 class="font-bold text-gray-800 mb-4">Kategori Terlaris</h3>
        <canvas id="categoryChart" height="200"></canvas>
    </div>
</div>

<!-- tabel detail harian -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="p-6 border-b border-gray-100">
        <h3 class="font-bold text-gray-800">Rincian Harian</h3>
    </div>
    <table class="w-full text-sm text-left text-gray-600">
        <thead class="bg-gray-50 text-gray-700 font-bold uppercase">
            <tr>
                <th class="px-6 py-3">Tanggal</th>
                <th class="px-6 py-3 text-center">Jumlah Pesanan</th>
                <th class="px-6 py-3 text-center">Item Terjual</th>
                <th class="px-6 py-3 text-right">Pendapatan</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @foreach($dailyReports as $day)
            <tr class="hover:bg-gray-50 transition">
                <td class="px-6 py-4 font-medium">{{ $day['date'] }}</td>
                <td class="px-6 py-4 text-center">{{ $day['orders'] }}</td>
                <td class="px-6 py-4 text-center">{{ $day['items'] }}</td>
                <td class="px-6 py-4 text-right font-bold text-leafly-dark">
                    Rp {{ number_format($day['income'], 0, ',', '.') }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // 1. Config Sales Chart (Line)
    const ctxSales = document.getElementById('salesChart').getContext('2d');
    new Chart(ctxSales, {
        type: 'line',
        data: {
            labels: {!! json_encode($chartSales['labels']) !!},
            datasets: [{
                label: 'Pendapatan (Rp)',
                data: {!! json_encode($chartSales['data']) !!},
                borderColor: '#225D2D',
                backgroundColor: 'rgba(34, 93, 45, 0.1)',
                borderWidth: 2,
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: { beginAtZero: true }
            }
        }
    });

    // 2. Config Category Chart (Doughnut)
    const ctxCategory = document.getElementById('categoryChart').getContext('2d');
    new Chart(ctxCategory, {
        type: 'doughnut',
        data: {
            labels: {!! json_encode($chartCategories['labels']) !!},
            datasets: [{
                data: {!! json_encode($chartCategories['data']) !!},
                backgroundColor: [
                    '#225D2D', // Dark
                    '#BADD7F', // Green
                    '#E5BC5F', // Gold
                    '#F7EFDA'  // Cream
                ],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'bottom' }
            }
        }
    });
</script>
@endpush