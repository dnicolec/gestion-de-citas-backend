<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\DoctorSchedule;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<DoctorSchedule>
 */
class DoctorScheduleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $startHour = fake()->randomElement(['08:00', '09:00', '10:00', '14:00', '15:00']);
        $endHour = match ($startHour) {
            '08:00' => '11:00',
            '09:00' => '12:00',
            '10:00' => '13:00',
            '14:00' => '17:00',
            '15:00' => '18:00',
        };

        return [
            'user_id' => User::factory()->medico(),
            'day_of_week' => fake()->randomElement(['lunes', 'martes', 'miercoles', 'jueves', 'viernes', 'sabado']),
            'start_time' => $startHour,
            'end_time' => $endHour,
        ];
    }
}
