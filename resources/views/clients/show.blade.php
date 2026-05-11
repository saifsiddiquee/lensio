@extends('layouts.app')
@section('title', 'Client Details')
@section('page-title', 'Client Details')

@section('content')
    <div class="page-header-modern">
        <h1><i class="bi bi-person-fill me-2" style="color: var(--success-color);"></i>{{ $client->name }}</h1>
        <div class="d-flex gap-2">
            <a href="{{ route('clients.edit', $client) }}" class="btn btn-modern btn-modern-primary"><i
                    class="bi bi-pencil me-1"></i> Edit</a>
            <a href="{{ route('clients.index') }}" class="btn btn-outline-secondary"><i class="bi bi-arrow-left me-1"></i>
                Back</a>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-6">
            <div class="card detail-card">
                <div class="card-header">
                    <h6><i class="bi bi-info-circle-fill"></i> Client Information</h6>
                </div>
                <div class="card-body">
                    <dl class="row detail-list mb-0">
                        <dt class="col-sm-4">Name</dt>
                        <dd class="col-sm-8">{{ $client->name }}</dd>
                        <dt class="col-sm-4">Phone</dt>
                        <dd class="col-sm-8">{{ $client->phone }}</dd>
                        <dt class="col-sm-4">Email</dt>
                        <dd class="col-sm-8">{{ $client->email ?? '-' }}</dd>
                        <dt class="col-sm-4">Address</dt>
                        <dd class="col-sm-8">{{ $client->address ?? '-' }}</dd>
                        <dt class="col-sm-4">Lead Source</dt>
                        <dd class="col-sm-8">{{ $client->lead->source ?? '-' }}</dd>
                    </dl>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card detail-card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h6 class="mb-0"><i class="bi bi-calendar-event-fill me-2"
                            style="color: var(--purple-color);"></i>Events</h6>
                    <a href="{{ route('events.create') }}" class="btn btn-sm btn-outline-primary"><i
                            class="bi bi-plus"></i></a>
                </div>
                <div class="card-body p-0">
                    @forelse($client->events as $event)
                        <div class="activity-list-item d-flex justify-content-between align-items-center">
                            <div>
                                <strong>{{ $event->event_type }}</strong><br>
                                <small class="text-muted">{{ $event->event_date->format('M d, Y') }} •
                                    {{ $event->venue }}</small>
                            </div>
                            <span class="badge-modern {{ $event->status }}">{{ $event->status }}</span>
                        </div>
                    @empty
                        <div class="empty-state"><i class="bi bi-calendar-event d-block"></i>
                            <div class="empty-title">No events yet</div>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection