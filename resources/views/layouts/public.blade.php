<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="@yield('meta_description', 'Blue Orient Logistics - Fast, reliable worldwide shipping with real-time tracking. Ship anywhere, track everything.')">

    <title>@yield('title', 'Blue Orient Logistics') - {{ config('app.name', 'Blue Orient Logistics') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700,800,900|outfit:400,500,600,700,800&display=swap" rel="stylesheet" />

    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

    <script>
        if (localStorage.getItem('theme') === 'light') {
            document.documentElement.classList.add('light-mode');
        } else {
            document.documentElement.classList.remove('light-mode');
        }
    </script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')
</head>
<body class="font-sans antialiased bg-slate-950 text-white">

    {{-- Navigation --}}
    <nav x-data="{ open: false, scrolled: false }" 
         x-init="window.addEventListener('scroll', () => { scrolled = window.scrollY > 20 })"
         :class="{ 'bg-slate-950/90 backdrop-blur-xl shadow-lg shadow-blue-500/5 border-b border-white/5': scrolled, 'bg-transparent': !scrolled }"
         class="fixed top-0 left-0 right-0 z-50 transition-all duration-500" id="main-nav">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20 items-center">
                {{-- Logo --}}
                <a href="{{ route('home') }}" class="flex items-center gap-3 group" id="logo-link">
                    <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-cyan-400 rounded-xl flex items-center justify-center shadow-lg shadow-blue-500/25 group-hover:shadow-blue-500/40 transition-all duration-300 group-hover:scale-110">
                        <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                    </div>
                    <span class="text-xl font-bold bg-gradient-to-r from-blue-400 to-cyan-300 bg-clip-text text-transparent">Blue Orient Logistics</span>
                </a>

                {{-- Desktop Navigation Links --}}
                <div class="hidden md:flex items-center gap-1">
                    <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'nav-link-active' : '' }}" id="nav-home">{{ __('Home') }}</a>
                    <a href="{{ route('about') }}" class="nav-link {{ request()->routeIs('about') ? 'nav-link-active' : '' }}" id="nav-about">{{ __('About') }}</a>
                    <a href="{{ route('services') }}" class="nav-link {{ request()->routeIs('services') ? 'nav-link-active' : '' }}" id="nav-services">{{ __('Services') }}</a>
                    <a href="{{ route('shipment.create') }}" class="nav-link {{ request()->routeIs('shipment.create') ? 'nav-link-active' : '' }}" id="nav-send">{{ __('Send Item') }}</a>
                    <a href="{{ route('track') }}" class="nav-link {{ request()->routeIs('track') || request()->routeIs('track.result') ? 'nav-link-active' : '' }}" id="nav-track">{{ __('Track') }}</a>
                </div>

                {{-- Auth Buttons --}}
                <div class="hidden md:flex items-center gap-3">
                    <!-- Theme Toggle -->
                    <button id="theme-toggle" class="p-2 rounded-lg text-slate-400 hover:text-white hover:bg-white/5 transition-all duration-300" title="Toggle Light/Dark Mode">
                        <svg id="theme-toggle-dark-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path></svg>
                        <svg id="theme-toggle-light-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.46 5.05l-.707-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 100 2h1z" clip-rule="evenodd"></path></svg>
                    </button>

                    <!-- Language Switcher -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center gap-1.5 px-3 py-2 text-sm font-medium text-slate-300 hover:text-white rounded-lg hover:bg-white/5 transition-all duration-300">
                            <span>🌐 {{ strtoupper(app()->getLocale()) }}</span>
                            <svg class="w-4 h-4 transition-transform duration-200" :class="{ 'rotate-180': open }" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </button>
                        <div x-show="open" @click.away="open = false" x-cloak class="absolute right-0 mt-2 w-32 glass-card shadow-xl z-50 overflow-hidden">
                            <a href="{{ route('lang.switch', 'en') }}" class="block px-4 py-2.5 text-sm text-slate-300 hover:text-white hover:bg-white/5 transition-colors">English</a>
                            <a href="{{ route('lang.switch', 'fr') }}" class="block px-4 py-2.5 text-sm text-slate-300 hover:text-white hover:bg-white/5 transition-colors">Français</a>
                            <a href="{{ route('lang.switch', 'es') }}" class="block px-4 py-2.5 text-sm text-slate-300 hover:text-white hover:bg-white/5 transition-colors">Español</a>
                            <a href="{{ route('lang.switch', 'de') }}" class="block px-4 py-2.5 text-sm text-slate-300 hover:text-white hover:bg-white/5 transition-colors">Deutsch</a>
                            <a href="{{ route('lang.switch', 'zh') }}" class="block px-4 py-2.5 text-sm text-slate-300 hover:text-white hover:bg-white/5 transition-colors">中文</a>
                        </div>
                    </div>

                    @auth
                        <a href="{{ route('dashboard') }}" class="nav-link" id="nav-dashboard">{{ __('Dashboard') }}</a>
                        @if(Auth::user()->is_admin)
                            <a href="{{ route('admin.dashboard') }}" class="nav-link text-amber-400" id="nav-admin">{{ __('Admin') }}</a>
                        @endif
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="nav-link hover:text-red-400" id="nav-logout">{{ __('Logout') }}</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="nav-link" id="nav-login">{{ __('Login') }}</a>
                        <a href="{{ route('register') }}" class="btn-primary text-sm" id="nav-register">{{ __('Get Started') }}</a>
                    @endauth
                </div>

                {{-- Mobile Hamburger --}}
                <button @click="open = !open" class="md:hidden p-2 rounded-lg text-slate-400 hover:text-white hover:bg-white/10 transition-colors" id="mobile-menu-toggle">
                    <svg x-show="!open" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    <svg x-show="open" x-cloak class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
        </div>

        {{-- Mobile Menu --}}
        <div x-show="open" x-cloak
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 -translate-y-4"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 -translate-y-4"
             class="md:hidden bg-slate-900/95 backdrop-blur-xl border-b border-white/5">
            <div class="px-4 py-4 space-y-2">
                <a href="{{ route('home') }}" class="mobile-nav-link">{{ __('Home') }}</a>
                <a href="{{ route('about') }}" class="mobile-nav-link">{{ __('About') }}</a>
                <a href="{{ route('services') }}" class="mobile-nav-link">{{ __('Services') }}</a>
                <a href="{{ route('shipment.create') }}" class="mobile-nav-link">{{ __('Send Item') }}</a>
                <a href="{{ route('track') }}" class="mobile-nav-link">{{ __('Track Shipment') }}</a>
                @auth
                    <a href="{{ route('dashboard') }}" class="mobile-nav-link">{{ __('Dashboard') }}</a>
                    @if(Auth::user()->is_admin)
                        <a href="{{ route('admin.dashboard') }}" class="mobile-nav-link text-amber-400">{{ __('Admin') }} Panel</a>
                    @endif
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="mobile-nav-link w-full text-left text-red-400">{{ __('Logout') }}</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="mobile-nav-link">{{ __('Login') }}</a>
                    <a href="{{ route('register') }}" class="mobile-nav-link text-blue-400">{{ __('Get Started') }}</a>
                @endauth
            </div>
        </div>
    </nav>

    {{-- Flash Messages --}}
    @if(session('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
             x-transition class="fixed top-24 right-6 z-50 bg-emerald-500/20 border border-emerald-500/30 text-emerald-300 px-6 py-3 rounded-xl backdrop-blur-xl shadow-lg">
            {{ session('success') }}
        </div>
    @endif

    {{-- Main Content --}}
    <main>
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="bg-slate-900/50 border-t border-white/5 mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12">
                {{-- Brand --}}
                <div class="md:col-span-1">
                    <a href="{{ route('home') }}" class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-cyan-400 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                            </svg>
                        </div>
                        <span class="text-xl font-bold bg-gradient-to-r from-blue-400 to-cyan-300 bg-clip-text text-transparent">Blue Orient Logistics</span>
                    </a>
                    <p class="text-slate-400 text-sm leading-relaxed">Ship anywhere in the world with real-time tracking. Fast, reliable, and secure logistics solutions.</p>
                </div>

                {{-- Quick Links --}}
                <div>
                    <h4 class="text-white font-semibold mb-4">Quick Links</h4>
                    <ul class="space-y-3">
                        <li><a href="{{ route('home') }}" class="text-slate-400 hover:text-blue-400 transition-colors text-sm">Home</a></li>
                        <li><a href="{{ route('about') }}" class="text-slate-400 hover:text-blue-400 transition-colors text-sm">{{ __('About Us') }}</a></li>
                        <li><a href="{{ route('services') }}" class="text-slate-400 hover:text-blue-400 transition-colors text-sm">Services</a></li>
                        <li><a href="{{ route('track') }}" class="text-slate-400 hover:text-blue-400 transition-colors text-sm">Track Shipment</a></li>
                    </ul>
                </div>

                {{-- Services --}}
                <div>
                    <h4 class="text-white font-semibold mb-4">Services</h4>
                    <ul class="space-y-3">
                        <li><a href="{{ route('services') }}" class="text-slate-400 hover:text-blue-400 transition-colors text-sm">{{ __('Express Delivery') }}</a></li>
                        <li><a href="{{ route('services') }}" class="text-slate-400 hover:text-blue-400 transition-colors text-sm">{{ __('Standard Shipping') }}</a></li>
                        <li><a href="{{ route('services') }}" class="text-slate-400 hover:text-blue-400 transition-colors text-sm">Freight Services</a></li>
                        <li><a href="{{ route('services') }}" class="text-slate-400 hover:text-blue-400 transition-colors text-sm">International</a></li>
                    </ul>
                </div>

                {{-- Contact --}}
                <div>
                    <h4 class="text-white font-semibold mb-4">Contact</h4>
                    <ul class="space-y-3">
                        <li class="flex items-center gap-2 text-slate-400 text-sm">
                            <svg class="w-4 h-4 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            info@blueorientlogistics.org
                        </li>
                        <li class="flex items-center gap-2 text-slate-400 text-sm">
                            <svg class="w-4 h-4 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            +1 (555) 123-4567
                        </li>
                        <li class="flex items-start gap-2 text-slate-400 text-sm">
                            <svg class="w-4 h-4 text-blue-400 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            123 Shipping Lane, New York, NY 10001
                        </li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-white/5 mt-12 pt-8 flex flex-col md:flex-row justify-between items-center gap-4">
                <p class="text-slate-500 text-sm">&copy; {{ date('Y') }} Blue Orient Logistics. All rights reserved.</p>
                <div class="flex gap-4">
                    <a href="#" class="w-9 h-9 bg-white/5 rounded-lg flex items-center justify-center text-slate-400 hover:text-blue-400 hover:bg-blue-500/10 transition-all">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/></svg>
                    </a>
                    <a href="#" class="w-9 h-9 bg-white/5 rounded-lg flex items-center justify-center text-slate-400 hover:text-blue-400 hover:bg-blue-500/10 transition-all">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M22.675 0h-21.35c-.732 0-1.325.593-1.325 1.325v21.351c0 .731.593 1.324 1.325 1.324h11.495v-9.294h-3.128v-3.622h3.128v-2.671c0-3.1 1.893-4.788 4.659-4.788 1.325 0 2.463.099 2.795.143v3.24l-1.918.001c-1.504 0-1.795.715-1.795 1.763v2.313h3.587l-.467 3.622h-3.12v9.293h6.116c.73 0 1.323-.593 1.323-1.325v-21.35c0-.732-.593-1.325-1.325-1.325z"/></svg>
                    </a>
                    <a href="#" class="w-9 h-9 bg-white/5 rounded-lg flex items-center justify-center text-slate-400 hover:text-blue-400 hover:bg-blue-500/10 transition-all">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                    </a>
                </div>
            </div>
        </div>
    </footer>

    {{-- Leaflet JS --}}
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    {{-- Theme Switcher JS --}}
    <script>
        (function() {
            const themeToggleBtn = document.getElementById('theme-toggle');
            const themeToggleDarkIcon = document.getElementById('theme-toggle-dark-icon');
            const themeToggleLightIcon = document.getElementById('theme-toggle-light-icon');

            if (themeToggleBtn && themeToggleDarkIcon && themeToggleLightIcon) {
                // Set initial icon visibility
                if (document.documentElement.classList.contains('light-mode')) {
                    themeToggleDarkIcon.classList.remove('hidden');
                } else {
                    themeToggleLightIcon.classList.remove('hidden');
                }

                themeToggleBtn.addEventListener('click', function() {
                    themeToggleDarkIcon.classList.toggle('hidden');
                    themeToggleLightIcon.classList.toggle('hidden');

                    if (document.documentElement.classList.contains('light-mode')) {
                        document.documentElement.classList.remove('light-mode');
                        localStorage.setItem('theme', 'dark');
                    } else {
                        document.documentElement.classList.add('light-mode');
                        localStorage.setItem('theme', 'light');
                    }
                    window.dispatchEvent(new Event('theme-changed'));
                });
            }
        })();
    </script>

    @stack('scripts')
</body>
</html>
