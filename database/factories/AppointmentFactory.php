<?php

namespace Database\Factories;

use App\Models\Patient;
use App\Models\User;
use App\Models\Appointment;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Appointment>
 */
class AppointmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $startHour = fake()->randomElement(['08:00', '09:00', '10:00', '11:00', '14:00', '15:00', '16:00']);
        $endHour = date('H:i', strtotime($startHour . ' +1 hour'));

        return [
            'patient_id' => Patient::factory(),
            'doctor_id' => User::factory()->medico(),
            'appointment_date' => fake()->dateTimeBetween('-7 days', '+14 days'),
            'start_time' => $startHour,
            'end_time' => $endHour,
            'status' => fake()->randomElement(['programada', 'completada', 'cancelada']),
            'visit_reason' => fake()->randomElement([
                'Consulta general',
                'Control de rutina',
                'Dolor de cabeza persistente',
                'Revisión de exámenes',
                'Dolor abdominal',
                'Chequeo preventivo',
                'Seguimiento de tratamiento',
            ]),
            'notes' => fake()->optional(0.4)->randomElement([
                'Paciente llegó con síntomas leves',
                'Se recetó tratamiento por 7 días',
                'Pendiente resultado de exámenes',
                'Se recomienda reposo por 3 días',
                'Paciente refiere mejoría desde última visita',
            ]),
        ];
    }
}
