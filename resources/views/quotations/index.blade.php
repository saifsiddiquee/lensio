@extends('layouts.app')
@section('title', 'Quotations')
@section('page-title', 'Quotations')
@section('content')
    <div class="page-header-modern">
        <h1><i class="bi bi-file-earmark-text-fill me-2" style="color: var(--primary-color);"></i>Quotation Management</h1>
        <a href="{{ route('quotations.create') }}" class="btn btn-modern btn-modern-primary"><i
                class="bi bi-plus-lg me-1"></i> New Quotation</a>
    </div>
    <div class="card card-modern">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-modern mb-0">
                    <thead>
                        <tr>
                            <th>Client</th>
                            <th>Package</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Valid Until</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($quotations as $quotation)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="avatar avatar-primary avatar-sm">
                                            {{ strtoupper(substr($quotation->client->name, 0, 2)) }}</div>
                                        <strong>{{ $quotation->client->name }}</strong>
                                    </div>
                                </td>
                                <td>{{ $quotation->package->name ?? '-' }}</td>
                                <td><strong>৳{{ number_format($quotation->amount, 2) }}</strong></td>
                                <td><span class="badge-modern {{ $quotation->status }}">{{ $quotation->status }}</span></td>
                                <td>{{ $quotation->valid_until?->format('M d, Y') ?? '-' }}</td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="{{ route('quotations.show', $quotation) }}"
                                            class="btn btn-sm btn-outline-secondary btn-icon btn-icon-sm"><i
                                                class="bi bi-eye"></i></a>
                                        <a href="{{ route('quotations.edit', $quotation) }}"
                                            class="btn btn-sm btn-outline-primary btn-icon btn-icon-sm"><i
                                                class="bi bi-pencil"></i></a>
                                        <form action="{{ route('quotations.destroy', $quotation) }}" method="POST"
                                            class="d-inline">@csrf @method('DELETE')<button type="submit"
                                                class="btn btn-sm btn-outline-danger btn-icon btn-icon-sm"
                                                onclick="return confirm('Delete?')"><i class="bi bi-trash"></i></button></form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6">
                                    <div class="empty-state"><i class="bi bi-file-earmark-text d-block"></i>
                                        <div class="empty-title">No quotations found</div>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="mt-3">{{ $quotations->links() }}</div>
@endsection