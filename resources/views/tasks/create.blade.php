@extends('layouts.app')
@section('title', 'Create Task')
@section('page-title', 'Create Task')
@section('content')
    <div class="page-header-modern">
        <h1><i class="bi bi-check2-square me-2" style="color: var(--danger-color);"></i>Create New Task</h1>
        <a href="{{ route('tasks.index') }}" class="btn btn-outline-secondary"><i class="bi bi-arrow-left me-1"></i>
            Back</a>
    </div>
    <div class="card card-modern">
        <div class="card-body">
            <form action="{{ route('tasks.store') }}" method="POST" class="form-modern">
                @csrf
                <div class="row g-4">
                    <div class="col-md-6"><label for="event_id" class="form-label">Event *</label><select
                            class="form-select @error('event_id') is-invalid @enderror" id="event_id" name="event_id"
                            required>
                            <option value="">Select Event</option>@foreach($events as $event)<option
                                value="{{ $event->id }}" {{ old('event_id') == $event->id ? 'selected' : '' }}>
                            {{ $event->event_type }} - {{ $event->client->name }}</option>@endforeach
                        </select>@error('event_id')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                    <div class="col-md-6"><label for="title" class="form-label">Title *</label><input type="text"
                            class="form-control @error('title') is-invalid @enderror" id="title" name="title"
                            value="{{ old('title') }}" required>@error('title')<div class="invalid-feedback">{{ $message }}
                            </div>@enderror</div>
                    <div class="col-md-4"><label for="task_type" class="form-label">Type *</label><select
                            class="form-select @error('task_type') is-invalid @enderror" id="task_type" name="task_type"
                            required>@foreach($taskTypes as $type)<option value="{{ $type }}" {{ old('task_type') == $type ? 'selected' : '' }}>{{ str_replace('_', ' ', ucfirst($type)) }}</option>
                            @endforeach</select>@error('task_type')<div class="invalid-feedback">{{ $message }}</div>
                            @enderror</div>
                    <div class="col-md-4"><label for="assigned_to" class="form-label">Assigned To *</label><select
                            class="form-select @error('assigned_to') is-invalid @enderror" id="assigned_to"
                            name="assigned_to" required>
                            <option value="">Select User</option>@foreach($users as $user)<option value="{{ $user->id }}" {{ old('assigned_to') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>@endforeach
                        </select>@error('assigned_to')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                    <div class="col-md-4"><label for="due_date" class="form-label">Due Date</label><input type="date"
                            class="form-control @error('due_date') is-invalid @enderror" id="due_date" name="due_date"
                            value="{{ old('due_date') }}">@error('due_date')<div class="invalid-feedback">{{ $message }}
                            </div>@enderror</div>
                    <div class="col-md-4"><label for="status" class="form-label">Status *</label><select
                            class="form-select @error('status') is-invalid @enderror" id="status" name="status"
                            required>@foreach($statuses as $status)<option value="{{ $status }}" {{ old('status', 'pending') == $status ? 'selected' : '' }}>{{ str_replace('_', ' ', ucfirst($status)) }}
                            </option>@endforeach</select>@error('status')<div class="invalid-feedback">{{ $message }}</div>
                            @enderror</div>
                </div>
                <div class="mt-4 pt-3 border-top"><button type="submit" class="btn btn-modern btn-modern-primary"><i
                            class="bi bi-check-lg me-1"></i> Create Task</button><a href="{{ route('tasks.index') }}"
                        class="btn btn-outline-secondary ms-2">Cancel</a></div>
            </form>
        </div>
    </div>
@endsection