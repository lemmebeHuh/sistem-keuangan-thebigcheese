<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// TAMBAHKAN ROUTE BARU DI BAWAH INI
Route::middleware('auth')->group(function () {
    Route::resource('categories', CategoryController::class)->except(['show', 'create', 'edit']);
    Route::resource('transactions', TransactionController::class)->except(['show', 'create', 'edit']);
    Route::resource('employees', EmployeeController::class)->only(['index', 'store']);
    Route::post('payrolls', [EmployeeController::class, 'storePayroll'])->name('payrolls.store');
    Route::put('payrolls/{payroll}', [EmployeeController::class, 'updatePayroll'])->name('payrolls.update');
    Route::delete('payrolls/{payroll}', [EmployeeController::class, 'destroyPayroll'])->name('payrolls.destroy');
    
    Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});





require __DIR__.'/auth.php';
