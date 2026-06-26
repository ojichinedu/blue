@extends('layouts.public')

@section('title', __('About Us'))
@section('meta_description', 'Learn about Blue Orient Logistics - our mission, values, and the team behind the world\'s most reliable shipping platform.')

@section('content')

{{-- Hero --}}
<section class="relative pt-32 pb-20 overflow-hidden">
    <div class="hero-glow top-0 right-0"></div>
    <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top_right,_var(--tw-gradient-stops))] from-blue-900/20 via-slate-950 to-slate-950"></div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl">
            <div class="inline-flex items-center gap-2 px-4 py-2 bg-blue-500/10 border border-blue-500/20 rounded-full text-blue-300 text-sm font-medium mb-6 animate-fade-in-up">
                {{ __('About Us') }}
            </div>
            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold mb-6 animate-fade-in-up delay-100" style="font-family: 'Outfit', sans-serif;">
                {{ __('Connecting the World') }},<br>
                <span class="text-gradient">{{ __('One Package at a Time') }}</span>
            </h1>
            <p class="text-lg text-slate-400 leading-relaxed animate-fade-in-up delay-200">
                {{ __("Founded with a vision to make global shipping accessible, transparent, and reliable for everyone. We've grown from a small courier service to a worldwide logistics platform trusted by thousands.") }}
            </p>
        </div>
    </div>
</section>

{{-- Mission / Vision / Values --}}
<section class="py-24 border-t border-white/5">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid md:grid-cols-3 gap-8">
            <div class="glass-card p-8 hover:bg-white/[0.07] transition-all duration-500">
                <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-cyan-400 rounded-xl flex items-center justify-center mb-6 shadow-lg shadow-blue-500/20">
                    <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                </div>
                <h3 class="text-xl font-bold text-white mb-3">{{ __('Our Mission') }}</h3>
                <p class="text-slate-400 text-sm leading-relaxed">{{ __('To provide fast, reliable, and affordable shipping solutions that connect businesses and people across the globe with complete transparency.') }}</p>
            </div>

            <div class="glass-card p-8 hover:bg-white/[0.07] transition-all duration-500">
                <div class="w-12 h-12 bg-gradient-to-br from-emerald-500 to-green-400 rounded-xl flex items-center justify-center mb-6 shadow-lg shadow-emerald-500/20">
                    <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                </div>
                <h3 class="text-xl font-bold text-white mb-3">{{ __('Our Vision') }}</h3>
                <p class="text-slate-400 text-sm leading-relaxed">{{ __("To become the world's most trusted logistics platform, where every shipment is trackable, every delivery is on time, and every customer feels valued.") }}</p>
            </div>

            <div class="glass-card p-8 hover:bg-white/[0.07] transition-all duration-500">
                <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-pink-400 rounded-xl flex items-center justify-center mb-6 shadow-lg shadow-purple-500/20">
                    <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                </div>
                <h3 class="text-xl font-bold text-white mb-3">{{ __('Our Values') }}</h3>
                <p class="text-slate-400 text-sm leading-relaxed">{{ __('Integrity, innovation, and customer-first thinking drive everything we do. We believe in building trust through consistent, exceptional service.') }}</p>
            </div>
        </div>
    </div>
</section>

{{-- Story Section --}}
<section class="py-24 bg-slate-900/30 border-y border-white/5">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid lg:grid-cols-2 gap-16 items-center">
            <div>
                <h2 class="text-3xl sm:text-4xl font-bold mb-6" style="font-family: 'Outfit', sans-serif;">
                    {{ __('Our') }} <span class="text-gradient">{{ __('Story') }}</span>
                </h2>
                <div class="space-y-4 text-slate-400 leading-relaxed">
                    <p>{{ __('Blue Orient Logistics started in 2018 with a simple idea: shipping should be transparent. Our founders, frustrated by the lack of real-time visibility in traditional logistics, set out to build something better.') }}</p>
                    <p>{{ __('What began as a small courier service in New York has grown into a global logistics platform serving over 120 countries. Our proprietary tracking technology gives customers unprecedented visibility into their shipments, right down to the exact location on a live map.') }}</p>
                    <p>{{ __('Today, we process over 50,000 shipments and continue to innovate with AI-powered route optimization, predictive delivery estimates, and our industry-leading live tracking dashboard.') }}</p>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div class="stat-card text-center">
                    <div class="text-3xl font-bold text-gradient mb-1" style="font-family: 'Outfit', sans-serif;">2018</div>
                    <div class="text-xs text-slate-500">{{ __('Founded') }}</div>
                </div>
                <div class="stat-card text-center">
                    <div class="text-3xl font-bold text-gradient mb-1" style="font-family: 'Outfit', sans-serif;">500+</div>
                    <div class="text-xs text-slate-500">{{ __('Team Members') }}</div>
                </div>
                <div class="stat-card text-center">
                    <div class="text-3xl font-bold text-gradient mb-1" style="font-family: 'Outfit', sans-serif;">15</div>
                    <div class="text-xs text-slate-500">{{ __('Global Offices') }}</div>
                </div>
                <div class="stat-card text-center">
                    <div class="text-3xl font-bold text-gradient mb-1" style="font-family: 'Outfit', sans-serif;">4.9★</div>
                    <div class="text-xs text-slate-500">{{ __('Customer Rating') }}</div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- CTA --}}
<section class="py-24 relative">
    <div class="max-w-4xl mx-auto px-4 text-center">
        <h2 class="text-3xl font-bold mb-6" style="font-family: 'Outfit', sans-serif;">{{ __('Want to Join Our') }} <span class="text-gradient">{{ __('Network') }}</span>?</h2>
        <p class="text-slate-400 mb-8">{{ __("Whether you're a business looking for reliable shipping or an individual sending a package, we're here for you.") }}</p>
        <a href="{{ route('shipment.create') }}" class="btn-primary text-lg px-10 py-4">{{ __('Start Shipping Today') }}</a>
    </div>
</section>

@endsection
