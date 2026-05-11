@extends('layouts.app')
@section('title', 'Packages')
@section('page-title', 'Packages')

@section('content')
    <div class="page-header-modern">
        <h1><i class="bi bi-box-fill me-2" style="color: var(--warning-color);"></i>Package Management</h1>
        <a href="{{ route('packages.create') }}" class="btn btn-modern btn-modern-primary"><i
                class="bi bi-plus-lg me-1"></i> New Package</a>
    </div>

    <div class="row g-4">
        @forelse($packages as $package)
            <div class="col-md-6 col-lg-4">
                <div class="card card-modern h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div class="avatar avatar-warning"><i class="bi bi-box"></i></div>
                            <h3 class="mb-0" style="color: var(--primary-color);">৳{{ number_format($package->price, 0) }}</h3>
                        </div>
                        <h5 class="fw-semibold mb-1">{{ $package->name }}</h5>
                        <p class="text-muted small mb-3">{{ $package->duration_hours }} hours coverage</p>
                        <p class="text-muted small mb-0">{{ Str::limit($package->description, 100) }}</p>
                    </div>
                    <div class="card-footer bg-transparent border-top-0 pt-0">
                        <div class="action-buttons">
                            <a href="{{ route('packages.show', $package) }}" class="btn btn-sm btn-outline-secondary"><i
                                    class="bi bi-eye me-1"></i>View</a>
                            <a href="{{ route('packages.edit', $package) }}" class="btn btn-sm btn-outline-primary"><i
                                    class="bi bi-pencil me-1"></i>Edit</a>
                            <form action="{{ route('packages.destroy', $package) }}" method="POST" class="d-inline">@csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger"
                                    onclick="return confirm('Delete?')"><i class="bi bi-trash"></i></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="card card-modern">
                    <div class="card-body">
                        <div class="empty-state"><i class="bi bi-box d-block"></i>
                            <div class="empty-title">No packages found</div>
                        </div>
                    </div>
                </div>
            </div>
        @endforelse
    </div>
    <div class="mt-3">{{ $packages->links() }}</div>
@endsection