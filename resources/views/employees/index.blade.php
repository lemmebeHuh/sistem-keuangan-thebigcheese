<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manajemen Karyawan & Penggajian') }}
        </h2>
    </x-slot>

    <div class="py-6"  x-data="{ editModal: false, payroll: {} }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- Notifikasi --}}
            @if (session('success'))
                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                {{-- Kolom Kiri: Form --}}
                <div class="lg:col-span-1 space-y-6">
                    {{-- Form Tambah Karyawan --}}
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900">
                            <h3 class="text-lg font-medium mb-4">Tambah Karyawan Baru</h3>
                            <form action="{{ route('employees.store') }}" method="POST" class="space-y-4">
                                @csrf
                                <div>
                                    <label for="name" class="block font-medium text-sm text-gray-700">Nama Lengkap</label>
                                    <input type="text" name="name" class="block mt-1 w-full rounded-md shadow-sm border-gray-300" required>
                                </div>
                                <div>
                                    <label for="position" class="block font-medium text-sm text-gray-700">Posisi</label>
                                    <input type="text" name="position" class="block mt-1 w-full rounded-md shadow-sm border-gray-300">
                                </div>
                                <div>
                                    <label for="joined_date" class="block font-medium text-sm text-gray-700">Tanggal Bergabung</label>
                                    <input type="date" name="joined_date" class="block mt-1 w-full rounded-md shadow-sm border-gray-300" value="{{ date('Y-m-d') }}" required>
                                </div>
                                <button type="submit" class="w-full inline-flex items-center justify-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">Simpan Karyawan</button>
                            </form>
                        </div>
                    </div>

                    {{-- Form Catat Gaji --}}
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900">
                            <h3 class="text-lg font-medium mb-4">Catat Pembayaran Gaji</h3>
                            <form action="{{ route('payrolls.store') }}" method="POST" class="space-y-4">
                                @csrf
                                <div>
                                    <label for="employee_id" class="block font-medium text-sm text-gray-700">Pilih Karyawan</label>
                                    <select name="employee_id" class="block mt-1 w-full rounded-md shadow-sm border-gray-300" required>
                                        <option value="">-- Pilih Karyawan --</option>
                                        @foreach($employees as $employee)
                                            <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label for="amount" class="block font-medium text-sm text-gray-700">Jumlah Gaji (Rp)</label>
                                    <input type="number" name="amount" step="100" class="block mt-1 w-full rounded-md shadow-sm border-gray-300" required>
                                </div>
                                <div>
                                    <label for="payment_date" class="block font-medium text-sm text-gray-700">Tanggal Pembayaran</label>
                                    <input type="date" name="payment_date" class="block mt-1 w-full rounded-md shadow-sm border-gray-300" value="{{ date('Y-m-d') }}" required>
                                </div>
                                <div>
                                    <label for="notes" class="block font-medium text-sm text-gray-700">Catatan</label>
                                    <textarea name="notes" rows="2" class="block mt-1 w-full rounded-md shadow-sm border-gray-300"></textarea>
                                </div>
                                <button type="submit" class="w-full inline-flex items-center justify-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500">Catat Gaji</button>
                            </form>
                        </div>
                    </div>
                </div>

                {{-- Kolom Kanan: Riwayat Penggajian --}}
                <div class="lg:col-span-2 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h3 class="text-lg font-medium mb-4">Riwayat Penggajian</h3>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Karyawan</th>
                                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah</th>
                                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @forelse($payrolls as $pr)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ \Carbon\Carbon::parse($pr->payment_date)->format('d M Y') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $pr->employee->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right font-medium text-black-600">Rp {{ number_format($pr->amount, 0, ',', '.') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                            <button @click="editModal = true; payroll = {{ $pr }}" class="text-indigo-600 hover:text-indigo-900">Edit</button>
                                            <form action="{{ route('payrolls.destroy', $pr) }}" method="POST" class="inline-block ml-4" onsubmit="return confirm('Anda yakin ingin menghapus data gaji ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-4 text-center text-gray-500">Belum ada riwayat penggajian.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-4">
                            {{ $payrolls->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Modal Edit Gaji --}}
        <div x-show="editModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" @click.away="editModal = false" style="display: none;">
            <div class="bg-white rounded-lg shadow-xl p-6 w-full max-w-lg" @click.stop>
                <h3 class="text-lg font-medium mb-4">Edit Data Gaji</h3>
                <form :action="`/payrolls/${payroll.id}`" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')
                    <div>
                        <label class="block font-medium text-sm text-gray-700">Pilih Karyawan</label>
                        <select name="employee_id" class="block mt-1 w-full rounded-md shadow-sm border-gray-300" required>
                            @foreach($employees as $employee)
                                <option value="{{ $employee->id }}" :selected="payroll.employee_id == {{ $employee->id }}">{{ $employee->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block font-medium text-sm text-gray-700">Jumlah Gaji (Rp)</label>
                        <input type="number" name="amount" step="100" class="block mt-1 w-full rounded-md shadow-sm border-gray-300" :value="parseFloat(payroll.amount)" required>
                    </div>
                    <div>
                        <label class="block font-medium text-sm text-gray-700">Tanggal Pembayaran</label>
                        <input type="date" name="payment_date" class="block mt-1 w-full rounded-md shadow-sm border-gray-300" :value="payroll.payment_date" required>
                    </div>
                    <div>
                        <label class="block font-medium text-sm text-gray-700">Catatan</label>
                        <textarea name="notes" rows="2" class="block mt-1 w-full rounded-md shadow-sm border-gray-300" x-text="payroll.notes"></textarea>
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