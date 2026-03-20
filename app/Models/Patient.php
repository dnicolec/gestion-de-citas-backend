<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = [
        'given_name',
        'family_name',
        'id_document',
        'birth_date',
        'gender',
        'phone_number',
        'email_address',
        'home_address',
        'emergency_contact_name',
        'emergency_contact_phone',
    ];

    protected function casts(): array
    {
        return [
            'birth_date' => 'date',
        ];
    }

    public function medicalRecord()
    {
        return $this->hasOne(MedicalRecord::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function getFullNameAttribute(): string
    {
        return "{$this->given_name} {$this->family_name}";
    }
}
