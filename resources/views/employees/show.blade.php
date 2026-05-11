@extends('layouts.app')
@section('title', 'Employee Details')
@section('page-title', 'Employee Details')
@section('content')
    <div class="page-header-modern">
        <h1><i class="bi bi-person-fill me-2" style="color: var(--primary-color);"></i>{{ $employee->name }}</h1>
        <div>
            <a href="{{ route('employees.edit', $employee) }}" class="btn btn-modern btn-modern-primary"><i
                    class="bi bi-pencil me-1"></i> Edit</a>
            <a href="{{ route('employees.index') }}" class="btn btn-outline-secondary ms-2"><i
                    class="bi bi-arrow-left me-1"></i> Back</a>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-4">
            <div class="card card-modern">
                <div class="card-body text-center py-4">
                    <div class="avatar avatar-primary avatar-xl mx-auto mb-3"
                        style="width: 80px; height: 80px; font-size: 2rem;">
                        {{ strtoupper(substr($employee->name, 0, 1)) }}
                    </div>
                    <h4 class="mb-1">{{ $employee->name }}</h4>
                    <p class="text-muted mb-3">{{ $employee->role_display }}</p>
                    <span
                        class="badge-modern {{ $employee->is_active ? 'approved' : 'cancelled' }}">{{ $employee->is_active ? 'Active' : 'Inactive' }}</span>
                </div>
                <div class="card-body border-top">
                    <div class="row g-3">
                        <div class="col-6">
                            <div class="text-muted small">Employment Type</div>
                            <strong>{{ $employee->employment_type_display }}</strong>
                        </div>
                        <div class="col-6">
                            <div class="text-muted small">Monthly Salary</div>
                            <strong>{{ $employee->monthly_salary ? '৳' . number_format($employee->monthly_salary, 0) : 'Per Event' }}</strong>
                        </div>
                        @if($employee->user)
                            <div class="col-12">
                                <div class="text-muted small">Linked Account</div>
                                <strong>{{ $employee->user->email }}</strong>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="card card-modern mt-4">
                <div class="card-header">
                    <h6 class="mb-0"><i class="bi bi-wallet2 me-2"></i>Payment Summary</h6>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Pending Event Payments</span>
                        <strong
                            class="text-warning">৳{{ number_format($employee->total_pending_event_payments, 0) }}</strong>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-muted">Pending Monthly Salaries</span>
                        <strong
                            class="text-warning">৳{{ number_format($employee->total_pending_monthly_salaries, 0) }}</strong>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card card-modern">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h6 class="mb-0"><i class="bi bi-calendar-event me-2"></i>Event Payments</h6>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-modern mb-0">
                            <thead>
                                <tr>
                                    <th>Event</th>
                                    <th>Agreed</th>
                                    <th>Paid</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($employee->eventPayments as $payment)
                                    <tr>
                                        <td>{{ $payment->event->client->name ?? 'N/A' }} -
                                            {{ $payment->event->event_type ?? 'Event' }}</td>
                                        <td>৳{{ number_format($payment->agreed_amount, 0) }}</td>
                                        <td>৳{{ number_format($payment->paid_amount, 0) }}</td>
                                        <td><span
                                                class="badge-modern {{ $payment->status }}">{{ ucfirst($payment->status) }}</span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted py-4">No event payments yet</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="card card-modern mt-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h6 class="mb-0"><i class="bi bi-cash-stack me-2"></i>Monthly Salaries</h6>
                    <a href="{{ route('salaries.create') }}" class="btn btn-sm btn-outline-primary"><i
                            class="bi bi-plus me-1"></i> Record Payment</a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-modern mb-0">
                            <thead>
                                <tr>
                                    <th>Month</th>
                                    <th>Payable</th>
                                    <th>Paid</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($employee->monthlySalaries as $salary)
                                    <tr>
                                        <td>{{ $salary->month_display }}</td>
                                        <td>৳{{ number_format($salary->payable_amount, 0) }}</td>
                                        <td>৳{{ number_format($salary->paid_amount, 0) }}</td>
                                        <td><span
                                                class="badge-modern {{ $salary->status }}">{{ ucfirst($salary->status) }}</span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted py-4">No salary records yet</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection