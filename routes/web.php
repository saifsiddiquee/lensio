<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ContractController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\EmployeePaymentController;
use App\Http\Controllers\EmployeeSalaryController;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\EventCostController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\QuotationController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\TaskController;
use App\Http\Middleware\RoleMiddleware;
use Illuminate\Support\Facades\Route;

// Guest routes
Route::middleware('guest')->group(function () {
    Route::get('login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('login', [AuthController::class, 'login']);
});

// Authenticated routes
Route::middleware(['auth', RoleMiddleware::class])->group(function () {
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Leads - Admin, Manager and Sales
    Route::middleware([RoleMiddleware::class . ':admin,manager,sales'])->group(function () {
        Route::resource('leads', LeadController::class);
        Route::post('leads/{lead}/convert', [LeadController::class, 'convertToClient'])->name('leads.convert');
    });

    // Clients - Admin, Manager and Sales
    Route::middleware([RoleMiddleware::class . ':admin,manager,sales'])->group(function () {
        Route::resource('clients', ClientController::class);
    });

    // Events - All authenticated users can view, Admin/Manager/Sales can manage
    Route::middleware([RoleMiddleware::class . ':admin,manager,sales'])->group(function () {
        Route::get('events/create', [EventController::class, 'create'])->name('events.create');
        Route::post('events', [EventController::class, 'store'])->name('events.store');
        Route::get('events/{event}/edit', [EventController::class, 'edit'])->name('events.edit');
        Route::put('events/{event}', [EventController::class, 'update'])->name('events.update');
        Route::delete('events/{event}', [EventController::class, 'destroy'])->name('events.destroy');
    });
    Route::get('events', [EventController::class, 'index'])->name('events.index');
    Route::get('events/{event}', [EventController::class, 'show'])->name('events.show');

    // Packages - Admin and Manager
    Route::middleware([RoleMiddleware::class . ':admin,manager'])->group(function () {
        Route::resource('packages', PackageController::class);
    });

    // Equipment - Admin and Manager
    Route::middleware([RoleMiddleware::class . ':admin,manager'])->group(function () {
        Route::resource('equipment', EquipmentController::class);
    });

    // Employees - Admin and Manager
    Route::middleware([RoleMiddleware::class . ':admin,manager'])->group(function () {
        Route::resource('employees', EmployeeController::class);
    });

    // Monthly Salaries - Admin and Manager
    Route::middleware([RoleMiddleware::class . ':admin,manager'])->group(function () {
        Route::resource('salaries', EmployeeSalaryController::class);
    });

    // Quotations - Admin, Manager and Sales
    Route::middleware([RoleMiddleware::class . ':admin,manager,sales'])->group(function () {
        Route::resource('quotations', QuotationController::class);
    });

    // Contracts - Admin, Manager and Sales
    Route::middleware([RoleMiddleware::class . ':admin,manager,sales'])->group(function () {
        Route::resource('contracts', ContractController::class);
    });

    // Tasks - All authenticated users
    Route::resource('tasks', TaskController::class);

    // Invoices - Admin, Manager and Sales
    Route::middleware([RoleMiddleware::class . ':admin,manager,sales'])->group(function () {
        Route::resource('invoices', InvoiceController::class);
    });

    // Payments - Admin, Manager and Sales
    Route::middleware([RoleMiddleware::class . ':admin,manager,sales'])->group(function () {
        Route::resource('payments', PaymentController::class);
    });

    // Users - Admin only
    Route::middleware([RoleMiddleware::class . ':admin'])->group(function () {
        Route::resource('users', UserController::class)->except(['show']);
    });

    // Reports - Admin and Manager
    Route::middleware([RoleMiddleware::class . ':admin,manager'])->prefix('reports')->name('reports.')->group(function () {
        Route::get('/', [ReportController::class, 'index'])->name('index');
        Route::get('/revenue', [ReportController::class, 'revenue'])->name('revenue');
        Route::get('/pending-payments', [ReportController::class, 'pendingPayments'])->name('pending-payments');
        Route::get('/event-status', [ReportController::class, 'eventStatus'])->name('event-status');
        Route::get('/profit-loss', [ReportController::class, 'profitLoss'])->name('profit-loss');
    });

    // Event-scoped resources (Admin and Manager)
    Route::middleware([RoleMiddleware::class . ':admin,manager'])->prefix('events/{event}')->group(function () {
        Route::post('costs', [EventCostController::class, 'store'])->name('events.costs.store');
        Route::put('costs/{cost}', [EventCostController::class, 'update'])->name('events.costs.update');
        Route::delete('costs/{cost}', [EventCostController::class, 'destroy'])->name('events.costs.destroy');

        Route::post('employee-payments', [EmployeePaymentController::class, 'store'])->name('events.employee-payments.store');
        Route::put('employee-payments/{payment}', [EmployeePaymentController::class, 'update'])->name('events.employee-payments.update');
        Route::delete('employee-payments/{payment}', [EmployeePaymentController::class, 'destroy'])->name('events.employee-payments.destroy');
    });
});
