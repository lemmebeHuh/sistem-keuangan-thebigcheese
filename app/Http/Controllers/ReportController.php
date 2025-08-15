<?php

namespace App\Http\Controllers;

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
}