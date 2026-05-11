<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class EquipmentController extends Controller
{
    public function index()
    {
        $equipment = Equipment::latest()->paginate(15);
        return view('equipment.index', compact('equipment'));
    }

    public function create()
    {
        $categories = Equipment::categories();
        $ownershipTypes = Equipment::ownershipTypes();
        $statuses = Equipment::statuses();
        return view('equipment.create', compact('categories', 'ownershipTypes', 'statuses'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|in:' . implode(',', Equipment::categories()),
            'ownership_type' => 'required|in:' . implode(',', Equipment::ownershipTypes()),
            'status' => 'required|in:' . implode(',', Equipment::statuses()),
            'purchase_cost' => 'nullable|numeric|min:0',
            'rental_cost_per_day' => 'nullable|numeric|min:0',
            'serial_number' => 'nullable|string|max:100',
            'notes' => 'nullable|string',
        ]);

        Equipment::create($validated);
        return redirect()->route('equipment.index')->with('success', 'Equipment added successfully!');
    }

    public function show(Equipment $equipment)
    {
        $equipment->load('events.client');
        return view('equipment.show', compact('equipment'));
    }

    public function edit(Equipment $equipment)
    {
        $categories = Equipment::categories();
        $ownershipTypes = Equipment::ownershipTypes();
        $statuses = Equipment::statuses();
        return view('equipment.edit', compact('equipment', 'categories', 'ownershipTypes', 'statuses'));
    }

    public function update(Request $request, Equipment $equipment)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|in:' . implode(',', Equipment::categories()),
            'ownership_type' => 'required|in:' . implode(',', Equipment::ownershipTypes()),
            'status' => 'required|in:' . implode(',', Equipment::statuses()),
            'purchase_cost' => 'nullable|numeric|min:0',
            'rental_cost_per_day' => 'nullable|numeric|min:0',
            'serial_number' => 'nullable|string|max:100',
            'notes' => 'nullable|string',
        ]);

        $equipment->update($validated);
        return redirect()->route('equipment.index')->with('success', 'Equipment updated successfully!');
    }

    public function destroy(Equipment $equipment)
    {
        try {
            $equipment->delete();

            return redirect()->route('equipment.index')
                ->with('success', 'Equipment deleted successfully!');
        } catch (QueryException $e) {
            if ($e->getCode() === '23000') {
                return redirect()->route('equipment.index')
                    ->with('error', 'This equipment cannot be deleted because it is assigned to one or more events. Unassign it from all events first.');
            }

            return redirect()->route('equipment.index')
                ->with('error', 'An unexpected error occurred while deleting the equipment.');
        }
    }
}
