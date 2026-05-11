@extends('layouts.app')
@section('title', 'Edit Quotation')
@section('page-title', 'Edit Quotation')
@section('content')
    <div class="page-header-modern">
        <h1><i class="bi bi-pencil-fill me-2" style="color: var(--primary-color);"></i>Edit Quotation</h1>
        <a href="{{ route('quotations.index') }}" class="btn btn-outline-secondary"><i class="bi bi-arrow-left me-1"></i>
            Back</a>
    </div>
    <div class="card card-modern">
        <div class="card-body">
            <form action="{{ route('quotations.update', $quotation) }}" method="POST" class="form-modern">
                @csrf @method('PUT')
                <div class="row g-4">
                    <div class="col-md-6"><label for="client_id" class="form-label">Client *</label><select
                            class="form-select @error('client_id') is-invalid @enderror" id="client_id" name="client_id"
                            required>@foreach($clients as $client)<option value="{{ $client->id }}" {{ old('client_id', $quotation->client_id) == $client->id ? 'selected' : '' }}>{{ $client->name }}</option>
                            @endforeach</select>@error('client_id')<div class="invalid-feedback">{{ $message }}</div>
                            @enderror</div>
                    <div class="col-md-6"><label for="package_id" class="form-label">Package</label><select
                            class="form-select @error('package_id') is-invalid @enderror" id="package_id" name="package_id">
                            <option value="">Select Package</option>@foreach($packages as $package)<option
                            value="{{ $package->id }}" {{ old('package_id', $quotation->package_id) == $package->id ? 'selected' : '' }}>{{ $package->name }}</option>@endforeach
                        </select>@error('package_id')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                    <div class="col-md-6"><label for="amount" class="form-label">Amount *</label>
                        <div class="input-group"><span class="input-group-text">৳</span><input type="number" step="0.01"
                                class="form-control @error('amount') is-invalid @enderror" id="amount" name="amount"
                                value="{{ old('amount', $quotation->amount) }}" required></div>@error('amount')<div
                                class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6"><label for="status" class="form-label">Status *</label><select
                            class="form-select @error('status') is-invalid @enderror" id="status" name="status"
                            required>@foreach($statuses as $status)<option value="{{ $status }}" {{ old('status', $quotation->status) == $status ? 'selected' : '' }}>{{ ucfirst($status) }}</option>
                            @endforeach</select>@error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6"><label for="valid_until" class="form-label">Valid Until *</label><input
                            type="date" class="form-control @error('valid_until') is-invalid @enderror" id="valid_until"
                            name="valid_until" value="{{ old('valid_until', $quotation->valid_until?->format('Y-m-d')) }}"
                            required>@error('valid_until')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                </div>
                <div class="mt-4 pt-3 border-top"><button type="submit" class="btn btn-modern btn-modern-primary"><i
                            class="bi bi-check-lg me-1"></i> Update Quotation</button><a
                        href="{{ route('quotations.index') }}" class="btn btn-outline-secondary ms-2">Cancel</a></div>
            </form>
        </div>
    </div>
@endsection