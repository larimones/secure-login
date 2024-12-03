<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('twofactor.verify') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="twoFactor" :value="__('Auth Code')" />
            <x-text-input id="twoFactor" class="block mt-1 w-full" type="text" name="twoFactor" required autofocus  />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>


        <div class="flex items-center justify-end mt-4">

            <x-primary-button type="submit" class="ms-3">
                {{ __('Verify') }}
            </x-primary-button>
        </div>
    </form>


</x-guest-layout>
