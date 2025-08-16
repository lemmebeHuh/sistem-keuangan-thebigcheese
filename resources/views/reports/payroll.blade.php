<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Laporan Penggajian') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Form Filter --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium mb-4">Filter Laporan</h3>
                    <form action="{{ route('reports.payroll') }}" method="GET">
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                            <div>
                                <label for="start_date" class="block font-medium text-sm text-gray-700">Tanggal Mulai</label>
                                <input type="date" name="start_date" id="start_date" class="block mt-1 w-full rounded-md shadow-sm border-gray-300" value="{{ $startDate }}" required>
                            </div>
                            <div>
                                <label for="end_date" class="block font-medium text-sm text-gray-700">Tanggal Selesai</label>
                                <input type="date" name="end_date" id="end_date" class="block mt-1 w-full rounded-md shadow-sm border-gray-300" value="{{ $endDate }}" required>
                            </div>
                            <div>
                                <label for="employee_id" class="block font-medium text-sm text-gray-700">Karyawan (Opsional)</label>
                                <select name="employee_id" id="employee_id" class="block mt-1 w-full rounded-md shadow-sm border-gray-300">
                                    <option value="">Semua Karyawan</option>
                                    @foreach($employees as $employee)
                                        <option value="{{ $employee->id }}" @if($employeeId == $employee->id) selected @endif>{{ $employee->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <button type="submit" class="w-full inline-flex items-center justify-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                                    Tampilkan Laporan
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Hasil Laporan --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-4">
                        <div>
                            <h3 class="text-xl font-bold">Laporan Gaji Karyawan</h3>
                            <p class="text-sm text-gray-600">
                                Periode: {{ \Carbon\Carbon::parse($startDate)->format('d M Y') }} - {{ \Carbon\Carbon::parse($endDate)->format('d M Y') }}
                            </p>
                        </div>
                        <button onclick="window.print()" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500">
                            Cetak
                        </button>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 mt-4">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Karyawan</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Catatan</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($payrolls as $payroll)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ \Carbon\Carbon::parse($payroll->payment_date)->format('d M Y') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $payroll->employee->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $payroll->notes }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right font-medium text-red-600">Rp {{ number_format($payroll->amount, 0, ',', '.') }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-4 text-center text-gray-500">Tidak ada data penggajian pada periode ini.</td>
                                </tr>
                                @endforelse
                            </tbody>
                            <tfoot class="bg-gray-50">
                                <tr>
                                    <th colspan="3" class="px-6 py-3 text-right text-sm font-bold text-gray-700 uppercase">Total Gaji Dibayarkan</th>
                                    <th class="px-6 py-3 text-right text-sm font-bold text-gray-700">Rp {{ number_format($totalPayroll, 0, ',', '.') }}</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>