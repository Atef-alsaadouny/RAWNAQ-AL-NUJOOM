<?php

namespace App\Http\Requests;

use App\Models\Appointment;
use App\Models\Payment;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreBookingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'package_ids' => 'nullable|array',
            'package_ids.*' => 'exists:packages,id',
            'service_ids' => 'nullable|array',
            'service_ids.*' => 'exists:services,id',
            'employee_id' => 'nullable|exists:users,id',
            'payment_method' => 'required|in:' . implode(',', [Payment::METHOD_KNET, Payment::METHOD_APPLE_PAY, Payment::METHOD_GOOGLE_PAY, Payment::METHOD_CASH]),
            'shift' => 'required|in:' . implode(',', [Appointment::SHIFT_MORNING, Appointment::SHIFT_EVENING]),
            'appointment_date' => 'required|date|after_or_equal:today',
            'notes' => 'nullable|string|max:500',
        ];

        if (!Auth::check()) {
            $rules['customer_name'] = 'required|string|max:255';
            $rules['customer_phone'] = ['required', 'regex:/^(?:[4569]\d{7}|\+965\d{8})$/'];
        }

        return $rules;
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
