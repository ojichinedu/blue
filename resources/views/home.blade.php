@extends('layouts.public')

@section('title', 'Home')
@section('meta_description', 'Blue Orient Logistics - Ship anywhere in the world with real-time tracking. Fast, reliable, and secure logistics solutions for businesses and individuals.')

@section('content')

{{-- Hero Section --}}
<section class="relative min-h-screen flex items-center justify-center overflow-hidden pt-20" id="hero">
    {{-- Background Effects --}}
    <div class="hero-glow top-20 -left-40 animate-float"></div>
    <div class="hero-glow bottom-20 -right-40 animate-float" style="animation-delay: 3s;"></div>
    <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top,_var(--tw-gradient-stops))] from-blue-900/20 via-slate-950 to-slate-950"></div>

    {{-- Grid Pattern --}}
    <div class="absolute inset-0 opacity-[0.03]" style="background-image: url('data:image/svg+xml,%3Csvg width=&quot;60&quot; height=&quot;60&quot; viewBox=&quot;0 0 60 60&quot; xmlns=&quot;http://www.w3.org/2000/svg&quot;%3E%3Cg fill=&quot;none&quot; fill-rule=&quot;evenodd&quot;%3E%3Cg fill=&quot;%239C92AC&quot; fill-opacity=&quot;0.4&quot;%3E%3Cpath d=&quot;M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z&quot;/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        {{-- Badge --}}
        <div class="inline-flex items-center gap-2 px-4 py-2 bg-blue-500/10 border border-blue-500/20 rounded-full text-blue-300 text-sm font-medium mb-8 animate-fade-in-up">
            <span class="w-2 h-2 bg-emerald-400 rounded-full animate-pulse"></span>
            {{ __('Trusted by 50,000+ businesses worldwide') }}
        </div>

        {{-- Headline --}}
        <h1 class="text-5xl sm:text-6xl lg:text-7xl font-bold leading-tight mb-6 animate-fade-in-up delay-100" style="font-family: 'Outfit', sans-serif;">
            {{ __('Ship Anywhere') }},<br>
            <span class="text-gradient">{{ __('Track Everything') }}</span>
        </h1>

        {{-- Subheading --}}
        <p class="text-lg sm:text-xl text-slate-400 max-w-2xl mx-auto mb-10 animate-fade-in-up delay-200">
            {{ __('Global shipping solutions with real-time GPS tracking, live animated maps, and seamless logistics management. Your package, our priority.') }}
        </p>

        {{-- CTA Buttons --}}
        <div class="flex flex-col sm:flex-row items-center justify-center gap-4 mb-16 animate-fade-in-up delay-300">
            <a href="{{ route('shipment.create') }}" class="btn-primary text-lg px-8 py-4" id="hero-send-btn">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                {{ __('Send a Package') }}
            </a>
            <a href="{{ route('track') }}" class="btn-secondary text-lg px-8 py-4" id="hero-track-btn">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                {{ __('Track Shipment') }}
            </a>
        </div>

        {{-- Quick {{ __('Track') }} Input --}}
        <div class="max-w-lg mx-auto animate-fade-in-up delay-400">
            <form action="{{ route('track') }}" method="GET" class="relative" id="hero-track-form">
                <input type="text" name="q" placeholder="{{ __('Enter tracking number (e.g. BLU-XXXXXXXX)') }}" 
                       class="w-full bg-white/5 border border-white/10 rounded-2xl pl-6 pr-36 py-4 text-white placeholder-slate-500 focus:outline-none focus:border-blue-500/50 focus:ring-2 focus:ring-blue-500/20 transition-all" id="hero-tracking-input">
                <button type="submit" class="absolute right-2 top-2 bottom-2 px-6 bg-gradient-to-r from-blue-600 to-cyan-500 text-white font-semibold rounded-xl hover:shadow-lg hover:shadow-blue-500/25 transition-all" id="hero-tracking-submit">
                    {{ __('Track') }}
                </button>
            </form>
        </div>
    </div>
</section>

