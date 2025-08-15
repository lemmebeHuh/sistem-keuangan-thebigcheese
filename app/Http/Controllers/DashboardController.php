<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Transaction;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $now = Carbon::now();

        // Menghitung total pemasukan bulan ini
        $totalIncome = Transaction::where('user_id', $user->id)
            ->whereHas('category', function ($query) {
                $query->where('type', 'income');
            })
            ->whereYear('transaction_date', $now->year)
            ->whereMonth('transaction_date', $now->month)
            ->sum('amount');

        // Menghitung total pengeluaran bulan ini
        $totalExpense = Transaction::where('user_id', $user->id)
            ->whereHas('category', function ($query) {
                $query->where('type', 'expense');
            })
            ->whereYear('transaction_date', $now->year)
            ->whereMonth('transaction_date', $now->month)
            ->sum('amount');
        
        // Menghitung profit
        $profit = $totalIncome - $totalExpense;

        // Mengirim data ke view
        return view('dashboard', [
            'totalIncome' => $totalIncome,
            'totalExpense' => $totalExpense,
            'profit' => $profit,
        ]);
    }
}