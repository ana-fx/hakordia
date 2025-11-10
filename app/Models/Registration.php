<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    use HasFactory;

    protected $fillable = [
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
        'medical_conditions'
    ];

    protected $casts = [
        'date_of_birth' => 'date'
    ];
}
