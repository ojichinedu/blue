@extends('layouts.public')

@section('title', __('Track Shipment'))
@section('meta_description', __('Track your Blue Orient Logistics package in real-time with GPS tracking and live animated maps.'))

@section('content')

<section class="relative min-h-[80vh] flex items-center justify-center overflow-hidden pt-20">
    <div class="hero-glow top-20 left-1/2 -translate-x-1/2"></div>
    <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_center,_var(--tw-gradient-stops))] from-blue-900/20 via-slate-950 to-slate-950"></div>

    <div class="relative max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 text-center w-full">
        {{-- Icon --}}
        <div class="w-20 h-20 bg-gradient-to-br from-blue-500 to-cyan-400 rounded-3xl flex items-center justify-center mx-auto mb-8 shadow-xl shadow-blue-500/25 animate-pulse-glow">
            <svg class="w-10 h-10 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
        </div>

        <h1 class="text-4xl sm:text-5xl font-bold mb-4 animate-fade-in-up" style="font-family: 'Outfit', sans-serif;">
            {{ __('Track') }} Your <span class="text-gradient">Shipment</span>
        </h1>
        <p class="text-lg text-slate-400 mb-10 animate-fade-in-up delay-100">
            Enter your tracking number to see real-time location and delivery status.
        </p>

        {{-- {{ __('Track') }} Form --}}
        <form action="" method="GET" class="animate-fade-in-up delay-200" id="track-form">
            <div class="relative max-w-xl mx-auto">
                <input type="text" name="q" id="tracking-input"
                       value="{{ request('q') }}"
                       placeholder="{{ __('Enter tracking number (e.g. BLU-XXXXXXXX)') }}"
                       class="w-full bg-white/5 border-2 border-white/10 rounded-2xl pl-6 pr-36 py-5 text-lg text-white placeholder-slate-500 focus:outline-none focus:border-blue-500/50 focus:ring-4 focus:ring-blue-500/10 transition-all"
                       autofocus>
                <button type="submit" class="absolute right-2 top-2 bottom-2 px-8 bg-gradient-to-r from-blue-600 to-cyan-500 text-white font-semibold rounded-xl hover:shadow-lg hover:shadow-blue-500/25 transition-all text-lg" id="track-submit">
                    {{ __('Track') }}
                </button>
            </div>
        </form>

        @if(request('q'))
            <div class="mt-8 bg-red-500/20 border border-red-500/30 text-red-300 px-6 py-4 rounded-xl animate-fade-in">
                <p class="font-medium">Shipment not found</p>
                <p class="text-sm text-red-400 mt-1">No shipment matches tracking number "{{ request('q') }}". Please check and try again.</p>
            </div>
        @endif

        {{-- Help Text --}}
        <div class="mt-12 text-slate-500 text-sm animate-fade-in-up delay-300">
            <p>Your tracking number was provided when you created your shipment.</p>
            <p class="mt-1">It starts with <span class="text-blue-400 font-mono">BLU-</span> followed by 8 characters.</p>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
    document.getElementById('track-form').addEventListener('submit', function(e) {
        e.preventDefault();
        const trackingNumber = document.getElementById('tracking-input').value.trim();
        if (trackingNumber) {
            window.location.href = `/track/${encodeURIComponent(trackingNumber)}`;
        }
    });
</script>
@endpush
