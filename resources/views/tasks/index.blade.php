@extends('layouts.app')
@section('title', 'Tasks')
@section('page-title', 'Tasks')
@section('content')
    <div class="page-header-modern">
        <h1><i class="bi bi-check2-square me-2" style="color: var(--danger-color);"></i>Task Management</h1>
        <a href="{{ route('tasks.create') }}" class="btn btn-modern btn-modern-primary"><i class="bi bi-plus-lg me-1"></i>
            New Task</a>
    </div>
    <div class="card card-modern">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-modern mb-0">
                    <thead>
                        <tr>
                            <th>Task</th>
                            <th>Event</th>
                            <th>Type</th>
                            <th>Assigned To</th>
                            <th>Due Date</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($tasks as $task)
                            <tr>
                                <td><strong>{{ $task->title }}</strong></td>
                                <td>{{ $task->event->event_type ?? '-' }} ({{ $task->event->client->name ?? '-' }})</td>
                                <td>{{ str_replace('_', ' ', ucfirst($task->task_type)) }}</td>
                                <td>{{ $task->assignedUser->name ?? '-' }}</td>
                                <td
                                    class="{{ $task->due_date && $task->due_date->isPast() && $task->status !== 'done' ? 'text-danger fw-semibold' : '' }}">
                                    {{ $task->due_date?->format('M d, Y') ?? '-' }}</td>
                                <td><span
                                        class="badge-modern {{ $task->status }}">{{ str_replace('_', ' ', $task->status) }}</span>
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="{{ route('tasks.show', $task) }}"
                                            class="btn btn-sm btn-outline-secondary btn-icon btn-icon-sm"><i
                                                class="bi bi-eye"></i></a>
                                        <a href="{{ route('tasks.edit', $task) }}"
                                            class="btn btn-sm btn-outline-primary btn-icon btn-icon-sm"><i
                                                class="bi bi-pencil"></i></a>
                                        <form action="{{ route('tasks.destroy', $task) }}" method="POST" class="d-inline">@csrf
                                            @method('DELETE')<button type="submit"
                                                class="btn btn-sm btn-outline-danger btn-icon btn-icon-sm"
                                                onclick="return confirm('Delete?')"><i class="bi bi-trash"></i></button></form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7">
                                    <div class="empty-state"><i class="bi bi-check2-square d-block"></i>
                                        <div class="empty-title">No tasks found</div>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="mt-3">{{ $tasks->links() }}</div>
@endsection