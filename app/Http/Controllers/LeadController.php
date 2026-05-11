<?php

namespace App\Http\Controllers;

use App\Http\Requests\LeadRequest;
use App\Models\AuditLog;
use App\Models\Lead;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class LeadController extends Controller
{
    /**
     * Display a listing of leads.
     */
    public function index(): View
    {
        $leads = Lead::with('assignedUser')
            ->latest()
            ->paginate(15);

        return view('leads.index', compact('leads'));
    }

    /**
     * Show the form for creating a new lead.
     */
    public function create(): View
    {
        $users = User::where('is_active', true)->get();
        $statuses = ['new', 'contacted', 'quoted', 'booked', 'lost'];

        return view('leads.create', compact('users', 'statuses'));
    }

    /**
     * Store a newly created lead.
     */
    public function store(LeadRequest $request): RedirectResponse
    {
        $lead = Lead::create($request->validated());

        AuditLog::log(auth()->id(), 'created', 'leads', $lead->id);

        return redirect()->route('leads.index')
            ->with('success', 'Lead created successfully.');
    }

    /**
     * Display the specified lead.
     */
    public function show(Lead $lead): View
    {
        $lead->load(['assignedUser', 'client']);

        return view('leads.show', compact('lead'));
    }

    /**
     * Show the form for editing the specified lead.
     */
    public function edit(Lead $lead): View
    {
        $users = User::where('is_active', true)->get();
        $statuses = ['new', 'contacted', 'quoted', 'booked', 'lost'];

        return view('leads.edit', compact('lead', 'users', 'statuses'));
    }

    /**
     * Update the specified lead.
     */
    public function update(LeadRequest $request, Lead $lead): RedirectResponse
    {
        $lead->update($request->validated());

        AuditLog::log(auth()->id(), 'updated', 'leads', $lead->id);

        return redirect()->route('leads.index')
            ->with('success', 'Lead updated successfully.');
    }

    /**
     * Remove the specified lead.
     */
    public function destroy(Lead $lead): RedirectResponse
    {
        try {
            $leadId = $lead->id;
            $lead->delete();
            AuditLog::log(auth()->id(), 'deleted', 'leads', $leadId);

            return redirect()->route('leads.index')
                ->with('success', 'Lead deleted successfully.');
        } catch (QueryException $e) {
            // FK constraint: lead has an associated client
            if ($e->getCode() === '23000') {
                return redirect()->route('leads.index')
                    ->with('error', 'This lead cannot be deleted because it has an associated client. Convert or remove the client first.');
            }

            return redirect()->route('leads.index')
                ->with('error', 'An unexpected error occurred while deleting the lead.');
        }
    }

    /**
     * Convert lead to client.
     */
    public function convertToClient(Lead $lead): RedirectResponse
    {
        if ($lead->client) {
            return redirect()->route('leads.show', $lead)
                ->with('error', 'This lead has already been converted to a client.');
        }

        $client = $lead->client()->create([
            'name' => $lead->name,
            'phone' => $lead->phone,
            'email' => $lead->email,
        ]);

        $lead->update(['status' => 'booked']);

        AuditLog::log(auth()->id(), 'converted_to_client', 'leads', $lead->id);

        return redirect()->route('clients.show', $client)
            ->with('success', 'Lead converted to client successfully.');
    }
}
