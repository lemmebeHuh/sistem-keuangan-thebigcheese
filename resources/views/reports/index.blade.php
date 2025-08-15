<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Laporan Laba Rugi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Form Filter Tanggal --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium mb-4">Pilih Periode Laporan</h3>
                    <form action="{{ route('reports.index') }}" method="GET">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
                            <div>
                                <label for="start_date" class="block font-medium text-sm text-gray-700">Tanggal Mulai</label>
                                <input type="date" name="start_date" id="start_date" class="block mt-1 w-full rounded-md shadow-sm border-gray-300" value="{{ $startDate }}" required>
                            </div>
                            <div>
                                <label for="end_date" class="block font-medium text-sm text-gray-700">Tanggal Selesai</label>
                                <input type="date" name="end_date" id="end_date" class="block mt-1 w-full rounded-md shadow-sm border-gray-300" value="{{ $endDate }}" required>
                            </div>
                            <div>
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                                    Tampilkan Laporan
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Hasil Laporan --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg" id="report-section">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-4">
                        <div>
                            <h3 class="text-xl font-bold">Laporan Laba Rugi</h3>
                            <p class="text-sm text-gray-600">
                                Periode: {{ \Carbon\Carbon::parse($startDate)->format('d M Y') }} - {{ \Carbon\Carbon::parse($endDate)->format('d M Y') }}
                            </p>
                        </div>
                        <button onclick="printReport()" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500">
                            Cetak
                        </button>
                    </div>

                    <div class="border-t border-gray-200 mt-4 pt-4">
                        <h4 class="font-semibold text-green-600">PEMASUKAN</h4>
                        <table class="min-w-full mt-2">
                            @forelse ($incomeTransactions as $categoryName => $transactions)
                                <tr>
                                    <td class="py-1 pl-4">{{ $categoryName }}</td>
                                    <td class="py-1 text-right">Rp {{ number_format($transactions->sum('amount'), 0, ',', '.') }}</td>
                                </tr>
                            @empty
                                <tr><td class="py-1 pl-4 text-gray-500 italic">Tidak ada pemasukan</td></tr>
                            @endforelse
                            <tr class="font-bold border-t">
                                <td class="py-2 pl-4">Total Pemasukan</td>
                                <td class="py-2 text-right">Rp {{ number_format($totalIncome, 0, ',', '.') }}</td>
                            </tr>
                        </table>
                    </div>

                    <div class="mt-6 pt-4">
                        <h4 class="font-semibold text-red-600">PENGELUARAN</h4>
                        <table class="min-w-full mt-2">
                            @forelse ($expenseTransactions as $categoryName => $transactions)
                                <tr>
                                    <td class="py-1 pl-4">{{ $categoryName }}</td>
                                    <td class="py-1 text-right">Rp {{ number_format($transactions->sum('amount'), 0, ',', '.') }}</td>
                                </tr>
                            @empty
                                <tr><td class="py-1 pl-4 text-gray-500 italic">Tidak ada pengeluaran</td></tr>
                            @endforelse
                             <tr class="font-bold border-t">
                                <td class="py-2 pl-4">Total Pengeluaran</td>
                                <td class="py-2 text-right">Rp {{ number_format($totalExpense, 0, ',', '.') }}</td>
                            </tr>
                        </table>
                    </div>

                    <div class="border-t-2 border-gray-800 mt-6 pt-4 text-right">
                        <span class="font-bold text-lg">PROFIT BERSIH:</span>
                        <span class="font-bold text-lg ml-4 text-blue-700">Rp {{ number_format($profit, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function printReport() {
            window.print();
        }
    </script>
</x-app-layout>