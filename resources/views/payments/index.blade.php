@extends('layouts.app')
@section('title', 'Payments')
@section('page-title', 'Payments')
@section('content')
    <div class="page-header-modern">
        <h1><i class="bi bi-credit-card-fill me-2" style="color: var(--success-color);"></i>Payment Records</h1>
        <a href="{{ route('payments.create') }}" class="btn btn-modern btn-modern-success"><i
                class="bi bi-plus-lg me-1"></i> Record Payment</a>
    </div>
    <div class="card card-modern">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-modern mb-0">
                    <thead>
                        <tr>
                            <th>Invoice</th>
                            <th>Client</th>
                            <th>Amount</th>
                            <th>Date</th>
                            <th>Method</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($payments as $payment)
                            <tr>
                                <td><strong>{{ $payment->invoice->invoice_no }}</strong></td>
                                <td>{{ $payment->invoice->event->client->name }}</td>
                                <td><strong class="text-success">৳{{ number_format($payment->amount, 2) }}</strong></td>
                                <td>{{ $payment->payment_date->format('M d, Y') }}</td>
                                <td><span class="badge bg-secondary">{{ $payment->method }}</span></td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="{{ route('payments.show', $payment) }}"
                                            class="btn btn-sm btn-outline-secondary btn-icon btn-icon-sm"><i
                                                class="bi bi-eye"></i></a>
                                        <a href="{{ route('payments.edit', $payment) }}"
                                            class="btn btn-sm btn-outline-primary btn-icon btn-icon-sm"><i
                                                class="bi bi-pencil"></i></a>
                                        <form action="{{ route('payments.destroy', $payment) }}" method="POST" class="d-inline">
                                            @csrf @method('DELETE')<button type="submit"
                                                class="btn btn-sm btn-outline-danger btn-icon btn-icon-sm"
                                                onclick="return confirm('Delete?')"><i class="bi bi-trash"></i></button></form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6">
                                    <div class="empty-state"><i class="bi bi-cash d-block"></i>
                                        <div class="empty-title">No payments found</div>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="mt-3">{{ $payments->links() }}</div>
@endsection