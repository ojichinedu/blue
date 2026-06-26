<x-guest-layout>
    <div class="mb-6 text-center">
        <h2 class="text-3xl font-extrabold text-white" style="font-family: 'Outfit', sans-serif;">
            {{ __('Confirm Password') }}
        </h2>
        <p class="text-slate-400 mt-2 text-sm">
            {{ __('Please verify your identity') }}
        </p>
    </div>

    <div class="mb-6 text-sm text-slate-400 leading-relaxed text-center">
        {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
    </div>

    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="mt-8">
            <x-primary-button class="w-full py-3.5 text-base">
                {{ __('Confirm') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
