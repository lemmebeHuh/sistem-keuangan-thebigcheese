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
            margin: 1cm; /* Memperkecil margin kertas agar ruang lebih luas */
        }
        body {
            font-family: 'Figtree', sans-serif;
            -webkit-print-color-adjust: exact;
        }
        /* Mengatur font standar lebih kecil untuk print */
        .print-text-sm {
            font-size: 0.75rem; /* Ukuran teks umum */
        }
        .print-text-base {
            font-size: 0.875rem; /* Ukuran judul/header tabel */
        }
    </style>
</head>
<body onload="window.print()" onafterprint="window.close()" class="print-text-sm">
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

    <div class="px-6 py-4 text-gray-900">
        <div class="mb-4 text-center">
            <h3 class="text-lg font-bold underline">LAPORAN LABA RUGI</h3>
            <p class="text-xs text-gray-600">
                Periode: {{ \Carbon\Carbon::parse($startDate)->format('d M Y') }} - {{ \Carbon\Carbon::parse($endDate)->format('d M Y') }}
            </p>
        </div>
        
        <div class="border-t border-gray-200 pt-2">
            <h4 class="font-semibold text-green-600 print-text-base uppercase">1. PEMASUKAN OPERASIONAL</h4>
            <table class="min-w-full mt-1">
                @forelse ($incomeTransactions as $categoryName => $transactions)
                    <tr>
                        <td class="py-0.5 pl-4">{{ $categoryName }}</td>
                        <td class="py-0.5 text-right">Rp {{ number_format($transactions->sum('amount'), 0, ',', '.') }}</td>
                    </tr>
                @empty
                    <tr><td class="py-0.5 pl-4 text-gray-500 italic">Tidak ada pemasukan</td></tr>
                @endforelse
                <tr class="font-bold border-t border-gray-100">
                    <td class="py-1 pl-4">Total Pemasukan</td>
                    <td class="py-1 text-right">Rp {{ number_format($totalIncome, 0, ',', '.') }}</td>
                </tr>
            </table>
        </div>

        <div class="mt-4 border-t border-gray-200 pt-2">
            <h4 class="font-semibold text-red-600 print-text-base uppercase">2. PENGELUARAN OPERASIONAL</h4>
            <table class="min-w-full mt-1">
                @forelse ($expenseTransactions as $categoryName => $transactions)
                    <tr>
                        <td class="py-0.5 pl-4">{{ $categoryName }}</td>
                        <td class="py-0.5 text-right">Rp {{ number_format($transactions->sum('amount'), 0, ',', '.') }}</td>
                    </tr>
                @empty
                @endforelse
                @if($totalPayroll > 0)
                <tr>
                    <td class="py-0.5 pl-4">Biaya Gaji Karyawan</td>
                    <td class="py-0.5 text-right">Rp {{ number_format($totalPayroll, 0, ',', '.') }}</td>
                </tr>
                @endif
                 <tr class="font-bold border-t border-gray-100">
                    <td class="py-1 pl-4">Total Pengeluaran</td>
                    <td class="py-1 text-right text-red-600">Rp {{ number_format($totalExpense, 0, ',', '.') }}</td>
                </tr>
            </table>
        </div>

        <div class="border-t-2 border-gray-800 mt-4 py-2 flex justify-between items-center">
            <span class="font-bold print-text-base">PROFIT BERSIH (Earning After Tax):</span>
            <span class="font-bold text-lg text-blue-700">Rp {{ number_format($profit, 0, ',', '.') }}</span>
        </div>

        {{-- REVISI: PERUBAHAN MODAL (DIBUAT LEBIH RINGKAS) --}}
        <div class="mt-4 border-t-2 border-dashed border-gray-300 pt-2 bg-gray-50 p-2 rounded">
            <h4 class="text-center font-bold text-gray-700 underline mb-2">LAPORAN PERUBAHAN MODAL</h4>
            <table class="min-w-full text-xs">
                <tr>
                    <td class="py-0.5">Modal Disetor (Owner Equity)</td>
                    <td class="py-0.5 text-right">Rp {{ number_format($totalCapital, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td class="py-0.5">Laba Bersih Periode Ini</td>
                    <td class="py-0.5 text-right text-blue-600">+ Rp {{ number_format($profit, 0, ',', '.') }}</td>
                </tr>
                <tr class="font-bold border-t border-gray-400">
                    <td class="py-1 text-sm uppercase">Modal Akhir Per {{ \Carbon\Carbon::parse($endDate)->format('d M Y') }}</td>
                    <td class="py-1 text-right text-sm">Rp {{ number_format($totalCapital + $profit, 0, ',', '.') }}</td>
                </tr>
            </table>
        </div>
    </div>

    {{-- FOOTER - DIPERECIL --}}
    <div class="px-6 py-2 border-t border-gray-300 mt-4 text-[10px] text-gray-500 flex justify-between italic">
        <span>Dicetak oleh: {{ Auth::user()->name }}</span>
        <span>Tanggal Cetak: {{ now()->format('d M Y, H:i') }}</span>
    </div>
</body>
</html>