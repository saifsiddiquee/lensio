@extends('layouts.app')
@section('title', 'Invoices')
@section('page-title', 'Invoices')
@section('content')
    <div class="page-header-modern">
        <h1><i class="bi bi-receipt me-2" style="color: var(--warning-color);"></i>Invoice Management</h1>
        <a href="{{ route('invoices.create') }}" class="btn btn-modern btn-modern-primary"><i
                class="bi bi-plus-lg me-1"></i> New Invoice</a>
    </div>
    <div class="card card-modern">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-modern mb-0">
                    <thead>
                        <tr>
                            <th>Invoice No</th>
                            <th>Event</th>
                            <th>Client</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($invoices as $invoice)
                            <tr>
                                <td><strong>{{ $invoice->invoice_no }}</strong></td>
                                <td>{{ $invoice->event->event_type }}</td>
                                <td>{{ $invoice->event->client->name }}</td>
                                <td><strong>৳{{ number_format($invoice->total_amount, 2) }}</strong></td>
                                <td><span class="badge-modern {{ $invoice->status }}">{{ $invoice->status }}</span></td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="{{ route('invoices.show', $invoice) }}"
                                            class="btn btn-sm btn-outline-secondary btn-icon btn-icon-sm"><i
                                                class="bi bi-eye"></i></a>
                                        <a href="{{ route('invoices.edit', $invoice) }}"
                                            class="btn btn-sm btn-outline-primary btn-icon btn-icon-sm"><i
                                                class="bi bi-pencil"></i></a>
                                        <form action="{{ route('invoices.destroy', $invoice) }}" method="POST" class="d-inline">
                                            @csrf @method('DELETE')<button type="submit"
                                                class="btn btn-sm btn-outline-danger btn-icon btn-icon-sm"
                                                onclick="return confirm('Delete?')"><i class="bi bi-trash"></i></button></form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6">
                                    <div class="empty-state"><i class="bi bi-receipt d-block"></i>
                                        <div class="empty-title">No invoices found</div>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="mt-3">{{ $invoices->links() }}</div>
@endsection