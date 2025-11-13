<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manajemen Transaksi') }}
        </h2>
    </x-slot>

    <div class="py-6" x-data="{ editModal: false, transaction: {} }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- Notifikasi --}}
            @if (session('success'))
                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif
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

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
            <div class="p-6 text-gray-900">
                <form method="GET" action="{{ route('transactions.index') }}">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">

        {{-- Search input --}}
        <div class="md:col-span-2">
            <label for="search" class="block font-medium text-sm text-gray-700">Cari (Ket/Kategori)</label>
            <input type="text" name="search" id="search" 
                   class="block mt-1 w-full rounded-md shadow-sm border-gray-300" 
                   placeholder="Ketik keterangan atau kategori..."
                   value="{{ request('search') }}">
        </div>

        {{-- Start Date --}}
        <div>
            <label for="start_date" class="block font-medium text-sm text-gray-700">Mulai Tanggal</label>
            <input type="date" name="start_date" id="start_date" 
                   class="block mt-1 w-full rounded-md shadow-sm border-gray-300" 
                   value="{{ request('start_date') }}">
        </div>

        {{-- End Date --}}
        <div>
            <label for="end_date" class="block font-medium text-sm text-gray-700">Sampai Tanggal</label>
            <input type="date" name="end_date" id="end_date" 
                   class="block mt-1 w-full rounded-md shadow-sm border-gray-300" 
                   value="{{ request('end_date') }}">
        </div>

    </div>

    {{-- Buttons --}}
    <div class="mt-4 flex items-center gap-2">
        <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
            Filter
        </button>

        {{-- Tombol Reset: sekarang cek semua filter --}}
        @if(request('search') || request('start_date') || request('end_date'))
            <a href="{{ route('transactions.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50">
                Reset
            </a>
        @endif
    </div>
</form>
            </div>
        </div>
        {{-- AKHIR BAGIAN BARU --}}
            {{-- Tabel Riwayat Transaksi --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium mb-4">Riwayat Transaksi</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kategori</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Keterangan</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah</th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($transactions as $tx)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ \Carbon\Carbon::parse($tx->transaction_date)->format('d M Y') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $tx->category->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $tx->description }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right font-medium {{ $tx->category->type == 'income' ? 'text-green-600' : 'text-red-600' }}">
                                            Rp {{ number_format($tx->amount, 0, ',', '.') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                            <button @click="editModal = true; transaction = {{ $tx }}" class="text-indigo-600 hover:text-indigo-900">Edit</button>
                                            <form action="{{ route('transactions.destroy', $tx) }}" method="POST" class="inline-block ml-4" onsubmit="return confirm('Anda yakin ingin menghapus transaksi ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">Belum ada transaksi.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    {{-- Link Paginasi --}}
                    <div class="mt-4">
                        {{ $transactions->withQueryString()->links() }}
                    </div>
                </div>
            </div>
        </div>

        {{-- Modal Edit --}}
        <div x-show="editModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" @click.away="editModal = false">
            <div class="bg-white rounded-lg shadow-xl p-6 w-full max-w-2xl" @click.stop>
                <h3 class="text-lg font-medium mb-4">Edit Transaksi</h3>
                <form :action="`/transactions/${transaction.id}`" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block font-medium text-sm text-gray-700">Tanggal</label>
                            <input type="date" name="transaction_date" class="block mt-1 w-full rounded-md shadow-sm border-gray-300" :value="transaction.transaction_date" required>
                        </div>
                        <div>
                            <label class="block font-medium text-sm text-gray-700">Kategori</label>
                            <select name="category_id" class="block mt-1 w-full rounded-md shadow-sm border-gray-300" required>
                                <optgroup label="Pemasukan">
                                    @foreach ($incomeCategories as $category)
                                        <option value="{{ $category->id }}" :selected="transaction.category_id == {{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </optgroup>
                                <optgroup label="Pengeluaran">
                                    @foreach ($expenseCategories as $category)
                                        <option value="{{ $category->id }}" :selected="transaction.category_id == {{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </optgroup>
                            </select>
                        </div>
                        <div>
                            <label class="block font-medium text-sm text-gray-700">Jumlah (Rp)</label>
                            <input type="number" name="amount" step="100" class="block mt-1 w-full rounded-md shadow-sm border-gray-300" :value="parseFloat(transaction.amount)" required>
                        </div>
                        <div>
                            <label class="block font-medium text-sm text-gray-700">Keterangan</label>
                            <input type="text" name="description" class="block mt-1 w-full rounded-md shadow-sm border-gray-300" :value="transaction.description">
                        </div>
                    </div>
                    <div class="mt-6 flex justify-end">
                        <button type="button" @click="editModal = false" class="mr-4 inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50">Batal</button>
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>