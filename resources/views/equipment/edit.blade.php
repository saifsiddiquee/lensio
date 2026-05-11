@extends('layouts.app')
@section('title', 'Edit Equipment')
@section('page-title', 'Edit Equipment')
@section('content')
    <div class="page-header-modern">
        <h1><i class="bi bi-pencil-fill me-2" style="color: var(--warning-color);"></i>Edit Equipment</h1>
        <a href="{{ route('equipment.index') }}" class="btn btn-outline-secondary"><i class="bi bi-arrow-left me-1"></i>
            Back</a>
    </div>

    <div class="card card-modern">
        <div class="card-body">
            <form action="{{ route('equipment.update', $equipment) }}" method="POST" class="form-modern">
                @csrf @method('PUT')
                <div class="row g-4">
                    <div class="col-md-6">
                        <label for="name" class="form-label">Equipment Name *</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name"
                            value="{{ old('name', $equipment->name) }}" required>
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label for="category" class="form-label">Category *</label>
                        <select class="form-select @error('category') is-invalid @enderror" id="category" name="category"
                            required>
                            @foreach($categories as $cat)
                                <option value="{{ $cat }}" {{ old('category', $equipment->category) == $cat ? 'selected' : '' }}>
                                    {{ ucfirst($cat) }}</option>
                            @endforeach
                        </select>
                        @error('category')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label for="ownership_type" class="form-label">Ownership Type *</label>
                        <select class="form-select @error('ownership_type') is-invalid @enderror" id="ownership_type"
                            name="ownership_type" required>
                            @foreach($ownershipTypes as $type)
                                <option value="{{ $type }}" {{ old('ownership_type', $equipment->ownership_type) == $type ? 'selected' : '' }}>{{ ucfirst($type) }}</option>
                            @endforeach
                        </select>
                        @error('ownership_type')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label for="status" class="form-label">Status *</label>
                        <select class="form-select @error('status') is-invalid @enderror" id="status" name="status"
                            required>
                            @foreach($statuses as $status)
                                <option value="{{ $status }}" {{ old('status', $equipment->status) == $status ? 'selected' : '' }}>{{ ucfirst($status) }}</option>
                            @endforeach
                        </select>
                        @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label for="purchase_cost" class="form-label">Purchase Cost</label>
                        <div class="input-group">
                            <span class="input-group-text">৳</span>
                            <input type="number" step="0.01"
                                class="form-control @error('purchase_cost') is-invalid @enderror" id="purchase_cost"
                                name="purchase_cost" value="{{ old('purchase_cost', $equipment->purchase_cost) }}">
                        </div>
                        @error('purchase_cost')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label for="rental_cost_per_day" class="form-label">Rental Cost Per Day</label>
                        <div class="input-group">
                            <span class="input-group-text">৳</span>
                            <input type="number" step="0.01"
                                class="form-control @error('rental_cost_per_day') is-invalid @enderror"
                                id="rental_cost_per_day" name="rental_cost_per_day"
                                value="{{ old('rental_cost_per_day', $equipment->rental_cost_per_day) }}">
                        </div>
                        @error('rental_cost_per_day')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label for="serial_number" class="form-label">Serial Number</label>
                        <input type="text" class="form-control @error('serial_number') is-invalid @enderror"
                            id="serial_number" name="serial_number"
                            value="{{ old('serial_number', $equipment->serial_number) }}">
                        @error('serial_number')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-12">
                        <label for="notes" class="form-label">Notes</label>
                        <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" name="notes"
                            rows="2">{{ old('notes', $equipment->notes) }}</textarea>
                        @error('notes')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="mt-4 pt-3 border-top">
                    <button type="submit" class="btn btn-modern btn-modern-primary"><i class="bi bi-check-lg me-1"></i>
                        Update Equipment</button>
                    <a href="{{ route('equipment.index') }}" class="btn btn-outline-secondary ms-2">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection