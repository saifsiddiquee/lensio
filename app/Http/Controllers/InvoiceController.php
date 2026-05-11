<?php

namespace App\Http\Controllers;

use App\Http\Requests\InvoiceRequest;
use App\Models\AuditLog;
use App\Models\Event;
use App\Models\Invoice;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class InvoiceController extends Controller
{
    /**
     * Display a listing of invoices.
     */
    public function index(): View
    {
        $invoices = Invoice::with('event.client')
            ->latest()
            ->paginate(15);

        return view('invoices.index', compact('invoices'));
    }

    /**
     * Show the form for creating a new invoice.
     */
    public function create(): View
    {
        $events = Event::whereDoesntHave('invoice')->with('client')->get();
        $statuses = ['unpaid', 'partial', 'paid'];

        return view('invoices.create', compact('events', 'statuses'));
    }

    /**
     * Store a newly created invoice.
     */
    public function store(InvoiceRequest $request): RedirectResponse
    {
        $invoice = Invoice::create($request->validated());

        AuditLog::log(auth()->id(), 'created', 'invoices', $invoice->id);

        return redirect()->route('invoices.index')
            ->with('success', 'Invoice created successfully.');
    }

    /**
     * Display the specified invoice.
     */
    public function show(Invoice $invoice): View
    {
        $invoice->load(['event.client', 'payments']);

        return view('invoices.show', compact('invoice'));
    }

    /**
     * Show the form for editing the specified invoice.
     */
    public function edit(Invoice $invoice): View
    {
        $events = Event::whereDoesntHave('invoice')
            ->orWhere('id', $invoice->event_id)
            ->with('client')
            ->get();
        $statuses = ['unpaid', 'partial', 'paid'];

        return view('invoices.edit', compact('invoice', 'events', 'statuses'));
    }

    /**
     * Update the specified invoice.
     */
    public function update(InvoiceRequest $request, Invoice $invoice): RedirectResponse
    {
        $invoice->update($request->validated());

        AuditLog::log(auth()->id(), 'updated', 'invoices', $invoice->id);

        return redirect()->route('invoices.index')
            ->with('success', 'Invoice updated successfully.');
    }

    /**
     * Remove the specified invoice.
     */
    public function destroy(Invoice $invoice): RedirectResponse
    {
        try {
            $invoiceId = $invoice->id;
            $invoice->delete();
            AuditLog::log(auth()->id(), 'deleted', 'invoices', $invoiceId);

            return redirect()->route('invoices.index')
                ->with('success', 'Invoice deleted successfully.');
        } catch (QueryException $e) {
            if ($e->getCode() === '23000') {
                return redirect()->route('invoices.index')
                    ->with('error', 'This invoice cannot be deleted because it has associated payment records. Delete the payments first.');
            }

            return redirect()->route('invoices.index')
                ->with('error', 'An unexpected error occurred while deleting the invoice.');
        }
    }
}
