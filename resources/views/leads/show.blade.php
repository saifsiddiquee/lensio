@extends('layouts.app')

@section('title', 'Lead Details')
@section('page-title', 'Lead Details')

@section('content')
<div class="page-header-modern">
    <h1><i class="bi bi-person-fill me-2" style="color: var(--primary-color);"></i>{{ $lead->name }}</h1>
    <div class="d-flex gap-2">
        <a href="{{ route('leads.edit', $lead) }}" class="btn btn-modern btn-modern-primary">
            <i class="bi bi-pencil me-1"></i> Edit
        </a>
        <a href="{{ route('leads.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i> Back
        </a>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="card detail-card">
            <div class="card-header">
                <h6><i class="bi bi-info-circle-fill"></i> Lead Information</h6>
            </div>
            <div class="card-body">
                <dl class="row detail-list mb-0">
                    <dt class="col-sm-3">Full Name</dt>
                    <dd class="col-sm-9">{{ $lead->name }}</dd>
                    
                    <dt class="col-sm-3">Phone</dt>
                    <dd class="col-sm-9">{{ $lead->phone }}</dd>
                    
                    <dt class="col-sm-3">Email</dt>
                    <dd class="col-sm-9">{{ $lead->email ?? '-' }}</dd>
                    
                    <dt class="col-sm-3">Source</dt>
                    <dd class="col-sm-9">{{ $lead->source }}</dd>
                    
                    <dt class="col-sm-3">Event Type</dt>
                    <dd class="col-sm-9">{{ $lead->event_type }}</dd>
                    
                    <dt class="col-sm-3">Event Date</dt>
                    <dd class="col-sm-9">{{ $lead->event_date?->format('F d, Y') ?? '-' }}</dd>
                    
                    <dt class="col-sm-3">Status</dt>
                    <dd class="col-sm-9"><span class="badge-modern {{ $lead->status }}">{{ $lead->status }}</span></dd>
                    
                    <dt class="col-sm-3">Assigned To</dt>
                    <dd class="col-sm-9">{{ $lead->assignedUser->name ?? '-' }}</dd>
                    
                    <dt class="col-sm-3">Notes</dt>
                    <dd class="col-sm-9">{{ $lead->notes ?? '-' }}</dd>
                </dl>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="card detail-card mb-4">
            <div class="card-header">
                <h6><i class="bi bi-lightning-fill"></i> Quick Actions</h6>
            </div>
            <div class="card-body">
                @if(!$lead->client)
                <form action="{{ route('leads.convert', $lead) }}" method="POST" class="mb-3">
                    @csrf
                    <button type="submit" class="btn btn-modern btn-modern-success w-100" onclick="return confirm('Convert this lead to a client?')">
                        <i class="bi bi-person-check me-1"></i> Convert to Client
                    </button>
                </form>
                @else
                <div class="alert alert-success mb-3">
                    <i class="bi bi-check-circle-fill me-1"></i> Converted to client
                    <a href="{{ route('clients.show', $lead->client) }}" class="alert-link d-block mt-1">View Client →</a>
                </div>
                @endif
                
                <form action="{{ route('leads.destroy', $lead) }}" method="POST">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger w-100" onclick="return confirm('Delete this lead?')">
                        <i class="bi bi-trash me-1"></i> Delete Lead
                    </button>
                </form>
            </div>
        </div>
        
        <div class="card detail-card">
            <div class="card-header">
                <h6><i class="bi bi-clock-fill"></i> Timeline</h6>
            </div>
            <div class="card-body">
                <small class="text-muted d-block mb-2">
                    <strong>Created:</strong> {{ $lead->created_at->format('M d, Y h:i A') }}
                </small>
                <small class="text-muted d-block">
                    <strong>Updated:</strong> {{ $lead->updated_at->format('M d, Y h:i A') }}
                </small>
            </div>
        </div>
    </div>
</div>
@endsection