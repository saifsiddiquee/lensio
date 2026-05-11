<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClientRequest;
use App\Models\AuditLog;
use App\Models\Client;
use App\Models\Lead;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ClientController extends Controller
{
    /**
     * Display a listing of clients.
     */
    public function index(): View
    {
        $clients = Client::with('lead')
            ->latest()
            ->paginate(15);

        return view('clients.index', compact('clients'));
    }

    /**
     * Show the form for creating a new client.
     */
    public function create(): View
    {
        $leads = Lead::whereDoesntHave('client')->get();

        return view('clients.create', compact('leads'));
    }

    /**
     * Store a newly created client.
     */
    public function store(ClientRequest $request): RedirectResponse
    {
        $client = Client::create($request->validated());

        AuditLog::log(auth()->id(), 'created', 'clients', $client->id);

        return redirect()->route('clients.index')
            ->with('success', 'Client created successfully.');
    }

    /**
     * Display the specified client.
     */
    public function show(Client $client): View
    {
        $client->load(['lead', 'events', 'quotations']);

        return view('clients.show', compact('client'));
    }

    /**
     * Show the form for editing the specified client.
     */
    public function edit(Client $client): View
    {
        $leads = Lead::whereDoesntHave('client')
            ->orWhere('id', $client->lead_id)
            ->get();

        return view('clients.edit', compact('client', 'leads'));
    }

    /**
     * Update the specified client.
     */
    public function update(ClientRequest $request, Client $client): RedirectResponse
    {
        $client->update($request->validated());

        AuditLog::log(auth()->id(), 'updated', 'clients', $client->id);

        return redirect()->route('clients.index')
            ->with('success', 'Client updated successfully.');
    }

    /**
     * Remove the specified client.
     */
    public function destroy(Client $client): RedirectResponse
    {
        try {
            $clientId = $client->id;
            $client->delete();
            AuditLog::log(auth()->id(), 'deleted', 'clients', $clientId);

            return redirect()->route('clients.index')
                ->with('success', 'Client deleted successfully.');
        } catch (QueryException $e) {
            if ($e->getCode() === '23000') {
                return redirect()->route('clients.index')
                    ->with('error', 'This client cannot be deleted because they have associated events or quotations. Remove those records first.');
            }

            return redirect()->route('clients.index')
                ->with('error', 'An unexpected error occurred while deleting the client.');
        }
    }
}
