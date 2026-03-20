<?php

namespace Database\Factories;

use App\Models\Patient;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Patient>
 */
class PatientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'given_name' => fake()->firstName(),
            'family_name' => fake()->lastName(),
            'id_document' => fake()->unique()->numerify('########-#'),
            'birth_date' => fake()->dateTimeBetween('-80 years', '-1 year'),
            'gender' => fake()->randomElement(['masculino', 'femenino']),
            'phone_number' => fake()->phoneNumber(),
            'email_address' => fake()->unique()->safeEmail(),
            'home_address' => fake()->address(),
            'emergency_contact_name' => fake()->name(),
            'emergency_contact_phone' => fake()->phoneNumber(),
        ];
    }
}
