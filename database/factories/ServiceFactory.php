<?php

namespace Database\Factories;

use App\Models\Business;
use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;

class ServiceFactory extends Factory
{
    protected $model = Service::class;

    public function definition(): array
    {
        return [
            'business_id' => Business::factory(),
            'name_ar' => $this->faker->word() . ' (AR)',
            'name_en' => $this->faker->word() . ' (EN)',
            'price' => $this->faker->randomFloat(3, 5, 50),
            'duration_minutes' => $this->faker->randomElement([30, 45, 60]),
            'is_active' => true,
            'sort_order' => 0,
        ];
    }
}
