<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Blue Orient Logistics') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700,800,900|outfit:400,500,600,700,800&display=swap" rel="stylesheet" />

        <!-- Theme Initialization Script -->
        <script>
            if (localStorage.getItem('theme') === 'light') {
                document.documentElement.classList.add('light-mode');
            } else {
                document.documentElement.classList.remove('light-mode');
            }
        </script>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-white antialiased bg-slate-950">
        <div class="relative min-h-screen flex flex-col justify-center items-center pt-6 sm:pt-0 overflow-hidden px-4">
            {{-- Background Gradients --}}
            <div class="hero-glow top-10 left-1/2 -translate-x-1/2"></div>
            <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_center,_var(--tw-gradient-stops))] from-blue-900/20 via-slate-950 to-slate-950"></div>

            {{-- Brand Logo --}}
            <div class="relative z-10 mb-8 animate-fade-in-up">
                <a href="{{ route('home') }}" class="flex items-center gap-3 group" id="logo-link">
                    <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-cyan-400 rounded-2xl flex items-center justify-center shadow-lg shadow-blue-500/25 group-hover:shadow-blue-500/40 transition-all duration-300 group-hover:scale-110">
                        <svg class="w-7 h-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                    </div>
                    <span class="text-2xl font-bold bg-gradient-to-r from-blue-400 to-cyan-300 bg-clip-text text-transparent" style="font-family: 'Outfit', sans-serif;">Blue Orient Logistics</span>
                </a>
            </div>

            {{-- Card Container --}}
            <div class="w-full sm:max-w-md relative z-10 glass-card px-8 py-10 shadow-2xl animate-fade-in-up delay-100">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
