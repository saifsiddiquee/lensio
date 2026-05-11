@extends('layouts.app')
@section('title', 'Add Employee')
@section('page-title', 'Add Employee')
@section('content')
    <div class="page-header-modern">
        <h1><i class="bi bi-person-plus-fill me-2" style="color: var(--primary-color);"></i>Add New Employee</h1>
        <a href="{{ route('employees.index') }}" class="btn btn-outline-secondary"><i class="bi bi-arrow-left me-1"></i>
            Back</a>
    </div>

    <div class="card card-modern">
        <div class="card-body">
            <form action="{{ route('employees.store') }}" method="POST" class="form-modern">
                @csrf
                <div class="row g-4">
                    <div class="col-md-6">
                        <label for="name" class="form-label">Full Name *</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name"
                            value="{{ old('name') }}" required>
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label for="role" class="form-label">Role *</label>
                        <select class="form-select @error('role') is-invalid @enderror" id="role" name="role" required>
                            <option value="">Select Role</option>
                            <option value="photographer" {{ old('role') == 'photographer' ? 'selected' : '' }}>Photographer</option>
                            <option value="editor" {{ old('role') == 'editor' ? 'selected' : '' }}>Editor</option>
                            <option value="support" {{ old('role') == 'support' ? 'selected' : '' }}>Support Staff</option>
                        </select>
                        @error('role')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label for="employment_type" class="form-label">Employment Type *</label>
                        <select class="form-select @error('employment_type') is-invalid @enderror" id="employment_type"
                            name="employment_type" required>
                            <option value="">Select Type</option>
                            <option value="full_time" {{ old('employment_type') == 'full_time' ? 'selected' : '' }}>Full Time</option>
                            <option value="part_time" {{ old('employment_type') == 'part_time' ? 'selected' : '' }}>Part Time</option>
                            <option value="contractual" {{ old('employment_type') == 'contractual' ? 'selected' : '' }}>Contractual</option>
                        </select>
                        @error('employment_type')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label for="monthly_salary" class="form-label">Monthly Salary</label>
                        <div class="input-group">
                            <span class="input-group-text">৳</span>
                            <input type="number" step="0.01" class="form-control @error('monthly_salary') is-invalid @enderror"
                                id="monthly_salary" name="monthly_salary" value="{{ old('monthly_salary') }}">
                        </div>
                        <small class="text-muted">Leave empty for contractual staff paid per event</small>
                        @error('monthly_salary')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label for="user_id" class="form-label">Link to User Account</label>
                        <select class="form-select @error('user_id') is-invalid @enderror" id="user_id" name="user_id">
                            <option value="">No linked user</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }} ({{ $user->email }})
                                </option>
                            @endforeach
                        </select>
                        <small class="text-muted">Optional: Link to a system user for access</small>
                        @error('user_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Status</label>
                        <div class="form-check form-switch mt-2">
                            <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" 
                                {{ old('is_active', true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">Active Employee</label>
                        </div>
                    </div>
                </div>
                <div class="mt-4 pt-3 border-top">
                    <button type="submit" class="btn btn-modern btn-modern-primary"><i class="bi bi-check-lg me-1"></i> Add Employee</button>
                    <a href="{{ route('employees.index') }}" class="btn btn-outline-secondary ms-2">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection
