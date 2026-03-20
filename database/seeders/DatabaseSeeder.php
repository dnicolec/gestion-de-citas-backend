<?php
// database/seeders/DatabaseSeeder.php
namespace Database\Seeders;

use App\Models\Appointment;
use App\Models\DoctorSchedule;
use App\Models\MedicalRecord;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        //Usuarios: 3 admin, 8 médicos, 12 asistentes = 23 total
        $admins    = User::factory(3)->admin()->create();
        $medicos   = User::factory(8)->medico()->create();
        $asistentes = User::factory(12)->asistente()->create();

        //Horarios para cada médico con 2-4 bloques por semana
        foreach ($medicos as $medico) {
            $dias = fake()->randomElements(
                ['lunes', 'martes', 'miercoles', 'jueves', 'viernes', 'sabado'],
                fake()->numberBetween(2, 4)
            );

            foreach ($dias as $dia) {
                $startHour = fake()->randomElement(['08:00', '09:00', '14:00', '15:00']);
                $endHour   = match ($startHour) {
                    '08:00' => '11:00',
                    '09:00' => '12:00',
                    '14:00' => '17:00',
                    '15:00' => '18:00',
                };

                DoctorSchedule::create([
                    'user_id' => $medico->id,
                    'day_of_week' => $dia,
                    'start_time' => $startHour,
                    'end_time' => $endHour,
                ]);
            }
        }

        //25 pacientes, cada uno con su expediente clínico
        $patients = Patient::factory(25)->create();

        foreach ($patients as $patient) {
            MedicalRecord::factory()->create([
                'patient_id' => $patient->id,
            ]);
        }

        //Más de 30 citas sin duplicados
        $usedSlots = [];

        for ($i = 0; $i < 40; $i++) {
            $medico = $medicos->random();
            $patient = $patients->random();
            $date = fake()->dateTimeBetween('-5 days', '+10 days');
            $startHour = fake()->randomElement(['08:00', '09:00', '10:00', '14:00', '15:00', '16:00']);
            $endHour = date('H:i', strtotime($startHour . ' +1 hour'));
            $slotKey = "{$medico->id}-{$date->format('Y-m-d')}-{$startHour}";

            if (in_array($slotKey, $usedSlots)) {
                continue;
            }

            $usedSlots[] = $slotKey;

            Appointment::create([
                'patient_id' => $patient->id,
                'doctor_id' => $medico->id,
                'appointment_date' => $date,
                'start_time' => $startHour,
                'end_time' => $endHour,
                'status' => fake()->randomElement(['programada', 'completada', 'cancelada']),
                'visit_reason' => fake()->randomElement([
                    'Consulta general',
                    'Control de rutina',
                    'Dolor de cabeza',
                    'Revisión de exámenes',
                    'Chequeo preventivo',
                ]),
                'notes' => fake()->optional(0.4)->randomElement([
                    'Paciente llegó con síntomas leves',
                    'Se recetó tratamiento por una semana',
                    'Pendiente resultado de exámenes de laboratorio',
                    'Se recomienda reposo por 7 días',
                    'Paciente refiere mejoría desde última visita',
                ]),
            ]);
        }
    }
}