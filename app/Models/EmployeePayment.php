<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EmployeePayment extends Model
{
    protected $fillable = [
        'event_id',
        'user_id',
        'employee_id',
        'payment_type',
        'agreed_amount',
        'paid_amount',
        'status',
        'payment_date',
        'notes',
    ];

    protected $casts = [
        'agreed_amount' => 'decimal:2',
        'paid_amount' => 'decimal:2',
        'payment_date' => 'date',
    ];

    // Payment types
    public static function paymentTypes(): array
    {
        return ['fixed', 'per_day', 'per_task'];
    }

    // Status options
    public static function statuses(): array
    {
        return ['pending', 'partial', 'paid'];
    }

    // Relationships
    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    // Accessors
    public function getBalanceAttribute(): float
    {
        return $this->agreed_amount - $this->paid_amount;
    }

    public function getPaymentTypeLabelAttribute(): string
    {
        return match ($this->payment_type) {
            'fixed' => 'Fixed',
            'per_day' => 'Per Day',
            'per_task' => 'Per Task',
            default => ucfirst($this->payment_type),
        };
    }

    // Auto-update status based on paid amount
    public function updatePaymentStatus(): void
    {
        if ($this->paid_amount >= $this->agreed_amount) {
            $this->status = 'paid';
        } elseif ($this->paid_amount > 0) {
            $this->status = 'partial';
        } else {
            $this->status = 'pending';
        }
        $this->save();
    }
}
