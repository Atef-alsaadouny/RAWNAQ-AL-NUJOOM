<?php

namespace Database\Factories;

use App\Models\Business;
use Illuminate\Database\Eloquent\Factories\Factory;

class BusinessFactory extends Factory
{
    protected $model = Business::class;

    public function definition(): array
    {
        return [
            'name_ar' => 'رونق النجوم',
            'name_en' => 'RAWNAQ AL NUJOOM',
            'phone' => $this->faker->numerify('########'),
            'email' => $this->faker->email(),
            'city' => 'Kuwait City',
            'is_active' => true,
            'subscription_plan' => 'trial',
        ];
    }
}
