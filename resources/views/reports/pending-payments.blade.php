@extends('layouts.app')
@section('title', 'Pending Payments')
@section('page-title', 'Pending Payments Report')
@section('content')
    <div class="page-header-modern">
        <h1><i class="bi bi-clock-history me-2" style="color: var(--warning-color);"></i>Pending Payments</h1>
        <a href="{{ route('reports.index') }}" class="btn btn-outline-secondary"><i class="bi bi-arrow-left me-1"></i>
            Back</a>
    </div>

    <div class="card stat-card-modern orange mb-4">
        <div class="card-body">
            <i class="bi bi-exclamation-triangle stat-icon"></i>
            <div class="stat-value">৳{{ number_format($totalPending, 0) }}</div>
            <div class="stat-label">Total Pending Amount</div>
        </div>
    </div>

    <div class="card card-modern">
        <div class="card-header">
            <h6 class="card-header-title"><i class="bi bi-receipt"></i> Unpaid Invoices</h6>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-modern mb-0">
                    <thead>
                        <tr>
                            <th>Invoice</th>
                            <th>Client</th>
                            <th>Total</th>
                            <th>Paid</th>
                            <th>Balance</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pendingInvoices as $invoice)
                            <tr>
                                <td><a href="{{ route('invoices.show', $invoice) }}"
                                        class="fw-semibold">{{ $invoice->invoice_no }}</a></td>
                                <td>{{ $invoice->event->client->name }}</td>
                                <td>৳{{ number_format($invoice->total_amount, 2) }}</td>
                                <td class="text-success">৳{{ number_format($invoice->paid_amount, 2) }}</td>
                                <td class="text-danger fw-semibold">৳{{ number_format($invoice->balance, 2) }}</td>
                                <td><span class="badge-modern {{ $invoice->status }}">{{ $invoice->status }}</span></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6">
                                    <div class="empty-state"><i class="bi bi-check-circle d-block text-success"></i>
                                        <div class="empty-title">No pending invoices!</div>
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