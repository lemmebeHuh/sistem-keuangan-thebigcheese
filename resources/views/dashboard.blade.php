<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("Selamat Datang Kembali,") }} {{ Auth::user()->name }}!
                </div>
            </div>

            {{-- Mulai bagian Ringkasan Keuangan --}}
            <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-6">
                {{-- Card Pemasukan --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-500">Pemasukan (Bulan Ini)</h3>
                        <p class="mt-1 text-3xl font-semibold text-green-600">
                            Rp {{ number_format($totalIncome, 0, ',', '.') }}
                        </p>
                    </div>
                </div>

                {{-- Card Pengeluaran --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-500">Pengeluaran (Bulan Ini)</h3>
                        <p class="mt-1 text-3xl font-semibold text-red-600">
                            Rp {{ number_format($totalExpense, 0, ',', '.') }}
                        </p>
                    </div>
                </div>

                {{-- Card Profit --}}
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


            {{-- Mulai bagian Grafik (Placeholder) --}}
            <div class="mt-8 grid grid-cols-1 lg:grid-cols-2 gap-8">
                {{-- Placeholder Grafik Garis --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900">Grafik Pendapatan vs Pengeluaran</h3>
                        <div class="mt-4 h-64 bg-gray-200 rounded-lg flex items-center justify-center">
                            <span class="text-gray-500">[Area Grafik Garis Akan Tampil di Sini]</span>
                        </div>
                    </div>
                </div>

                {{-- Placeholder Grafik Lingkaran --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900">Komposisi Pengeluaran</h3>
                        <div class="mt-4 h-64 bg-gray-200 rounded-lg flex items-center justify-center">
                            <span class="text-gray-500">[Area Grafik Lingkaran Akan Tampil di Sini]</span>
                        </div>
                    </div>
                </div>
            </div>
            {{-- Selesai bagian Grafik (Placeholder) --}}

        </div>
    </div>
</x-app-layout>