@extends('layouts.public')

@section('title', 'Services')
@section('meta_description', 'Blue Orient Logistics services - Express, Standard, Freight, and International shipping with real-time tracking and competitive pricing.')

@section('content')

{{-- Hero --}}
<section class="relative pt-32 pb-20 overflow-hidden">
    <div class="hero-glow top-0 left-0"></div>
    <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top_left,_var(--tw-gradient-stops))] from-blue-900/20 via-slate-950 to-slate-950"></div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <div class="inline-flex items-center gap-2 px-4 py-2 bg-blue-500/10 border border-blue-500/20 rounded-full text-blue-300 text-sm font-medium mb-6 animate-fade-in-up">
            Our Services
        </div>
        <h1 class="text-4xl sm:text-5xl font-bold mb-6 animate-fade-in-up delay-100" style="font-family: 'Outfit', sans-serif;">
            Shipping Solutions for<br>
            <span class="text-gradient">Every Need</span>
        </h1>
        <p class="text-lg text-slate-400 max-w-2xl mx-auto animate-fade-in-up delay-200">
            From urgent documents to heavy freight, we have the perfect shipping solution for you.
        </p>
    </div>
</section>

{{-- Service Cards --}}
<section class="py-24 border-t border-white/5">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid md:grid-cols-2 gap-8">
            {{-- {{ __('Express Delivery') }} --}}
            <div class="glass-card p-8 lg:p-10 hover:bg-white/[0.07] hover:border-white/15 transition-all duration-500 group relative overflow-hidden" id="service-card-express">
                <div class="absolute top-0 right-0 w-40 h-40 bg-gradient-to-br from-blue-500/10 to-transparent rounded-bl-full"></div>
                <div class="relative">
                    <div class="flex items-start justify-between mb-6">
                        <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-cyan-400 rounded-2xl flex items-center justify-center shadow-lg shadow-blue-500/20 group-hover:shadow-blue-500/40 transition-all">
                            <svg class="w-7 h-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                        </div>
                        <span class="badge badge-in_transit">Popular</span>
                    </div>
                    <h3 class="text-2xl font-bold text-white mb-3">{{ __('Express Delivery') }}</h3>
                    <p class="text-slate-400 text-sm leading-relaxed mb-6">Next-day and same-day delivery for urgent shipments. Guaranteed delivery times with priority handling and real-time tracking.</p>
                    <ul class="space-y-3 mb-8">
                        <li class="flex items-center gap-3 text-sm text-slate-300">
                            <svg class="w-4 h-4 text-emerald-400 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            Same-day & next-day options
                        </li>
                        <li class="flex items-center gap-3 text-sm text-slate-300">
                            <svg class="w-4 h-4 text-emerald-400 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            Priority handling & dedicated routes
                        </li>
                        <li class="flex items-center gap-3 text-sm text-slate-300">
                            <svg class="w-4 h-4 text-emerald-400 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            Live GPS tracking with map
                        </li>
                        <li class="flex items-center gap-3 text-sm text-slate-300">
                            <svg class="w-4 h-4 text-emerald-400 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            Insurance up to $5,000
                        </li>
                    </ul>
                    <div class="flex items-center justify-between">
                        <div><span class="text-2xl font-bold text-white">$29.99</span> <span class="text-slate-500 text-sm">starting</span></div>
                        <a href="{{ route('shipment.create') }}" class="btn-primary btn-sm">Ship Now</a>
                    </div>
                </div>
            </div>

            {{-- {{ __('Standard Shipping') }} --}}
            <div class="glass-card p-8 lg:p-10 hover:bg-white/[0.07] hover:border-white/15 transition-all duration-500 group relative overflow-hidden" id="service-card-standard">
                <div class="absolute top-0 right-0 w-40 h-40 bg-gradient-to-br from-emerald-500/10 to-transparent rounded-bl-full"></div>
                <div class="relative">
                    <div class="flex items-start justify-between mb-6">
                        <div class="w-14 h-14 bg-gradient-to-br from-emerald-500 to-green-400 rounded-2xl flex items-center justify-center shadow-lg shadow-emerald-500/20 group-hover:shadow-emerald-500/40 transition-all">
                            <svg class="w-7 h-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                        </div>
                        <span class="badge badge-delivered">Best Value</span>
                    </div>
                    <h3 class="text-2xl font-bold text-white mb-3">{{ __('Standard Shipping') }}</h3>
                    <p class="text-slate-400 text-sm leading-relaxed mb-6">Affordable and reliable shipping for everyday needs. Perfect for non-urgent deliveries with full tracking capabilities.</p>
                    <ul class="space-y-3 mb-8">
                        <li class="flex items-center gap-3 text-sm text-slate-300">
                            <svg class="w-4 h-4 text-emerald-400 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            3-7 business day delivery
                        </li>
                        <li class="flex items-center gap-3 text-sm text-slate-300">
                            <svg class="w-4 h-4 text-emerald-400 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            Full real-time tracking
                        </li>
                        <li class="flex items-center gap-3 text-sm text-slate-300">
                            <svg class="w-4 h-4 text-emerald-400 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            Signature on delivery
                        </li>
                        <li class="flex items-center gap-3 text-sm text-slate-300">
                            <svg class="w-4 h-4 text-emerald-400 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            Insurance up to $1,000
                        </li>
                    </ul>
                    <div class="flex items-center justify-between">
                        <div><span class="text-2xl font-bold text-white">$9.99</span> <span class="text-slate-500 text-sm">starting</span></div>
                        <a href="{{ route('shipment.create') }}" class="btn-primary btn-sm">Ship Now</a>
                    </div>
                </div>
            </div>

            {{-- Freight --}}
            <div class="glass-card p-8 lg:p-10 hover:bg-white/[0.07] hover:border-white/15 transition-all duration-500 group relative overflow-hidden" id="service-card-freight">
                <div class="absolute top-0 right-0 w-40 h-40 bg-gradient-to-br from-amber-500/10 to-transparent rounded-bl-full"></div>
                <div class="relative">
                    <div class="mb-6">
                        <div class="w-14 h-14 bg-gradient-to-br from-amber-500 to-orange-400 rounded-2xl flex items-center justify-center shadow-lg shadow-amber-500/20 group-hover:shadow-amber-500/40 transition-all">
                            <svg class="w-7 h-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>
                        </div>
                    </div>
                    <h3 class="text-2xl font-bold text-white mb-3">Freight Services</h3>
                    <p class="text-slate-400 text-sm leading-relaxed mb-6">Heavy cargo and bulk shipments handled with industrial-grade care. Air, sea, and ground freight options available.</p>
                    <ul class="space-y-3 mb-8">
                        <li class="flex items-center gap-3 text-sm text-slate-300">
                            <svg class="w-4 h-4 text-emerald-400 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            Up to 20,000 kg capacity
                        </li>
                        <li class="flex items-center gap-3 text-sm text-slate-300">
                            <svg class="w-4 h-4 text-emerald-400 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            Dedicated logistics coordinator
                        </li>
                        <li class="flex items-center gap-3 text-sm text-slate-300">
                            <svg class="w-4 h-4 text-emerald-400 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            Temperature-controlled options
                        </li>
                        <li class="flex items-center gap-3 text-sm text-slate-300">
                            <svg class="w-4 h-4 text-emerald-400 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            Full cargo insurance
                        </li>
                    </ul>
                    <div class="flex items-center justify-between">
                        <div><span class="text-2xl font-bold text-white">Custom</span> <span class="text-slate-500 text-sm">quote</span></div>
                        <a href="{{ route('shipment.create') }}" class="btn-primary btn-sm">Get Quote</a>
                    </div>
                </div>
            </div>

            {{-- International --}}
            <div class="glass-card p-8 lg:p-10 hover:bg-white/[0.07] hover:border-white/15 transition-all duration-500 group relative overflow-hidden" id="service-card-intl">
                <div class="absolute top-0 right-0 w-40 h-40 bg-gradient-to-br from-purple-500/10 to-transparent rounded-bl-full"></div>
                <div class="relative">
                    <div class="mb-6">
                        <div class="w-14 h-14 bg-gradient-to-br from-purple-500 to-pink-400 rounded-2xl flex items-center justify-center shadow-lg shadow-purple-500/20 group-hover:shadow-purple-500/40 transition-all">
                            <svg class="w-7 h-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                    </div>
                    <h3 class="text-2xl font-bold text-white mb-3">{{ __('International Shipping') }}</h3>
                    <p class="text-slate-400 text-sm leading-relaxed mb-6">Seamless cross-border logistics to 120+ countries. We handle customs clearance, duties, and documentation for you.</p>
                    <ul class="space-y-3 mb-8">
                        <li class="flex items-center gap-3 text-sm text-slate-300">
                            <svg class="w-4 h-4 text-emerald-400 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            120+ countries coverage
                        </li>
                        <li class="flex items-center gap-3 text-sm text-slate-300">
                            <svg class="w-4 h-4 text-emerald-400 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            Customs clearance included
                        </li>
                        <li class="flex items-center gap-3 text-sm text-slate-300">
                            <svg class="w-4 h-4 text-emerald-400 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            Door-to-door tracking
                        </li>
                        <li class="flex items-center gap-3 text-sm text-slate-300">
                            <svg class="w-4 h-4 text-emerald-400 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            Multi-language support
                        </li>
                    </ul>
                    <div class="flex items-center justify-between">
                        <div><span class="text-2xl font-bold text-white">$19.99</span> <span class="text-slate-500 text-sm">starting</span></div>
                        <a href="{{ route('shipment.create') }}" class="btn-primary btn-sm">Ship Now</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- FAQ Section --}}
