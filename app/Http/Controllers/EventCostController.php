<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventCost;
use Illuminate\Http\Request;

class EventCostController extends Controller
{
    public function store(Request $request, Event $event)
    {
        $validated = $request->validate([
            'cost_type' => 'required|in:' . implode(',', array_keys(EventCost::costTypes())),
            'amount' => 'required|numeric|min:0',
            'description' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        $event->eventCosts()->create($validated);
        return back()->with('success', 'Cost added successfully!');
    }

    public function update(Request $request, Event $event, EventCost $cost)
    {
        $validated = $request->validate([
            'cost_type' => 'required|in:' . implode(',', array_keys(EventCost::costTypes())),
            'amount' => 'required|numeric|min:0',
            'description' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        $cost->update($validated);
        return back()->with('success', 'Cost updated successfully!');
    }

    public function destroy(Event $event, EventCost $cost)
    {
        $cost->delete();
        return back()->with('success', 'Cost deleted successfully!');
    }
}
