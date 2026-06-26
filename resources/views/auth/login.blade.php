<x-guest-layout>
    <div class="mb-8 text-center">
        <h2 class="text-3xl font-extrabold text-white" style="font-family: 'Outfit', sans-serif;">
            {{ __('Welcome Back') }}
        </h2>
        <p class="text-slate-400 mt-2 text-sm">
            {{ __('Sign in to access your shipping dashboard') }}
        </p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-6" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-5">
            <div class="flex justify-between items-center">
                <x-input-label for="password" :value="__('Password')" />
                @if (Route::has('password.request'))
                    <a class="text-xs text-blue-400 hover:text-blue-300 transition-colors" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif
            </div>

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-5">
            <label for="remember_me" class="inline-flex items-center cursor-pointer">
                <input id="remember_me" type="checkbox" class="rounded bg-white/5 border-white/10 text-blue-600 focus:ring-blue-500/20 focus:ring-offset-slate-950" name="remember">
                <span class="ms-2 text-sm text-slate-400 hover:text-slate-300 transition-colors">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="mt-8">
            <x-primary-button class="w-full py-3.5 text-base">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>

    <div class="mt-6 text-center text-sm">
        <p class="text-slate-400">
            {{ __("Don't have an account?") }}
            <a href="{{ route('register') }}" class="text-blue-400 hover:text-blue-300 font-semibold transition-colors">
                {{ __('Register') }}
            </a>
        </p>
    </div>
</x-guest-layout>
