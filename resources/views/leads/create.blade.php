@extends('layouts.app')

@section('title', 'Create Lead')
@section('page-title', 'Create Lead')

@section('content')
    <div class="page-header-modern">
        <h1><i class="bi bi-person-plus-fill me-2" style="color: var(--primary-color);"></i>Create New Lead</h1>
        <a href="{{ route('leads.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i> Back
        </a>
    </div>

    <div class="card card-modern">
        <div class="card-body">
            <form action="{{ route('leads.store') }}" method="POST" class="form-modern">
                @csrf
                <div class="row g-4">
                    <div class="col-md-6">
                        <label for="name" class="form-label">Full Name *</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name"
                            value="{{ old('name') }}" required>
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label for="phone" class="form-label">Phone Number *</label>
                        <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone"
                            value="{{ old('phone') }}" required>
                        @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                            name="email" value="{{ old('email') }}">
                        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label for="source" class="form-label">Lead Source *</label>
                        <select class="form-select @error('source') is-invalid @enderror" id="source" name="source"
                            required>
                            <option value="">Select Source</option>
                            @foreach(['Facebook', 'Instagram', 'Referral', 'Website', 'Walk-in', 'Other'] as $source)
                                <option value="{{ $source }}" {{ old('source') == $source ? 'selected' : '' }}>{{ $source }}
                                </option>
                            @endforeach
                        </select>
                        @error('source')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label for="event_type" class="form-label">Event Type *</label>
                        <select class="form-select @error('event_type') is-invalid @enderror" id="event_type"
                            name="event_type" required>
                            <option value="">Select Event Type</option>
                            @foreach(['Wedding', 'Corporate', 'Birthday', 'Portrait', 'Product', 'Other'] as $type)
                                <option value="{{ $type }}" {{ old('event_type') == $type ? 'selected' : '' }}>{{ $type }}
                                </option>
                            @endforeach
                        </select>
                        @error('event_type')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label for="event_date" class="form-label">Tentative Event Date</label>
                        <input type="date" class="form-control @error('event_date') is-invalid @enderror" id="event_date"
                            name="event_date" value="{{ old('event_date') }}">
                        @error('event_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label for="status" class="form-label">Status *</label>
                        <select class="form-select @error('status') is-invalid @enderror" id="status" name="status"
                            required>
                            @foreach($statuses as $status)
                                <option value="{{ $status }}" {{ old('status', 'new') == $status ? 'selected' : '' }}>
                                    {{ ucfirst($status) }}</option>
                            @endforeach
                        </select>
                        @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label for="assigned_to" class="form-label">Assign To *</label>
                        <select class="form-select @error('assigned_to') is-invalid @enderror" id="assigned_to"
                            name="assigned_to" required>
                            <option value="">Select User</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ old('assigned_to', auth()->id()) == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }} ({{ ucfirst($user->role) }})
                                </option>
                            @endforeach
                        </select>
                        @error('assigned_to')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-12">
                        <label for="notes" class="form-label">Notes</label>
                        <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" name="notes"
                            rows="3">{{ old('notes') }}</textarea>
                        @error('notes')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="mt-4 pt-3 border-top">
                    <button type="submit" class="btn btn-modern btn-modern-primary">
                        <i class="bi bi-check-lg me-1"></i> Create Lead
                    </button>
                    <a href="{{ route('leads.index') }}" class="btn btn-outline-secondary ms-2">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection