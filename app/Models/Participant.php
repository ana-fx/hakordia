<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Participant extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'payment_id',
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

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'date_of_birth' => 'date',
    ];

    /**
     * Get the user that owns the participant.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the payment associated with the participant.
     */
    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }
}
