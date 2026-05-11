<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaymentRequest;
use App\Models\AuditLog;
use App\Models\Invoice;
use App\Models\Payment;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PaymentController extends Controller
{
    /**
     * Display a listing of payments.
     */
    public function index(): View
    {
        $payments = Payment::with('invoice.event.client')
            ->latest('created_at')
            ->paginate(15);

        return view('payments.index', compact('payments'));
    }

    /**
     * Show the form for creating a new payment.
     */
    public function create(): View
    {
        $invoices = Invoice::where('status', '!=', 'paid')
            ->with('event.client')
            ->get();

        return view('payments.create', compact('invoices'));
    }

    /**
     * Store a newly created payment.
     */
    public function store(PaymentRequest $request): RedirectResponse
    {
        $payment = Payment::create($request->validated());

        // Update invoice status based on payments
        $this->updateInvoiceStatus($payment->invoice);

        AuditLog::log(auth()->id(), 'created', 'payments', $payment->id);

        return redirect()->route('payments.index')
            ->with('success', 'Payment recorded successfully.');
    }

    /**
     * Display the specified payment.
     */
    public function show(Payment $payment): View
    {
        $payment->load('invoice.event.client');

        return view('payments.show', compact('payment'));
    }

    /**
     * Show the form for editing the specified payment.
     */
    public function edit(Payment $payment): View
    {
        $invoices = Invoice::with('event.client')->get();

        return view('payments.edit', compact('payment', 'invoices'));
    }

    /**
     * Update the specified payment.
     */
    public function update(PaymentRequest $request, Payment $payment): RedirectResponse
    {
        $oldInvoice = $payment->invoice;
        $payment->update($request->validated());

        // Update both old and new invoice status
        $this->updateInvoiceStatus($oldInvoice);
        if ($payment->invoice_id !== $oldInvoice->id) {
            $this->updateInvoiceStatus($payment->fresh()->invoice);
        }

        AuditLog::log(auth()->id(), 'updated', 'payments', $payment->id);

        return redirect()->route('payments.index')
            ->with('success', 'Payment updated successfully.');
    }

    /**
     * Remove the specified payment.
     */
    public function destroy(Payment $payment): RedirectResponse
    {
        $paymentId = $payment->id;
        $invoice = $payment->invoice;
        $payment->delete();

        // Update invoice status after deletion
        $this->updateInvoiceStatus($invoice);

        AuditLog::log(auth()->id(), 'deleted', 'payments', $paymentId);

        return redirect()->route('payments.index')
            ->with('success', 'Payment deleted successfully.');
    }

    /**
     * Update invoice status based on payments.
     */
    private function updateInvoiceStatus(Invoice $invoice): void
    {
        $invoice->refresh();
        $totalPaid = $invoice->payments->sum('amount');

        if ($totalPaid >= $invoice->total_amount) {
            $invoice->update(['status' => 'paid']);
        } elseif ($totalPaid > 0) {
            $invoice->update(['status' => 'partial']);
        } else {
            $invoice->update(['status' => 'unpaid']);
        }
    }
}
