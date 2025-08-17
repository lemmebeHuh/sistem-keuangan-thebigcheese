<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manajemen Kategori') }}
        </h2>
    </x-slot>

    <div class="py-6" x-data="{ editModal: false, category: {} }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- Notifikasi --}}
            @if (session('success'))
                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif
            @if (session('error'))
                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif
            {{-- Form Tambah Kategori --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium mb-4">Tambah Kategori Baru</h3>
                    <form action="{{ route('categories.store') }}" method="POST">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label for="name" class="block font-medium text-sm text-gray-700">Nama Kategori</label>
                                <input type="text" name="name" id="name" class="block mt-1 w-full rounded-md shadow-sm border-gray-300" required>
                            </div>
                            <div>
                                <label for="type" class="block font-medium text-sm text-gray-700">Jenis Kategori</label>
                                <select name="type" id="type" class="block mt-1 w-full rounded-md shadow-sm border-gray-300" required>
                                    <option value="income">Pemasukan</option>
                                    <option value="expense">Pengeluaran</option>
                                </select>
                            </div>
                            <div class="flex items-end">
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                                    Simpan Kategori
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Tabel Daftar Kategori --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium mb-4">Daftar Kategori</h3>
                     <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jenis</th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($categories as $cat)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $cat->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $cat->type == 'income' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                {{ ucfirst($cat->type) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                            <button @click="editModal = true; category = {{ $cat }}" class="text-indigo-600 hover:text-indigo-900">Edit</button>
                                            <form action="{{ route('categories.destroy', $cat) }}" method="POST" class="inline-block ml-4" onsubmit="return confirm('Anda yakin ingin menghapus kategori ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="px-6 py-4 text-center text-gray-500">Belum ada kategori.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    {{-- Link Paginasi --}}
                    <div class="mt-4">
                        {{ $categories->links() }}
                    </div>
                </div>
            </div>
        </div>

        {{-- Modal Edit Kategori --}}
        <div x-show="editModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" @click.away="editModal = false" style="display: none;">
            <div class="bg-white rounded-lg shadow-xl p-6 w-full max-w-lg" @click.stop>
                <h3 class="text-lg font-medium mb-4">Edit Kategori</h3>
                <form :action="`/categories/${category.id}`" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="space-y-4">
                        <div>
                            <label class="block font-medium text-sm text-gray-700">Nama Kategori</label>
                            <input type="text" name="name" class="block mt-1 w-full rounded-md shadow-sm border-gray-300" :value="category.name" required>
                        </div>
                        <div>
                            <label class="block font-medium text-sm text-gray-700">Jenis Kategori</label>
                            <select name="type" class="block mt-1 w-full rounded-md shadow-sm border-gray-300" required>
                                <option value="income" :selected="category.type == 'income'">Pemasukan</option>
                                <option value="expense" :selected="category.type == 'expense'">Pengeluaran</option>
                            </select>
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