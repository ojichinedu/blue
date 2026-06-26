<x-guest-layout>
    <div class="mb-6 text-center">
        <h2 class="text-3xl font-extrabold text-white" style="font-family: 'Outfit', sans-serif;">
            {{ __('Verify Email') }}
        </h2>
        <p class="text-slate-400 mt-2 text-sm">
            {{ __('Please confirm your email address') }}
        </p>
    </div>

    <div class="mb-6 text-sm text-slate-400 leading-relaxed text-center">
        {{ __("Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn't receive the email, we will gladly send you another.") }}
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-6 bg-emerald-500/10 border border-emerald-500/20 text-emerald-300 px-4 py-3 rounded-xl text-sm text-center">
            {{ __('A new verification link has been sent to the email address you provided during registration.') }}
        </div>
    @endif

    <div class="mt-6 flex flex-col sm:flex-row items-center justify-between gap-4">
        <form method="POST" action="{{ route('verification.send') }}" class="w-full sm:w-auto">
            @csrf
            <x-primary-button class="w-full sm:w-auto py-2.5">
                {{ __('Resend Verification Email') }}
            </x-primary-button>
        </form>

        <form method="POST" action="{{ route('logout') }}" class="w-full sm:w-auto text-center">
            @csrf
            <button type="submit" class="text-sm text-slate-400 hover:text-red-400 transition-colors font-medium">
                {{ __('Log Out') }}
            </button>
        </form>
    </div>
</x-guest-layout>
