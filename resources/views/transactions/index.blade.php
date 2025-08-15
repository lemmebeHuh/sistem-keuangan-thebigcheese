<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manajemen Transaksi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Form Tambah Transaksi --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium mb-4">Catat Transaksi Baru</h3>
                    <form action="{{ route('transactions.store') }}" method="POST">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            <div>
                                <label for="transaction_date" class="block font-medium text-sm text-gray-700">Tanggal</label>
                                <input type="date" name="transaction_date" id="transaction_date" class="block mt-1 w-full rounded-md shadow-sm border-gray-300" value="{{ date('Y-m-d') }}" required>
                            </div>
                            <div>
                                <label for="category_id" class="block font-medium text-sm text-gray-700">Kategori</label>
                                <select name="category_id" id="category_id" class="block mt-1 w-full rounded-md shadow-sm border-gray-300" required>
                                    <option value="">Pilih Kategori</option>
                                    <optgroup label="Pemasukan">
                                        @foreach ($incomeCategories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </optgroup>
                                    <optgroup label="Pengeluaran">
                                        @foreach ($expenseCategories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </optgroup>
                                </select>
                            </div>
                            <div>
                                <label for="amount" class="block font-medium text-sm text-gray-700">Jumlah (Rp)</label>
                                <input type="number" name="amount" id="amount" step="100" class="block mt-1 w-full rounded-md shadow-sm border-gray-300" required>
                            </div>
                            <div>
                                <label for="description" class="block font-medium text-sm text-gray-700">Keterangan</label>
                                <input type="text" name="description" id="description" class="block mt-1 w-full rounded-md shadow-sm border-gray-300">
                            </div>
                        </div>
                        <div class="mt-4">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                                Simpan Transaksi
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Tabel Riwayat Transaksi --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium mb-4">Riwayat Transaksi</h3>
                    <table class="min-w-full divide-y divide-gray-200">
                         <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kategori</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Keterangan</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($transactions as $transaction)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ \Carbon\Carbon::parse($transaction->transaction_date)->format('d M Y') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $transaction->category->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $transaction->description }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right font-medium {{ $transaction->category->type == 'income' ? 'text-green-600' : 'text-red-600' }}">
                                        Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-4 text-center text-gray-500">Belum ada transaksi.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>