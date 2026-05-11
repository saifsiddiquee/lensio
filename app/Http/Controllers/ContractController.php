<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContractRequest;
use App\Models\AuditLog;
use App\Models\Contract;
use App\Models\Event;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ContractController extends Controller
{
    /**
     * Display a listing of contracts.
     */
    public function index(): View
    {
        $contracts = Contract::with('event.client')
            ->latest()
            ->paginate(15);

        return view('contracts.index', compact('contracts'));
    }

    /**
     * Show the form for creating a new contract.
     */
    public function create(): View
    {
        $events = Event::whereDoesntHave('contract')->with('client')->get();
        $statuses = ['draft', 'signed', 'completed'];

        return view('contracts.create', compact('events', 'statuses'));
    }

    /**
     * Store a newly created contract.
     */
    public function store(ContractRequest $request): RedirectResponse
    {
        $contract = Contract::create($request->validated());

        AuditLog::log(auth()->id(), 'created', 'contracts', $contract->id);

        return redirect()->route('contracts.index')
            ->with('success', 'Contract created successfully.');
    }

    /**
     * Display the specified contract.
     */
    public function show(Contract $contract): View
    {
        $contract->load('event.client');

        return view('contracts.show', compact('contract'));
    }

    /**
     * Show the form for editing the specified contract.
     */
    public function edit(Contract $contract): View
    {
        $events = Event::whereDoesntHave('contract')
            ->orWhere('id', $contract->event_id)
            ->with('client')
            ->get();
        $statuses = ['draft', 'signed', 'completed'];

        return view('contracts.edit', compact('contract', 'events', 'statuses'));
    }

    /**
     * Update the specified contract.
     */
    public function update(ContractRequest $request, Contract $contract): RedirectResponse
    {
        $contract->update($request->validated());

        AuditLog::log(auth()->id(), 'updated', 'contracts', $contract->id);

        return redirect()->route('contracts.index')
            ->with('success', 'Contract updated successfully.');
    }

    /**
     * Remove the specified contract.
     */
    public function destroy(Contract $contract): RedirectResponse
    {
        try {
            $contractId = $contract->id;
            $contract->delete();
            AuditLog::log(auth()->id(), 'deleted', 'contracts', $contractId);

            return redirect()->route('contracts.index')
                ->with('success', 'Contract deleted successfully.');
        } catch (QueryException $e) {
            if ($e->getCode() === '23000') {
                return redirect()->route('contracts.index')
                    ->with('error', 'This contract cannot be deleted because it is linked to other records. Remove those records first.');
            }

            return redirect()->route('contracts.index')
                ->with('error', 'An unexpected error occurred while deleting the contract.');
        }
    }
}
