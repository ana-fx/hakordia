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
        'participant_count',
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
        // Use Asia/Jakarta timezone to match WIB
        $today = now('Asia/Jakarta')->toDateString();

        return $query->whereDate('start_date', '<=', $today)
            ->whereDate('end_date', '>=', $today);
    }

    /**
     * Get remaining quota for this ticket
     */
    public function getRemainingQuota(): ?int
    {
        if ($this->quota === null) {
            return null; // Unlimited quota
        }

        $usedQuota = \App\Models\Checkout::where('ticket_id', $this->id)
            ->where('status', 'paid')
            ->sum('total_participants');

        return max(0, $this->quota - $usedQuota);
    }

    /**
     * Check if ticket has available quota
     */
    public function hasAvailableQuota(int $needed = 1): bool
    {
        if ($this->quota === null) {
            return true; // Unlimited quota
        }

        return $this->getRemainingQuota() >= $needed;
    }

    /**
     * Get used quota count
     */
    public function getUsedQuota(): int
    {
        return \App\Models\Checkout::where('ticket_id', $this->id)
            ->where('status', 'paid')
            ->sum('total_participants');
    }
}


