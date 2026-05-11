@extends('layouts.app')
@section('title', 'Edit Invoice')
@section('page-title', 'Edit Invoice')
@section('content')
    <div class="page-header-modern">
        <h1><i class="bi bi-pencil-fill me-2" style="color: var(--warning-color);"></i>Edit Invoice</h1>
        <a href="{{ route('invoices.index') }}" class="btn btn-outline-secondary"><i class="bi bi-arrow-left me-1"></i>
            Back</a>
    </div>
    <div class="card card-modern">
        <div class="card-body">
            <form action="{{ route('invoices.update', $invoice) }}" method="POST" class="form-modern">
                @csrf @method('PUT')
                <div class="row g-4">
                    <div class="col-md-6"><label for="event_id" class="form-label">Event *</label><select
                            class="form-select @error('event_id') is-invalid @enderror" id="event_id" name="event_id"
                            required>@foreach($events as $event)<option value="{{ $event->id }}" {{ old('event_id', $invoice->event_id) == $event->id ? 'selected' : '' }}>{{ $event->event_type }} -
                            {{ $event->client->name }}</option>@endforeach</select>@error('event_id')<div
                                class="invalid-feedback">{{ $message }}</div>@enderror</div>
                    <div class="col-md-6"><label for="invoice_no" class="form-label">Invoice No *</label><input type="text"
                            class="form-control @error('invoice_no') is-invalid @enderror" id="invoice_no" name="invoice_no"
                            value="{{ old('invoice_no', $invoice->invoice_no) }}" required>@error('invoice_no')<div
                            class="invalid-feedback">{{ $message }}</div>@enderror</div>
                    <div class="col-md-6"><label for="total_amount" class="form-label">Total Amount *</label>
                        <div class="input-group"><span class="input-group-text">৳</span><input type="number" step="0.01"
                                class="form-control @error('total_amount') is-invalid @enderror" id="total_amount"
                                name="total_amount" value="{{ old('total_amount', $invoice->total_amount) }}" required>
                        </div>@error('total_amount')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6"><label for="status" class="form-label">Status *</label><select
                            class="form-select @error('status') is-invalid @enderror" id="status" name="status"
                            required>@foreach($statuses as $status)<option value="{{ $status }}" {{ old('status', $invoice->status) == $status ? 'selected' : '' }}>{{ ucfirst($status) }}</option>
                            @endforeach</select>@error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="mt-4 pt-3 border-top"><button type="submit" class="btn btn-modern btn-modern-primary"><i
                            class="bi bi-check-lg me-1"></i> Update Invoice</button><a href="{{ route('invoices.index') }}"
                        class="btn btn-outline-secondary ms-2">Cancel</a></div>
            </form>
        </div>
    </div>
@endsection