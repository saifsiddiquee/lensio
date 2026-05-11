@extends('layouts.app')
@section('title', 'Payment Details')
@section('page-title', 'Payment Details')
@section('content')
    <div class="page-header-modern">
        <h1><i class="bi bi-credit-card-fill me-2" style="color: var(--success-color);"></i>Payment Details</h1>
        <div class="d-flex gap-2">
            <a href="{{ route('payments.edit', $payment) }}" class="btn btn-modern btn-modern-primary"><i
                    class="bi bi-pencil me-1"></i> Edit</a>
            <a href="{{ route('payments.index') }}" class="btn btn-outline-secondary"><i class="bi bi-arrow-left me-1"></i>
                Back</a>
        </div>
    </div>
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card detail-card">
                <div class="card-header">
                    <h6><i class="bi bi-info-circle-fill"></i> Payment Details</h6>
                </div>
                <div class="card-body">
                    <dl class="row detail-list mb-0">
                        <dt class="col-sm-3">Invoice</dt>
                        <dd class="col-sm-9">{{ $payment->invoice->invoice_no }}</dd>
                        <dt class="col-sm-3">Client</dt>
                        <dd class="col-sm-9">{{ $payment->invoice->event->client->name }}</dd>
                        <dt class="col-sm-3">Amount</dt>
                        <dd class="col-sm-9"><span
                                class="fs-4 fw-bold text-success">৳{{ number_format($payment->amount, 2) }}</span></dd>
                        <dt class="col-sm-3">Date</dt>
                        <dd class="col-sm-9">{{ $payment->payment_date->format('F d, Y') }}</dd>
                        <dt class="col-sm-3">Method</dt>
                        <dd class="col-sm-9"><span class="badge bg-secondary">{{ $payment->method }}</span></dd>
                        <dt class="col-sm-3">Notes</dt>
                        <dd class="col-sm-9">{{ $payment->notes ?? '-' }}</dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>
@endsection