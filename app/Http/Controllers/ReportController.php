<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Payroll;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ReportController extends Controller
{
    /**
     * Menampilkan Dashboard Laporan (Langkah 5)
     */
    public function index(Request $request)
    {
        // Set tanggal default ke bulan ini jika tidak ada input
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->toDateString());
        $endDate = $request->input('end_date', Carbon::now()->endOfMonth()->toDateString());

        $user = Auth::user();

        // 1. HITUNG TOTAL MODAL (Equity)
        // Mengambil semua transaksi pemasukan yang mengandung kata 'Modal' di nama kategorinya
        $totalCapital = Transaction::where('user_id', $user->id)
            ->whereHas('category', function ($query) {
                $query->where('name', 'like', '%Modal%');
            })
            ->sum('amount');

        // 2. AMBIL PEMASUKAN OPERASIONAL (Penjualan saja, Tanpa Modal)
        // Penting: Modal tidak boleh dihitung sebagai Laba agar perhitungan untung/rugi akurat
        $incomeTransactions = Transaction::where('user_id', $user->id)
            ->whereBetween('transaction_date', [$startDate, $endDate])
            ->whereHas('category', function ($query) {
                $query->where('type', 'income')
                      ->where('name', 'not like', '%Modal%'); 
            })
            ->with('category')
            ->get()
            ->groupBy('category.name');

        // 3. AMBIL PENGELUARAN (Expense)
        $expenseTransactions = Transaction::where('user_id', $user->id)
            ->whereBetween('transaction_date', [$startDate, $endDate])
            ->whereHas('category', function ($query) {
                $query->where('type', 'expense');
            })
            ->with('category')
            ->get()
            ->groupBy('category.name');

        // 4. HITUNG TOTAL GAJI (Dari tabel Payrolls)
        $totalPayroll = Payroll::whereBetween('payment_date', [$startDate, $endDate])->sum('amount');

        // 5. PERHITUNGAN AKHIR
        $totalIncome = $incomeTransactions->flatten()->sum('amount');
        $totalExpenseFromTransactions = $expenseTransactions->flatten()->sum('amount');
        
        $totalExpense = $totalExpenseFromTransactions + $totalPayroll;
        
        // Laba/Rugi Bersih
        $profit = $totalIncome - $totalExpense;
        
        // Modal Akhir = Semua Modal yang disetor + Laba/Rugi saat ini
        $finalEquity = $totalCapital + $profit;

        return view('reports.index', compact(
            'startDate',
            'endDate',
            'incomeTransactions',
            'expenseTransactions',
            'totalIncome',
            'totalExpense',
            'profit',
            'totalPayroll',
            'totalCapital',
            'finalEquity'
        ));
    }

    /**
     * Laporan Penggajian Karyawan
     */
    public function payrollReport(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->toDateString());
        $endDate = $request->input('end_date', Carbon::now()->endOfMonth()->toDateString());
        $employeeId = $request->input('employee_id');

        $employees = Employee::where('is_active', true)->orderBy('name')->get();

        $payrollQuery = Payroll::with('employee')
            ->whereBetween('payment_date', [$startDate, $endDate]);

        if ($employeeId) {
            $payrollQuery->where('employee_id', $employeeId);
        }

        $payrolls = $payrollQuery->latest('payment_date')->get();
        $totalPayroll = $payrolls->sum('amount');

        return view('reports.payroll', compact(
            'startDate', 'endDate', 'employeeId', 'employees', 'payrolls', 'totalPayroll'
        ));
    }

    /**
     * Cetak Laporan Laba Rugi & Perubahan Modal
     */
    public function printLabaRugi(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->toDateString());
        $endDate = $request->input('end_date', Carbon::now()->endOfMonth()->toDateString());
        $user = Auth::user();

        // Ambil Modal
        $totalCapital = Transaction::where('user_id', $user->id)
            ->whereHas('category', function ($query) { $query->where('name', 'like', '%Modal%'); })
            ->sum('amount');

        // Ambil Income (Tanpa Modal)
        $incomeTransactions = Transaction::where('user_id', $user->id)
            ->whereBetween('transaction_date', [$startDate, $endDate])
            ->whereHas('category', function ($query) { 
                $query->where('type', 'income')->where('name', 'not like', '%Modal%'); 
            })
            ->with('category')->get()->groupBy('category.name');

        // Ambil Expense
        $expenseTransactions = Transaction::where('user_id', $user->id)
            ->whereBetween('transaction_date', [$startDate, $endDate])
            ->whereHas('category', function ($query) { $query->where('type', 'expense'); })
            ->with('category')->get()->groupBy('category.name');
            
        $totalPayroll = Payroll::whereBetween('payment_date', [$startDate, $endDate])->sum('amount');
        
        $totalIncome = $incomeTransactions->flatten()->sum('amount');
        $totalExpense = $expenseTransactions->flatten()->sum('amount') + $totalPayroll;
        $profit = $totalIncome - $totalExpense;

        return view('reports.print-laba-rugi', compact(
            'startDate', 'endDate', 'incomeTransactions', 'expenseTransactions',
            'totalIncome', 'totalExpense', 'profit', 'totalPayroll', 'totalCapital'
        ));
    }
}