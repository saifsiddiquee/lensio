<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Quotation extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'package_id',
        'total_amount',
        'status',
        'valid_until',
    ];

    protected function casts(): array
    {
        return [
            'total_amount' => 'decimal:2',
            'valid_until' => 'date',
        ];
    }

    /**
     * Get the client for this quotation
     */
    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    /**
     * Get the package for this quotation
     */
    public function package(): BelongsTo
    {
        return $this->belongsTo(Package::class);
    }
}
