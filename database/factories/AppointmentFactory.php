<?php

namespace Database\Factories;

use App\Models\Appointment;
use App\Models\Business;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class AppointmentFactory extends Factory
{
    protected $model = Appointment::class;

    public function definition(): array
    {
        return [
            'business_id' => Business::factory(),
            'customer_name' => $this->faker->name(),
            'customer_phone' => '9' . $this->faker->numerify('#######'),
            'shift' => $this->faker->randomElement(['morning', 'evening']),
            'appointment_date' => $this->faker->dateTimeBetween('today', '+1 month')->format('Y-m-d'),
            'status' => 'pending',
            'priority' => 'normal',
            'ticket_number' => '00001',
        ];
    }

    public function pending(): static
    {
        return $this->state(fn(array $attrs) => ['status' => 'pending']);
    }

    public function assigned(): static
    {
        return $this->state(fn(array $attrs) => ['status' => 'assigned', 'employee_id' => User::factory()->employee()]);
    }

    public function cancelled(): static
    {
        return $this->state(fn(array $attrs) => ['status' => 'cancelled']);
    }

    public function completed(): static
    {
        return $this->state(fn(array $attrs) => ['status' => 'completed', 'completed_at' => now()]);
    }

    public function inProgress(): static
    {
        return $this->state(fn(array $attrs) => ['status' => 'in_progress']);
    }

    public function forCustomer(?User $customer): static
    {
        return $this->state(fn(array $attrs) => [
            'customer_id' => $customer?->id,
            'customer_name' => $customer?->name ?? $attrs['customer_name'],
            'customer_phone' => $customer?->phone ?? $attrs['customer_phone'],
        ]);
    }

    public function cashPayment(): static
    {
        return $this->afterCreating(function (Appointment $appointment) {
            $appointment->payment()->create([
                'method' => 'cash',
                'amount' => $appointment->total_price,
                'status' => 'unpaid',
            ]);
        });
    }
}
