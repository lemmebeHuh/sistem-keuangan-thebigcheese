<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-6">
        {{-- PERUBAHAN DI SINI: Menambahkan 'px-4' untuk padding di layar mobile --}}
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("Selamat Datang Kembali,") }} {{ Auth::user()->name }}!
                </div>
            </div>
            <div class="mt-6">
    <form method="GET" action="{{ route('dashboard') }}" class="bg-white p-4 shadow-sm sm:rounded-lg flex items-center gap-4">
        <div>
            <label for="start_date" class="block text-sm font-medium text-gray-700">Mulai Tanggal</label>
            <input type="date" name="start_date" id="start_date" 
                   value="{{ request('start_date', $startDate->format('Y-m-d')) }}" 
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
        </div>
        <div>
            <label for="end_date" class="block text-sm font-medium text-gray-700">Sampai Tanggal</label>
            <input type="date" name="end_date" id="end_date" 
                   value="{{ request('end_date', $endDate->format('Y-m-d')) }}" 
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
        </div>
        <div class="pt-5">
            <x-primary-button type="submit">Filter</x-primary-button>
        </div>
    </form>
</div>
            {{-- Bagian Ringkasan Keuangan (Sudah Responsif) --}}
            {{-- Layout ini akan menjadi 1 kolom di mobile dan 3 kolom di desktop --}}
            <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-500">Pemasukan (Bulan Ini)</h3>
                        <p class="mt-1 text-3xl font-semibold text-green-600">
                            Rp {{ number_format($totalIncome, 0, ',', '.') }}
                        </p>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-500">Pengeluaran (Bulan Ini)</h3>
                        <p class="mt-1 text-3xl font-semibold text-red-600">
                            Rp {{ number_format($totalExpense, 0, ',', '.') }}
                        </p>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-500">Profit (Bulan Ini)</h3>
                        <p class="mt-1 text-3xl font-semibold text-blue-600">
                            Rp {{ number_format($profit, 0, ',', '.') }}
                        </p>
                    </div>
                </div>
            </div>

            {{-- Bagian Grafik (Sudah Responsif) --}}
            {{-- Layout ini akan menjadi 1 kolom di mobile dan 2 kolom di desktop --}}
            <div class="mt-8 grid grid-cols-1 lg:grid-cols-2 gap-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900">Tren Keuangan (30 Hari Terakhir)</h3>
                        <canvas id="lineChart" class="mt-4"></canvas>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900">Komposisi Pengeluaran (Bulan Ini)</h3>
                        <canvas id="pieChart" class="mt-4"></canvas>
                    </div>
                </div>
            </div>
            <div class="mt-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900">Aktivitas Transaksi Terkini</h3>
                    <div class="mt-4 flow-root">
                        <ul role="list" class="-my-5 divide-y divide-gray-200">
                            {{-- Loop data transaksi --}}
                            @forelse ($recentTransactions as $transaction)
                                <li class="py-4">
                                    <div class="flex items-center space-x-4">
                                        <div class="flex-shrink-0">
                                            {{-- Tampilkan ikon berdasarkan Tipe Kategori --}}
                                            @if ($transaction->category->type == 'income')
                                                <svg class="h-6 w-6 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                            @else
                                                <svg class="h-6 w-6 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                            @endif
                                        </div>
                                        <div class="min-w-0 flex-1">
                                            <p class="truncate text-sm font-medium text-gray-900">{{ $transaction->description ?? 'Transaksi' }}</p>
                                            <p class="truncate text-sm text-gray-500">
                                                {{ $transaction->category->name }} | {{ $transaction->transaction_date->format('d M Y') }}
                                            </p>
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium {{ $transaction->category->type == 'income' ? 'text-green-600' : 'text-red-600' }}">
                                                {{ $transaction->category->type == 'income' ? '+' : '-' }}
                                                Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                                            </p>
                                        </div>
                                    </div>
                                </li>
                            @empty
                                {{-- Tampilkan ini jika tidak ada transaksi --}}
                                <li class="py-4 text-sm text-gray-500 text-center">
                                    Belum ada transaksi.
                                </li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        {{-- AKHIR BAGIAN BARU --}}

    </div>
        </div>
    </div>

    {{-- Script untuk Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Data dari Controller
        const lineLabels = @json($lineChartLabels);
        const lineIncomeData = @json($lineChartIncome);
        const lineExpenseData = @json($lineChartExpense);

        const pieLabels = @json($pieChartLabels);
        const pieValues = @json($pieChartValues);

        // Grafik Garis (Line Chart)
        const lineCtx = document.getElementById('lineChart').getContext('2d');
        new Chart(lineCtx, {
            type: 'line',
            data: {
                labels: lineLabels,
                datasets: [{
                    label: 'Pemasukan',
                    data: lineIncomeData,
                    borderColor: 'rgba(75, 192, 192, 1)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    tension: 0.1
                }, {
                    label: 'Pengeluaran',
                    data: lineExpenseData,
                    borderColor: 'rgba(255, 99, 132, 1)',
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    tension: 0.1
                }]
            }
        });

        // Grafik Lingkaran (Pie Chart)
        const pieCtx = document.getElementById('pieChart').getContext('2d');
        new Chart(pieCtx, {
            type: 'pie',
            data: {
                labels: pieLabels,
                datasets: [{
                    label: 'Pengeluaran',
                    data: pieValues,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.8)',
                        'rgba(54, 162, 235, 0.8)',
                        'rgba(255, 206, 86, 0.8)',
                        'rgba(75, 192, 192, 0.8)',
                        'rgba(153, 102, 255, 0.8)',
                        'rgba(255, 159, 64, 0.8)'
                    ],
                    hoverOffset: 4
                }]
            }
        });
    </script>
</x-app-layout> 