<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Payroll;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Transaction;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        // Set tanggal default ke bulan ini jika tidak ada input
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->toDateString());
        $endDate = $request->input('end_date', Carbon::now()->endOfMonth()->toDateString());

        $user = Auth::user();

        // Ambil data pemasukan berdasarkan rentang tanggal
        $incomeTransactions = Transaction::where('user_id', $user->id)
            ->whereBetween('transaction_date', [$startDate, $endDate])
            ->whereHas('category', function ($query) {
                $query->where('type', 'income');
            })
            ->with('category')
            ->get()
            ->groupBy('category.name'); // Kelompokkan berdasarkan nama kategori

        // Ambil data pengeluaran berdasarkan rentang tanggal
        $expenseTransactions = Transaction::where('user_id', $user->id)
            ->whereBetween('transaction_date', [$startDate, $endDate])
            ->whereHas('category', function ($query) {
                $query->where('type', 'expense');
            })
            ->with('category')
            ->get()
            ->groupBy('category.name');

        // Hitung total
        $totalIncome = $incomeTransactions->flatten()->sum('amount');
        $totalExpense = $expenseTransactions->flatten()->sum('amount');
        $profit = $totalIncome - $totalExpense;

        return view('reports.index', compact(
            'startDate',
            'endDate',
            'incomeTransactions',
            'expenseTransactions',
            'totalIncome',
            'totalExpense',
            'profit'
        ));
    }

    public function payrollReport(Request $request)
    {
        // Set tanggal default ke bulan ini jika tidak ada input
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->toDateString());
        $endDate = $request->input('end_date', Carbon::now()->endOfMonth()->toDateString());
        $employeeId = $request->input('employee_id');

        // Ambil semua karyawan untuk filter dropdown
        $employees = Employee::where('is_active', true)->orderBy('name')->get();

        // Query dasar untuk payroll
        $payrollQuery = Payroll::with('employee')
            ->whereBetween('payment_date', [$startDate, $endDate]);

        // Terapkan filter karyawan jika dipilih
        if ($employeeId) {
            $payrollQuery->where('employee_id', $employeeId);
        }

        $payrolls = $payrollQuery->latest('payment_date')->get();
        $totalPayroll = $payrolls->sum('amount');

        return view('reports.payroll', compact(
            'startDate',
            'endDate',
            'employeeId',
            'employees',
            'payrolls',
            'totalPayroll'
        ));
    }
}