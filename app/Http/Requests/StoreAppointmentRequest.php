<?php

namespace App\Http\Requests;

use App\Models\Appointment;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class StoreAppointmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::check() && in_array(Auth::user()->role, ['admin', 'owner']);
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $businessId = $this->user()?->business_id;

        return [
            'customer_name' => 'required|string|max:255',
            'customer_phone' => ['required', 'regex:/^(?:[4569]\d{7}|\+965\d{8})$/'],
            'package_ids' => 'nullable|array',
            'package_ids.*' => $businessId ? Rule::exists('packages', 'id')->where('business_id', $businessId) : 'exists:packages,id',
            'service_ids' => 'nullable|array',
            'service_ids.*' => $businessId ? Rule::exists('services', 'id')->where('business_id', $businessId) : 'exists:services,id',
            'employee_id' => [
                'nullable',
                $businessId
                    ? Rule::exists('users', 'id')->where(function ($q) use ($businessId) {
                        $q->where('business_id', $businessId)->where('role', 'employee');
                    })
                    : 'exists:users,id',
            ],
            'shift' => 'required|in:' . implode(',', [Appointment::SHIFT_MORNING, Appointment::SHIFT_EVENING]),
            'appointment_date' => 'required|date|after_or_equal:today',
            'priority' => 'required|in:' . implode(',', [Appointment::PRIORITY_NORMAL, Appointment::PRIORITY_URGENT, Appointment::PRIORITY_VIP]),
            'notes' => 'nullable|string|max:500',
            'status' => 'nullable|in:' . implode(',', [Appointment::STATUS_PENDING, Appointment::STATUS_ASSIGNED, Appointment::STATUS_IN_PROGRESS, Appointment::STATUS_COMPLETED, Appointment::STATUS_CANCELLED]),
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'customer_phone.regex' => __('Please enter a Kuwaiti number'),
        ];
    }
}
