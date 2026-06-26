<x-guest-layout>
    <div class="mb-6 text-center">
        <h2 class="text-3xl font-extrabold text-white" style="font-family: 'Outfit', sans-serif;">
            {{ __('Reset Password') }}
        </h2>
        <p class="text-slate-400 mt-2 text-sm">
            {{ __('Request a password reset link') }}
        </p>
    </div>

    <div class="mb-6 text-sm text-slate-400 leading-relaxed text-center">
        {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-6" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-8">
            <x-primary-button class="w-full py-3.5 text-base">
                {{ __('Email Password Reset Link') }}
            </x-primary-button>
        </div>
    </form>

    <div class="mt-6 text-center text-sm">
        <a href="{{ route('login') }}" class="text-blue-400 hover:text-blue-300 font-semibold transition-colors">
            {{ __('Back to login') }}
        </a>
    </div>
</x-guest-layout>
