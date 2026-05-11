@extends('layouts.app')
@section('title', 'Revenue Report')
@section('page-title', 'Revenue Report')
@section('content')
    <div class="page-header-modern">
        <h1><i class="bi bi-cash me-2" style="color: var(--success-color);"></i>Revenue Report</h1>
        <a href="{{ route('reports.index') }}" class="btn btn-outline-secondary"><i class="bi bi-arrow-left me-1"></i>
            Back</a>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card stat-card-modern green">
                <div class="card-body">
                    <i class="bi bi-cash stat-icon"></i>
                    <div class="stat-value">৳{{ number_format($totalRevenue, 0) }}</div>
                    <div class="stat-label">Total Revenue (Paid)</div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card stat-card-modern">
                <div class="card-body">
                    <i class="bi bi-cash-stack stat-icon"></i>
                    <div class="stat-value">৳{{ number_format($paidPayments, 0) }}</div>
                    <div class="stat-label">Total Payments Received</div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card stat-card-modern orange">
                <div class="card-body">
                    <i class="bi bi-exclamation-circle stat-icon"></i>
                    <div class="stat-value">৳{{ number_format($totalPending, 0) }}</div>
                    <div class="stat-label">Total Pending</div>
                </div>
            </div>
        </div>
    </div>

    <div class="card card-modern">
        <div class="card-header">
            <h6 class="card-header-title"><i class="bi bi-graph-up"></i> Monthly Revenue (Last 12 Months)</h6>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-modern mb-0">
                    <thead>
                        <tr>
                            <th>Month</th>
                            <th>Revenue</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($monthlyRevenue as $month)
                            <tr>
                                <td>{{ date('F Y', mktime(0, 0, 0, $month->month, 1, $month->year)) }}</td>
                                <td><strong class="text-success">৳{{ number_format($month->total, 2) }}</strong></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2">
                                    <div class="empty-state"><i class="bi bi-graph-up d-block"></i>
                                        <div class="empty-title">No revenue data</div>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection