<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CheckoutParticipant extends Model
{
    protected $fillable = [
        'checkout_id',
        'nik',
        'full_name',
        'whatsapp_number',
        'email',
        'address',
        'date_of_birth',
        'city',
        'jersey_size',
        'blood_type',
        'emergency_contact_number',
        'medical_conditions',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
    ];

    public function checkout(): BelongsTo
    {
        return $this->belongsTo(Checkout::class);
    }
}
