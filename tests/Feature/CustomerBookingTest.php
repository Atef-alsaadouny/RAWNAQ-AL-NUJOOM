<?php

namespace Tests\Feature;

use App\Models\Appointment;
use App\Models\Business;
use App\Models\Payment;
use App\Models\Service;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CustomerBookingTest extends TestCase
{
    use RefreshDatabase;

    protected Business $business;
    protected Service $service;
    protected User $customer;
    protected User $employee;

    protected function setUp(): void
    {
        parent::setUp();

        $this->business = Business::factory()->create();
        $this->service = $this->createService($this->business, 15.000);
        $this->customer = User::factory()->customer()->create([
            'business_id' => $this->business->id,
            'phone' => '97777777',
        ]);
        $this->employee = User::factory()->employee()->create([
            'business_id' => $this->business->id,
            'phone' => '96666666',
        ]);

        $this->createDefaultSchedule($this->business);
    }

    public function test_customer_can_book(): void
    {
        $response = $this->actingAs($this->customer)->post('/book', [
            'service_ids' => [$this->service->id],
            'shift' => Appointment::SHIFT_MORNING,
            'appointment_date' => now()->addDay()->format('Y-m-d'),
            'payment_method' => Payment::METHOD_CASH,
            'form_loaded_at' => $this->validFormLoadedAt(),
        ]);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect();

        $this->assertDatabaseHas('appointments', [
            'customer_id' => $this->customer->id,
            'status' => Appointment::STATUS_PENDING,
        ]);
    }

    public function test_customer_can_edit_own_booking(): void
    {
        $appointment = Appointment::factory()
            ->for($this->business)
            ->forCustomer($this->customer)
            ->cashPayment()
            ->create([
                'shift' => Appointment::SHIFT_MORNING,
                'appointment_date' => now()->addDay()->format('Y-m-d'),
                'status' => Appointment::STATUS_PENDING,
            ]);

        $appointment->services()->attach($this->service);

        $response = $this->actingAs($this->customer)
            ->put("/customer/appointments/{$appointment->id}", [
                'service_ids' => [$this->service->id],
                'shift' => Appointment::SHIFT_EVENING,
                'appointment_date' => now()->addDays(2)->format('Y-m-d'),
                'notes' => 'Edited by customer',
            ]);

        $response->assertSessionHasNoErrors();

        $this->assertDatabaseHas('appointments', [
            'id' => $appointment->id,
            'shift' => Appointment::SHIFT_EVENING,
            'notes' => 'Edited by customer',
        ]);
    }

    public function test_customer_can_cancel_own_booking(): void
    {
        $appointment = Appointment::factory()
            ->for($this->business)
            ->forCustomer($this->customer)
            ->cashPayment()
            ->create([
                'shift' => Appointment::SHIFT_MORNING,
                'appointment_date' => now()->addDay()->format('Y-m-d'),
                'status' => Appointment::STATUS_PENDING,
            ]);

        $response = $this->actingAs($this->customer)
            ->delete("/customer/appointments/{$appointment->id}/cancel", [
                'cancel_reason' => 'No longer needed',
            ]);

        $response->assertSessionHasNoErrors();

        $this->assertDatabaseHas('appointments', [
            'id' => $appointment->id,
            'status' => Appointment::STATUS_CANCELLED,
            'cancel_reason' => 'No longer needed',
        ]);
    }

    public function test_customer_cancels_booking_creates_log(): void
    {
        $appointment = Appointment::factory()
            ->for($this->business)
            ->forCustomer($this->customer)
            ->cashPayment()
            ->create([
                'shift' => Appointment::SHIFT_MORNING,
                'appointment_date' => now()->addDay()->format('Y-m-d'),
                'status' => Appointment::STATUS_ASSIGNED,
                'employee_id' => $this->employee->id,
            ]);

        $this->actingAs($this->customer)
            ->delete("/customer/appointments/{$appointment->id}/cancel", [
                'cancel_reason' => 'No longer needed',
            ]);

        $this->assertDatabaseHas('appointment_logs', [
            'appointment_id' => $appointment->id,
            'action_by' => $this->customer->id,
            'new_status' => Appointment::STATUS_CANCELLED,
        ]);
    }

    public function test_customer_cannot_edit_others_booking(): void
    {
        $otherCustomer = User::factory()->customer()->create(['business_id' => $this->business->id]);
        $appointment = Appointment::factory()
            ->for($this->business)
            ->forCustomer($otherCustomer)
            ->cashPayment()
            ->create([
                'shift' => Appointment::SHIFT_MORNING,
                'appointment_date' => now()->addDay()->format('Y-m-d'),
                'status' => Appointment::STATUS_PENDING,
            ]);

        $response = $this->actingAs($this->customer)
            ->get("/customer/appointments/{$appointment->id}/edit");

        $response->assertStatus(403);
    }

    public function test_customer_cannot_edit_non_cash_booking(): void
    {
        $appointment = Appointment::factory()
            ->for($this->business)
            ->forCustomer($this->customer)
            ->create([
                'shift' => Appointment::SHIFT_MORNING,
                'appointment_date' => now()->addDay()->format('Y-m-d'),
                'status' => Appointment::STATUS_PENDING,
            ]);

        $appointment->payment()->create([
            'method' => Payment::METHOD_KNET,
            'amount' => 50,
            'status' => Payment::STATUS_PAID,
        ]);

        $response = $this->actingAs($this->customer)
            ->get("/customer/appointments/{$appointment->id}/edit");

        $response->assertSessionHas('error');
    }

    public function test_customer_booking_with_employee_sets_assigned(): void
    {
        $response = $this->actingAs($this->customer)->post('/book', [
            'service_ids' => [$this->service->id],
            'employee_id' => $this->employee->id,
            'shift' => Appointment::SHIFT_MORNING,
            'appointment_date' => now()->addDay()->format('Y-m-d'),
            'payment_method' => Payment::METHOD_CASH,
            'form_loaded_at' => $this->validFormLoadedAt(),
        ]);

        $response->assertSessionHasNoErrors();

        $this->assertDatabaseHas('appointments', [
            'customer_id' => $this->customer->id,
            'employee_id' => $this->employee->id,
            'status' => Appointment::STATUS_ASSIGNED,
        ]);
    }
}
