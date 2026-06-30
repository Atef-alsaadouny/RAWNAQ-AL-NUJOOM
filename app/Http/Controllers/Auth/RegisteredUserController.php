<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Business;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /** عرض نموذج التسجيل مع قائمة الشركات النشطة */
    public function create(): View
    {
        $businesses = Business::where('is_active', true)->get();
        return view('auth.register', compact('businesses'));
    }

    /** التحقق من صحة البيانات وإنشاء مستخدم جديد وتسجيل الدخول تلقائياً */
    public function store(Request $request): RedirectResponse
    {
        $request->merge(['phone' => normalizeArabicDigits($request->phone ?? '')]);

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'phone' => ['required', 'regex:/^(?:[4569]\d{7}|\+965\d{8})$/', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'business_id' => ['nullable', 'exists:businesses,id'],
        ], [
            'phone.regex' => __('Please enter a Kuwaiti number'),
            'email.unique' => __('Registration failed, please try again'),
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email ?: null,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
        ]);
        $user->business_id = $request->business_id
            ?? Business::where('is_active', true)->first()->id
            ?? null;
        $user->role = 'customer';
        $user->save();

        event(new Registered($user));
        Auth::login($user);

        return redirect()->intended(route('home'));
    }
}
