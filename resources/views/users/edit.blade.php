@extends('layouts.app')
@section('title', 'Edit User')
@section('page-title', 'Edit User')
@section('content')
    <div class="page-header-modern">
        <h1><i class="bi bi-person-gear me-2" style="color: var(--primary-color);"></i>Edit User</h1>
        <a href="{{ route('users.index') }}" class="btn btn-outline-secondary"><i class="bi bi-arrow-left me-1"></i> Back</a>
    </div>

    <div class="card card-modern">
        <div class="card-body">
            <form action="{{ route('users.update', $user) }}" method="POST" class="form-modern">
                @csrf @method('PUT')
                <div class="row g-4">
                    <div class="col-md-6">
                        <label for="name" class="form-label">Full Name *</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                            id="name" name="name" value="{{ old('name', $user->name) }}" required>
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label for="email" class="form-label">Email *</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                            id="email" name="email" value="{{ old('email', $user->email) }}" required>
                        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label for="password" class="form-label">New Password</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                            id="password" name="password" placeholder="Leave blank to keep current">
                        @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label for="password_confirmation" class="form-label">Confirm New Password</label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                    </div>
                    <div class="col-md-6">
                        <label for="role" class="form-label">Role *</label>
                        <select class="form-select @error('role') is-invalid @enderror" id="role" name="role" required>
                            <option value="admin"        {{ old('role', $user->role) == 'admin'        ? 'selected' : '' }}>Admin</option>
                            <option value="manager"      {{ old('role', $user->role) == 'manager'      ? 'selected' : '' }}>Manager</option>
                            <option value="sales"        {{ old('role', $user->role) == 'sales'        ? 'selected' : '' }}>Sales</option>
                            <option value="photographer" {{ old('role', $user->role) == 'photographer' ? 'selected' : '' }}>Photographer</option>
                            <option value="editor"       {{ old('role', $user->role) == 'editor'       ? 'selected' : '' }}>Editor</option>
                        </select>
                        @error('role')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Status</label>
                        <div class="form-check form-switch mt-2">
                            <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1"
                                {{ old('is_active', $user->is_active) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">Active</label>
                        </div>
                    </div>
                </div>
                <div class="mt-4 pt-3 border-top">
                    <button type="submit" class="btn btn-modern btn-modern-primary">
                        <i class="bi bi-check-lg me-1"></i> Save Changes
                    </button>
                    <a href="{{ route('users.index') }}" class="btn btn-outline-secondary ms-2">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection
