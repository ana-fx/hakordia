<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'start_date',
        'end_date',
        'quota',
        'notes',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function scopeAvailable(Builder $query): Builder
    {
        $today = now()->toDateString();

        return $query->whereDate('start_date', '<=', $today)
            ->whereDate('end_date', '>=', $today);
    }
}


