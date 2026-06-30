<?php

namespace Database\Factories;

use App\Models\Appointment;
use App\Models\Payment;
use Illuminate\Database\Eloquent\Factories\Factory;

class PaymentFactory extends Factory
{
    protected $model = Payment::class;

    public function definition(): array
    {
        return [
            'appointment_id' => Appointment::factory(),
            'method' => $this->faker->randomElement(['cash', 'knet']),
            'amount' => $this->faker->randomFloat(3, 10, 200),
            'status' => 'unpaid',
        ];
    }

    public function paid(): static
    {
        return $this->state(fn(array $attrs) => [
            'status' => 'paid',
            'paid_at' => now(),
        ]);
    }

    public function cash(): static
    {
        return $this->state(fn(array $attrs) => [
            'method' => 'cash',
        ]);
    }

    public function knet(): static
    {
        return $this->state(fn(array $attrs) => [
            'method' => 'knet',
        ]);
    }
}
