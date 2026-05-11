@extends('layouts.app')
@section('title', 'Create Package')
@section('page-title', 'Create Package')
@section('content')
    <div class="page-header-modern">
        <h1><i class="bi bi-box-fill me-2" style="color: var(--warning-color);"></i>Create New Package</h1>
        <a href="{{ route('packages.index') }}" class="btn btn-outline-secondary"><i class="bi bi-arrow-left me-1"></i>
            Back</a>
    </div>
    <div class="card card-modern">
        <div class="card-body">
            <form action="{{ route('packages.store') }}" method="POST" class="form-modern">
                @csrf
                <div class="row g-4">
                    <div class="col-md-6"><label for="name" class="form-label">Package Name *</label><input type="text"
                            class="form-control @error('name') is-invalid @enderror" id="name" name="name"
                            value="{{ old('name') }}" required>@error('name')<div class="invalid-feedback">{{ $message }}
                            </div>@enderror</div>
                    <div class="col-md-6"><label for="price" class="form-label">Price *</label>
                        <div class="input-group"><span class="input-group-text">৳</span><input type="number" step="0.01"
                                class="form-control @error('price') is-invalid @enderror" id="price" name="price"
                                value="{{ old('price') }}" required></div>@error('price')<div class="invalid-feedback">
                                {{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6"><label for="duration_hours" class="form-label">Duration (hours) *</label><input
                            type="number" class="form-control @error('duration_hours') is-invalid @enderror"
                            id="duration_hours" name="duration_hours" value="{{ old('duration_hours') }}"
                            required>@error('duration_hours')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-12"><label for="description" class="form-label">Description</label><textarea
                            class="form-control @error('description') is-invalid @enderror" id="description"
                            name="description" rows="3">{{ old('description') }}</textarea>@error('description')<div
                            class="invalid-feedback">{{ $message }}</div>@enderror</div>
                </div>
                <div class="mt-4 pt-3 border-top"><button type="submit" class="btn btn-modern btn-modern-primary"><i
                            class="bi bi-check-lg me-1"></i> Create Package</button><a href="{{ route('packages.index') }}"
                        class="btn btn-outline-secondary ms-2">Cancel</a></div>
            </form>
        </div>
    </div>
@endsection