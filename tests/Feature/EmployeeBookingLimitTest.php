<?php

namespace Tests\Feature;

use App\Models\Appointment;
use App\Models\Business;
use App\Models\Payment;
use App\Models\Service;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EmployeeBookingLimitTest extends TestCase
{
    use RefreshDatabase;

    protected Business $business;
    protected User $employee;
    protected Service $service;
    protected string $date;

    protected function setUp(): void
    {
        parent::setUp();

        $this->business = Business::factory()->create();
        $this->employee = User::factory()->employee()->create([
            'business_id' => $this->business->id,
            'phone' => '96666666',
        ]);
        $this->service = $this->createService($this->business);
        $this->date = now()->addDay()->format('Y-m-d');
        $this->createDefaultSchedule($this->business);
    }

    protected function createBookingForEmployee(string $shift): Appointment
    {
        $max = Appointment::where('business_id', $this->business->id)->max('ticket_number');
        $next = $max ? intval($max) + 1 : 1;
        $ticketNumber = str_pad($next, 5, '0', STR_PAD_LEFT);

        $appointment = Appointment::create([
            'business_id' => $this->business->id,
            'employee_id' => $this->employee->id,
            'shift' => $shift,
            'appointment_date' => $this->date,
            'status' => Appointment::STATUS_ASSIGNED,
            'ticket_number' => $ticketNumber,
            'customer_name' => 'Test Customer',
            'customer_phone' => '96666666',
            'priority' => Appointment::PRIORITY_NORMAL,
        ]);

        $appointment->services()->attach($this->service);
        $appointment->payment()->create([
            'method' => Payment::METHOD_CASH,
            'amount' => 10,
            'status' => Payment::STATUS_UNPAID,
        ]);

        return $appointment;
    }

    public function test_employee_can_have_two_bookings_in_same_shift(): void
    {
        $this->createBookingForEmployee(Appointment::SHIFT_MORNING);
        $this->createBookingForEmployee(Appointment::SHIFT_MORNING);

        $existingCount = Appointment::where('employee_id', $this->employee->id)
            ->whereDate('appointment_date', $this->date)
            ->where('shift', Appointment::SHIFT_MORNING)
            ->whereIn('status', [Appointment::STATUS_PENDING, Appointment::STATUS_ASSIGNED, Appointment::STATUS_IN_PROGRESS])
            ->count();

        $this->assertEquals(2, $existingCount);
    }

    public function test_third_assignment_to_same_shift_blocked(): void
    {
        $this->createBookingForEmployee(Appointment::SHIFT_MORNING);
        $this->createBookingForEmployee(Appointment::SHIFT_MORNING);

        $response = $this->post('/book', [
            'customer_name' => 'Third Customer',
            'customer_phone' => '95555555',
            'service_ids' => [$this->service->id],
            'employee_id' => $this->employee->id,
            'shift' => Appointment::SHIFT_MORNING,
            'appointment_date' => $this->date,
            'payment_method' => Payment::METHOD_CASH,
            'form_loaded_at' => $this->validFormLoadedAt(),
        ]);

        $response->assertRedirect()->assertSessionHas('error');
    }

    public function test_employee_can_have_two_in_morning_and_two_in_evening(): void
    {
        $this->createBookingForEmployee(Appointment::SHIFT_MORNING);
        $this->createBookingForEmployee(Appointment::SHIFT_MORNING);
        $this->createBookingForEmployee(Appointment::SHIFT_EVENING);
        $this->createBookingForEmployee(Appointment::SHIFT_EVENING);

        $morningCount = Appointment::where('employee_id', $this->employee->id)
            ->whereDate('appointment_date', $this->date)
            ->where('shift', Appointment::SHIFT_MORNING)
            ->whereIn('status', [Appointment::STATUS_PENDING, Appointment::STATUS_ASSIGNED, Appointment::STATUS_IN_PROGRESS])
            ->count();

        $eveningCount = Appointment::where('employee_id', $this->employee->id)
            ->whereDate('appointment_date', $this->date)
            ->where('shift', Appointment::SHIFT_EVENING)
            ->whereIn('status', [Appointment::STATUS_PENDING, Appointment::STATUS_ASSIGNED, Appointment::STATUS_IN_PROGRESS])
            ->count();

        $this->assertEquals(2, $morningCount);
        $this->assertEquals(2, $eveningCount);
    }

    public function test_cancelled_bookings_dont_count_towards_limit(): void
    {
        $this->createBookingForEmployee(Appointment::SHIFT_MORNING);
        $cancelled = $this->createBookingForEmployee(Appointment::SHIFT_MORNING);
        $cancelled->update(['status' => Appointment::STATUS_CANCELLED]);

        $activeCount = Appointment::where('employee_id', $this->employee->id)
            ->whereDate('appointment_date', $this->date)
            ->where('shift', Appointment::SHIFT_MORNING)
            ->whereIn('status', [Appointment::STATUS_PENDING, Appointment::STATUS_ASSIGNED, Appointment::STATUS_IN_PROGRESS])
            ->count();

        $this->assertEquals(1, $activeCount);
    }
}
