@extends('layouts.app')
@section('title', 'Edit Payment')
@section('page-title', 'Edit Payment')
@section('content')
    <div class="page-header-modern">
        <h1><i class="bi bi-pencil-fill me-2" style="color: var(--success-color);"></i>Edit Payment</h1>
        <a href="{{ route('payments.index') }}" class="btn btn-outline-secondary"><i class="bi bi-arrow-left me-1"></i>
            Back</a>
    </div>
    <div class="card card-modern">
        <div class="card-body">
            <form action="{{ route('payments.update', $payment) }}" method="POST" class="form-modern">
                @csrf @method('PUT')
                <div class="row g-4">
                    <div class="col-md-6"><label for="invoice_id" class="form-label">Invoice *</label><select
                            class="form-select @error('invoice_id') is-invalid @enderror" id="invoice_id" name="invoice_id"
                            required>@foreach($invoices as $invoice)<option value="{{ $invoice->id }}" {{ old('invoice_id', $payment->invoice_id) == $invoice->id ? 'selected' : '' }}>{{ $invoice->invoice_no }} -
                            {{ $invoice->event->client->name }}</option>@endforeach</select>@error('invoice_id')<div
                                class="invalid-feedback">{{ $message }}</div>@enderror</div>
                    <div class="col-md-6"><label for="amount" class="form-label">Amount *</label>
                        <div class="input-group"><span class="input-group-text">৳</span><input type="number" step="0.01"
                                class="form-control @error('amount') is-invalid @enderror" id="amount" name="amount"
                                value="{{ old('amount', $payment->amount) }}" required></div>@error('amount')<div
                                class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6"><label for="payment_date" class="form-label">Payment Date *</label><input
                            type="date" class="form-control @error('payment_date') is-invalid @enderror" id="payment_date"
                            name="payment_date" value="{{ old('payment_date', $payment->payment_date->format('Y-m-d')) }}"
                            required>@error('payment_date')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                    <div class="col-md-6"><label for="method" class="form-label">Method *</label><select
                            class="form-select @error('method') is-invalid @enderror" id="method" name="method"
                            required>@foreach(['Cash', 'Bank Transfer', 'Check'] as $method)<option value="{{ $method }}" {{ old('method', $payment->method) == $method ? 'selected' : '' }}>{{ $method }}</option>
                            @endforeach</select>@error('method')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-12"><label for="notes" class="form-label">Notes</label><textarea
                            class="form-control @error('notes') is-invalid @enderror" id="notes" name="notes"
                            rows="2">{{ old('notes', $payment->notes) }}</textarea>@error('notes')<div
                            class="invalid-feedback">{{ $message }}</div>@enderror</div>
                </div>
                <div class="mt-4 pt-3 border-top"><button type="submit" class="btn btn-modern btn-modern-success"><i
                            class="bi bi-check-lg me-1"></i> Update Payment</button><a href="{{ route('payments.index') }}"
                        class="btn btn-outline-secondary ms-2">Cancel</a></div>
            </form>
        </div>
    </div>
@endsection