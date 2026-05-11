@extends('layouts.app')
@section('title', 'Employees')
@section('page-title', 'Employees')
@section('content')
    <div class="page-header-modern">
        <h1><i class="bi bi-people-fill me-2" style="color: var(--primary-color);"></i>Staff Management</h1>
        <a href="{{ route('employees.create') }}" class="btn btn-modern btn-modern-primary"><i
                class="bi bi-plus-lg me-1"></i> Add Employee</a>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card stat-card-modern green">
                <div class="card-body py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="stat-value fs-3">{{ $employees->where('is_active', true)->count() }}</div>
                            <div class="stat-label">Active</div>
                        </div>
                        <i class="bi bi-person-check fs-1 opacity-25"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stat-card-modern">
                <div class="card-body py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="stat-value fs-3">{{ $employees->where('role', 'photographer')->count() }}</div>
                            <div class="stat-label">Photographers</div>
                        </div>
                        <i class="bi bi-camera fs-1 opacity-25"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stat-card-modern purple">
                <div class="card-body py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="stat-value fs-3">{{ $employees->where('role', 'editor')->count() }}</div>
                            <div class="stat-label">Editors</div>
                        </div>
                        <i class="bi bi-pencil-square fs-1 opacity-25"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stat-card-modern orange">
                <div class="card-body py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="stat-value fs-3">{{ $employees->total() }}</div>
                            <div class="stat-label">Total</div>
                        </div>
                        <i class="bi bi-people fs-1 opacity-25"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card card-modern">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-modern mb-0">
                    <thead>
                        <tr>
                            <th>Employee</th>
                            <th>Role</th>
                            <th>Type</th>
                            <th>Salary</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($employees as $employee)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="avatar avatar-primary avatar-sm">
                                            {{ strtoupper(substr($employee->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <strong>{{ $employee->name }}</strong>
                                            @if($employee->user)
                                                <br><small class="text-muted">{{ $employee->user->email }}</small>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td><span class="badge bg-secondary">{{ $employee->role_display }}</span></td>
                                <td><span class="badge-modern {{ $employee->employment_type == 'full_time' ? 'approved' : ($employee->employment_type == 'part_time' ? 'sent' : 'pending') }}">{{ $employee->employment_type_display }}</span></td>
                                <td>
                                    @if($employee->monthly_salary)
                                        ৳{{ number_format($employee->monthly_salary, 0) }}/mo
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>
                                <td><span class="badge-modern {{ $employee->is_active ? 'approved' : 'cancelled' }}">{{ $employee->is_active ? 'Active' : 'Inactive' }}</span></td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="{{ route('employees.show', $employee) }}"
                                            class="btn btn-sm btn-outline-secondary btn-icon btn-icon-sm"><i
                                                class="bi bi-eye"></i></a>
                                        <a href="{{ route('employees.edit', $employee) }}"
                                            class="btn btn-sm btn-outline-primary btn-icon btn-icon-sm"><i
                                                class="bi bi-pencil"></i></a>
                                        <form action="{{ route('employees.destroy', $employee) }}" method="POST" class="d-inline">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger btn-icon btn-icon-sm"
                                                onclick="return confirm('Delete this employee?')"><i class="bi bi-trash"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6">
                                    <div class="empty-state"><i class="bi bi-people d-block"></i>
                                        <div class="empty-title">No employees found</div>
                                        <div class="empty-subtitle">Add your first employee to get started</div>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="mt-3">{{ $employees->links() }}</div>
@endsection
