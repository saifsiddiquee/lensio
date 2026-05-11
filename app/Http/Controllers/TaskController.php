<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskRequest;
use App\Models\AuditLog;
use App\Models\Event;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class TaskController extends Controller
{
    /**
     * Display a listing of tasks.
     */
    public function index(): View
    {
        $tasks = Task::with(['event.client', 'assignedUser'])
            ->latest()
            ->paginate(15);

        return view('tasks.index', compact('tasks'));
    }

    /**
     * Show the form for creating a new task.
     */
    public function create(): View
    {
        $events = Event::with('client')->get();
        $users = User::where('is_active', true)->get();
        $taskTypes = ['pre_event', 'event_day', 'post_event'];
        $statuses = ['pending', 'in_progress', 'done'];

        return view('tasks.create', compact('events', 'users', 'taskTypes', 'statuses'));
    }

    /**
     * Store a newly created task.
     */
    public function store(TaskRequest $request): RedirectResponse
    {
        $task = Task::create($request->validated());

        AuditLog::log(auth()->id(), 'created', 'tasks', $task->id);

        return redirect()->route('tasks.index')
            ->with('success', 'Task created successfully.');
    }

    /**
     * Display the specified task.
     */
    public function show(Task $task): View
    {
        $task->load(['event.client', 'assignedUser']);

        return view('tasks.show', compact('task'));
    }

    /**
     * Show the form for editing the specified task.
     */
    public function edit(Task $task): View
    {
        $events = Event::with('client')->get();
        $users = User::where('is_active', true)->get();
        $taskTypes = ['pre_event', 'event_day', 'post_event'];
        $statuses = ['pending', 'in_progress', 'done'];

        return view('tasks.edit', compact('task', 'events', 'users', 'taskTypes', 'statuses'));
    }

    /**
     * Update the specified task.
     */
    public function update(TaskRequest $request, Task $task): RedirectResponse
    {
        $task->update($request->validated());

        AuditLog::log(auth()->id(), 'updated', 'tasks', $task->id);

        return redirect()->route('tasks.index')
            ->with('success', 'Task updated successfully.');
    }

    /**
     * Remove the specified task.
     */
    public function destroy(Task $task): RedirectResponse
    {
        try {
            $taskId = $task->id;
            $task->delete();
            AuditLog::log(auth()->id(), 'deleted', 'tasks', $taskId);

            return redirect()->route('tasks.index')
                ->with('success', 'Task deleted successfully.');
        } catch (QueryException $e) {
            if ($e->getCode() === '23000') {
                return redirect()->route('tasks.index')
                    ->with('error', 'This task cannot be deleted because it is linked to other records.');
            }

            return redirect()->route('tasks.index')
                ->with('error', 'An unexpected error occurred while deleting the task.');
        }
    }
}
