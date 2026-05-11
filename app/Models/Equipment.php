<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Equipment extends Model
{
    protected $table = 'equipment';

    protected $fillable = [
        'name',
        'category',
        'ownership_type',
        'status',
        'purchase_cost',
        'rental_cost_per_day',
        'serial_number',
        'notes',
    ];

    protected $casts = [
        'purchase_cost' => 'decimal:2',
        'rental_cost_per_day' => 'decimal:2',
    ];

    // Category options
    public static function categories(): array
    {
        return ['camera', 'lens', 'lighting', 'drone', 'audio', 'tripod', 'other'];
    }

    // Ownership types
    public static function ownershipTypes(): array
    {
        return ['owned', 'rented'];
    }

    // Status options
    public static function statuses(): array
    {
        return ['available', 'assigned', 'maintenance'];
    }

    // Relationships
    public function events(): BelongsToMany
    {
        return $this->belongsToMany(Event::class, 'equipment_event')
            ->withPivot(['assigned_date', 'return_date', 'rental_cost', 'notes'])
            ->withTimestamps();
    }

    // Scopes
    public function scopeAvailable($query)
    {
        return $query->where('status', 'available');
    }

    public function scopeByCategory($query, string $category)
    {
        return $query->where('category', $category);
    }

    public function scopeOwned($query)
    {
        return $query->where('ownership_type', 'owned');
    }

    public function scopeRented($query)
    {
        return $query->where('ownership_type', 'rented');
    }

    // Check if equipment is available for given date range
    public function isAvailableForDates($startDate, $endDate, $excludeEventId = null): bool
    {
        if ($this->status === 'maintenance') {
            return false;
        }

        $query = $this->events()
            ->where(function ($q) use ($startDate, $endDate) {
                $q->where(function ($inner) use ($startDate, $endDate) {
                    $inner->where('assigned_date', '<=', $endDate)
                        ->where(function ($sub) use ($startDate) {
                            $sub->whereNull('equipment_event.return_date')
                                ->orWhere('equipment_event.return_date', '>=', $startDate);
                        });
                });
            });

        if ($excludeEventId) {
            $query->where('events.id', '!=', $excludeEventId);
        }

        return $query->count() === 0;
    }

    // Get formatted category name
    public function getCategoryLabelAttribute(): string
    {
        return ucfirst($this->category);
    }

    // Get formatted status with color
    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'available' => 'success',
            'assigned' => 'primary',
            'maintenance' => 'warning',
            default => 'secondary',
        };
    }
}
