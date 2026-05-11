@extends('layouts.app')
@section('title', 'Equipment Details')
@section('page-title', 'Equipment Details')
@section('content')
    <div class="page-header-modern">
        <h1><i class="bi bi-camera-fill me-2" style="color: var(--warning-color);"></i>{{ $equipment->name }}</h1>
        <div class="d-flex gap-2">
            <a href="{{ route('equipment.edit', $equipment) }}" class="btn btn-modern btn-modern-primary"><i
                    class="bi bi-pencil me-1"></i> Edit</a>
            <a href="{{ route('equipment.index') }}" class="btn btn-outline-secondary"><i class="bi bi-arrow-left me-1"></i>
                Back</a>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-6">
            <div class="card detail-card">
                <div class="card-header">
                    <h6><i class="bi bi-info-circle-fill"></i> Equipment Details</h6>
                </div>
                <div class="card-body">
                    <dl class="row detail-list mb-0">
                        <dt class="col-sm-4">Name</dt>
                        <dd class="col-sm-8">{{ $equipment->name }}</dd>
                        <dt class="col-sm-4">Category</dt>
                        <dd class="col-sm-8"><span class="badge bg-secondary">{{ $equipment->category_label }}</span></dd>
                        <dt class="col-sm-4">Ownership</dt>
                        <dd class="col-sm-8"><span
                                class="badge-modern {{ $equipment->ownership_type == 'owned' ? 'approved' : 'sent' }}">{{ ucfirst($equipment->ownership_type) }}</span>
                        </dd>
                        <dt class="col-sm-4">Status</dt>
                        <dd class="col-sm-8"><span
                                class="badge-modern {{ $equipment->status }}">{{ ucfirst($equipment->status) }}</span></dd>
                        @if($equipment->serial_number)
                            <dt class="col-sm-4">Serial No</dt>
                            <dd class="col-sm-8">{{ $equipment->serial_number }}</dd>
                        @endif
                        @if($equipment->purchase_cost)
                            <dt class="col-sm-4">Purchase Cost</dt>
                            <dd class="col-sm-8">৳{{ number_format($equipment->purchase_cost, 2) }}</dd>
                        @endif
                        @if($equipment->rental_cost_per_day)
                            <dt class="col-sm-4">Rental/Day</dt>
                            <dd class="col-sm-8">৳{{ number_format($equipment->rental_cost_per_day, 2) }}</dd>
                        @endif
                        @if($equipment->notes)
                            <dt class="col-sm-4">Notes</dt>
                            <dd class="col-sm-8">{{ $equipment->notes }}</dd>
                        @endif
                    </dl>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card detail-card">
                <div class="card-header">
                    <h6><i class="bi bi-calendar-event-fill"></i> Assignment History</h6>
                </div>
                <div class="card-body p-0">
                    @forelse($equipment->events as $event)
                        <div class="activity-list-item d-flex justify-content-between align-items-center">
                            <div>
                                <strong>{{ $event->event_type }}</strong> - {{ $event->client->name }}<br>
                                <small class="text-muted">{{ $event->pivot->assigned_date }} →
                                    {{ $event->pivot->return_date ?? 'Ongoing' }}</small>
                            </div>
                            <div class="text-end">
                                @if($event->pivot->rental_cost > 0)
                                    <span
                                        class="text-success fw-semibold">৳{{ number_format($event->pivot->rental_cost, 2) }}</span>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="empty-state"><i class="bi bi-calendar d-block"></i>
                            <div class="empty-title">No assignments yet</div>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection