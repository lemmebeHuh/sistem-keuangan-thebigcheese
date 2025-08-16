<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manajemen Karyawan & Penggajian') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
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
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @forelse($payrolls as $payroll)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ \Carbon\Carbon::parse($payroll->payment_date)->format('d M Y') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $payroll->employee->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right font-medium text-red-600">Rp {{ number_format($payroll->amount, 0, ',', '.') }}</td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="3" class="px-6 py-4 text-center text-gray-500">Belum ada riwayat penggajian.</td>
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
    </div>
</x-app-layout>