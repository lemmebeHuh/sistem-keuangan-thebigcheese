<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("Selamat Datang Kembali,") }} {{ Auth::user()->name }}!
                </div>
            </div>

            {{-- Mulai bagian Ringkasan Keuangan --}}
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
            {{-- Selesai bagian Ringkasan Keuangan --}}


            {{-- Mulai bagian Grafik --}}
            <div class="mt-8 grid grid-cols-1 lg:grid-cols-2 gap-8">
                {{-- Grafik Garis --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900">Tren Keuangan (30 Hari Terakhir)</h3>
                        <canvas id="lineChart" class="mt-4"></canvas>
                    </div>
                </div>

                {{-- Grafik Lingkaran --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900">Komposisi Pengeluaran (Bulan Ini)</h3>
                        <canvas id="pieChart" class="mt-4"></canvas>
                    </div>
                </div>
            </div>
            {{-- Selesai bagian Grafik --}}

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