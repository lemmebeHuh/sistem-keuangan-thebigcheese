<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Laporan Laba Rugi - {{ config('app.name') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600,700&display=swap" rel="stylesheet" />
    <style>
        @page {
            margin: 1.5cm;
        }
        body {
            font-family: 'Figtree', sans-serif;
        }
    </style>
</head>
<body onload="window.print()" onafterprint="window.close()">
    <div class="p-6 border-b-2 border-gray-800">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">{{ config('app.name', 'The Big Cheese') }}</h1>
                <p class="text-sm text-gray-600">Jalan Telekomunikasi No. 1, Terusan Buahbatu</p>
                <p class="text-sm text-gray-600">Bandung, Jawa Barat, 40257</p>
            </div>
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-20 w-20 rounded-full">
        </div>
    </div>

    <div class="p-6 text-gray-900">
        <div class="mb-6 text-center">
            <h3 class="text-xl font-bold underline">LAPORAN LABA RUGI</h3>
            <p class="text-sm text-gray-600">
                Periode: {{ \Carbon\Carbon::parse($startDate)->format('d M Y') }} - {{ \Carbon\Carbon::parse($endDate)->format('d M Y') }}
            </p>
        </div>
        
        <!-- Tabel Laporan -->
        <div class="border-t border-gray-200 pt-4">
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
                @endforelse
                @if($totalPayroll > 0)
                <tr>
                    <td class="py-1 pl-4">Biaya Gaji Karyawan</td>
                    <td class="py-1 text-right">Rp {{ number_format($totalPayroll, 0, ',', '.') }}</td>
                </tr>
                @endif
                @if($totalExpense == 0)
                    <tr><td class="py-1 pl-4 text-gray-500 italic">Tidak ada pengeluaran</td></tr>
                @endif
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

    <div class="p-6 border-t border-gray-300 mt-4 text-sm text-gray-500 absolute bottom-0 w-full">
        <div class="flex justify-between">
            <span>Dicetak oleh: {{ Auth::user()->name }}</span>
            <span>Tanggal Cetak: {{ now()->format('d M Y, H:i') }}</span>
        </div>
    </div>
</body>
</html>