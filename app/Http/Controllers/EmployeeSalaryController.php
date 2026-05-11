<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\EmployeeMonthlySalary;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Carbon\Carbon;

class EmployeeSalaryController extends Controller
{
    /**
     * Display a listing of monthly salaries
     */
    public function index(Request $request): View
    {
        $query = EmployeeMonthlySalary::with('employee');

        // Filter by employee
        if ($request->filled('employee_id')) {
            $query->where('employee_id', $request->employee_id);
        }

        // Filter by month
        if ($request->filled('month')) {
            $query->whereMonth('salary_month', Carbon::parse($request->month)->month)
                ->whereYear('salary_month', Carbon::parse($request->month)->year);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $salaries = $query->orderBy('salary_month', 'desc')->paginate(15);
        $employees = Employee::active()->orderBy('name')->get();

        return view('salaries.index', compact('salaries', 'employees'));
    }

    /**
     * Show the form for creating a new salary record
     */
    public function create(): View
    {
        $employees = Employee::active()
            ->where('employment_type', '!=', 'contractual')
            ->orderBy('name')
            ->get();

        return view('salaries.create', compact('employees'));
    }

    /**
     * Store a newly created salary record
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'salary_month' => 'required|date',
            'payable_amount' => 'required|numeric|min:0',
            'paid_amount' => 'nullable|numeric|min:0',
        ]);

        // Set salary_month to first day of the month
        $validated['salary_month'] = Carbon::parse($validated['salary_month'])->startOfMonth();
        $validated['paid_amount'] = $validated['paid_amount'] ?? 0;

        // Auto-calculate status
        $validated['status'] = $validated['paid_amount'] >= $validated['payable_amount'] ? 'paid' : 'pending';

        EmployeeMonthlySalary::create($validated);

        return redirect()->route('salaries.index')
            ->with('success', 'Salary record created successfully.');
    }

    /**
     * Show the form for editing the specified salary record
     */
    public function edit(EmployeeMonthlySalary $salary): View
    {
        $employees = Employee::active()
            ->where('employment_type', '!=', 'contractual')
            ->orderBy('name')
            ->get();

        return view('salaries.edit', compact('salary', 'employees'));
    }

    /**
     * Update the specified salary record
     */
    public function update(Request $request, EmployeeMonthlySalary $salary): RedirectResponse
    {
        $validated = $request->validate([
            'payable_amount' => 'required|numeric|min:0',
            'paid_amount' => 'required|numeric|min:0',
        ]);

        // Auto-calculate status
        $validated['status'] = $validated['paid_amount'] >= $validated['payable_amount'] ? 'paid' : 'pending';

        $salary->update($validated);

        return redirect()->route('salaries.index')
            ->with('success', 'Salary record updated successfully.');
    }

    /**
     * Remove the specified salary record
     */
    public function destroy(EmployeeMonthlySalary $salary): RedirectResponse
    {
        $salary->delete();

        return redirect()->route('salaries.index')
            ->with('success', 'Salary record deleted successfully.');
    }
}
