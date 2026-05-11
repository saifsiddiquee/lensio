<?php

namespace App\Http\Controllers;

use App\Http\Requests\QuotationRequest;
use App\Models\AuditLog;
use App\Models\Client;
use App\Models\Package;
use App\Models\Quotation;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class QuotationController extends Controller
{
    /**
     * Display a listing of quotations.
     */
    public function index(): View
    {
        $quotations = Quotation::with(['client', 'package'])
            ->latest()
            ->paginate(15);

        return view('quotations.index', compact('quotations'));
    }

    /**
     * Show the form for creating a new quotation.
     */
    public function create(): View
    {
        $clients = Client::all();
        $packages = Package::all();
        $statuses = ['draft', 'sent', 'approved', 'rejected'];

        return view('quotations.create', compact('clients', 'packages', 'statuses'));
    }

    /**
     * Store a newly created quotation.
     */
    public function store(QuotationRequest $request): RedirectResponse
    {
        $quotation = Quotation::create($request->validated());

        AuditLog::log(auth()->id(), 'created', 'quotations', $quotation->id);

        return redirect()->route('quotations.index')
            ->with('success', 'Quotation created successfully.');
    }

    /**
     * Display the specified quotation.
     */
    public function show(Quotation $quotation): View
    {
        $quotation->load(['client', 'package']);

        return view('quotations.show', compact('quotation'));
    }

    /**
     * Show the form for editing the specified quotation.
     */
    public function edit(Quotation $quotation): View
    {
        $clients = Client::all();
        $packages = Package::all();
        $statuses = ['draft', 'sent', 'approved', 'rejected'];

        return view('quotations.edit', compact('quotation', 'clients', 'packages', 'statuses'));
    }

    /**
     * Update the specified quotation.
     */
    public function update(QuotationRequest $request, Quotation $quotation): RedirectResponse
    {
        $quotation->update($request->validated());

        AuditLog::log(auth()->id(), 'updated', 'quotations', $quotation->id);

        return redirect()->route('quotations.index')
            ->with('success', 'Quotation updated successfully.');
    }

    /**
     * Remove the specified quotation.
     */
    public function destroy(Quotation $quotation): RedirectResponse
    {
        try {
            $quotationId = $quotation->id;
            $quotation->delete();
            AuditLog::log(auth()->id(), 'deleted', 'quotations', $quotationId);

            return redirect()->route('quotations.index')
                ->with('success', 'Quotation deleted successfully.');
        } catch (QueryException $e) {
            if ($e->getCode() === '23000') {
                return redirect()->route('quotations.index')
                    ->with('error', 'This quotation cannot be deleted because it is linked to other records. Remove those records first.');
            }

            return redirect()->route('quotations.index')
                ->with('error', 'An unexpected error occurred while deleting the quotation.');
        }
    }
}
