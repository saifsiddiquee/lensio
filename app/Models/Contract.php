<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Contract extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'reference_no',
        'status',
    ];

    /**
     * Get the event for this contract
     */
    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }
}
