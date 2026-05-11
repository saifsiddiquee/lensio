@extends('layouts.app')
@section('title', 'Event Details')
@section('page-title', 'Event Details')

@section('content')
    <div class="page-header-modern">
        <h1><i class="bi bi-calendar-event-fill me-2" style="color: var(--purple-color);"></i>{{ $event->event_type }}</h1>
        <div class="d-flex gap-2">
            @if(auth()->user()->isAdmin() || auth()->user()->isSales())
                <a href="{{ route('events.edit', $event) }}" class="btn btn-modern btn-modern-primary"><i
                        class="bi bi-pencil me-1"></i> Edit</a>
            @endif
            <a href="{{ route('events.index') }}" class="btn btn-outline-secondary"><i class="bi bi-arrow-left me-1"></i>
                Back</a>
        </div>
    </div>

    {{-- Admin Financial Summary --}}
    @if(auth()->user()->isAdmin())
        <div class="row g-3 mb-4">
            <div class="col-md-3">
                <div class="card stat-card-modern green">
                    <div class="card-body py-3">
                        <div class="stat-value fs-4">৳{{ number_format($event->total_income, 0) }}</div>
                        <div class="stat-label">Income</div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card stat-card-modern orange">
                    <div class="card-body py-3">
                        <div class="stat-value fs-4">৳{{ number_format($event->total_costs, 0) }}</div>
                        <div class="stat-label">Total Costs</div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card stat-card-modern {{ $event->is_profitable ? 'green' : '' }}"
                    style="{{ !$event->is_profitable ? 'background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);' : '' }}">
                    <div class="card-body py-3">
                        <div class="stat-value fs-4">৳{{ number_format(abs($event->net_profit), 0) }}</div>
                        <div class="stat-label">{{ $event->is_profitable ? 'Profit' : 'Loss' }}</div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card stat-card-modern purple">
                    <div class="card-body py-3">
                        <div class="stat-value fs-4">
                            {{ $event->total_income > 0 ? number_format(($event->net_profit / $event->total_income) * 100, 0) : 0 }}%
                        </div>
                        <div class="stat-label">Margin</div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- Tabs --}}
    <ul class="nav nav-tabs mb-4" role="tablist">
        <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#details"><i
                    class="bi bi-info-circle me-1"></i> Details</a></li>
        <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#team"><i class="bi bi-people me-1"></i>
                Team</a></li>
        <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#tasks"><i class="bi bi-check2-square me-1"></i>
                Tasks</a></li>
        @if(auth()->user()->isAdmin())
            <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#costs"><i class="bi bi-cash-stack me-1"></i>
                    Costs</a></li>
            <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#payments"><i class="bi bi-wallet2 me-1"></i>
                    Staff Payments</a></li>
        @endif
    </ul>

    <div class="tab-content">
        {{-- Details Tab --}}
        <div class="tab-pane fade show active" id="details">
            <div class="row g-4">
                <div class="col-lg-8">
                    <div class="card detail-card">
                        <div class="card-header">
                            <h6><i class="bi bi-info-circle-fill"></i> Event Details</h6>
                        </div>
                        <div class="card-body">
                            <dl class="row detail-list mb-0">
                                <dt class="col-sm-3">Client</dt>
                                <dd class="col-sm-9">{{ $event->client->name }}</dd>
                                <dt class="col-sm-3">Event Type</dt>
                                <dd class="col-sm-9">{{ $event->event_type }}</dd>
                                <dt class="col-sm-3">Date</dt>
                                <dd class="col-sm-9">{{ $event->event_date->format('F d, Y') }}</dd>
                                <dt class="col-sm-3">Venue</dt>
                                <dd class="col-sm-9">{{ $event->venue }}</dd>
                                <dt class="col-sm-3">Status</dt>
                                <dd class="col-sm-9"><span
                                        class="badge-modern {{ $event->status }}">{{ $event->status }}</span></dd>
                            </dl>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card detail-card mb-4">
                        <div class="card-header">
                            <h6><i class="bi bi-file-earmark-check-fill"></i> Contract</h6>
                        </div>
                        <div class="card-body">
                            @if($event->contract)
                                <p class="mb-1"><strong>{{ $event->contract->reference_no }}</strong></p>
                                <span class="badge-modern {{ $event->contract->status }}">{{ $event->contract->status }}</span>
                            @else
                                <p class="text-muted mb-0">No contract created</p>
                            @endif
                        </div>
                    </div>
                    <div class="card detail-card">
                        <div class="card-header">
                            <h6><i class="bi bi-receipt"></i> Invoice</h6>
                        </div>
                        <div class="card-body">
                            @if($event->invoice)
                                <p class="mb-1"><strong>{{ $event->invoice->invoice_no }}</strong></p>
                                <p class="mb-1 fs-5 fw-bold" style="color: var(--success-color);">
                                    ৳{{ number_format($event->invoice->total_amount, 2) }}</p>
                                <span class="badge-modern {{ $event->invoice->status }}">{{ $event->invoice->status }}</span>
                            @else
                                <p class="text-muted mb-0">No invoice created</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Team Tab --}}
        <div class="tab-pane fade" id="team">
            <div class="card detail-card">
                <div class="card-header">
                    <h6><i class="bi bi-people-fill"></i> Assigned Team</h6>
                </div>
                <div class="card-body p-0">
                    @forelse($event->users as $user)
                        <div class="activity-list-item d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center gap-3">
                                <div class="avatar avatar-primary">{{ strtoupper(substr($user->name, 0, 2)) }}</div>
                                <div>
                                    <strong>{{ $user->name }}</strong><br>
                                    <small class="text-muted">{{ $user->email }}</small>
                                </div>
                            </div>
                            <span class="badge bg-secondary">{{ ucfirst($user->pivot->role) }}</span>
                        </div>
                    @empty
                        <div class="empty-state"><i class="bi bi-people d-block"></i>
                            <div class="empty-title">No team assigned</div>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- Tasks Tab --}}
        <div class="tab-pane fade" id="tasks">
            <div class="card detail-card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h6 class="mb-0"><i class="bi bi-check2-square me-2"></i>Tasks</h6>
                    <a href="{{ route('tasks.create') }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-plus"></i>
                        Add Task</a>
                </div>
                <div class="card-body p-0">
                    @forelse($event->tasks as $task)
                        <div class="activity-list-item d-flex justify-content-between align-items-center">
                            <div>
                                <strong>{{ $task->title }}</strong><br>
                                <small class="text-muted">{{ $task->assignedUser->name ?? 'Unassigned' }} •
                                    {{ str_replace('_', ' ', ucfirst($task->task_type)) }}</small>
                            </div>
                            <span class="badge-modern {{ $task->status }}">{{ str_replace('_', ' ', $task->status) }}</span>
                        </div>
                    @empty
                        <div class="empty-state"><i class="bi bi-list-task d-block"></i>
                            <div class="empty-title">No tasks assigned</div>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        @if(auth()->user()->isAdmin())
            {{-- Costs Tab --}}
            <div class="tab-pane fade" id="costs">
                <div class="card detail-card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h6 class="mb-0"><i class="bi bi-cash-stack me-2"></i>Event Costs</h6>
                        <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                            data-bs-target="#addCostModal"><i class="bi bi-plus"></i> Add Cost</button>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-modern mb-0">
                                <thead>
                                    <tr>
                                        <th>Type</th>
                                        <th>Description</th>
                                        <th>Amount</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $totalCosts = 0; @endphp
                                    @forelse($event->eventCosts as $cost)
                                        @php $totalCosts += $cost->amount; @endphp
                                        <tr>
                                            <td><span class="badge bg-secondary">{{ $cost->cost_type_label }}</span></td>
                                            <td>{{ $cost->description ?? '-' }}</td>
                                            <td><strong>৳{{ number_format($cost->amount, 2) }}</strong></td>
                                            <td>
                                                <form action="{{ route('events.costs.destroy', [$event, $cost]) }}" method="POST"
                                                    class="d-inline">@csrf @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger btn-icon btn-icon-sm"
                                                        onclick="return confirm('Delete?')"><i class="bi bi-trash"></i></button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4">
                                                <div class="empty-state"><i class="bi bi-cash d-block"></i>
                                                    <div class="empty-title">No costs recorded</div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                                @if($totalCosts > 0)
                                    <tfoot>
                                        <tr class="fw-bold">
                                            <td colspan="2">Total</td>
                                            <td>৳{{ number_format($totalCosts, 2) }}</td>
                                            <td></td>
                                        </tr>
                                    </tfoot>
                                @endif
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Staff Payments Tab --}}
            <div class="tab-pane fade" id="payments">
                <div class="card detail-card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h6 class="mb-0"><i class="bi bi-wallet2 me-2"></i>Employee Payments</h6>
                        <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                            data-bs-target="#addPaymentModal"><i class="bi bi-plus"></i> Add Payment</button>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-modern mb-0">
                                <thead>
                                    <tr>
                                        <th>Employee</th>
                                        <th>Type</th>
                                        <th>Agreed</th>
                                        <th>Paid</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $totalAgreed = 0;
                                    $totalPaid = 0; @endphp
                                    @forelse($event->employeePayments as $payment)
                                        @php $totalAgreed += $payment->agreed_amount;
                                        $totalPaid += $payment->paid_amount; @endphp
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center gap-2">
                                                    <div class="avatar avatar-sm avatar-primary">
                                                        {{ strtoupper(substr($payment->user->name, 0, 2)) }}</div>
                                                    {{ $payment->user->name }}
                                                </div>
                                            </td>
                                            <td>{{ $payment->payment_type_label }}</td>
                                            <td><strong>৳{{ number_format($payment->agreed_amount, 2) }}</strong></td>
                                            <td class="text-success">৳{{ number_format($payment->paid_amount, 2) }}</td>
                                            <td><span
                                                    class="badge-modern {{ $payment->status }}">{{ ucfirst($payment->status) }}</span>
                                            </td>
                                            <td>
                                                <form action="{{ route('events.employee-payments.destroy', [$event, $payment]) }}"
                                                    method="POST" class="d-inline">@csrf @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger btn-icon btn-icon-sm"
                                                        onclick="return confirm('Delete?')"><i class="bi bi-trash"></i></button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6">
                                                <div class="empty-state"><i class="bi bi-wallet d-block"></i>
                                                    <div class="empty-title">No employee payments</div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                                @if($totalAgreed > 0)
                                    <tfoot>
                                        <tr class="fw-bold">
                                            <td colspan="2">Total</td>
                                            <td>৳{{ number_format($totalAgreed, 2) }}</td>
                                            <td class="text-success">৳{{ number_format($totalPaid, 2) }}</td>
                                            <td colspan="2"></td>
                                        </tr>
                                    </tfoot>
                                @endif
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    @if(auth()->user()->isAdmin())
        {{-- Add Cost Modal --}}
        <div class="modal fade" id="addCostModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="{{ route('events.costs.store', $event) }}" method="POST">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title">Add Event Cost</h5><button type="button" class="btn-close"
                                data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label">Cost Type *</label>
                                <select name="cost_type" class="form-select" required>
                                    @foreach(\App\Models\EventCost::costTypes() as $key => $label)
                                        <option value="{{ $key }}">{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Amount *</label>
                                <div class="input-group"><span class="input-group-text">৳</span><input type="number" step="0.01"
                                        name="amount" class="form-control" required></div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Description</label>
                                <input type="text" name="description" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Notes</label>
                                <textarea name="notes" class="form-control" rows="2"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer"><button type="button" class="btn btn-secondary"
                                data-bs-dismiss="modal">Cancel</button><button type="submit" class="btn btn-primary">Add
                                Cost</button></div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Add Payment Modal --}}
        <div class="modal fade" id="addPaymentModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="{{ route('events.employee-payments.store', $event) }}" method="POST">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title">Add Employee Payment</h5><button type="button" class="btn-close"
                                data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label">Employee *</label>
                                <select name="user_id" class="form-select" required>
                                    @foreach(\App\Models\User::all() as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }} ({{ ucfirst($user->role) }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Payment Type *</label>
                                <select name="payment_type" class="form-select" required>
                                    @foreach(\App\Models\EmployeePayment::paymentTypes() as $type)
                                        <option value="{{ $type }}">{{ ucfirst(str_replace('_', ' ', $type)) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Agreed Amount *</label>
                                    <div class="input-group"><span class="input-group-text">৳</span><input type="number"
                                            step="0.01" name="agreed_amount" class="form-control" required></div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Paid Amount</label>
                                    <div class="input-group"><span class="input-group-text">৳</span><input type="number"
                                            step="0.01" name="paid_amount" class="form-control" value="0"></div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Status *</label>
                                <select name="status" class="form-select" required>
                                    @foreach(\App\Models\EmployeePayment::statuses() as $status)
                                        <option value="{{ $status }}">{{ ucfirst($status) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Payment Date</label>
                                <input type="date" name="payment_date" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Notes</label>
                                <textarea name="notes" class="form-control" rows="2"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer"><button type="button" class="btn btn-secondary"
                                data-bs-dismiss="modal">Cancel</button><button type="submit" class="btn btn-primary">Add
                                Payment</button></div>
                    </form>
                </div>
            </div>
        </div>
    @endif
@endsection