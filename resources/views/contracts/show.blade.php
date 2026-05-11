@extends('layouts.app')
@section('title', 'Contract Details')
@section('page-title', 'Contract Details')
@section('content')
    <div class="page-header-modern">
        <h1><i class="bi bi-file-earmark-check-fill me-2"
                style="color: var(--success-color);"></i>{{ $contract->reference_no }}</h1>
        <div class="d-flex gap-2">
            <a href="{{ route('contracts.edit', $contract) }}" class="btn btn-modern btn-modern-primary"><i
                    class="bi bi-pencil me-1"></i> Edit</a>
            <a href="{{ route('contracts.index') }}" class="btn btn-outline-secondary"><i class="bi bi-arrow-left me-1"></i>
                Back</a>
        </div>
    </div>
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card detail-card">
                <div class="card-header">
                    <h6><i class="bi bi-info-circle-fill"></i> Contract Details</h6>
                </div>
                <div class="card-body">
                    <dl class="row detail-list mb-0">
                        <dt class="col-sm-3">Reference</dt>
                        <dd class="col-sm-9">{{ $contract->reference_no }}</dd>
                        <dt class="col-sm-3">Event</dt>
                        <dd class="col-sm-9">{{ $contract->event->event_type }} -
                            {{ $contract->event->event_date->format('F d, Y') }}</dd>
                        <dt class="col-sm-3">Client</dt>
                        <dd class="col-sm-9">{{ $contract->event->client->name }}</dd>
                        <dt class="col-sm-3">Status</dt>
                        <dd class="col-sm-9"><span
                                class="badge-modern {{ $contract->status }}">{{ $contract->status }}</span></dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>
@endsection