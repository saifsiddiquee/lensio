@extends('layouts.app')
@section('title', 'Edit Event')
@section('page-title', 'Edit Event')

@section('content')
    <div class="page-header-modern">
        <h1><i class="bi bi-pencil-fill me-2" style="color: var(--purple-color);"></i>Edit Event</h1>
        <a href="{{ route('events.index') }}" class="btn btn-outline-secondary"><i class="bi bi-arrow-left me-1"></i>
            Back</a>
    </div>

    <div class="card card-modern">
        <div class="card-body">
            <form action="{{ route('events.update', $event) }}" method="POST" class="form-modern">
                @csrf @method('PUT')
                <div class="row g-4">
                    <div class="col-md-6">
                        <label for="client_id" class="form-label">Client *</label>
                        <select class="form-select @error('client_id') is-invalid @enderror" id="client_id" name="client_id"
                            required>
                            @foreach($clients as $client)<option value="{{ $client->id }}" {{ old('client_id', $event->client_id) == $client->id ? 'selected' : '' }}>{{ $client->name }}</option>@endforeach
                        </select>
                        @error('client_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label for="event_type" class="form-label">Event Type *</label>
                        <select class="form-select @error('event_type') is-invalid @enderror" id="event_type"
                            name="event_type" required>
                            @foreach(['Wedding', 'Corporate', 'Birthday', 'Portrait', 'Product', 'Other'] as $type)
                                <option value="{{ $type }}" {{ old('event_type', $event->event_type) == $type ? 'selected' : '' }}>{{ $type }}</option>
                            @endforeach
                        </select>
                        @error('event_type')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label for="event_date" class="form-label">Event Date *</label>
                        <input type="date" class="form-control @error('event_date') is-invalid @enderror" id="event_date"
                            name="event_date" value="{{ old('event_date', $event->event_date->format('Y-m-d')) }}" required>
                        @error('event_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label for="status" class="form-label">Status *</label>
                        <select class="form-select @error('status') is-invalid @enderror" id="status" name="status"
                            required>
                            @foreach($statuses as $status)<option value="{{ $status }}" {{ old('status', $event->status) == $status ? 'selected' : '' }}>{{ ucfirst($status) }}</option>@endforeach
                        </select>
                        @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-12">
                        <label for="venue" class="form-label">Venue *</label>
                        <input type="text" class="form-control @error('venue') is-invalid @enderror" id="venue" name="venue"
                            value="{{ old('venue', $event->venue) }}" required>
                        @error('venue')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="mt-4 pt-3 border-top">
                    <button type="submit" class="btn btn-modern btn-modern-primary"><i class="bi bi-check-lg me-1"></i>
                        Update Event</button>
                    <a href="{{ route('events.index') }}" class="btn btn-outline-secondary ms-2">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection