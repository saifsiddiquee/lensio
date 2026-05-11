@extends('layouts.app')
@section('title', 'Contracts')
@section('page-title', 'Contracts')
@section('content')
    <div class="page-header-modern">
        <h1><i class="bi bi-file-earmark-check-fill me-2" style="color: var(--success-color);"></i>Contract Management</h1>
        <a href="{{ route('contracts.create') }}" class="btn btn-modern btn-modern-success"><i
                class="bi bi-plus-lg me-1"></i> New Contract</a>
    </div>
    <div class="card card-modern">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-modern mb-0">
                    <thead>
                        <tr>
                            <th>Reference</th>
                            <th>Event</th>
                            <th>Client</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($contracts as $contract)
                            <tr>
                                <td><strong>{{ $contract->reference_no }}</strong></td>
                                <td>{{ $contract->event->event_type }} ({{ $contract->event->event_date->format('M d, Y') }})
                                </td>
                                <td>{{ $contract->event->client->name }}</td>
                                <td><span class="badge-modern {{ $contract->status }}">{{ $contract->status }}</span></td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="{{ route('contracts.show', $contract) }}"
                                            class="btn btn-sm btn-outline-secondary btn-icon btn-icon-sm"><i
                                                class="bi bi-eye"></i></a>
                                        <a href="{{ route('contracts.edit', $contract) }}"
                                            class="btn btn-sm btn-outline-primary btn-icon btn-icon-sm"><i
                                                class="bi bi-pencil"></i></a>
                                        <form action="{{ route('contracts.destroy', $contract) }}" method="POST"
                                            class="d-inline">@csrf @method('DELETE')<button type="submit"
                                                class="btn btn-sm btn-outline-danger btn-icon btn-icon-sm"
                                                onclick="return confirm('Delete?')"><i class="bi bi-trash"></i></button></form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5">
                                    <div class="empty-state"><i class="bi bi-file-earmark-check d-block"></i>
                                        <div class="empty-title">No contracts found</div>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="mt-3">{{ $contracts->links() }}</div>
@endsection