{{-- Stats Section --}}
<section class="relative py-20 border-t border-white/5" id="stats-section">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            <div class="text-center p-6 animate-fade-in-up">
                <div class="text-4xl font-bold text-gradient mb-2" style="font-family: 'Outfit', sans-serif;">50K+</div>
                <div class="text-sm text-slate-400">Packages Delivered</div>
            </div>
            <div class="text-center p-6 animate-fade-in-up delay-100">
                <div class="text-4xl font-bold text-gradient mb-2" style="font-family: 'Outfit', sans-serif;">120+</div>
                <div class="text-sm text-slate-400">Countries Covered</div>
            </div>
            <div class="text-center p-6 animate-fade-in-up delay-200">
                <div class="text-4xl font-bold text-gradient mb-2" style="font-family: 'Outfit', sans-serif;">99.8%</div>
                <div class="text-sm text-slate-400">On-Time Delivery</div>
            </div>
            <div class="text-center p-6 animate-fade-in-up delay-300">
                <div class="text-4xl font-bold text-gradient mb-2" style="font-family: 'Outfit', sans-serif;">24/7</div>
                <div class="text-sm text-slate-400">Support Available</div>
            </div>
        </div>
    </div>
</section>

{{-- Services Preview --}}
<section class="py-24 relative" id="services-preview">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl sm:text-4xl font-bold mb-4" style="font-family: 'Outfit', sans-serif;">{{ __('Our') }} <span class="text-gradient">{{ __('Services') }}</span></h2>
            <p class="text-slate-400 max-w-2xl mx-auto">{{ __('Comprehensive shipping solutions tailored to your needs, from documents to heavy freight.') }}</p>
        </div>

        <div class="grid md:grid-cols-3 gap-8">
            {{-- Express --}}
            <div class="glass-card p-8 hover:bg-white/[0.07] hover:border-white/15 hover:scale-[1.02] transition-all duration-500 group" id="service-express">
                <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-cyan-400 rounded-2xl flex items-center justify-center mb-6 shadow-lg shadow-blue-500/20 group-hover:shadow-blue-500/40 transition-all">
                    <svg class="w-7 h-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                </div>
                <h3 class="text-xl font-bold text-white mb-3">{{ __('Express Delivery') }}</h3>
                <p class="text-slate-400 text-sm leading-relaxed mb-4">{{ __('Next-day and same-day delivery for urgent shipments. Lightning-fast with full tracking visibility.') }}</p>
                <a href="{{ route('services') }}" class="text-blue-400 text-sm font-medium hover:text-blue-300 transition-colors inline-flex items-center gap-1">
                    {{ __('Learn more') }} <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>

            {{-- Standard --}}
            <div class="glass-card p-8 hover:bg-white/[0.07] hover:border-white/15 hover:scale-[1.02] transition-all duration-500 group" id="service-standard">
                <div class="w-14 h-14 bg-gradient-to-br from-emerald-500 to-green-400 rounded-2xl flex items-center justify-center mb-6 shadow-lg shadow-emerald-500/20 group-hover:shadow-emerald-500/40 transition-all">
                    <svg class="w-7 h-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                </div>
                <h3 class="text-xl font-bold text-white mb-3">{{ __('Standard Shipping') }}</h3>
                <p class="text-slate-400 text-sm leading-relaxed mb-4">{{ __('Cost-effective shipping for non-urgent deliveries. Reliable 3-7 day delivery with real-time updates.') }}</p>
                <a href="{{ route('services') }}" class="text-emerald-400 text-sm font-medium hover:text-emerald-300 transition-colors inline-flex items-center gap-1">
                    {{ __('Learn more') }} <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>

            {{-- International --}}
            <div class="glass-card p-8 hover:bg-white/[0.07] hover:border-white/15 hover:scale-[1.02] transition-all duration-500 group" id="service-international">
                <div class="w-14 h-14 bg-gradient-to-br from-purple-500 to-pink-400 rounded-2xl flex items-center justify-center mb-6 shadow-lg shadow-purple-500/20 group-hover:shadow-purple-500/40 transition-all">
                    <svg class="w-7 h-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <h3 class="text-xl font-bold text-white mb-3">{{ __('International Shipping') }}</h3>
                <p class="text-slate-400 text-sm leading-relaxed mb-4">{{ __('Seamless cross-border logistics with customs handling. Ship to 120+ countries worldwide.') }}</p>
                <a href="{{ route('services') }}" class="text-purple-400 text-sm font-medium hover:text-purple-300 transition-colors inline-flex items-center gap-1">
                    {{ __('Learn more') }} <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>
        </div>
    </div>
