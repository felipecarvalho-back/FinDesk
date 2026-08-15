<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Caixinha extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'target_amount',
        'balance',
        'color',
        'icon',
        'description',
    ];

    protected $casts = [
        'target_amount' => 'float',
        'balance' => 'float',
    ];

    public function getProgressPercentageAttribute(): float
    {
        if (! $this->target_amount || $this->target_amount <= 0) {
            return 100.0;
        }

        return min(100.0, round(($this->balance / $this->target_amount) * 100, 1));
    }
}
