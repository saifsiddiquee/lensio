<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Employee;
use App\Models\EmployeeMonthlySalary;
use App\Models\EmployeePayment;
use App\Models\Event;
use App\Models\EventCost;
use App\Models\Invoice;
use App\Models\Lead;
use App\Models\Payment;
use App\Models\Task;
use Carbon\Carbon;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Show the dashboard
     */
    public function index(): View
    {
        $user = auth()->user();
        $isAdmin = $user->isAdmin();

        // Base stats
        $stats = [
            'total_leads' => Lead::count(),
            'new_leads' => Lead::where('status', 'new')->count(),
            'total_clients' => Client::count(),
            'total_events' => Event::count(),
            'upcoming_events' => Event::where('event_date', '>=', now())->where('status', 'planned')->count(),
            'pending_tasks' => Task::where('status', '!=', 'done')->count(),
            'unpaid_invoices' => Invoice::where('status', '!=', 'paid')->count(),
            'total_revenue' => Invoice::where('status', 'paid')->sum('total_amount'),
        ];

        // Admin-only financial stats
        if ($isAdmin) {
            $currentMonth = Carbon::now()->startOfMonth();

            // Pending employee payments (event-wise)
            $stats['pending_event_payments'] = EmployeePayment::whereIn('status', ['pending', 'partial'])
                ->selectRaw('SUM(agreed_amount - paid_amount) as total')
                ->value('total') ?? 0;

            // Pending monthly salaries
            $stats['pending_salaries'] = EmployeeMonthlySalary::where('status', 'pending')
                ->selectRaw('SUM(payable_amount - paid_amount) as total')
                ->value('total') ?? 0;

            // Total pending employee payments
            $stats['total_pending_employee_payments'] = $stats['pending_event_payments'] + $stats['pending_salaries'];

            // Monthly income (current month)
            $stats['monthly_income'] = Payment::whereMonth('payment_date', $currentMonth->month)
                ->whereYear('payment_date', $currentMonth->year)
                ->sum('amount');

            // Monthly expenses (current month)
            $monthlyEventCosts = EventCost::whereHas('event', function ($q) use ($currentMonth) {
                $q->whereMonth('event_date', $currentMonth->month)
                    ->whereYear('event_date', $currentMonth->year);
            })->sum('amount');

            $monthlyEmployeePayments = EmployeePayment::whereMonth('payment_date', $currentMonth->month)
                ->whereYear('payment_date', $currentMonth->year)
                ->sum('paid_amount');

            $monthlySalaries = EmployeeMonthlySalary::where('salary_month', $currentMonth->toDateString())
                ->sum('paid_amount');

            $stats['monthly_expenses'] = $monthlyEventCosts + $monthlyEmployeePayments + $monthlySalaries;

            // Net for month
            $stats['monthly_net'] = $stats['monthly_income'] - $stats['monthly_expenses'];

            // Active employees
            $stats['active_employees'] = Employee::active()->count();
        }

        $recentLeads = Lead::with('assignedUser')
            ->latest()
            ->take(5)
            ->get();

        $upcomingEvents = Event::with('client')
            ->where('event_date', '>=', now())
            ->where('status', 'planned')
            ->orderBy('event_date')
            ->take(5)
            ->get();

        $pendingTasks = Task::with(['event', 'assignedUser'])
            ->where('status', '!=', 'done')
            ->orderBy('due_date')
            ->take(5)
            ->get();

        return view('dashboard.index', compact('stats', 'recentLeads', 'upcomingEvents', 'pendingTasks', 'isAdmin'));
    }
}
