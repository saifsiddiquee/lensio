<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EmployeeMonthlySalary extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'salary_month',
        'payable_amount',
        'paid_amount',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'salary_month' => 'date',
            'payable_amount' => 'decimal:2',
            'paid_amount' => 'decimal:2',
        ];
    }

    // ========================================
    // Relationships
    // ========================================

    /**
     * Get the employee for this salary record
     */
    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    // ========================================
    // Accessors
    // ========================================

    /**
     * Get the remaining balance to pay
     */
    public function getBalanceAttribute(): float
    {
        return $this->payable_amount - $this->paid_amount;
    }

    /**
     * Get formatted month display
     */
    public function getMonthDisplayAttribute(): string
    {
        return $this->salary_month->format('F Y');
    }

    /**
     * Check if fully paid
     */
    public function getIsPaidAttribute(): bool
    {
        return $this->status === 'paid' || $this->paid_amount >= $this->payable_amount;
    }
}
