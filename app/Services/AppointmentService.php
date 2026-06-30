<?php

namespace App\Services;

use App\Models\Appointment;
use App\Models\AppointmentLog;
use App\Models\Package;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AppointmentService
{
    public function syncServicesAndPackages(Appointment $appointment, Request $request, bool $setPackageId = false): void
    {
        $allPackageServiceIds = [];
        $servicesToSync = [];

        if ($request->has('package_ids')) {
            $pkgIds = $request->input('package_ids');
            if (is_array($pkgIds) && count($pkgIds) > 0) {
                if ($setPackageId) {
                    $appointment->package_id = $pkgIds[0];
                    $appointment->save();
                }

                $appointment->packages()->sync($pkgIds);

                $packageServices = Package::whereIn('id', $pkgIds)->with('services')->get();
                foreach ($packageServices as $pkg) {
                    $ids = $pkg->services->pluck('id')->toArray();
                    $allPackageServiceIds = array_merge($allPackageServiceIds, $ids);
                    if ($setPackageId) {
                        $servicesToSync = array_merge($servicesToSync, $ids);
                    }
                }
            } else {
                if ($setPackageId) {
                    $appointment->package_id = null;
                    $appointment->save();
                }
                $appointment->packages()->detach();
            }
        }

        if ($request->filled('service_ids')) {
            $extraIds = $request->service_ids;
            if (!empty($allPackageServiceIds)) {
                $extraIds = array_diff($extraIds, $allPackageServiceIds);
            }
            $servicesToSync = array_merge($servicesToSync, $extraIds);
        }

        if (!empty($servicesToSync)) {
            $appointment->services()->sync(array_unique($servicesToSync));
        } elseif (!$setPackageId) {
            $appointment->services()->detach();
        }

        $appointment->load(['services', 'packages']);
    }

    public function applyAutoPriority(Appointment $appointment): void
    {
        if ($appointment->total_price >= Appointment::VIP_PRICE_THRESHOLD && $appointment->priority !== Appointment::PRIORITY_VIP) {
            $appointment->update(['priority' => Appointment::PRIORITY_VIP]);
        }
    }

    public function syncEmployee(Appointment $appointment, ?int $newEmployeeId, ?int $oldEmployeeId, ?int $actionBy): void
    {
        $appointment->update([
            'employee_id' => $newEmployeeId,
            'status' => $newEmployeeId ? Appointment::STATUS_ASSIGNED : Appointment::STATUS_PENDING,
        ]);

        if ($newEmployeeId && $newEmployeeId !== $oldEmployeeId) {
            AppointmentLog::create([
                'appointment_id' => $appointment->id,
                'action_by' => $actionBy,
                'old_status' => $oldEmployeeId ? Appointment::STATUS_ASSIGNED : Appointment::STATUS_PENDING,
                'new_status' => Appointment::STATUS_ASSIGNED,
                'notes' => 'Employee changed on edit',
            ]);
        } elseif (!$newEmployeeId && $oldEmployeeId) {
            AppointmentLog::create([
                'appointment_id' => $appointment->id,
                'action_by' => $actionBy,
                'old_status' => Appointment::STATUS_ASSIGNED,
                'new_status' => Appointment::STATUS_PENDING,
                'notes' => 'Employee unassigned',
            ]);
        }

        $appointment->employees()->sync($newEmployeeId ? [$newEmployeeId] : []);
    }

    public function generateTicketNumber(int $businessId): string
    {
        $max = Appointment::where('business_id', $businessId)
            ->lockForUpdate()
            ->max('ticket_number');

        $next = $max ? intval($max) + 1 : 1;

        return str_pad($next, Appointment::TICKET_PAD_LENGTH, '0', STR_PAD_LEFT);
    }

    public function generateGuestToken(Appointment $appointment): void
    {
        $appointment->guest_token = Str::random(Appointment::GUEST_TOKEN_LENGTH);
        $appointment->save();
    }

    public function createPayment(Appointment $appointment, string $method): Payment
    {
        return Payment::create([
            'appointment_id' => $appointment->id,
            'method' => $method,
            'amount' => $appointment->total_price,
            'status' => Payment::STATUS_UNPAID,
        ]);
    }

    public function validateBookingLimits(
        ?int $customerId,
        ?string $phone,
        bool $isEmployee,
        ?int $employeeId,
        string $date,
        string $shift,
        bool $withLocking = false
    ): ?string {
        if ($customerId && !$isEmployee) {
            $query = Appointment::where('customer_id', $customerId)
                ->whereIn('status', Appointment::ACTIVE_STATUSES);
            if ($withLocking) $query->lockForUpdate();
            $count = $query->count();

            if ($count >= 3) {
                return 'Cannot exceed 3 active bookings';
            }
        }

        if ($phone) {
            $query = Appointment::where('customer_phone', $phone)
                ->whereIn('status', Appointment::ACTIVE_STATUSES);
            if ($withLocking) $query->lockForUpdate();
            $count = $query->count();

            if ($count >= 3) {
                return 'This phone reached the maximum limit (3 active bookings)';
            }
        }

        if ($employeeId) {
            $query = Appointment::where('employee_id', $employeeId)
                ->whereDate('appointment_date', $date)
                ->where('shift', $shift)
                ->whereIn('status', Appointment::ACTIVE_STATUSES);
            if ($withLocking) $query->lockForUpdate();
            $count = $query->count();

            if ($count >= 2) {
                return 'This employee is already booked for this time slot';
            }
        }

        return null;
    }
}
