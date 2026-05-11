@extends('layouts.app')
@section('title', 'Package Details')
@section('page-title', 'Package Details')
@section('content')
    <div class="page-header-modern">
        <h1><i class="bi bi-box-fill me-2" style="color: var(--warning-color);"></i>{{ $package->name }}</h1>
        <div class="d-flex gap-2">
            <a href="{{ route('packages.edit', $package) }}" class="btn btn-modern btn-modern-primary"><i
                    class="bi bi-pencil me-1"></i> Edit</a>
            <a href="{{ route('packages.index') }}" class="btn btn-outline-secondary"><i class="bi bi-arrow-left me-1"></i>
                Back</a>
        </div>
    </div>
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card detail-card">
                <div class="card-header">
                    <h6><i class="bi bi-info-circle-fill"></i> Package Details</h6>
                </div>
                <div class="card-body">
                    <dl class="row detail-list mb-0">
                        <dt class="col-sm-3">Name</dt>
                        <dd class="col-sm-9">{{ $package->name }}</dd>
                        <dt class="col-sm-3">Price</dt>
                        <dd class="col-sm-9"><span class="fs-4 fw-bold"
                                style="color: var(--success-color);">৳{{ number_format($package->price, 2) }}</span></dd>
                        <dt class="col-sm-3">Duration</dt>
                        <dd class="col-sm-9">{{ $package->duration_hours }} hours</dd>
                        <dt class="col-sm-3">Description</dt>
                        <dd class="col-sm-9">{{ $package->description ?? '-' }}</dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>
@endsection