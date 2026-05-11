@extends('layouts.app')
@section('title', 'Edit Client')
@section('page-title', 'Edit Client')

@section('content')
    <div class="page-header-modern">
        <h1><i class="bi bi-pencil-fill me-2" style="color: var(--success-color);"></i>Edit Client</h1>
        <a href="{{ route('clients.index') }}" class="btn btn-outline-secondary"><i class="bi bi-arrow-left me-1"></i>
            Back</a>
    </div>

    <div class="card card-modern">
        <div class="card-body">
            <form action="{{ route('clients.update', $client) }}" method="POST" class="form-modern">
                @csrf @method('PUT')
                <div class="row g-4">
                    <div class="col-md-6">
                        <label for="lead_id" class="form-label">From Lead *</label>
                        <select class="form-select @error('lead_id') is-invalid @enderror" id="lead_id" name="lead_id"
                            required>
                            @foreach($leads as $lead)<option value="{{ $lead->id }}" {{ old('lead_id', $client->lead_id) == $lead->id ? 'selected' : '' }}>{{ $lead->name }} -
                            {{ $lead->event_type }}</option>@endforeach
                        </select>
                        @error('lead_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label for="name" class="form-label">Full Name *</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name"
                            value="{{ old('name', $client->name) }}" required>
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label for="phone" class="form-label">Phone *</label>
                        <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone"
                            value="{{ old('phone', $client->phone) }}" required>
                        @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                            name="email" value="{{ old('email', $client->email) }}">
                        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-12">
                        <label for="address" class="form-label">Address</label>
                        <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address"
                            rows="2">{{ old('address', $client->address) }}</textarea>
                        @error('address')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="mt-4 pt-3 border-top">
                    <button type="submit" class="btn btn-modern btn-modern-success"><i class="bi bi-check-lg me-1"></i>
                        Update Client</button>
                    <a href="{{ route('clients.index') }}" class="btn btn-outline-secondary ms-2">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection