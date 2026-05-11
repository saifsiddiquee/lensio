@extends('layouts.app')
@section('title', 'Clients')
@section('page-title', 'Clients')

@section('content')
    <div class="page-header-modern">
        <h1><i class="bi bi-people-fill me-2" style="color: var(--success-color);"></i>Client Management</h1>
        <a href="{{ route('clients.create') }}" class="btn btn-modern btn-modern-success">
            <i class="bi bi-plus-lg me-1"></i> New Client
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
                            <th>Lead Source</th>
                            <th>Events</th>
                            <th>Created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($clients as $client)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="avatar avatar-success avatar-sm">
                                            {{ strtoupper(substr($client->name, 0, 2)) }}</div>
                                        <strong>{{ $client->name }}</strong>
                                    </div>
                                </td>
                                <td>
                                    <div>{{ $client->phone }}</div><small class="text-muted">{{ $client->email }}</small>
                                </td>
                                <td>{{ $client->lead->source ?? '-' }}</td>
                                <td><span class="badge bg-secondary">{{ $client->events->count() }}</span></td>
                                <td>{{ $client->created_at->format('M d, Y') }}</td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="{{ route('clients.show', $client) }}"
                                            class="btn btn-sm btn-outline-secondary btn-icon btn-icon-sm"><i
                                                class="bi bi-eye"></i></a>
                                        <a href="{{ route('clients.edit', $client) }}"
                                            class="btn btn-sm btn-outline-primary btn-icon btn-icon-sm"><i
                                                class="bi bi-pencil"></i></a>
                                        <form action="{{ route('clients.destroy', $client) }}" method="POST" class="d-inline">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger btn-icon btn-icon-sm"
                                                onclick="return confirm('Delete?')"><i class="bi bi-trash"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6">
                                    <div class="empty-state"><i class="bi bi-people d-block"></i>
                                        <div class="empty-title">No clients found</div>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="mt-3">{{ $clients->links() }}</div>
@endsection