<section class="py-24 bg-slate-900/30 border-y border-white/5" id="faq-section">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl font-bold mb-4" style="font-family: 'Outfit', sans-serif;">Frequently Asked <span class="text-gradient">Questions</span></h2>
        </div>

        <div class="space-y-4">
            @php
                $faqs = [
                    ['How do I track my shipment?', 'You can track your shipment using the tracking number provided when you create a shipment. Simply enter it on our ' . __('Track') . ' page to see real-time location on an interactive map with animated movement.'],
                    ['What is the maximum package weight?', 'For standard and express shipping, the maximum weight is 70 kg. For freight services, we can handle shipments up to 20,000 kg. Contact us for custom requirements.'],
                    ['Do you offer insurance?', 'Yes! All shipments include basic insurance. Express shipments are covered up to $5,000, standard up to $1,000. Additional coverage is available on request.'],
                    ['How long does international shipping take?', 'International delivery times vary by destination. Express international takes 2-5 days, standard international 7-14 days. You can track your package in real-time on our map.'],
                    ['Can I change the delivery address?', 'Yes, you can update the delivery address before the package reaches "Out for Delivery" status. Contact our support team or update it through your dashboard.'],
                ];
            @endphp

            @foreach($faqs as $index => $faq)
                <div x-data="{ open: false }" class="glass-card overflow-hidden">
                    <button @click="open = !open" class="w-full flex items-center justify-between p-6 text-left hover:bg-white/5 transition-colors" id="faq-{{ $index }}">
                        <span class="text-white font-medium">{{ $faq[0] }}</span>
                        <svg class="w-5 h-5 text-slate-400 transition-transform duration-300" :class="{ 'rotate-180': open }" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <div x-show="open" x-collapse class="px-6 pb-6">
                        <p class="text-slate-400 text-sm leading-relaxed">{{ $faq[1] }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

@endsection
