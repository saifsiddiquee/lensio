@extends('layouts.app')
@section('title', 'Edit Salary Record')
@section('page-title', 'Edit Salary Record')
@section('content')
    <div class="page-header-modern">
        <h1><i class="bi bi-pencil-fill me-2" style="color: var(--success-color);"></i>Edit Salary Record</h1>
        <a href="{{ route('salaries.index') }}" class="btn btn-outline-secondary"><i class="bi bi-arrow-left me-1"></i>
            Back</a>
    </div>

    <div class="card card-modern">
        <div class="card-body">
            <div class="alert alert-info mb-4">
                <i class="bi bi-info-circle me-2"></i>
                <strong>{{ $salary->employee->name }}</strong> - {{ $salary->month_display }}
            </div>

            <form action="{{ route('salaries.update', $salary) }}" method="POST" class="form-modern">
                @csrf
                @method('PUT')
                <div class="row g-4">
                    <div class="col-md-6">
                        <label for="payable_amount" class="form-label">Payable Amount *</label>
                        <div class="input-group">
                            <span class="input-group-text">৳</span>
                            <input type="number" step="0.01"
                                class="form-control @error('payable_amount') is-invalid @enderror" id="payable_amount"
                                name="payable_amount" value="{{ old('payable_amount', $salary->payable_amount) }}" required>
                        </div>
                        @error('payable_amount')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label for="paid_amount" class="form-label">Paid Amount *</label>
                        <div class="input-group">
                            <span class="input-group-text">৳</span>
                            <input type="number" step="0.01" class="form-control @error('paid_amount') is-invalid @enderror"
                                id="paid_amount" name="paid_amount" value="{{ old('paid_amount', $salary->paid_amount) }}"
                                required>
                        </div>
                        @error('paid_amount')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="mt-3 p-3 bg-light rounded">
                    <div class="row">
                        <div class="col-md-4">
                            <span class="text-muted">Balance:</span>
                            <strong class="ms-2">৳{{ number_format($salary->balance, 0) }}</strong>
                        </div>
                        <div class="col-md-4">
                            <span class="text-muted">Current Status:</span>
                            <span class="badge-modern {{ $salary->status }} ms-2">{{ ucfirst($salary->status) }}</span>
                        </div>
                    </div>
                </div>

                <div class="mt-4 pt-3 border-top">
                    <button type="submit" class="btn btn-modern btn-modern-primary"><i class="bi bi-check-lg me-1"></i>
                        Update Record</button>
                    <a href="{{ route('salaries.index') }}" class="btn btn-outline-secondary ms-2">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection