@extends('layouts.app')
@section('title', 'Users')
@section('page-title', 'Users')
@section('content')
    <div class="page-header-modern">
        <h1><i class="bi bi-person-badge-fill me-2" style="color: var(--primary-color);"></i>User Management</h1>
        <a href="{{ route('users.create') }}" class="btn btn-modern btn-modern-primary">
            <i class="bi bi-plus-lg me-1"></i> Add User
        </a>
    </div>

    <div class="card card-modern">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-modern mb-0">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="avatar avatar-primary avatar-sm">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>
                                        <strong>{{ $user->name }}</strong>
                                        @if($user->id === auth()->id())
                                            <span class="badge bg-secondary">You</span>
                                        @endif
                                    </div>
                                </td>
                                <td>{{ $user->email }}</td>
                                <td><span class="role-badge {{ $user->role }}">{{ $user->role }}</span></td>
                                <td><span class="badge-modern {{ $user->is_active ? 'approved' : 'cancelled' }}">{{ $user->is_active ? 'Active' : 'Inactive' }}</span></td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="{{ route('users.edit', $user) }}" class="btn btn-sm btn-outline-primary btn-icon btn-icon-sm">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        @if($user->id !== auth()->id())
                                            <form action="{{ route('users.destroy', $user) }}" method="POST" class="d-inline">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger btn-icon btn-icon-sm"
                                                    onclick="return confirm('Delete user {{ $user->name }}?')">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5">
                                    <div class="empty-state">
                                        <i class="bi bi-people d-block"></i>
                                        <div class="empty-title">No users found</div>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="mt-3">{{ $users->links() }}</div>
@endsection
