<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Checkout extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'order_number',
        'unique_id',
        'total_amount',
        'total_participants',
        'status',
        'status_verifikasi',
        'payment_proof',
        'payment_deadline',
        'paid_at',
    ];

    protected $casts = [
        'payment_deadline' => 'datetime',
        'paid_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->unique_id)) {
                $model->unique_id = Str::uuid();
            }
        });

        static::saving(function ($model) {
            // Ensure order_number is unique
            if ($model->isDirty('order_number')) {
                $exists = self::where('order_number', $model->order_number)
                    ->where('id', '!=', $model->id ?? 0)
                    ->exists();

                if ($exists) {
                    throw new \Illuminate\Database\QueryException(
                        'Order number already exists',
                        [],
                        new \Exception('duplicate key value violates unique constraint')
                    );
                }
            }
        });
    }

    public function participants(): HasMany
    {
        return $this->hasMany(CheckoutParticipant::class);
    }

    public static function generateOrderNumber(): string
    {
        $prefix = 'NR' . date('Ymd');

        // Use microtime to ensure uniqueness
        $microtime = microtime(true);
        $timestamp = (int)($microtime * 1000000); // Convert to microseconds
        $random = mt_rand(100, 999); // Add some randomness

        // Get the last 4 digits from timestamp + random
        $uniquePart = substr($timestamp . $random, -4);

        return $prefix . $uniquePart;
    }
}
