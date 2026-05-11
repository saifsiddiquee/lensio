@extends('layouts.app')
@section('title', 'Quotation Details')
@section('page-title', 'Quotation Details')
@section('content')
    <div class="page-header-modern">
        <h1><i class="bi bi-file-earmark-text-fill me-2" style="color: var(--primary-color);"></i>Quotation for
            {{ $quotation->client->name }}</h1>
        <div class="d-flex gap-2">
            <a href="{{ route('quotations.edit', $quotation) }}" class="btn btn-modern btn-modern-primary"><i
                    class="bi bi-pencil me-1"></i> Edit</a>
            <a href="{{ route('quotations.index') }}" class="btn btn-outline-secondary"><i
                    class="bi bi-arrow-left me-1"></i> Back</a>
        </div>
    </div>
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card detail-card">
                <div class="card-header">
                    <h6><i class="bi bi-info-circle-fill"></i> Quotation Details</h6>
                </div>
                <div class="card-body">
                    <dl class="row detail-list mb-0">
                        <dt class="col-sm-3">Client</dt>
                        <dd class="col-sm-9">{{ $quotation->client->name }}</dd>
                        <dt class="col-sm-3">Package</dt>
                        <dd class="col-sm-9">{{ $quotation->package->name ?? '-' }}</dd>
                        <dt class="col-sm-3">Amount</dt>
                        <dd class="col-sm-9"><span class="fs-4 fw-bold"
                                style="color: var(--success-color);">৳{{ number_format($quotation->amount, 2) }}</span></dd>
                        <dt class="col-sm-3">Status</dt>
                        <dd class="col-sm-9"><span
                                class="badge-modern {{ $quotation->status }}">{{ $quotation->status }}</span></dd>
                        <dt class="col-sm-3">Valid Until</dt>
                        <dd class="col-sm-9">{{ $quotation->valid_until?->format('F d, Y') ?? '-' }}</dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>
@endsection