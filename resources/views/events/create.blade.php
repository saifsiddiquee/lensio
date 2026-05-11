@extends('layouts.app')
@section('title', 'Create Event')
@section('page-title', 'Create Event')

@section('content')
    <div class="page-header-modern">
        <h1><i class="bi bi-calendar-event-fill me-2" style="color: var(--purple-color);"></i>Create New Event</h1>
        <a href="{{ route('events.index') }}" class="btn btn-outline-secondary"><i class="bi bi-arrow-left me-1"></i>
            Back</a>
    </div>

    <div class="card card-modern">
        <div class="card-body">
            <form action="{{ route('events.store') }}" method="POST" class="form-modern">
                @csrf
                <div class="row g-4">
                    <div class="col-md-6">
                        <label for="client_id" class="form-label">Client *</label>
                        <select class="form-select @error('client_id') is-invalid @enderror" id="client_id" name="client_id"
                            required>
                            <option value="">Select Client</option>
                            @foreach($clients as $client)<option value="{{ $client->id }}" {{ old('client_id') == $client->id ? 'selected' : '' }}>{{ $client->name }}</option>@endforeach
                        </select>
                        @error('client_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label for="event_type" class="form-label">Event Type *</label>
                        <select class="form-select @error('event_type') is-invalid @enderror" id="event_type"
                            name="event_type" required>
                            <option value="">Select Type</option>
                            @foreach(['Wedding', 'Corporate', 'Birthday', 'Portrait', 'Product', 'Other'] as $type)
                                <option value="{{ $type }}" {{ old('event_type') == $type ? 'selected' : '' }}>{{ $type }}
                                </option>
                            @endforeach
                        </select>
                        @error('event_type')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label for="event_date" class="form-label">Event Date *</label>
                        <input type="date" class="form-control @error('event_date') is-invalid @enderror" id="event_date"
                            name="event_date" value="{{ old('event_date') }}" required>
                        @error('event_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label for="status" class="form-label">Status *</label>
                        <select class="form-select @error('status') is-invalid @enderror" id="status" name="status"
                            required>
                            @foreach($statuses as $status)<option value="{{ $status }}" {{ old('status', 'planned') == $status ? 'selected' : '' }}>{{ ucfirst($status) }}</option>@endforeach
                        </select>
                        @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-12">
                        <label for="venue" class="form-label">Venue *</label>
                        <input type="text" class="form-control @error('venue') is-invalid @enderror" id="venue" name="venue"
                            value="{{ old('venue') }}" required>
                        @error('venue')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Assign Photographers</label>
                        <div class="border rounded p-3" style="max-height: 150px; overflow-y: auto;">
                            @foreach($photographers as $photographer)
                                <div class="form-check"><input class="form-check-input" type="checkbox" name="user_ids[]"
                                        value="{{ $photographer->id }}" id="p{{ $photographer->id }}"><label
                                        class="form-check-label"
                                        for="p{{ $photographer->id }}">{{ $photographer->name }}</label></div>
                            @endforeach
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Assign Editors</label>
                        <div class="border rounded p-3" style="max-height: 150px; overflow-y: auto;">
                            @foreach($editors as $editor)
                                <div class="form-check"><input class="form-check-input" type="checkbox" name="user_ids[]"
                                        value="{{ $editor->id }}" id="e{{ $editor->id }}"><label class="form-check-label"
                                        for="e{{ $editor->id }}">{{ $editor->name }}</label></div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="mt-4 pt-3 border-top">
                    <button type="submit" class="btn btn-modern btn-modern-primary"><i class="bi bi-check-lg me-1"></i>
                        Create Event</button>
                    <a href="{{ route('events.index') }}" class="btn btn-outline-secondary ms-2">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection