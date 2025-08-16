<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Transaction;
use App\Models\Category;
use App\Models\Payroll;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $now = Carbon::now();

        // --- Perhitungan untuk Ringkasan (Tetap Sama) ---
        $totalIncome = Transaction::where('user_id', $user->id)
            ->whereHas('category', function ($query) {
                $query->where('type', 'income');
            })
            ->whereYear('transaction_date', $now->year)
            ->whereMonth('transaction_date', $now->month)
            ->sum('amount');

        $totalExpense = Transaction::where('user_id', $user->id)
            ->whereHas('category', function ($query) {
                $query->where('type', 'expense');
            })
            ->whereYear('transaction_date', $now->year)
            ->whereMonth('transaction_date', $now->month)
            ->sum('amount');
        
        $profit = $totalIncome - $totalExpense;

        // --- PERSIAPAN DATA UNTUK GRAFIK ---

        // 1. Ambil pengeluaran dari tabel transactions
        $totalExpenseFromTransactions = Transaction::where('user_id', $user->id)
            ->whereHas('category', function ($query) {
                $query->where('type', 'expense');
            })
            ->whereYear('transaction_date', $now->year)
            ->whereMonth('transaction_date', $now->month)
            ->sum('amount');
        
        // 2. Ambil pengeluaran gaji dari tabel payrolls
        $totalPayroll = Payroll::whereYear('payment_date', $now->year)
            ->whereMonth('payment_date', $now->month)
            ->sum('amount');

        // 3. Gabungkan kedua pengeluaran
        $totalExpense = $totalExpenseFromTransactions + $totalPayroll;
        
        $profit = $totalIncome - $totalExpense;

        // --- PERSIAPAN DATA UNTUK GRAFIK ---

        // 1. Data untuk Grafik Garis (Line Chart) - (Tidak ada perubahan signifikan)
        $lineChartData = Transaction::where('user_id', $user->id)
            ->where('transaction_date', '>=', Carbon::now()->subDays(30))
            ->select(
                DB::raw('DATE(transaction_date) as date'),
                DB::raw('SUM(CASE WHEN categories.type = "income" THEN amount ELSE 0 END) as total_income'),
                DB::raw('SUM(CASE WHEN categories.type = "expense" THEN amount ELSE 0 END) as total_expense')
            )
            ->join('categories', 'transactions.category_id', '=', 'categories.id')
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();
        
        $lineChartLabels = $lineChartData->pluck('date')->map(function($date) {
            return Carbon::parse($date)->format('d M');
        });
        $lineChartIncome = $lineChartData->pluck('total_income');
        $lineChartExpense = $lineChartData->pluck('total_expense');


        // 2. Data untuk Grafik Lingkaran (Pie Chart) - (Logika diperbarui)
        $pieChartDataFromTransactions = Transaction::where('user_id', $user->id)
            ->whereHas('category', function ($query) {
                $query->where('type', 'expense');
            })
            ->whereYear('transaction_date', $now->year)
            ->whereMonth('transaction_date', $now->month)
            ->select('categories.name as category_name', DB::raw('SUM(amount) as total_amount'))
            ->join('categories', 'transactions.category_id', '=', 'categories.id')
            ->groupBy('category_name')
            ->get();
            
        $pieChartLabels = $pieChartDataFromTransactions->pluck('category_name');
        $pieChartValues = $pieChartDataFromTransactions->pluck('total_amount');

        // Tambahkan data gaji ke pie chart jika ada
        if ($totalPayroll > 0) {
            $pieChartLabels->push('Biaya Gaji Karyawan');
            $pieChartValues->push($totalPayroll);
        }

        // Mengirim semua data ke view
        return view('dashboard', compact(
            'totalIncome', 
            'totalExpense', 
            'profit',
            'lineChartLabels',
            'lineChartIncome',
            'lineChartExpense',
            'pieChartLabels',
            'pieChartValues'
        ));
    }
}