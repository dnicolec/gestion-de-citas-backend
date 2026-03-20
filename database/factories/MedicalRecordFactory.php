<?php

namespace Database\Factories;

use App\Models\Patient;
use App\Models\MedicalRecord;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<MedicalRecord>
 */
class MedicalRecordFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'patient_id' => Patient::factory(),
            'known_allergies' => fake()->optional(0.4)->randomElement([
                'Penicilina',
                'Aspirina',
                'Sulfamidas',
                'Ninguna conocida',
                'Naproxeno',
                'Metoclopramida',
            ]),
            'chronic_conditions' => fake()->optional(0.3)->randomElement([
                'Rinitis alérgica',
                'Colitis nerviosa',
                'Asma',
                'Ninguna',
                'Síndrome del túnel carpiano',
                'Artritis reumatoide',
            ]),
            'current_medications' => fake()->optional(0.3)->randomElement([
                'Metformina 850mg',
                'Losartán 50mg',
                'Omeprazol 20mg',
                'Ninguno',
                'Levotiroxina 100mcg',
            ]),
            'family_background' => fake()->optional(0.5)->randomElement([
                'Abuela con artritis reumatoide',
                'Abuelo con lupus',
                'Sin antecedentes relevantes',
                'Abuelo con migraña crónica',
                'Tío con asma',
            ]),
            'notes' => fake()->optional(0.3)->randomElement([
                'Paciente en seguimiento trimestral',
                'Próxima cita en dos semanas',
                'Pendiente resultado de laboratorio',
                'Derivado a nutricionista',
                'Paciente estable, sin novedades',
            ]),
            'blood_type' => fake()->randomElement(['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-']),
        ];
    }
}
