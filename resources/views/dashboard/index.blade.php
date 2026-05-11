@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
    <div class="welcome-section">
        <h2>Welcome back, {{ explode(' ', auth()->user()->name)[0] }}! 👋</h2>
        <p>Here's what's happening with your photography business today.</p>
    </div>

    <div class="row g-4 mb-4">
        <!-- Stats Cards -->
        <div class="col-sm-6 col-xl-3">
            <div class="card stat-card-modern">
                <div class="card-body">
                    <i class="bi bi-person-plus stat-icon"></i>
                    <div class="stat-value">{{ $stats['total_leads'] }}</div>
                    <div class="stat-label">Total Leads</div>
                    <div class="stat-change">
                        <i class="bi bi-arrow-up-short"></i> {{ $stats['new_leads'] }} new this week
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="card stat-card-modern green">
                <div class="card-body">
                    <i class="bi bi-people stat-icon"></i>
                    <div class="stat-value">{{ $stats['total_clients'] }}</div>
                    <div class="stat-label">Active Clients</div>
                    <div class="stat-change">
                        <i class="bi bi-check-circle"></i> All accounts healthy
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="card stat-card-modern purple">
                <div class="card-body">
                    <i class="bi bi-calendar-event stat-icon"></i>
                    <div class="stat-value">{{ $stats['upcoming_events'] }}</div>
                    <div class="stat-label">Upcoming Events</div>
                    <div class="stat-change">
                        <i class="bi bi-calendar3"></i> {{ $stats['total_events'] }} total scheduled
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="card stat-card-modern orange">
                <div class="card-body">
                    <i class="bi bi-receipt stat-icon"></i>
                    <div class="stat-value">{{ $stats['unpaid_invoices'] }}</div>
                    <div class="stat-label">Pending Invoices</div>
                    <div class="stat-change">
                        <i class="bi bi-cash"></i> ৳{{ number_format($stats['total_revenue'], 0) }} total revenue
                    </div>
                </div>
            </div>
        </div>

        @if($isAdmin)
            <!-- Admin Financial Summary -->
            <div class="row g-4 mb-4">
                <div class="col-sm-6 col-xl-3">
                    <a href="{{ route('employees.index') }}" class="text-decoration-none">
                        <div class="card stat-card-modern" style="border-left: 4px solid var(--danger-color); cursor: pointer;">
                            <div class="card-body">
                                <i class="bi bi-wallet2 stat-icon" style="color: var(--danger-color);"></i>
                                <div class="stat-value">৳{{ number_format($stats['total_pending_employee_payments'] ?? 0, 0) }}
                                </div>
                                <div class="stat-label">Pending Staff Payments</div>
                                <div class="stat-change">
                                    <i class="bi bi-people"></i> {{ $stats['active_employees'] ?? 0 }} active employees
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-sm-6 col-xl-3">
                    <div class="card stat-card-modern green">
                        <div class="card-body">
                            <i class="bi bi-graph-up-arrow stat-icon"></i>
                            <div class="stat-value">৳{{ number_format($stats['monthly_income'] ?? 0, 0) }}</div>
                            <div class="stat-label">This Month Income</div>
                            <div class="stat-change">
                                <i class="bi bi-calendar3"></i> {{ now()->format('F Y') }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-xl-3">
                    <a href="{{ route('salaries.index') }}" class="text-decoration-none">
                        <div class="card stat-card-modern orange">
                            <div class="card-body">
                                <i class="bi bi-graph-down-arrow stat-icon"></i>
                                <div class="stat-value">৳{{ number_format($stats['monthly_expenses'] ?? 0, 0) }}</div>
                                <div class="stat-label">This Month Expenses</div>
                                <div class="stat-change">
                                    <i class="bi bi-cash-stack"></i> Manage salaries
                                </div>
                            </div>
                        </div>
                    </a>

                </div>
                <div class="col-sm-6 col-xl-3">
                    <a href="{{ route('reports.profit-loss') }}" class="text-decoration-none">
                        <div class="card stat-card-modern {{ ($stats['monthly_net'] ?? 0) >= 0 ? 'green' : '' }}"
                            style="{{ ($stats['monthly_net'] ?? 0) < 0 ? 'border-left: 4px solid var(--danger-color);' : '' }}">
                            <div class="card-body">
                                <i class="bi bi-currency-exchange stat-icon"></i>
                                <div class="stat-value {{ ($stats['monthly_net'] ?? 0) < 0 ? 'text-danger' : '' }}">
                                    {{ ($stats['monthly_net'] ?? 0) < 0 ? '-' : '' }}৳{{ number_format(abs($stats['monthly_net'] ?? 0), 0) }}
                                </div>
                                <div class="stat-label">Net {{ ($stats['monthly_net'] ?? 0) >= 0 ? 'Profit' : 'Loss' }}</div>
                                <div class="stat-change">
                                    <i class="bi bi-bar-chart"></i> View reports
                                </div>
                            </div>
                    </a>
                </div>
            </div>
        @endif

        <div class="row g-4">
            <!-- Recent Leads -->
            <div class="col-lg-4">
                <div class="card activity-card h-100">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h6 class="card-header-title"><i class="bi bi-person-plus-fill"></i> Recent Leads</h6>
                        @if(auth()->user()->isAdmin() || auth()->user()->isSales())
                            <a href="{{ route('leads.index') }}" class="btn btn-sm btn-outline-primary view-all-btn">View
                                All</a>
                        @endif
                    </div>
                    <div class="card-body p-0">
                        @forelse($recentLeads as $lead)
                            <div class="activity-list-item d-flex align-items-center gap-3">
                                <div class="avatar avatar-primary">
                                    {{ strtoupper(substr($lead->name, 0, 2)) }}
                                </div>
                                <div class="flex-grow-1 min-width-0">
                                    <div class="fw-semibold text-truncate">{{ $lead->name }}</div>
                                    <small class="text-muted">{{ $lead->event_type }} • {{ $lead->source }}</small>
                                </div>
                                <span class="badge-modern {{ $lead->status }}">{{ $lead->status }}</span>
                            </div>
                        @empty
                            <div class="empty-state">
                                <i class="bi bi-person-plus d-block"></i>
                                <div class="empty-title">No leads yet</div>
                                <div class="empty-subtitle">New leads will appear here</div>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Upcoming Events -->
            <div class="col-lg-4">
                <div class="card activity-card h-100">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h6 class="card-header-title"><i class="bi bi-calendar-event-fill"></i> Upcoming Events</h6>
                        <a href="{{ route('events.index') }}" class="btn btn-sm btn-outline-primary view-all-btn">View
                            All</a>
                    </div>
                    <div class="card-body p-0">
                        @forelse($upcomingEvents as $event)
                            <div class="activity-list-item d-flex align-items-center gap-3">
                                <div class="avatar avatar-purple">
                                    <i class="bi bi-camera"></i>
                                </div>
                                <div class="flex-grow-1 min-width-0">
                                    <div class="fw-semibold text-truncate">{{ $event->event_type }}</div>
                                    <small class="text-muted">{{ $event->client->name }} • {{ $event->venue }}</small>
                                </div>
                                <div class="text-end">
                                    <div class="fw-semibold" style="color: var(--primary-color);">
                                        {{ $event->event_date->format('M d') }}
                                    </div>
                                    <small class="text-muted">{{ $event->event_date->format('D') }}</small>
                                </div>
                            </div>
                        @empty
                            <div class="empty-state">
                                <i class="bi bi-calendar-event d-block"></i>
                                <div class="empty-title">No upcoming events</div>
                                <div class="empty-subtitle">Schedule events to see them here</div>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Pending Tasks -->
            <div class="col-lg-4">
                <div class="card activity-card h-100">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h6 class="card-header-title"><i class="bi bi-check2-square"></i> Pending Tasks</h6>
                        <a href="{{ route('tasks.index') }}" class="btn btn-sm btn-outline-primary view-all-btn">View
                            All</a>
                    </div>
                    <div class="card-body p-0">
                        @forelse($pendingTasks as $task)
                            <div class="activity-list-item d-flex align-items-center gap-3">
                                <div class="avatar avatar-danger">
                                    <i class="bi bi-list-task"></i>
                                </div>
                                <div class="flex-grow-1 min-width-0">
                                    <div class="fw-semibold text-truncate">{{ $task->title }}</div>
                                    <small class="text-muted">
                                        {{ $task->event->event_type ?? 'N/A' }}
                                        @if($task->due_date)
                                            • <span class="{{ $task->due_date->isPast() ? 'text-danger' : '' }}">
                                                Due {{ $task->due_date->format('M d') }}
                                            </span>
                                        @endif
                                    </small>
                                </div>
                                <span class="badge-modern {{ $task->status }}">{{ str_replace('_', ' ', $task->status) }}</span>
                            </div>
                        @empty
                            <div class="empty-state">
                                <i class="bi bi-check2-square d-block"></i>
                                <div class="empty-title">No pending tasks</div>
                                <div class="empty-subtitle">You're all caught up!</div>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
@endsection