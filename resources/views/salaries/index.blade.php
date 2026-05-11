@extends('layouts.app')
@section('title', 'Monthly Salaries')
@section('page-title', 'Monthly Salaries')
@section('content')
    <div class="page-header-modern">
        <h1><i class="bi bi-cash-stack me-2" style="color: var(--success-color);"></i>Monthly Salary Records</h1>
        <a href="{{ route('salaries.create') }}" class="btn btn-modern btn-modern-primary"><i
                class="bi bi-plus-lg me-1"></i> Record Payment</a>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card stat-card-modern green">
                <div class="card-body py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="stat-value fs-3">
                                ৳{{ number_format($salaries->where('status', 'paid')->sum('paid_amount'), 0) }}</div>
                            <div class="stat-label">Total Paid</div>
                        </div>
                        <i class="bi bi-check-circle fs-1 opacity-25"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card stat-card-modern orange">
                <div class="card-body py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="stat-value fs-3">
                                ৳{{ number_format($salaries->where('status', 'pending')->sum('payable_amount') - $salaries->where('status', 'pending')->sum('paid_amount'), 0) }}
                            </div>
                            <div class="stat-label">Pending</div>
                        </div>
                        <i class="bi bi-hourglass-split fs-1 opacity-25"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card stat-card-modern purple">
                <div class="card-body py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="stat-value fs-3">{{ $salaries->total() }}</div>
                            <div class="stat-label">Records</div>
                        </div>
                        <i class="bi bi-file-text fs-1 opacity-25"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card card-modern mb-4">
        <div class="card-body">
            <form method="GET" class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label class="form-label">Employee</label>
                    <select name="employee_id" class="form-select">
                        <option value="">All Employees</option>
                        @foreach($employees as $employee)
                            <option value="{{ $employee->id }}" {{ request('employee_id') == $employee->id ? 'selected' : '' }}>
                                {{ $employee->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Month</label>
                    <input type="month" name="month" class="form-control" value="{{ request('month') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="">All Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Paid</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100"><i class="bi bi-filter me-1"></i> Filter</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card card-modern">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-modern mb-0">
                    <thead>
                        <tr>
                            <th>Employee</th>
                            <th>Month</th>
                            <th>Payable</th>
                            <th>Paid</th>
                            <th>Balance</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($salaries as $salary)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="avatar avatar-success avatar-sm">
                                            {{ strtoupper(substr($salary->employee->name, 0, 1)) }}
                                        </div>
                                        <a
                                            href="{{ route('employees.show', $salary->employee) }}">{{ $salary->employee->name }}</a>
                                    </div>
                                </td>
                                <td>{{ $salary->month_display }}</td>
                                <td>৳{{ number_format($salary->payable_amount, 0) }}</td>
                                <td>৳{{ number_format($salary->paid_amount, 0) }}</td>
                                <td class="{{ $salary->balance > 0 ? 'text-warning' : 'text-success' }}">
                                    ৳{{ number_format($salary->balance, 0) }}
                                </td>
                                <td><span class="badge-modern {{ $salary->status }}">{{ ucfirst($salary->status) }}</span></td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="{{ route('salaries.edit', $salary) }}"
                                            class="btn btn-sm btn-outline-primary btn-icon btn-icon-sm"><i
                                                class="bi bi-pencil"></i></a>
                                        <form action="{{ route('salaries.destroy', $salary) }}" method="POST" class="d-inline">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger btn-icon btn-icon-sm"
                                                onclick="return confirm('Delete this record?')"><i
                                                    class="bi bi-trash"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7">
                                    <div class="empty-state"><i class="bi bi-cash-stack d-block"></i>
                                        <div class="empty-title">No salary records found</div>
                                        <div class="empty-subtitle">Record monthly salary payments to track disbursements</div>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="mt-3">{{ $salaries->links() }}</div>
@endsection