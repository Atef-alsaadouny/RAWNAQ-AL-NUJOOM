<?php

namespace Tests\Feature;

use App\Models\Appointment;
use App\Models\Business;
use App\Models\Payment;
use App\Models\Service;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GuestBookingTest extends TestCase
{
    use RefreshDatabase;

    protected Business $business;
    protected Service $service;
    protected User $employee;

    protected function setUp(): void
    {
        parent::setUp();

        $this->business = Business::factory()->create();
        $this->service = $this->createService($this->business);
        $this->employee = User::factory()->employee()->create([
            'business_id' => $this->business->id,
            'phone' => '96666666',
        ]);

        $this->createDefaultSchedule($this->business);
    }

    protected function guestBookingData(array $overrides = []): array
    {
        return array_merge([
            'customer_name' => 'Test Guest',
            'customer_phone' => '98888888',
            'service_ids' => [$this->service->id],
            'shift' => Appointment::SHIFT_MORNING,
            'appointment_date' => now()->addDay()->format('Y-m-d'),
            'payment_method' => Payment::METHOD_CASH,
            'form_loaded_at' => $this->validFormLoadedAt(),
        ], $overrides);
    }

    public function test_guest_can_book_an_appointment(): void
    {
        $response = $this->post('/book', $this->guestBookingData());

        $response->assertSessionHasNoErrors();
        $response->assertRedirect();

        $this->assertDatabaseHas('appointments', [
            'customer_name' => 'Test Guest',
            'customer_phone' => '98888888',
            'status' => Appointment::STATUS_PENDING,
        ]);
    }

    public function test_guest_booking_creates_appointment_log_when_employee_assigned(): void
    {
        $this->post('/book', $this->guestBookingData([
            'employee_id' => $this->employee->id,
        ]));

        $appointment = Appointment::first();
        $this->assertNotNull($appointment);

        $this->assertDatabaseHas('appointment_logs', [
            'appointment_id' => $appointment->id,
        ]);
    }

    public function test_guest_booking_with_employee_sets_assigned(): void
    {
        $response = $this->post('/book', $this->guestBookingData([
            'employee_id' => $this->employee->id,
        ]));

        $response->assertSessionHasNoErrors();

        $this->assertDatabaseHas('appointments', [
            'customer_name' => 'Test Guest',
            'employee_id' => $this->employee->id,
            'status' => Appointment::STATUS_ASSIGNED,
        ]);
    }

    public function test_guest_booking_with_high_total_gets_vip(): void
    {
        $expensiveService = $this->createService($this->business, 200.000);

        $this->post('/book', $this->guestBookingData([
            'service_ids' => [$expensiveService->id],
        ]));

        $this->assertDatabaseHas('appointments', [
            'customer_name' => 'Test Guest',
            'priority' => Appointment::PRIORITY_VIP,
        ]);
    }

    public function test_guest_booking_validation_fails(): void
    {
        $response = $this->post('/book', [
            'customer_phone' => 'invalid',
            'form_loaded_at' => $this->validFormLoadedAt(),
        ]);

        $response->assertInvalid(['customer_name', 'customer_phone', 'shift', 'appointment_date', 'payment_method']);
    }

    public function test_guest_booking_creates_payment(): void
    {
        $this->post('/book', $this->guestBookingData());

        $appointment = Appointment::first();
        $this->assertNotNull($appointment);

        $this->assertDatabaseHas('payments', [
            'appointment_id' => $appointment->id,
            'method' => Payment::METHOD_CASH,
            'status' => Payment::STATUS_UNPAID,
        ]);
    }

    public function test_guest_can_edit_booking(): void
    {
        $this->post('/book', $this->guestBookingData());

        $appointment = Appointment::first();
        $token = $appointment->guest_token;

        $response = $this->put("/booking/{$appointment->id}", [
            'service_ids' => [$this->service->id],
            'shift' => Appointment::SHIFT_EVENING,
            'appointment_date' => now()->addDays(2)->format('Y-m-d'),
            'notes' => 'Updated note',
            'phone' => '98888888',
            'token' => $token,
        ]);

        $response->assertSessionHasNoErrors();

        $this->assertDatabaseHas('appointments', [
            'id' => $appointment->id,
            'shift' => Appointment::SHIFT_EVENING,
            'notes' => 'Updated note',
        ]);

        $this->assertDatabaseHas('appointment_logs', [
            'appointment_id' => $appointment->id,
            'notes' => 'Booking updated',
        ]);
    }

    public function test_guest_can_cancel_booking(): void
    {
        $this->post('/book', $this->guestBookingData());

        $appointment = Appointment::first();
        $token = $appointment->guest_token;

        $response = $this->delete("/booking/{$appointment->id}", [
            'phone' => '98888888',
            'token' => $token,
            'cancel_reason' => 'Changed my mind',
        ]);

        $response->assertSessionHasNoErrors();

        $this->assertDatabaseHas('appointments', [
            'id' => $appointment->id,
            'status' => Appointment::STATUS_CANCELLED,
            'cancel_reason' => 'Changed my mind',
        ]);

        $this->assertDatabaseHas('appointment_logs', [
            'appointment_id' => $appointment->id,
            'new_status' => Appointment::STATUS_CANCELLED,
        ]);
    }

    public function test_guest_cannot_book_with_invalid_phone(): void
    {
        $response = $this->post('/book', $this->guestBookingData([
            'customer_phone' => '123',
            'form_loaded_at' => $this->validFormLoadedAt(),
        ]));

        $response->assertSessionHasErrors(['customer_phone']);
    }

    public function test_guest_booking_syncs_services(): void
    {
        $service2 = Service::factory()->create(['business_id' => $this->business->id]);

        $this->post('/book', $this->guestBookingData([
            'service_ids' => [$this->service->id, $service2->id],
        ]));

        $appointment = Appointment::first();
        $this->assertCount(2, $appointment->services);
    }
}
