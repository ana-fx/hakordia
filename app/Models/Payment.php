<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Payment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'amount',
        'status',
        'payment_method',
        'payment_proof',
        'payment_date',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'payment_date' => 'datetime',
        'amount' => 'decimal:2',
    ];

    /**
     * Get the user that owns the payment.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the participant associated with the payment.
     */
    public function participant()
    {
        return $this->hasOne(Participant::class);
    }

    public function participants(): HasMany
    {
        return $this->hasMany(Participant::class);
    }

    public static function generateOrderNumber(): string
    {
        $prefix = 'NR' . date('Ymd');
        $lastOrder = self::where('order_number', 'like', $prefix . '%')
            ->orderBy('order_number', 'desc')
            ->first();

        if (!$lastOrder) {
            $number = '0001';
        } else {
            $lastNumber = intval(substr($lastOrder->order_number, -4));
            $number = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        }

        return $prefix . $number;
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($payment) {
            // Generate unique ID if not set
            if (!$payment->unique_id) {
                $payment->unique_id = Str::uuid()->toString();
            }
        });
    }
}
