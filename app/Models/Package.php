<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Package extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'duration_hours',
        'description',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'duration_hours' => 'integer',
        ];
    }

    /**
     * Get the quotations using this package
     */
    public function quotations(): HasMany
    {
        return $this->hasMany(Quotation::class);
    }
}
