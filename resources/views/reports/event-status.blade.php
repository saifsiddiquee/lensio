@extends('layouts.app')
@section('title', 'Event Status')
@section('page-title', 'Event Status Report')
@section('content')
    <div class="page-header-modern">
        <h1><i class="bi bi-calendar-check me-2" style="color: var(--purple-color);"></i>Event Status Report</h1>
        <a href="{{ route('reports.index') }}" class="btn btn-outline-secondary"><i class="bi bi-arrow-left me-1"></i>
            Back</a>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card stat-card-modern">
                <div class="card-body">
                    <i class="bi bi-calendar-event stat-icon"></i>
                    <div class="stat-value">{{ $eventStats['planned'] }}</div>
                    <div class="stat-label">Planned</div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card stat-card-modern green">
                <div class="card-body">
                    <i class="bi bi-check-circle stat-icon"></i>
                    <div class="stat-value">{{ $eventStats['completed'] }}</div>
                    <div class="stat-label">Completed</div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card stat-card-modern orange">
                <div class="card-body">
                    <i class="bi bi-x-circle stat-icon"></i>
                    <div class="stat-value">{{ $eventStats['cancelled'] }}</div>
                    <div class="stat-label">Cancelled</div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-md-6">
            <div class="card detail-card">
                <div class="card-header">
                    <h6><i class="bi bi-calendar-event-fill"></i> Upcoming Events</h6>
                </div>
                <div class="card-body p-0">
                    @forelse($upcomingEvents as $event)
                        <div class="activity-list-item d-flex justify-content-between align-items-center">
                            <div>
                                <strong>{{ $event->event_type }}</strong> - {{ $event->client->name }}<br>
                                <small class="text-muted">{{ $event->venue }}</small>
                            </div>
                            <span class="fw-semibold"
                                style="color: var(--primary-color);">{{ $event->event_date->format('M d') }}</span>
                        </div>
                    @empty
                        <div class="empty-state"><i class="bi bi-calendar d-block"></i>
                            <div class="empty-title">No upcoming events</div>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card detail-card">
                <div class="card-header">
                    <h6><i class="bi bi-check-circle-fill"></i> Recently Completed</h6>
                </div>
                <div class="card-body p-0">
                    @forelse($recentCompleted as $event)
                        <div class="activity-list-item">
                            <strong>{{ $event->event_type }}</strong> - {{ $event->client->name }}<br>
                            <small class="text-muted">{{ $event->event_date->format('M d, Y') }}</small>
                        </div>
                    @empty
                        <div class="empty-state"><i class="bi bi-check-circle d-block"></i>
                            <div class="empty-title">No completed events</div>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection