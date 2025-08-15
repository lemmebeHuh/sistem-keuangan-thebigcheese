<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        // Ganti get() menjadi paginate() untuk membatasi data per halaman
        $transactions = Transaction::where('user_id', $user->id)
                            ->with('category')
                            ->latest('transaction_date')
                            ->paginate(10); // Menampilkan 10 transaksi per halaman
        
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
