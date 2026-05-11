<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Invoice;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReportController extends Controller
{
    /**
     * Display the reports dashboard.
     */
    public function index(): View
    {
        return view('reports.index');
    }

    /**
     * Display revenue report.
     */
    public function revenue(): View
    {
        $monthlyRevenue = Payment::selectRaw('YEAR(payment_date) as year, MONTH(payment_date) as month, SUM(amount) as total')
            ->groupByRaw('YEAR(payment_date), MONTH(payment_date)')
            ->orderByRaw('YEAR(payment_date) DESC, MONTH(payment_date) DESC')
            ->limit(12)
            ->get();

        $totalRevenue = Invoice::where('status', 'paid')->sum('total_amount');
        $totalPending = Invoice::whereIn('status', ['unpaid', 'partial'])->sum('total_amount');

        $paidPayments = Payment::sum('amount');

        return view('reports.revenue', compact('monthlyRevenue', 'totalRevenue', 'totalPending', 'paidPayments'));
    }

    /**
     * Display pending payments report.
     */
    public function pendingPayments(): View
    {
        $pendingInvoices = Invoice::with('event.client')
            ->whereIn('status', ['unpaid', 'partial'])
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($invoice) {
                $invoice->paid_amount = $invoice->payments->sum('amount');
                $invoice->balance = $invoice->total_amount - $invoice->paid_amount;
                return $invoice;
            });

        $totalPending = $pendingInvoices->sum('balance');

        return view('reports.pending-payments', compact('pendingInvoices', 'totalPending'));
    }

    /**
     * Display event status report.
     */
    public function eventStatus(): View
    {
        $eventStats = [
            'planned' => Event::where('status', 'planned')->count(),
            'completed' => Event::where('status', 'completed')->count(),
            'cancelled' => Event::where('status', 'cancelled')->count(),
        ];

        $upcomingEvents = Event::with('client')
            ->where('status', 'planned')
            ->where('event_date', '>=', now())
            ->orderBy('event_date')
            ->get();

        $recentCompleted = Event::with('client')
            ->where('status', 'completed')
            ->latest()
            ->limit(10)
            ->get();

        return view('reports.event-status', compact('eventStats', 'upcomingEvents', 'recentCompleted'));
    }

    /**
     * Display profit/loss report.
     */
    public function profitLoss(Request $request): View
    {
        $year = $request->input('year', now()->year);
        $viewType = $request->input('view', 'monthly'); // monthly or yearly

        // Get available years for filter
        $years = Event::selectRaw('YEAR(event_date) as year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year');

        if ($years->isEmpty()) {
            $years = collect([now()->year]);
        }

        // Base query for events with relationships loaded
        $eventsQuery = Event::with(['invoice', 'employeePayments', 'eventCosts', 'equipment', 'client']);

        if ($viewType === 'monthly') {
            // Monthly report for selected year
            $monthlyData = collect();

            for ($month = 1; $month <= 12; $month++) {
                $events = (clone $eventsQuery)
                    ->whereYear('event_date', $year)
                    ->whereMonth('event_date', $month)
                    ->get();

                $income = $events->sum('total_income');
                $costs = $events->sum('total_costs');
                $profit = $income - $costs;

                $monthlyData->push([
                    'month' => $month,
                    'month_name' => date('F', mktime(0, 0, 0, $month, 1)),
                    'events_count' => $events->count(),
                    'income' => $income,
                    'costs' => $costs,
                    'profit' => $profit,
                ]);
            }

            $reportData = $monthlyData;
        } else {
            // Yearly summary across all years
            $yearlyData = collect();

            foreach ($years as $y) {
                $events = (clone $eventsQuery)
                    ->whereYear('event_date', $y)
                    ->get();

                $income = $events->sum('total_income');
                $costs = $events->sum('total_costs');
                $profit = $income - $costs;

                $yearlyData->push([
                    'year' => $y,
                    'events_count' => $events->count(),
                    'income' => $income,
                    'costs' => $costs,
                    'profit' => $profit,
                ]);
            }

            $reportData = $yearlyData;
        }

        // Summary totals
        $totals = [
            'events' => $reportData->sum('events_count'),
            'income' => $reportData->sum('income'),
            'costs' => $reportData->sum('costs'),
            'profit' => $reportData->sum('profit'),
        ];

        return view('reports.profit-loss', compact('reportData', 'totals', 'years', 'year', 'viewType'));
    }
}

