<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EmployeeController extends Controller
{
    /**
     * Display a listing of employees
     */
    public function index(Request $request): View
    {
        $query = Employee::with('user');

        // Filter by role
        if ($request->filled('role')) {
            $query->byRole($request->role);
        }

        // Filter by employment type
        if ($request->filled('employment_type')) {
            $query->byEmploymentType($request->employment_type);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        // Search by name
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $employees = $query->latest()->paginate(15);

        return view('employees.index', compact('employees'));
    }

    /**
     * Show the form for creating a new employee
     */
    public function create(): View
    {
        $users = User::whereDoesntHave('employee')
            ->orderBy('name')
            ->get();

        return view('employees.create', compact('users'));
    }

    /**
     * Store a newly created employee
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'role' => 'required|in:photographer,editor,support',
            'employment_type' => 'required|in:full_time,part_time,contractual',
            'monthly_salary' => 'nullable|numeric|min:0',
            'user_id' => 'nullable|exists:users,id|unique:employees,user_id',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);

        Employee::create($validated);

        return redirect()->route('employees.index')
            ->with('success', 'Employee created successfully.');
    }

    /**
     * Display the specified employee
     */
    public function show(Employee $employee): View
    {
        $employee->load([
            'user',
            'eventPayments.event',
            'monthlySalaries' => fn($q) => $q->orderBy('salary_month', 'desc'),
        ]);

        return view('employees.show', compact('employee'));
    }

    /**
     * Show the form for editing the specified employee
     */
    public function edit(Employee $employee): View
    {
        $users = User::where(function ($query) use ($employee) {
            $query->whereDoesntHave('employee')
                ->orWhere('id', $employee->user_id);
        })->orderBy('name')->get();

        return view('employees.edit', compact('employee', 'users'));
    }

    /**
     * Update the specified employee
     */
    public function update(Request $request, Employee $employee): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'role' => 'required|in:photographer,editor,support',
            'employment_type' => 'required|in:full_time,part_time,contractual',
            'monthly_salary' => 'nullable|numeric|min:0',
            'user_id' => 'nullable|exists:users,id|unique:employees,user_id,' . $employee->id,
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);

        $employee->update($validated);

        return redirect()->route('employees.index')
            ->with('success', 'Employee updated successfully.');
    }

    /**
     * Remove the specified employee
     */
    public function destroy(Employee $employee): RedirectResponse
    {
        try {
            $employee->delete();

            return redirect()->route('employees.index')
                ->with('success', 'Employee deleted successfully.');
        } catch (QueryException $e) {
            if ($e->getCode() === '23000') {
                return redirect()->route('employees.index')
                    ->with('error', 'This employee cannot be deleted because they have associated payment or salary records. Deactivate them instead.');
            }

            return redirect()->route('employees.index')
                ->with('error', 'An unexpected error occurred while deleting the employee.');
        }
    }
}
