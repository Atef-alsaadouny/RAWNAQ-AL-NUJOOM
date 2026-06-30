<?php

namespace Tests\Unit;

use App\Models\Appointment;
use App\Models\Business;
use App\Models\Payment;
use App\Models\Service;
use App\Services\AppointmentService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AppointmentServiceTest extends TestCase
{
    use RefreshDatabase;

    protected AppointmentService $service;
    protected Business $business;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new AppointmentService();
        $this->business = Business::factory()->create();
    }

    public function test_priority_upgraded_to_vip_when_total_ge_200(): void
    {
        $service = Service::factory()->create([
            'business_id' => $this->business->id,
            'price' => 200.000,
        ]);

        $appointment = Appointment::factory()
            ->for($this->business)
            ->create(['priority' => Appointment::PRIORITY_NORMAL]);

        $appointment->services()->attach($service);
        $appointment->load('services');
        $appointment->payment()->create([
            'method' => Payment::METHOD_CASH,
            'amount' => 200,
            'status' => Payment::STATUS_UNPAID,
        ]);

        $this->service->applyAutoPriority($appointment);

        $this->assertDatabaseHas('appointments', [
            'id' => $appointment->id,
            'priority' => Appointment::PRIORITY_VIP,
        ]);
    }

    public function test_priority_not_upgraded_when_total_lt_200(): void
    {
        $service = Service::factory()->create([
            'business_id' => $this->business->id,
            'price' => 50.000,
        ]);

        $appointment = Appointment::factory()
            ->for($this->business)
            ->create(['priority' => Appointment::PRIORITY_NORMAL]);

        $appointment->services()->attach($service);
        $appointment->load('services');
        $appointment->payment()->create([
            'method' => Payment::METHOD_CASH,
            'amount' => 50,
            'status' => Payment::STATUS_UNPAID,
        ]);

        $this->service->applyAutoPriority($appointment);

        $this->assertDatabaseHas('appointments', [
            'id' => $appointment->id,
            'priority' => Appointment::PRIORITY_NORMAL,
        ]);
    }

    public function test_vip_priority_not_overwritten_when_already_vip(): void
    {
        $service = Service::factory()->create([
            'business_id' => $this->business->id,
            'price' => 50.000,
        ]);

        $appointment = Appointment::factory()
            ->for($this->business)
            ->create(['priority' => Appointment::PRIORITY_VIP]);

        $appointment->services()->attach($service);
        $appointment->load('services');
        $appointment->payment()->create([
            'method' => Payment::METHOD_CASH,
            'amount' => 50,
            'status' => Payment::STATUS_UNPAID,
        ]);

        $this->service->applyAutoPriority($appointment);

        $this->assertDatabaseHas('appointments', [
            'id' => $appointment->id,
            'priority' => Appointment::PRIORITY_VIP,
        ]);
    }

    public function test_vip_activated_for_package_total_ge_200(): void
    {
        $package = \App\Models\Package::factory()->create([
            'business_id' => $this->business->id,
            'price' => 250.000,
        ]);

        $appointment = Appointment::factory()
            ->for($this->business)
            ->create(['priority' => Appointment::PRIORITY_NORMAL]);

        $appointment->packages()->attach($package);
        $appointment->load('packages');
        $appointment->payment()->create([
            'method' => Payment::METHOD_CASH,
            'amount' => 250,
            'status' => Payment::STATUS_UNPAID,
        ]);

        $this->service->applyAutoPriority($appointment);

        $this->assertDatabaseHas('appointments', [
            'id' => $appointment->id,
            'priority' => Appointment::PRIORITY_VIP,
        ]);
    }

    public function test_auto_priority_does_not_downgrade_urgent(): void
    {
        $service = Service::factory()->create([
            'business_id' => $this->business->id,
            'price' => 50.000,
        ]);

        $appointment = Appointment::factory()
            ->for($this->business)
            ->create(['priority' => Appointment::PRIORITY_URGENT]);

        $appointment->services()->attach($service);
        $appointment->load('services');
        $appointment->payment()->create([
            'method' => Payment::METHOD_CASH,
            'amount' => 50,
            'status' => Payment::STATUS_UNPAID,
        ]);

        $this->service->applyAutoPriority($appointment);

        $this->assertDatabaseHas('appointments', [
            'id' => $appointment->id,
            'priority' => Appointment::PRIORITY_URGENT,
        ]);
    }

    public function test_priority_stays_normal_when_total_below_200(): void
    {
        $business = Business::factory()->create();
        $service = $this->createService($business, 50.000);
        $appointment = Appointment::factory()->create([
            'business_id' => $business->id,
            'priority' => Appointment::PRIORITY_NORMAL,
        ]);
        $appointment->services()->attach($service->id);
        Payment::factory()->create([
            'appointment_id' => $appointment->id,
            'amount' => 50.000,
            'method' => Payment::METHOD_CASH,
            'status' => Payment::STATUS_UNPAID,
        ]);
        $appointment->load(['services', 'packages', 'payment']);

        $s = app(AppointmentService::class);
        $s->applyAutoPriority($appointment);

        $this->assertDatabaseHas('appointments', [
            'id' => $appointment->id,
            'priority' => Appointment::PRIORITY_NORMAL,
        ]);
    }

    public function test_vip_activated_at_exactly_200(): void
    {
        $business = Business::factory()->create();
        $service = $this->createService($business, 200.000);
        $appointment = Appointment::factory()->create([
            'business_id' => $business->id,
            'priority' => Appointment::PRIORITY_NORMAL,
        ]);
        $appointment->services()->attach($service->id);
        Payment::factory()->create([
            'appointment_id' => $appointment->id,
            'amount' => 200.000,
            'method' => Payment::METHOD_CASH,
            'status' => Payment::STATUS_UNPAID,
        ]);
        $appointment->load(['services', 'packages', 'payment']);

        $s = app(AppointmentService::class);
        $s->applyAutoPriority($appointment);

        $this->assertDatabaseHas('appointments', [
            'id' => $appointment->id,
            'priority' => Appointment::PRIORITY_VIP,
        ]);
    }
}
