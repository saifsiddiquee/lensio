<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Laravel\Sanctum\HasApiTokens;
use HasinHayder\Tyro\Concerns\HasTyroRoles;



class User extends Authenticatable
{
    use HasApiTokens, HasTyroRoles;


    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'is_active',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Check if user is admin
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Check if user is manager
     */
    public function isManager(): bool
    {
        return $this->role === 'manager';
    }

    /**
     * Check if user is sales
     */
    public function isSales(): bool
    {
        return $this->role === 'sales';
    }

    /**
     * Check if user is photographer
     */
    public function isPhotographer(): bool
    {
        return $this->role === 'photographer';
    }

    /**
     * Check if user is editor
     */
    public function isEditor(): bool
    {
        return $this->role === 'editor';
    }

    /**
     * Get the leads assigned to this user
     */
    public function leads(): HasMany
    {
        return $this->hasMany(Lead::class, 'assigned_to');
    }

    /**
     * Get the events assigned to this user (as photographer or editor)
     */
    public function events(): BelongsToMany
    {
        return $this->belongsToMany(Event::class, 'event_user')->withPivot('role');
    }

    /**
     * Get the tasks assigned to this user
     */
    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class, 'assigned_to');
    }

    /**
     * Get the audit logs for this user
     */
    public function auditLogs(): HasMany
    {
        return $this->hasMany(AuditLog::class);
    }

    /**
     * Get the linked employee record
     */
    public function employee(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Employee::class);
    }
}

