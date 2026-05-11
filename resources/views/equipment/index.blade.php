@extends('layouts.app')
@section('title', 'Equipment')
@section('page-title', 'Equipment')
@section('content')
    <div class="page-header-modern">
        <h1><i class="bi bi-camera-fill me-2" style="color: var(--warning-color);"></i>Equipment Inventory</h1>
        <a href="{{ route('equipment.create') }}" class="btn btn-modern btn-modern-primary"><i
                class="bi bi-plus-lg me-1"></i> Add Equipment</a>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card stat-card-modern green">
                <div class="card-body py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="stat-value fs-3">{{ $equipment->where('status', 'available')->count() }}</div>
                            <div class="stat-label">Available</div>
                        </div>
                        <i class="bi bi-check-circle fs-1 opacity-25"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stat-card-modern">
                <div class="card-body py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="stat-value fs-3">{{ $equipment->where('status', 'assigned')->count() }}</div>
                            <div class="stat-label">Assigned</div>
                        </div>
                        <i class="bi bi-calendar-check fs-1 opacity-25"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stat-card-modern orange">
                <div class="card-body py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="stat-value fs-3">{{ $equipment->where('status', 'maintenance')->count() }}</div>
                            <div class="stat-label">Maintenance</div>
                        </div>
                        <i class="bi bi-tools fs-1 opacity-25"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stat-card-modern purple">
                <div class="card-body py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="stat-value fs-3">{{ $equipment->total() }}</div>
                            <div class="stat-label">Total</div>
                        </div>
                        <i class="bi bi-box fs-1 opacity-25"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card card-modern">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-modern mb-0">
                    <thead>
                        <tr>
                            <th>Equipment</th>
                            <th>Category</th>
                            <th>Type</th>
                            <th>Cost</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($equipment as $item)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="avatar avatar-warning avatar-sm"><i class="bi bi-camera"></i></div>
                                        <div>
                                            <strong>{{ $item->name }}</strong>
                                            @if($item->serial_number)<br><small class="text-muted">S/N:
                                            {{ $item->serial_number }}</small>@endif
                                        </div>
                                    </div>
                                </td>
                                <td><span class="badge bg-secondary">{{ $item->category_label }}</span></td>
                                <td><span
                                        class="badge-modern {{ $item->ownership_type == 'owned' ? 'approved' : 'sent' }}">{{ ucfirst($item->ownership_type) }}</span>
                                </td>
                                <td>
                                    @if($item->ownership_type == 'owned' && $item->purchase_cost)
                                        ৳{{ number_format($item->purchase_cost, 2) }}
                                    @elseif($item->rental_cost_per_day)
                                        ৳{{ number_format($item->rental_cost_per_day, 2) }}/day
                                    @else
                                        -
                                    @endif
                                </td>
                                <td><span class="badge-modern {{ $item->status }}">{{ ucfirst($item->status) }}</span></td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="{{ route('equipment.show', $item) }}"
                                            class="btn btn-sm btn-outline-secondary btn-icon btn-icon-sm"><i
                                                class="bi bi-eye"></i></a>
                                        <a href="{{ route('equipment.edit', $item) }}"
                                            class="btn btn-sm btn-outline-primary btn-icon btn-icon-sm"><i
                                                class="bi bi-pencil"></i></a>
                                        <form action="{{ route('equipment.destroy', $item) }}" method="POST" class="d-inline">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger btn-icon btn-icon-sm"
                                                onclick="return confirm('Delete?')"><i class="bi bi-trash"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6">
                                    <div class="empty-state"><i class="bi bi-camera d-block"></i>
                                        <div class="empty-title">No equipment found</div>
                                        <div class="empty-subtitle">Add your first equipment item to get started</div>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="mt-3">{{ $equipment->links() }}</div>
@endsection