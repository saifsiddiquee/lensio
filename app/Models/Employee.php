<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'role',
        'employment_type',
        'monthly_salary',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'monthly_salary' => 'decimal:2',
            'is_active' => 'boolean',
        ];
    }

    // ========================================
    // Relationships
    // ========================================

    /**
     * Get the linked user account (if any)
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get event-wise payments for this employee
     */
    public function eventPayments(): HasMany
    {
        return $this->hasMany(EmployeePayment::class);
    }

    /**
     * Get monthly salary records for this employee
     */
    public function monthlySalaries(): HasMany
    {
        return $this->hasMany(EmployeeMonthlySalary::class);
    }

    // ========================================
    // Scopes
    // ========================================

    /**
     * Scope to active employees only
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope by role
     */
    public function scopeByRole(Builder $query, string $role): Builder
    {
        return $query->where('role', $role);
    }

    /**
     * Scope by employment type
     */
    public function scopeByEmploymentType(Builder $query, string $type): Builder
    {
        return $query->where('employment_type', $type);
    }

    // ========================================
    // Accessors
    // ========================================

    /**
     * Get total pending event payments
     */
    public function getTotalPendingEventPaymentsAttribute(): float
    {
        return $this->eventPayments()
            ->whereIn('status', ['pending', 'partial'])
            ->sum('agreed_amount') - $this->eventPayments()
                ->whereIn('status', ['pending', 'partial'])
                ->sum('paid_amount');
    }

    /**
     * Get total pending monthly salaries
     */
    public function getTotalPendingMonthlySalariesAttribute(): float
    {
        return $this->monthlySalaries()
            ->where('status', 'pending')
            ->sum('payable_amount') - $this->monthlySalaries()
                ->where('status', 'pending')
                ->sum('paid_amount');
    }

    /**
     * Get display name for role
     */
    public function getRoleDisplayAttribute(): string
    {
        return match ($this->role) {
            'photographer' => 'Photographer',
            'editor' => 'Editor',
            'support' => 'Support Staff',
            default => ucfirst($this->role),
        };
    }

    /**
     * Get display name for employment type
     */
    public function getEmploymentTypeDisplayAttribute(): string
    {
        return match ($this->employment_type) {
            'full_time' => 'Full Time',
            'part_time' => 'Part Time',
            'contractual' => 'Contractual',
            default => ucfirst(str_replace('_', ' ', $this->employment_type)),
        };
    }
}
