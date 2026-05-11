<?php

namespace App\Http\Controllers;

use App\Models\EmployeePayment;
use App\Models\Event;
use App\Models\User;
use Illuminate\Http\Request;

class EmployeePaymentController extends Controller
{
    public function store(Request $request, Event $event)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'payment_type' => 'required|in:' . implode(',', EmployeePayment::paymentTypes()),
            'agreed_amount' => 'required|numeric|min:0',
            'paid_amount' => 'nullable|numeric|min:0',
            'status' => 'required|in:' . implode(',', EmployeePayment::statuses()),
            'payment_date' => 'nullable|date',
            'notes' => 'nullable|string',
        ]);

        $validated['paid_amount'] = $validated['paid_amount'] ?? 0;
        $event->employeePayments()->create($validated);
        return back()->with('success', 'Employee payment added successfully!');
    }

    public function update(Request $request, Event $event, EmployeePayment $payment)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'payment_type' => 'required|in:' . implode(',', EmployeePayment::paymentTypes()),
            'agreed_amount' => 'required|numeric|min:0',
            'paid_amount' => 'nullable|numeric|min:0',
            'status' => 'required|in:' . implode(',', EmployeePayment::statuses()),
            'payment_date' => 'nullable|date',
            'notes' => 'nullable|string',
        ]);

        $validated['paid_amount'] = $validated['paid_amount'] ?? 0;
        $payment->update($validated);
        return back()->with('success', 'Employee payment updated successfully!');
    }

    public function destroy(Event $event, EmployeePayment $payment)
    {
        $payment->delete();
        return back()->with('success', 'Employee payment deleted successfully!');
    }
}
