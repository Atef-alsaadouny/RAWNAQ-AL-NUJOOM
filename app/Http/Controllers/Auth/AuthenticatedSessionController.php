<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /** عرض نموذج تسجيل الدخول للعملاء */
    public function create(): View
    {
        return view('auth.login');
    }

    /** معالجة تسجيل الدخول الموحد — توجيه حسب الـ role */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();
        $request->session()->regenerate();

        $user = Auth::user();

        if (!$user->is_active) {
            Auth::guard('web')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return back()->withErrors(['login' => 'بيانات الدخول هذي مو صحيحة']);
        }

        RateLimiter::clear(Str::transliterate(Str::lower($request->input('login')) . '|' . $request->ip()));

        $user->last_login_at = now();
        $user->remember_token = Str::random(60);
        $user->save();

        if ($user->isAdmin() || $user->isOwner()) {
            return redirect()->intended(route('admin.dashboard', absolute: false));
        }
        if ($user->isEmployee()) {
            return redirect()->intended(route('employee.dashboard', absolute: false));
        }
        return redirect()->intended(route('home', absolute: false));
    }

    /** تسجيل الخروج وإنهاء الجلسة */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
