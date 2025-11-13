<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class TransactionController extends Controller
{
    public function index(Request $request) 
{
    $user = Auth::user();
    $keyword = $request->input('search'); 

    // --- Ambil input tanggal ---
    $startDate = $request->input('start_date') 
        ? Carbon::parse($request->input('start_date'))->startOfDay() 
        : null;
    $endDate = $request->input('end_date')
        ? Carbon::parse($request->input('end_date'))->endOfDay()
        : null;

    $query = Transaction::where('user_id', $user->id)
                        ->with('category');

    // Filter Keyword (Sudah ada)
    $query->when($keyword, function ($query, $keyword) {
        $query->where(function ($subQuery) use ($keyword) {
            $subQuery->where('description', 'like', "%{$keyword}%")
                     ->orWhereHas('category', function ($categoryQuery) use ($keyword) {
                         $categoryQuery->where('name', 'like', "%{$keyword}%");
                     });
        });
    });

    // --- TAMBAHKAN FILTER TANGGAL ---
    // Filter Start Date
    $query->when($startDate, function ($query, $startDate) {
        $query->where('transaction_date', '>=', $startDate);
    });

    // Filter End Date
    $query->when($endDate, function ($query, $endDate) {
        $query->where('transaction_date', '<=', $endDate);
    });
    // --- AKHIR FILTER TANGGAL ---

    $transactions = $query->latest('transaction_date')
                           ->paginate(10);

    $incomeCategories = Category::where('type', 'income')->get();
    $expenseCategories = Category::where('type', 'expense')->get();

    return view('transactions.index', compact('transactions', 'incomeCategories', 'expenseCategories'));
}

    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'transaction_date' => 'required|date',
            'description' => 'nullable|string',
        ]);

        Auth::user()->transactions()->create($request->all());

        return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil dicatat.');
    }

    public function update(Request $request, Transaction $transaction)
    {
        // Pastikan pengguna hanya bisa mengedit transaksinya sendiri
        if ($transaction->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'amount' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'transaction_date' => 'required|date',
            'description' => 'nullable|string',
        ]);

        $transaction->update($request->all());

        return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil diperbarui.');
    }

    public function destroy(Transaction $transaction)
    {
        // Pastikan pengguna hanya bisa menghapus transaksinya sendiri
        if ($transaction->user_id !== Auth::id()) {
            abort(403);
        }

        $transaction->delete();

        return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil dihapus.');
    }
}