</section>

{{-- How It Works --}}
<section class="py-24 bg-slate-900/30 border-y border-white/5" id="how-it-works">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl sm:text-4xl font-bold mb-4" style="font-family: 'Outfit', sans-serif;">{{ __('How It') }} <span class="text-gradient">{{ __('Works') }}</span></h2>
            <p class="text-slate-400 max-w-2xl mx-auto">{{ __('Three simple steps to ship your packages anywhere in the world.') }}</p>
        </div>

        <div class="grid md:grid-cols-3 gap-8 relative">
            {{-- Connecting line --}}
            <div class="hidden md:block absolute top-16 left-1/6 right-1/6 h-px bg-gradient-to-r from-blue-500/0 via-blue-500/30 to-blue-500/0"></div>

            {{-- Step 1 --}}
            <div class="text-center relative">
                <div class="w-16 h-16 bg-gradient-to-br from-blue-600 to-cyan-500 rounded-2xl flex items-center justify-center text-2xl font-bold text-white mx-auto mb-6 shadow-xl shadow-blue-500/25 rotate-3 hover:rotate-0 transition-transform duration-500">1</div>
                <h3 class="text-lg font-bold text-white mb-3">{{ __('Create Shipment') }}</h3>
                <p class="text-slate-400 text-sm">{{ __('Fill in sender and receiver details, select package type, and submit your shipment request.') }}</p>
            </div>

            {{-- Step 2 --}}
            <div class="text-center relative">
                <div class="w-16 h-16 bg-gradient-to-br from-emerald-600 to-green-500 rounded-2xl flex items-center justify-center text-2xl font-bold text-white mx-auto mb-6 shadow-xl shadow-emerald-500/25 -rotate-3 hover:rotate-0 transition-transform duration-500">2</div>
                <h3 class="text-lg font-bold text-white mb-3">{{ __('We Pick Up & Ship') }}</h3>
                <p class="text-slate-400 text-sm">{{ __('Our team picks up your package and routes it through our optimized global logistics network.') }}</p>
            </div>

            {{-- Step 3 --}}
            <div class="text-center relative">
                <div class="w-16 h-16 bg-gradient-to-br from-purple-600 to-pink-500 rounded-2xl flex items-center justify-center text-2xl font-bold text-white mx-auto mb-6 shadow-xl shadow-purple-500/25 rotate-3 hover:rotate-0 transition-transform duration-500">3</div>
                <h3 class="text-lg font-bold text-white mb-3">{{ __('Track') }} & Receive</h3>
                <p class="text-slate-400 text-sm">{{ __('Track') }} your package on our live map with animated GPS tracking until it arrives at the destination.</p>
            </div>
        </div>
    </div>
</section>

{{-- CTA Section --}}
<section class="py-24 relative overflow-hidden" id="cta-section">
    <div class="hero-glow -top-40 left-1/2 -translate-x-1/2"></div>
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative">
        <h2 class="text-3xl sm:text-4xl font-bold mb-6" style="font-family: 'Outfit', sans-serif;">
            {{ __('Ready to') }} <span class="text-gradient">{{ __('Ship') }}</span>?
        </h2>
        <p class="text-slate-400 text-lg mb-10 max-w-2xl mx-auto">
            {{ __('Join thousands of businesses and individuals who trust Blue Orient Logistics for fast, reliable, and trackable deliveries worldwide.') }}
        </p>
        <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
            <a href="{{ route('shipment.create') }}" class="btn-primary text-lg px-10 py-4" id="cta-send-btn">
                {{ __("Get Started — It's Free") }}
            </a>
            <a href="{{ route('services') }}" class="btn-secondary text-lg px-10 py-4" id="cta-services-btn">
                {{ __('View Pricing') }}
            </a>
        </div>
    </div>
</section>

@endsection
