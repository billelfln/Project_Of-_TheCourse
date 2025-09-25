<x-guest-layout>


    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('auth.email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required
                autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>
        <!-- Password -->
        <div class="mt-4" x-data="{ show: false }">
            <x-input-label for="password" :value="__('auth.password')" />

            <div class="relative">
                <!-- حطينا pr-10 علشان في مساحة للأيقونة -->
                <x-text-input id="password" class="block mt-1 w-full pr-10" x-bind:type="show ? 'text' : 'password'"
                    name="password" required autocomplete="current-password" />

                <!-- الزر داخل الـ input -->
                <button type="button" @click="show = !show"
                    class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-500 focus:outline-none">

                    <!-- Eye closed -->
                    <svg x-show="!show" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 3l18 18M9.88 9.88A3 3 0 0012 15a3 3 0 002.12-5.12M6.1 6.1A10.97 10.97 0 0012 5c4.48 0 8.27 2.94 9.54 7-.57 1.82-1.68 3.41-3.15 4.6M17.9 17.9A10.97 10.97 0 0112 19c-4.48 0-8.27-2.94-9.54-7a11.03 11.03 0 012.64-4.36" />
                    </svg>

                    <!-- Eye open -->
                    <svg x-show="show" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 15a3 3 0 100-6 3 3 0 000 6z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                </button>
            </div>

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>



        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox"
                    class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button class="ms-3">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>


<style>
    /* التأكد من أن الـ input له ارتفاع مناسب */
    .relative input[type="password"],
    .relative input[type="text"] {
        min-height: 2.5rem;
        /* 40px */
    }

    /* التأكد من أن الزر محاذي بشكل مثالي */
    .relative button {
        top: 50%;
        transform: translateY(-50%);
    }

    /* إضافة تأثير hover للزر */
    .relative button:hover {
        background-color: rgba(0, 0, 0, 0.05);
        border-radius: 0.375rem;
    }
</style>