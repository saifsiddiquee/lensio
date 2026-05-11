@extends('layouts.app')
@section('title', 'Profit & Loss Report')
@section('page-title', 'Profit & Loss Report')
@section('content')
    <div class="page-header-modern">
        <h1><i class="bi bi-graph-up-arrow me-2" style="color: var(--success-color);"></i>Profit & Loss Report</h1>
        <a href="{{ route('reports.index') }}" class="btn btn-outline-secondary"><i class="bi bi-arrow-left me-1"></i>
            Back</a>
    </div>

    {{-- Filters --}}
    <div class="card card-modern mb-4">
        <div class="card-body py-3">
            <form method="GET" class="row g-3 align-items-end">
                <div class="col-auto">
                    <label class="form-label small text-muted">View</label>
                    <select name="view" class="form-select form-select-sm" onchange="this.form.submit()">
                        <option value="monthly" {{ $viewType == 'monthly' ? 'selected' : '' }}>Monthly</option>
                        <option value="yearly" {{ $viewType == 'yearly' ? 'selected' : '' }}>Yearly</option>
                    </select>
                </div>
                @if($viewType == 'monthly')
                    <div class="col-auto">
                        <label class="form-label small text-muted">Year</label>
                        <select name="year" class="form-select form-select-sm" onchange="this.form.submit()">
                            @foreach($years as $y)
                                <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                            @endforeach
                        </select>
                    </div>
                @endif
            </form>
        </div>
    </div>

    {{-- Summary Cards --}}
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card stat-card-modern purple">
                <div class="card-body py-3">
                    <div class="stat-value fs-3">{{ $totals['events'] }}</div>
                    <div class="stat-label">Total Events</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stat-card-modern green">
                <div class="card-body py-3">
                    <div class="stat-value fs-3">৳{{ number_format($totals['income'], 0) }}</div>
                    <div class="stat-label">Total Income</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stat-card-modern orange">
                <div class="card-body py-3">
                    <div class="stat-value fs-3">৳{{ number_format($totals['costs'], 0) }}</div>
                    <div class="stat-label">Total Costs</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stat-card-modern {{ $totals['profit'] >= 0 ? 'green' : '' }}"
                style="{{ $totals['profit'] < 0 ? 'background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);' : '' }}">
                <div class="card-body py-3">
                    <div class="stat-value fs-3">৳{{ number_format(abs($totals['profit']), 0) }}</div>
                    <div class="stat-label">{{ $totals['profit'] >= 0 ? 'Net Profit' : 'Net Loss' }}</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Report Table --}}
    <div class="card card-modern">
        <div class="card-header">
            <h6 class="card-header-title"><i class="bi bi-table"></i>
                {{ $viewType == 'monthly' ? 'Monthly Breakdown - ' . $year : 'Yearly Breakdown' }}</h6>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-modern mb-0">
                    <thead>
                        <tr>
                            <th>{{ $viewType == 'monthly' ? 'Month' : 'Year' }}</th>
                            <th>Events</th>
                            <th>Income</th>
                            <th>Costs</th>
                            <th>Profit/Loss</th>
                            <th>Margin</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($reportData as $row)
                            <tr>
                                <td><strong>{{ $viewType == 'monthly' ? $row['month_name'] : $row['year'] }}</strong></td>
                                <td>{{ $row['events_count'] }}</td>
                                <td class="text-success">৳{{ number_format($row['income'], 2) }}</td>
                                <td class="text-danger">৳{{ number_format($row['costs'], 2) }}</td>
                                <td class="{{ $row['profit'] >= 0 ? 'text-success' : 'text-danger' }} fw-semibold">
                                    {{ $row['profit'] >= 0 ? '+' : '-' }}৳{{ number_format(abs($row['profit']), 2) }}
                                </td>
                                <td>
                                    @if($row['income'] > 0)
                                        <span
                                            class="badge {{ ($row['profit'] / $row['income']) >= 0.2 ? 'bg-success' : (($row['profit'] / $row['income']) >= 0 ? 'bg-warning' : 'bg-danger') }}">
                                            {{ number_format(($row['profit'] / $row['income']) * 100, 0) }}%
                                        </span>
                                    @else
                                        <span class="badge bg-secondary">-</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6">
                                    <div class="empty-state"><i class="bi bi-graph-up d-block"></i>
                                        <div class="empty-title">No data available</div>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                    @if($reportData->count() > 0)
                        <tfoot class="table-light">
                            <tr class="fw-bold">
                                <td>Total</td>
                                <td>{{ $totals['events'] }}</td>
                                <td class="text-success">৳{{ number_format($totals['income'], 2) }}</td>
                                <td class="text-danger">৳{{ number_format($totals['costs'], 2) }}</td>
                                <td class="{{ $totals['profit'] >= 0 ? 'text-success' : 'text-danger' }}">
                                    {{ $totals['profit'] >= 0 ? '+' : '-' }}৳{{ number_format(abs($totals['profit']), 2) }}
                                </td>
                                <td>
                                    @if($totals['income'] > 0)
                                        <span
                                            class="badge {{ ($totals['profit'] / $totals['income']) >= 0.2 ? 'bg-success' : 'bg-warning' }}">
                                            {{ number_format(($totals['profit'] / $totals['income']) * 100, 0) }}%
                                        </span>
                                    @else
                                        <span class="badge bg-secondary">-</span>
                                    @endif
                                </td>
                            </tr>
                        </tfoot>
                    @endif
                </table>
            </div>
        </div>
    </div>
@endsection