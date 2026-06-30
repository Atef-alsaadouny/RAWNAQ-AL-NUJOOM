<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    /** السماح لجميع المستخدمين بتقديم طلب تسجيل الدخول */
    public function authorize(): bool
    {
        return true;
    }

    /** قواعد التحقق من صحة بيانات تسجيل الدخول */
    public function rules(): array
    {
        return [
            'login' => ['required', 'string'],
            'password' => ['required', 'string'],
        ];
    }

    /** محاولة المصادقة لكل الأدوار (عميل، موظف، مسؤول) */
    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        $login = normalizeArabicDigits($this->input('login') ?? '');

        $field = 'email';
        if (preg_match('/^(?:\d{8}|\+965\d{8})$/', $login)) {
            $field = 'phone';
        } elseif (preg_match('/^EMP-/i', $login)) {
            $field = 'employee_id';
        } elseif (filter_var($login, FILTER_VALIDATE_EMAIL)) {
            $field = 'email';
        }

        $credentials = [
            $field => $login,
            'password' => $this->input('password'),
        ];

        if (!Auth::attempt($credentials, $this->boolean('remember'))) {
            RateLimiter::hit($this->throttleKey());
            throw ValidationException::withMessages([
                'login' => __('بيانات الدخول هذي مو صحيحة'),
            ]);
        }
    }

    /** التأكد من أن المستخدم لم يتجاوز عدد محاولات تسجيل الدخول المسموح بها */
    public function ensureIsNotRateLimited(): void
    {
        if (!RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'login' => __('محاولات دخول كثيرة. حاولي بعد :seconds ثانية.', [
                'seconds' => $seconds,
            ]),
        ]);
    }

    /** إنشاء مفتاح فريد لتحديد معدل المحاولات لكل مستخدم */
    public function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->string('login')) . '|' . $this->ip());
    }
}
