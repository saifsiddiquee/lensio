@extends('layouts.app')
@section('title', 'Events')
@section('page-title', 'Events')

@section('content')
    <div class="page-header-modern">
        <h1><i class="bi bi-calendar-event-fill me-2" style="color: var(--purple-color);"></i>Event Management</h1>
        @if(auth()->user()->isAdmin() || auth()->user()->isSales())
            <a href="{{ route('events.create') }}" class="btn btn-modern btn-modern-primary"><i class="bi bi-plus-lg me-1"></i>
                New Event</a>
        @endif
    </div>

    <div class="card card-modern">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-modern mb-0">
                    <thead>
                        <tr>
                            <th>Event</th>
                            <th>Client</th>
                            <th>Date</th>
                            <th>Venue</th>
                            <th>Team</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($events as $event)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="avatar avatar-purple avatar-sm"><i class="bi bi-camera"></i></div>
                                        <strong>{{ $event->event_type }}</strong>
                                    </div>
                                </td>
                                <td>{{ $event->client->name }}</td>
                                <td>{{ $event->event_date->format('M d, Y') }}</td>
                                <td>{{ Str::limit($event->venue, 25) }}</td>
                                <td>
                                    @foreach($event->users->take(2) as $user)
                                        <span class="badge bg-secondary">{{ explode(' ', $user->name)[0] }}</span>
                                    @endforeach
                                    @if($event->users->count() > 2)<span
                                    class="badge bg-light text-dark">+{{ $event->users->count() - 2 }}</span>@endif
                                </td>
                                <td><span class="badge-modern {{ $event->status }}">{{ $event->status }}</span></td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="{{ route('events.show', $event) }}"
                                            class="btn btn-sm btn-outline-secondary btn-icon btn-icon-sm"><i
                                                class="bi bi-eye"></i></a>
                                        @if(auth()->user()->isAdmin() || auth()->user()->isSales())
                                            <a href="{{ route('events.edit', $event) }}"
                                                class="btn btn-sm btn-outline-primary btn-icon btn-icon-sm"><i
                                                    class="bi bi-pencil"></i></a>
                                            <form action="{{ route('events.destroy', $event) }}" method="POST" class="d-inline">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger btn-icon btn-icon-sm"
                                                    onclick="return confirm('Delete?')"><i class="bi bi-trash"></i></button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7">
                                    <div class="empty-state"><i class="bi bi-calendar-event d-block"></i>
                                        <div class="empty-title">No events found</div>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="mt-3">{{ $events->links() }}</div>
@endsection