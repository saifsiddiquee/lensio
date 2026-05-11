@extends('layouts.app')
@section('title', 'Reports')
@section('page-title', 'Reports')
@section('content')
    <div class="page-header-modern">
        <h1><i class="bi bi-bar-chart-fill me-2" style="color: var(--primary-color);"></i>Business Reports</h1>
    </div>

    <div class="row g-4">
        <div class="col-md-3">
            <div class="card card-modern h-100">
                <div class="card-body text-center py-5">
                    <div class="avatar avatar-success mx-auto mb-3" style="width: 64px; height: 64px; font-size: 1.5rem;">
                        <i class="bi bi-cash"></i>
                    </div>
                    <h5 class="fw-semibold mb-2">Revenue Report</h5>
                    <p class="text-muted small mb-4">Monthly revenue breakdown and totals</p>
                    <a href="{{ route('reports.revenue') }}" class="btn btn-modern btn-modern-success">View Report</a>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card card-modern h-100">
                <div class="card-body text-center py-5">
                    <div class="avatar avatar-warning mx-auto mb-3" style="width: 64px; height: 64px; font-size: 1.5rem;">
                        <i class="bi bi-clock-history"></i>
                    </div>
                    <h5 class="fw-semibold mb-2">Pending Payments</h5>
                    <p class="text-muted small mb-4">Outstanding invoices and balances</p>
                    <a href="{{ route('reports.pending-payments') }}" class="btn btn-outline-warning">View Report</a>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card card-modern h-100">
                <div class="card-body text-center py-5">
                    <div class="avatar avatar-purple mx-auto mb-3" style="width: 64px; height: 64px; font-size: 1.5rem;">
                        <i class="bi bi-calendar-check"></i>
                    </div>
                    <h5 class="fw-semibold mb-2">Event Status</h5>
                    <p class="text-muted small mb-4">Event completion and scheduling</p>
                    <a href="{{ route('reports.event-status') }}" class="btn btn-modern btn-modern-primary">View Report</a>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card card-modern h-100">
                <div class="card-body text-center py-5">
                    <div class="avatar avatar-primary mx-auto mb-3" style="width: 64px; height: 64px; font-size: 1.5rem;">
                        <i class="bi bi-graph-up-arrow"></i>
                    </div>
                    <h5 class="fw-semibold mb-2">Profit & Loss</h5>
                    <p class="text-muted small mb-4">Event-wise profitability analysis</p>
                    <a href="{{ route('reports.profit-loss') }}" class="btn btn-modern btn-modern-success">View Report</a>
                </div>
            </div>
        </div>
    </div>
@endsection