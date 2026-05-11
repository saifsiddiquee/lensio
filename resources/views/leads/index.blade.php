@extends('layouts.app')

@section('title', 'Leads')
@section('page-title', 'Leads')

@section('content')
    <div class="page-header-modern">
        <h1><i class="bi bi-person-plus-fill me-2" style="color: var(--primary-color);"></i>Lead Management</h1>
        <a href="{{ route('leads.create') }}" class="btn btn-modern btn-modern-primary">
            <i class="bi bi-plus-lg me-1"></i> New Lead
        </a>
    </div>

    <div class="card card-modern">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-modern mb-0">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Contact</th>
                            <th>Event Type</th>
                            <th>Event Date</th>
                            <th>Status</th>
                            <th>Assigned To</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($leads as $lead)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="avatar avatar-primary avatar-sm">{{ strtoupper(substr($lead->name, 0, 2)) }}
                                        </div>
                                        <strong>{{ $lead->name }}</strong>
                                    </div>
                                </td>
                                <td>
                                    <div>{{ $lead->phone }}</div>
                                    <small class="text-muted">{{ $lead->email }}</small>
                                </td>
                                <td>{{ $lead->event_type }}</td>
                                <td>{{ $lead->event_date?->format('M d, Y') ?? '-' }}</td>
                                <td><span class="badge-modern {{ $lead->status }}">{{ $lead->status }}</span></td>
                                <td>{{ $lead->assignedUser->name ?? '-' }}</td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="{{ route('leads.show', $lead) }}"
                                            class="btn btn-sm btn-outline-secondary btn-icon btn-icon-sm" title="View">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('leads.edit', $lead) }}"
                                            class="btn btn-sm btn-outline-primary btn-icon btn-icon-sm" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        @if(!$lead->client)
                                            <form action="{{ route('leads.convert', $lead) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-outline-success btn-icon btn-icon-sm"
                                                    title="Convert" onclick="return confirm('Convert this lead to a client?')">
                                                    <i class="bi bi-person-check"></i>
                                                </button>
                                            </form>
                                        @endif
                                        <form action="{{ route('leads.destroy', $lead) }}" method="POST" class="d-inline">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger btn-icon btn-icon-sm"
                                                title="Delete" onclick="return confirm('Are you sure?')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7">
                                    <div class="empty-state">
                                        <i class="bi bi-person-plus d-block"></i>
                                        <div class="empty-title">No leads found</div>
                                        <div class="empty-subtitle">Create your first lead to get started</div>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="mt-3">{{ $leads->links() }}</div>
@endsection