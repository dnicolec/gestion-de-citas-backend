<?php
namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected $model = User::class;
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
            'role' => 'asistente',
            'phone_number' => fake()->phoneNumber(),
            'medical_specialty' => null,
            'is_active' => true,
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    // Estados de Rol

    public function admin(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'admin',
        ]);
    }

    public function medico(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'medico',
            'medical_specialty' => fake()->randomElement([
                'Medicina General',
                'Pediatría',
                'Ginecología',
                'Cardiología',
                'Dermatología',
                'Traumatología',
                'Oftalmología',
            ]),
        ]);
    }

    public function asistente(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'asistente',
        ]);
    }
}