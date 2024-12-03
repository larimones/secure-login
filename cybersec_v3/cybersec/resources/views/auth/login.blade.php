<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800" name="remember">
                <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button class="ms-3">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>

    <!-- Divider -->
    <div class="flex items-center mt-6">
        <div class="border-t border-gray-300 dark:border-gray-700 flex-grow"></div>
        <span class="px-3 text-gray-600 dark:text-gray-400 text-sm">or</span>
        <div class="border-t border-gray-300 dark:border-gray-700 flex-grow"></div>
    </div>

    <!-- Login with Google -->
    <div class="flex justify-center mt-6">
        <a href="{{ route('google-auth') }}" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 dark:focus:ring-offset-gray-800">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 me-2" fill="currentColor" viewBox="0 0 24 24">
                <path d="M22.49 12.223c0-.654-.059-1.285-.17-1.897H12v3.585h5.891c-.257 1.38-1.004 2.552-2.137 3.331v2.776h3.45c2.016-1.858 3.186-4.591 3.186-7.795z" fill="#4285F4"/>
                <path d="M12 23c3.159 0 5.814-1.044 7.752-2.828l-3.45-2.776c-.964.646-2.194 1.029-3.552 1.029-2.733 0-5.051-1.843-5.876-4.33H3.462v2.727C5.39 20.93 8.455 23 12 23z" fill="#34A853"/>
                <path d="M6.124 14.095C5.897 13.463 5.764 12.779 5.764 12s.133-1.463.36-2.095V7.178H3.462A10.926 10.926 0 0 0 1 12c0 1.75.417 3.396 1.153 4.822l2.971-2.727z" fill="#FBBC05"/>
                <path d="M12 4.896c1.718 0 3.257.589 4.47 1.741l3.354-3.354C17.808 1.537 15.162 0 12 0 8.455 0 5.39 2.07 3.462 4.822l2.971 2.727C6.95 5.438 9.267 4.896 12 4.896z" fill="#EA4335"/>
            </svg>
            {{ __('Login with Google') }}
        </a>
    </div>
</x-guest-layout>
