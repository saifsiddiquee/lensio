@extends('layouts.app')
@section('title', 'Record Salary Payment')
@section('page-title', 'Record Salary Payment')
@section('content')
    <div class="page-header-modern">
        <h1><i class="bi bi-cash-stack me-2" style="color: var(--success-color);"></i>Record Salary Payment</h1>
        <a href="{{ route('salaries.index') }}" class="btn btn-outline-secondary"><i class="bi bi-arrow-left me-1"></i>
            Back</a>
    </div>

    <div class="card card-modern">
        <div class="card-body">
            <form action="{{ route('salaries.store') }}" method="POST" class="form-modern">
                @csrf
                <div class="row g-4">
                    <div class="col-md-6">
                        <label for="employee_id" class="form-label">Employee *</label>
                        <select class="form-select @error('employee_id') is-invalid @enderror" id="employee_id" name="employee_id" required>
                            <option value="">Select Employee</option>
                            @foreach($employees as $employee)
                                <option value="{{ $employee->id }}" 
                                    {{ old('employee_id') == $employee->id ? 'selected' : '' }}
                                    data-salary="{{ $employee->monthly_salary }}">
                                    {{ $employee->name }} ({{ $employee->role_display }})
                                    @if($employee->monthly_salary) - ৳{{ number_format($employee->monthly_salary, 0) }}/mo @endif
                                </option>
                            @endforeach
                        </select>
                        @error('employee_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label for="salary_month" class="form-label">Salary Month *</label>
                        <input type="month" class="form-control @error('salary_month') is-invalid @enderror" id="salary_month"
                            name="salary_month" value="{{ old('salary_month', date('Y-m')) }}" required>
                        @error('salary_month')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label for="payable_amount" class="form-label">Payable Amount *</label>
                        <div class="input-group">
                            <span class="input-group-text">৳</span>
                            <input type="number" step="0.01" class="form-control @error('payable_amount') is-invalid @enderror"
                                id="payable_amount" name="payable_amount" value="{{ old('payable_amount') }}" required>
                        </div>
                        <small class="text-muted">Total salary payable for this month</small>
                        @error('payable_amount')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label for="paid_amount" class="form-label">Paid Amount</label>
                        <div class="input-group">
                            <span class="input-group-text">৳</span>
                            <input type="number" step="0.01" class="form-control @error('paid_amount') is-invalid @enderror"
                                id="paid_amount" name="paid_amount" value="{{ old('paid_amount', 0) }}">
                        </div>
                        <small class="text-muted">Amount paid so far (0 if unpaid)</small>
                        @error('paid_amount')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="mt-4 pt-3 border-top">
                    <button type="submit" class="btn btn-modern btn-modern-primary"><i class="bi bi-check-lg me-1"></i> Record Payment</button>
                    <a href="{{ route('salaries.index') }}" class="btn btn-outline-secondary ms-2">Cancel</a>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('employee_id').addEventListener('change', function() {
            const selected = this.options[this.selectedIndex];
            const salary = selected.getAttribute('data-salary');
            if (salary) {
                document.getElementById('payable_amount').value = salary;
            }
        });
    </script>
@endsection
