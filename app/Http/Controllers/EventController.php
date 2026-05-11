<?php

namespace App\Http\Controllers;

use App\Http\Requests\EventRequest;
use App\Models\AuditLog;
use App\Models\Client;
use App\Models\Event;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class EventController extends Controller
{
    /**
     * Display a listing of events.
     */
    public function index(): View
    {
        $events = Event::with(['client', 'users'])
            ->latest()
            ->paginate(15);

        return view('events.index', compact('events'));
    }

    /**
     * Show the form for creating a new event.
     */
    public function create(): View
    {
        $clients = Client::all();
        $photographers = User::where('is_active', true)
            ->whereIn('role', ['photographer', 'admin'])
            ->get();
        $editors = User::where('is_active', true)
            ->whereIn('role', ['editor', 'admin'])
            ->get();
        $statuses = ['planned', 'completed', 'cancelled'];

        return view('events.create', compact('clients', 'photographers', 'editors', 'statuses'));
    }

    /**
     * Store a newly created event.
     */
    public function store(EventRequest $request): RedirectResponse
    {
        $event = Event::create($request->only([
            'client_id',
            'event_type',
            'event_date',
            'venue',
            'status'
        ]));

        // Sync assigned users with roles
        $this->syncEventUsers($event, $request);

        AuditLog::log(auth()->id(), 'created', 'events', $event->id);

        return redirect()->route('events.index')
            ->with('success', 'Event created successfully.');
    }

    /**
     * Display the specified event.
     */
    public function show(Event $event): View
    {
        $event->load(['client', 'users', 'tasks', 'contract', 'invoice']);

        return view('events.show', compact('event'));
    }

    /**
     * Show the form for editing the specified event.
     */
    public function edit(Event $event): View
    {
        $clients = Client::all();
        $photographers = User::where('is_active', true)
            ->whereIn('role', ['photographer', 'admin'])
            ->get();
        $editors = User::where('is_active', true)
            ->whereIn('role', ['editor', 'admin'])
            ->get();
        $statuses = ['planned', 'completed', 'cancelled'];
        $event->load('users');

        return view('events.edit', compact('event', 'clients', 'photographers', 'editors', 'statuses'));
    }

    /**
     * Update the specified event.
     */
    public function update(EventRequest $request, Event $event): RedirectResponse
    {
        $event->update($request->only([
            'client_id',
            'event_type',
            'event_date',
            'venue',
            'status'
        ]));

        // Sync assigned users with roles
        $this->syncEventUsers($event, $request);

        AuditLog::log(auth()->id(), 'updated', 'events', $event->id);

        return redirect()->route('events.index')
            ->with('success', 'Event updated successfully.');
    }

    /**
     * Remove the specified event.
     */
    public function destroy(Event $event): RedirectResponse
    {
        try {
            $eventId = $event->id;
            $event->users()->detach();
            $event->delete();
            AuditLog::log(auth()->id(), 'deleted', 'events', $eventId);

            return redirect()->route('events.index')
                ->with('success', 'Event deleted successfully.');
        } catch (QueryException $e) {
            if ($e->getCode() === '23000') {
                return redirect()->route('events.index')
                    ->with('error', 'This event cannot be deleted because it has associated tasks, contracts, invoices, or costs. Remove those records first.');
            }

            return redirect()->route('events.index')
                ->with('error', 'An unexpected error occurred while deleting the event.');
        }
    }

    /**
     * Sync event users with their roles.
     */
    private function syncEventUsers(Event $event, EventRequest $request): void
    {
        $userIds = $request->input('user_ids', []);
        $userRoles = $request->input('user_roles', []);

        $syncData = [];
        foreach ($userIds as $index => $userId) {
            if ($userId && isset($userRoles[$index])) {
                $syncData[$userId] = ['role' => $userRoles[$index]];
            }
        }

        $event->users()->sync($syncData);
    }
}
