<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'event_type',
        'event_date',
        'venue',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'event_date' => 'date',
        ];
    }

    /**
     * Get the client for this event
     */
    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    /**
     * Get the users assigned to this event (photographers/editors)
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'event_user')->withPivot('role');
    }

    /**
     * Get the tasks for this event
     */
    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }

    /**
     * Get the contract for this event
     */
    public function contract(): HasOne
    {
        return $this->hasOne(Contract::class);
    }

    /**
     * Get the invoice for this event
     */
    public function invoice(): HasOne
    {
        return $this->hasOne(Invoice::class);
    }

    /**
     * Get the equipment assigned to this event
     */
    public function equipment(): BelongsToMany
    {
        return $this->belongsToMany(Equipment::class, 'equipment_event')
            ->withPivot(['assigned_date', 'return_date', 'rental_cost', 'notes'])
            ->withTimestamps();
    }

    /**
     * Get employee payments for this event
     */
    public function employeePayments(): HasMany
    {
        return $this->hasMany(EmployeePayment::class);
    }

    /**
     * Get additional costs for this event
     */
    public function eventCosts(): HasMany
    {
        return $this->hasMany(EventCost::class);
    }

    // ========================================
    // Financial Accessors (Admin view only)
    // ========================================

    /**
     * Get total income from invoice
     */
    public function getTotalIncomeAttribute(): float
    {
        return $this->invoice?->total_amount ?? 0;
    }

    /**
     * Get total employee payment costs
     */
    public function getTotalEmployeePaymentsAttribute(): float
    {
        return $this->employeePayments->sum('agreed_amount');
    }

    /**
     * Get total equipment rental costs
     */
    public function getTotalEquipmentCostsAttribute(): float
    {
        return $this->equipment->sum('pivot.rental_cost');
    }

    /**
     * Get total additional event costs
     */
    public function getTotalEventCostsAttribute(): float
    {
        return $this->eventCosts->sum('amount');
    }

    /**
     * Get total costs (all expenses combined)
     */
    public function getTotalCostsAttribute(): float
    {
        return $this->total_employee_payments
            + $this->total_equipment_costs
            + $this->total_event_costs;
    }

    /**
     * Get net profit (income - costs)
     */
    public function getNetProfitAttribute(): float
    {
        return $this->total_income - $this->total_costs;
    }

    /**
     * Check if event is profitable
     */
    public function getIsProfitableAttribute(): bool
    {
        return $this->net_profit >= 0;
    }
}
