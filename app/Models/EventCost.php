<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EventCost extends Model
{
    protected $fillable = [
        'event_id',
        'cost_type',
        'amount',
        'description',
        'notes',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
    ];

    // Cost types
    public static function costTypes(): array
    {
        return [
            'accommodation' => 'Accommodation',
            'transportation' => 'Transportation',
            'food' => 'Food & Allowance',
            'equipment_rental' => 'Equipment Rental',
            'venue' => 'Venue Expenses',
            'miscellaneous' => 'Miscellaneous',
        ];
    }

    // Relationships
    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    // Accessor
    public function getCostTypeLabelAttribute(): string
    {
        return self::costTypes()[$this->cost_type] ?? ucfirst($this->cost_type);
    }
}
