@php
    $labelClass = 'block text-[15px] font-medium text-gray-700 mb-1.5';
    $inputClass = 'block w-full px-4 py-3 rounded-xl border border-gray-200 shadow-sm focus:border-rose-300 focus:ring focus:ring-rose-200/50 focus:ring-opacity-50 transition duration-200 text-[15px]';
    $iconClass = 'absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none text-gray-400';
@endphp

<x-guest-layout>
    <div class="text-center mb-7">
        <h1 class="text-2xl font-bold text-gray-800">{{ __('Welcome Back') }}</h1>
        <p class="text-gray-500 mt-1.5">{{ __('Login To View Bookings') }}</p>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" id="loginForm">
        @csrf

        <div>
            <label for="login" class="{{ $labelClass }}">{{ __('Phone Or Email') }} <span class="text-red-500">*</span></label>
            <div class="relative">
                <div class="{{ $iconClass }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                    </svg>
                </div>
                <input id="login" class="{{ $inputClass }} ps-10" type="text" name="login" value="{{ old('login') }}" required autofocus autocomplete="username" placeholder="6xxxxxxx" />
            </div>
            <x-input-error :messages="$errors->get('login')" class="mt-1.5" />
        </div>

        <div class="mt-5">
            <label for="password" class="{{ $labelClass }}">{{ __('Password') }} <span class="text-red-500">*</span></label>
            <div class="relative">
                <div class="{{ $iconClass }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                </div>
                <input id="password" class="{{ $inputClass }} ps-10 pe-12" type="password" name="password" required autocomplete="current-password" placeholder="••••••••" />
                <button type="button" id="togglePassword" class="absolute inset-y-0 end-0 flex items-center pe-3.5 text-gray-400 hover:text-gray-600 transition">
                    <svg id="eyeIcon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-1.5" />
        </div>

        <div class="flex items-center justify-between mt-6">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-rose-500 shadow-sm focus:ring-rose-400" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Remember Me') }}</span>
            </label>
            @if (Route::has('password.request'))
                <a class="text-sm text-rose-600 hover:text-rose-700 hover:underline" href="{{ route('password.request') }}">
                    {{ __('Forgot Password') }}
                </a>
            @endif
        </div>

        <div class="mt-8">
            <button type="submit" id="loginButton" class="w-full inline-flex items-center justify-center px-6 py-3 bg-gradient-to-l from-rose-500 to-rose-600 border border-transparent rounded-xl font-semibold text-[15px] text-white shadow-md shadow-rose-200 hover:from-rose-600 hover:to-rose-700 focus:outline-none focus:ring-2 focus:ring-rose-400 focus:ring-offset-2 transition-all duration-200">
                <span id="buttonText">{{ __('Log In') }}</span>
                <svg id="buttonSpinner" class="hidden animate-spin ms-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            </button>
        </div>

        <div class="text-center mt-6">
            <p class="text-sm text-gray-500">
                {{ __("Don't Have An Account") }}
                <a href="{{ route('register') }}" class="text-rose-600 hover:text-rose-700 hover:underline font-medium">{{ __('Register Now') }}</a>
            </p>
        </div>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const passwordInput = document.getElementById('password');
            const toggleBtn = document.getElementById('togglePassword');
            const eyeIcon = document.getElementById('eyeIcon');
            const form = document.getElementById('loginForm');
            const loginBtn = document.getElementById('loginButton');
            const btnText = document.getElementById('buttonText');
            const btnSpinner = document.getElementById('buttonSpinner');

            toggleBtn.addEventListener('click', function () {
                const isPassword = passwordInput.type === 'password';
                passwordInput.type = isPassword ? 'text' : 'password';
                eyeIcon.innerHTML = isPassword
                    ? '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />'
                    : '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />';
            });

            form.addEventListener('submit', function () {
                loginBtn.disabled = true;
                loginBtn.classList.add('opacity-75', 'cursor-not-allowed');
                btnText.textContent = '{{ __('Loading') }}';
                btnSpinner.classList.remove('hidden');
            });
        });
    </script>
</x-guest-layout>
