<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Admin - @yield('title', 'Dashboard') - Blue Orient Logistics</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700,800&display=swap" rel="stylesheet" />

    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

    <!-- Scripts -->
    <script>
        if (localStorage.getItem('theme') === 'light' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: light)').matches)) {
            document.documentElement.classList.add('light-mode');
        } else {
            document.documentElement.classList.remove('light-mode');
        }
    </script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')
</head>
<body class="font-sans antialiased bg-slate-950 text-white" x-data="{ sidebarOpen: false }">
    <div class="flex min-h-screen">
        {{-- Sidebar --}}
        <aside class="hidden lg:flex lg:flex-col w-72 bg-slate-900/50 border-r border-white/5 fixed inset-y-0 left-0 z-40">
            {{-- Logo --}}
            <div class="h-20 flex items-center px-6 border-b border-white/5">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-cyan-400 rounded-xl flex items-center justify-center shadow-lg shadow-blue-500/25">
                        <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                    </div>
                    <div>
                        <span class="text-lg font-bold bg-gradient-to-r from-blue-400 to-cyan-300 bg-clip-text text-transparent">Blue Orient Logistics</span>
                        <span class="block text-xs text-slate-500">Admin Panel</span>
                    </div>
                </a>
            </div>

            {{-- Nav Links --}}
            <nav class="flex-1 px-4 py-6 space-y-1 overflow-y-auto">
                <a href="{{ route('admin.dashboard') }}" class="admin-nav-link {{ request()->routeIs('admin.dashboard') ? 'admin-nav-active' : '' }}" id="admin-nav-dashboard">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                    Dashboard
                </a>
                <a href="{{ route('admin.shipments') }}" class="admin-nav-link {{ request()->routeIs('admin.shipments') || request()->routeIs('admin.shipment.*') ? 'admin-nav-active' : '' }}" id="admin-nav-shipments">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                    Shipments
                </a>
                <a href="{{ route('home') }}" class="admin-nav-link" id="admin-nav-site" target="_blank">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                    View Site
                </a>
            </nav>

            {{-- User Info --}}
            <div class="px-4 py-4 border-t border-white/5">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 bg-gradient-to-br from-amber-500 to-orange-500 rounded-lg flex items-center justify-center text-white font-semibold text-sm">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-white truncate">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-slate-500 truncate">{{ Auth::user()->email }}</p>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="p-2 text-slate-500 hover:text-red-400 transition-colors" title="Logout">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        {{-- Mobile Sidebar Overlay --}}
        <div x-show="sidebarOpen" x-cloak @click="sidebarOpen = false" class="fixed inset-0 bg-black/50 z-30 lg:hidden" x-transition:enter="transition-opacity ease-out duration-300" x-transition:leave="transition-opacity ease-in duration-200"></div>

        {{-- Mobile Sidebar --}}
        <aside x-show="sidebarOpen" x-cloak
               x-transition:enter="transition ease-out duration-300"
               x-transition:enter-start="-translate-x-full"
               x-transition:enter-end="translate-x-0"
               x-transition:leave="transition ease-in duration-200"
               x-transition:leave-start="translate-x-0"
               x-transition:leave-end="-translate-x-full"
               class="fixed inset-y-0 left-0 z-40 w-72 bg-slate-900 border-r border-white/5 lg:hidden">
            <div class="h-20 flex items-center justify-between px-6 border-b border-white/5">
                <span class="text-lg font-bold bg-gradient-to-r from-blue-400 to-cyan-300 bg-clip-text text-transparent">Admin</span>
                <button @click="sidebarOpen = false" class="p-2 text-slate-400 hover:text-white">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <nav class="px-4 py-6 space-y-1">
                <a href="{{ route('admin.dashboard') }}" class="admin-nav-link {{ request()->routeIs('admin.dashboard') ? 'admin-nav-active' : '' }}">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                    Dashboard
                </a>
                <a href="{{ route('admin.shipments') }}" class="admin-nav-link {{ request()->routeIs('admin.shipments') || request()->routeIs('admin.shipment.*') ? 'admin-nav-active' : '' }}">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                    Shipments
                </a>
            </nav>
        </aside>

        {{-- Main Content --}}
        <div class="flex-1 lg:ml-72">
            {{-- Top Bar --}}
            <header class="h-20 flex items-center justify-between px-6 border-b border-white/5 bg-slate-950/50 backdrop-blur-xl sticky top-0 z-20">
                <div class="flex items-center gap-4">
                    <button @click="sidebarOpen = true" class="lg:hidden p-2 text-slate-400 hover:text-white rounded-lg hover:bg-white/5">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    </button>
                    <h1 class="text-xl font-semibold text-white">@yield('page_title', 'Dashboard')</h1>
                </div>
                <div class="flex items-center gap-3">
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

                    @yield('header_actions')
                </div>
            </header>

            {{-- Flash Messages --}}
            @if(session('success'))
                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
                     x-transition class="mx-6 mt-4 bg-emerald-500/20 border border-emerald-500/30 text-emerald-300 px-6 py-3 rounded-xl backdrop-blur-xl">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="mx-6 mt-4 bg-red-500/20 border border-red-500/30 text-red-300 px-6 py-3 rounded-xl">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Page Content --}}
            <main class="p-6">
                @yield('content')
            </main>
        </div>
    </div>

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
