<?php

namespace Tests\Feature;

use App\Models\Appointment;
use App\Models\AppointmentLog;
use App\Models\Business;
use App\Models\Service;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminBookingActionsTest extends TestCase
{
    use RefreshDatabase;

    protected Business $business;
    protected User $admin;
    protected Appointment $appointment;

    protected function setUp(): void
    {
        parent::setUp();

        $this->business = Business::factory()->create();
        $this->admin = User::factory()->admin()->create([
            'business_id' => $this->business->id,
        ]);
        $service = Service::factory()->create(['business_id' => $this->business->id]);

        $this->appointment = Appointment::factory()
            ->for($this->business)
            ->cashPayment()
            ->create([
                'shift' => Appointment::SHIFT_MORNING,
                'appointment_date' => now()->addDay()->format('Y-m-d'),
                'status' => Appointment::STATUS_PENDING,
            ]);

        $this->appointment->services()->attach($service);
    }

    public function test_admin_can_cancel_appointment(): void
    {
        $response = $this->actingAs($this->admin)
            ->patch("/admin/appointments/{$this->appointment->id}/cancel", [
                'cancel_reason' => 'Admin override',
            ]);

        $response->assertSessionHasNoErrors();

        $this->assertDatabaseHas('appointments', [
            'id' => $this->appointment->id,
            'status' => Appointment::STATUS_CANCELLED,
            'cancel_reason' => 'Admin override',
        ]);
    }

    public function test_admin_cancel_creates_log(): void
    {
        $this->actingAs($this->admin)
            ->patch("/admin/appointments/{$this->appointment->id}/cancel", [
                'cancel_reason' => 'Admin override',
            ]);

        $this->assertDatabaseHas('appointment_logs', [
            'appointment_id' => $this->appointment->id,
            'action_by' => $this->admin->id,
            'new_status' => Appointment::STATUS_CANCELLED,
        ]);
    }

    public function test_admin_can_rebook_appointment(): void
    {
        $this->appointment->update(['status' => Appointment::STATUS_CANCELLED]);

        $response = $this->actingAs($this->admin)
            ->get("/admin/appointments/{$this->appointment->id}/rebook");

        $response->assertRedirect();
    }

    public function test_admin_cannot_cancel_completed_appointment(): void
    {
        $this->appointment->update(['status' => Appointment::STATUS_COMPLETED, 'completed_at' => now()]);

        $response = $this->actingAs($this->admin)
            ->patch("/admin/appointments/{$this->appointment->id}/cancel", [
                'cancel_reason' => 'Admin override',
            ]);

        $response->assertSessionHas('error');

        $this->assertDatabaseHas('appointments', [
            'id' => $this->appointment->id,
            'status' => Appointment::STATUS_COMPLETED,
        ]);
    }

    public function test_admin_from_other_business_cannot_cancel(): void
    {
        $otherBusiness = Business::factory()->create();
        $otherAdmin = User::factory()->admin()->create(['business_id' => $otherBusiness->id]);

        $response = $this->actingAs($otherAdmin)
            ->patch("/admin/appointments/{$this->appointment->id}/cancel", [
                'cancel_reason' => 'Admin override',
            ]);

        $response->assertStatus(403);
    }
}
