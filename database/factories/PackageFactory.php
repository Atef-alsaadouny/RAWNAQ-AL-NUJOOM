<?php

namespace Database\Factories;

use App\Models\Business;
use App\Models\Package;
use Illuminate\Database\Eloquent\Factories\Factory;

class PackageFactory extends Factory
{
    protected $model = Package::class;

    public function definition(): array
    {
        return [
            'business_id' => Business::factory(),
            'name_ar' => $this->faker->word() . ' AR',
            'name_en' => $this->faker->word() . ' EN',
            'price' => $this->faker->randomFloat(3, 20, 100),
            'original_price' => $this->faker->randomFloat(3, 30, 150),
            'is_active' => true,
            'sort_order' => 0,
        ];
    }
}
