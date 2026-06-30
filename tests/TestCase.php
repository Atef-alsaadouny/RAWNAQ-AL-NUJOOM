<?php

namespace Tests;

use App\Models\Business;
use App\Models\BusinessSchedule;
use App\Models\Service;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected function createDefaultSchedule(Business $business, ?int $dayOfWeek = null): void
    {
        $day = $dayOfWeek ?? now()->dayOfWeek;
        BusinessSchedule::create([
            'business_id' => $business->id,
            'day_of_week' => $day,
            'shift' => 'morning',
            'start_time' => '09:00',
            'end_time' => '13:00',
            'is_active' => true,
        ]);
        BusinessSchedule::create([
            'business_id' => $business->id,
            'day_of_week' => $day,
            'shift' => 'evening',
            'start_time' => '16:00',
            'end_time' => '21:00',
            'is_active' => true,
        ]);
    }

    protected function validFormLoadedAt(): int
    {
        return (int)(microtime(true) * 1000) - 5000;
    }

    protected function createService(Business $business, float $price = 10.000): Service
    {
        return Service::factory()->create([
            'business_id' => $business->id,
            'price' => $price,
        ]);
    }
}
