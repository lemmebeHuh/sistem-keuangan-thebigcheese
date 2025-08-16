<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Payroll;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $employees = Employee::where('is_active', true)->latest()->get();
        $payrolls = Payroll::with('employee')->latest('payment_date')->paginate(10);
        return view('employees.index', compact('employees', 'payrolls'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'nullable|string|max:255',
            'joined_date' => 'required|date',
        ]);

        Employee::create($request->all());
        return redirect()->route('employees.index')->with('success', 'Karyawan baru berhasil ditambahkan.');
    }

    public function storePayroll(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'amount' => 'required|numeric|min:0',
            'payment_date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        Payroll::create($request->all());
        return redirect()->route('employees.index')->with('success', 'Pembayaran gaji berhasil dicatat.');
    }

    public function updatePayroll(Request $request, Payroll $payroll)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'amount' => 'required|numeric|min:0',
            'payment_date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        $payroll->update($request->all());

        return redirect()->route('employees.index')->with('success', 'Data gaji berhasil diperbarui.');
    }

    public function destroyPayroll(Payroll $payroll)
    {
        $payroll->delete();

        return redirect()->route('employees.index')->with('success', 'Data gaji berhasil dihapus.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
