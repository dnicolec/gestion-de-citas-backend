<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicalRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'known_allergies',
        'chronic_conditions',
        'current_medications',
        'family_background',
        'notes',
        'blood_type',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
