@extends('layouts.app')
@section('title', 'Invoice Details')
@section('page-title', 'Invoice Details')
@section('content')
    <div class="page-header-modern">
        <h1><i class="bi bi-receipt me-2" style="color: var(--warning-color);"></i>{{ $invoice->invoice_no }}</h1>
        <div class="d-flex gap-2">
            <a href="{{ route('payments.create') }}" class="btn btn-modern btn-modern-success"><i
                    class="bi bi-cash me-1"></i> Add Payment</a>
            <a href="{{ route('invoices.edit', $invoice) }}" class="btn btn-modern btn-modern-primary"><i
                    class="bi bi-pencil me-1"></i> Edit</a>
            <a href="{{ route('invoices.index') }}" class="btn btn-outline-secondary"><i class="bi bi-arrow-left me-1"></i>
                Back</a>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-md-6">
            <div class="card detail-card">
                <div class="card-header">
                    <h6><i class="bi bi-info-circle-fill"></i> Invoice Details</h6>
                </div>
                <div class="card-body">
                    <dl class="row detail-list mb-0">
                        <dt class="col-sm-4">Invoice No</dt>
                        <dd class="col-sm-8">{{ $invoice->invoice_no }}</dd>
                        <dt class="col-sm-4">Event</dt>
                        <dd class="col-sm-8">{{ $invoice->event->event_type }}</dd>
                        <dt class="col-sm-4">Client</dt>
                        <dd class="col-sm-8">{{ $invoice->event->client->name }}</dd>
                        <dt class="col-sm-4">Total</dt>
                        <dd class="col-sm-8 fs-5 fw-bold">৳{{ number_format($invoice->total_amount, 2) }}</dd>
                        <dt class="col-sm-4">Paid</dt>
                        <dd class="col-sm-8 text-success">৳{{ number_format($invoice->total_paid, 2) }}</dd>
                        <dt class="col-sm-4">Balance</dt>
                        <dd class="col-sm-8 {{ $invoice->balance > 0 ? 'text-danger fw-semibold' : 'text-success' }}">
                            ৳{{ number_format($invoice->balance, 2) }}</dd>
                        <dt class="col-sm-4">Status</dt>
                        <dd class="col-sm-8"><span class="badge-modern {{ $invoice->status }}">{{ $invoice->status }}</span>
                        </dd>
                    </dl>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card detail-card">
                <div class="card-header">
                    <h6><i class="bi bi-cash-stack"></i> Payment History</h6>
                </div>
                <div class="card-body p-0">
                    @forelse($invoice->payments as $payment)
                        <div class="activity-list-item d-flex justify-content-between">
                            <div>
                                <strong class="text-success">৳{{ number_format($payment->amount, 2) }}</strong><br>
                                <small class="text-muted">{{ $payment->payment_date->format('M d, Y') }} •
                                    {{ $payment->method }}</small>
                            </div>
                        </div>
                    @empty
                        <div class="empty-state"><i class="bi bi-cash d-block"></i>
                            <div class="empty-title">No payments</div>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection