@extends('layouts.app')
@section('title', 'Edit Contract')
@section('page-title', 'Edit Contract')
@section('content')
    <div class="page-header-modern">
        <h1><i class="bi bi-pencil-fill me-2" style="color: var(--success-color);"></i>Edit Contract</h1>
        <a href="{{ route('contracts.index') }}" class="btn btn-outline-secondary"><i class="bi bi-arrow-left me-1"></i>
            Back</a>
    </div>
    <div class="card card-modern">
        <div class="card-body">
            <form action="{{ route('contracts.update', $contract) }}" method="POST" class="form-modern">
                @csrf @method('PUT')
                <div class="row g-4">
                    <div class="col-md-6"><label for="event_id" class="form-label">Event *</label><select
                            class="form-select @error('event_id') is-invalid @enderror" id="event_id" name="event_id"
                            required>@foreach($events as $event)<option value="{{ $event->id }}" {{ old('event_id', $contract->event_id) == $event->id ? 'selected' : '' }}>{{ $event->event_type }} -
                            {{ $event->client->name }}</option>@endforeach</select>@error('event_id')<div
                                class="invalid-feedback">{{ $message }}</div>@enderror</div>
                    <div class="col-md-6"><label for="reference_no" class="form-label">Reference No *</label><input
                            type="text" class="form-control @error('reference_no') is-invalid @enderror" id="reference_no"
                            name="reference_no" value="{{ old('reference_no', $contract->reference_no) }}"
                            required>@error('reference_no')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                    <div class="col-md-6"><label for="status" class="form-label">Status *</label><select
                            class="form-select @error('status') is-invalid @enderror" id="status" name="status"
                            required>@foreach($statuses as $status)<option value="{{ $status }}" {{ old('status', $contract->status) == $status ? 'selected' : '' }}>{{ ucfirst($status) }}</option>
                            @endforeach</select>@error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="mt-4 pt-3 border-top"><button type="submit" class="btn btn-modern btn-modern-success"><i
                            class="bi bi-check-lg me-1"></i> Update Contract</button><a
                        href="{{ route('contracts.index') }}" class="btn btn-outline-secondary ms-2">Cancel</a></div>
            </form>
        </div>
    </div>
@endsection