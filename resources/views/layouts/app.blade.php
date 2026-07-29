@php
    $theme = request()->get('theme', 'light');
    $isDark = $theme === 'dark';
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" @if($isDark) class="dark" @endif>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'FleetGo - Vehicle Management')</title>

    <!-- FAVICON -->
    <link rel="icon" href="{{ asset('images/fleetgo.png') }}" type="image/png">

    <!-- ============================================================
         FONTS
         ============================================================ -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- ============================================================
         FONT AWESOME (Icons)
         ============================================================ -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- ============================================================
         TAILWIND CSS (CDN) + CONFIG
         PENTING: darkMode harus 'class', kalau enggak, class="dark"
         di <html> nggak akan ngaruh apa-apa ke Tailwind (defaultnya
         ikut preferensi OS/browser, bukan toggle manual kita).
         Ini akar masalah kenapa warnanya jadi kacau.
         ============================================================ -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        brand: {
                            50:  '#ecfdf5',
                            100: '#d1fae5',
                            200: '#a7f3d0',
                            300: '#6ee7b7',
                            400: '#34d399',
                            500: '#0b7a3d',
                            600: '#096b35',
                            700: '#075a2c',
                            800: '#064a24',
                            900: '#053b1d',
                        }
                    }
                }
            }
        }
    </script>

    <!-- ============================================================
         CUSTOM STYLES
         ============================================================ -->
    <style>
        /* ===== BASE ===== */
        * {
            transition: background-color 0.3s, color 0.3s, border-color 0.3s;
        }

        html, body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        }

        body {
            @apply bg-gray-50 dark:bg-gray-950 text-gray-900 dark:text-gray-100 antialiased;
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        ::-webkit-scrollbar-track {
            @apply bg-gray-100 dark:bg-gray-900 rounded-full;
        }
        ::-webkit-scrollbar-thumb {
            @apply bg-brand-500 dark:bg-brand-400 rounded-full;
        }
        ::-webkit-scrollbar-thumb:hover {
            @apply bg-brand-600 dark:bg-brand-300;
        }

        /* ===== GLASSMORPHISM ===== */
        .glass {
            background: rgba(255, 255, 255, 0.6);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.5);
            box-shadow: 0 8px 32px 0 rgba(15, 23, 42, 0.06);
        }

        .dark .glass {
            background: rgba(30, 41, 59, 0.55);
            border: 1px solid rgba(255, 255, 255, 0.08);
            box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.35);
        }

        /* ===== CARDS ===== */
        .card {
            @apply bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-200 dark:border-gray-800;
            @apply hover:shadow-md dark:hover:shadow-black/30 transition-shadow duration-200;
        }

        .card-glass {
            @apply glass rounded-xl p-6 hover:shadow-xl transition-all duration-300;
        }

        /* ===== BUTTONS ===== */
        .btn-primary {
            @apply px-4 py-2.5 bg-brand-500 hover:bg-brand-600 dark:bg-brand-400 dark:hover:bg-brand-300;
            @apply text-white dark:text-gray-900 font-medium rounded-lg;
            @apply transition-all duration-200;
            @apply focus:outline-none focus:ring-2 focus:ring-brand-500 focus:ring-offset-2 dark:focus:ring-offset-gray-950;
        }

        .btn-secondary {
            @apply px-4 py-2.5 bg-gray-100 hover:bg-gray-200 dark:bg-gray-800 dark:hover:bg-gray-700;
            @apply text-gray-700 dark:text-gray-200 font-medium rounded-lg;
            @apply transition-all duration-200;
        }

        .btn-success {
            @apply px-4 py-2 bg-emerald-500 hover:bg-emerald-600 dark:bg-emerald-500 dark:hover:bg-emerald-400;
            @apply text-white font-medium rounded-lg;
            @apply transition-all duration-200;
        }

        .btn-danger {
            @apply px-4 py-2 bg-red-500 hover:bg-red-600 dark:bg-red-500 dark:hover:bg-red-400;
            @apply text-white font-medium rounded-lg;
            @apply transition-all duration-200;
        }

        .btn-outline {
            @apply px-4 py-2.5 border border-gray-300 dark:border-gray-700;
            @apply text-gray-700 dark:text-gray-300 font-medium rounded-lg;
            @apply hover:bg-gray-50 dark:hover:bg-gray-800;
            @apply transition-all duration-200;
        }

        /* ===== INPUTS ===== */
        .input {
            @apply w-full px-4 py-2.5 bg-white dark:bg-gray-900;
            @apply border border-gray-300 dark:border-gray-700 rounded-lg;
            @apply text-gray-900 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-500;
            @apply focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent;
            @apply transition-all duration-200;
        }

        .input-dark {
            @apply w-full px-4 py-2.5 bg-gray-800/60 dark:bg-gray-800/60;
            @apply border border-gray-600/50 dark:border-gray-600 rounded-lg;
            @apply text-gray-100 placeholder-gray-400;
            @apply focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent;
            @apply transition-all duration-200;
        }

        /* ===== BADGES ===== */
        .badge {
            @apply px-2.5 py-0.5 rounded-full text-xs font-medium;
        }
        .badge-pending-l1 {
            @apply bg-yellow-100 text-yellow-800 dark:bg-yellow-400/15 dark:text-yellow-300;
        }
        .badge-pending-l2 {
            @apply bg-orange-100 text-orange-800 dark:bg-orange-400/15 dark:text-orange-300;
        }
        .badge-approved {
            @apply bg-emerald-100 text-emerald-800 dark:bg-emerald-400/15 dark:text-emerald-300;
        }
        .badge-rejected {
            @apply bg-red-100 text-red-800 dark:bg-red-400/15 dark:text-red-300;
        }
        .badge-completed {
            @apply bg-blue-100 text-blue-800 dark:bg-blue-400/15 dark:text-blue-300;
        }

        /* ===== STATS ICON ===== */
        .stat-icon {
            @apply w-12 h-12 rounded-lg flex items-center justify-center;
            @apply bg-brand-50 dark:bg-brand-400/10 text-brand-600 dark:text-brand-300;
        }

        /* ===== NAV LINKS ===== */
        .nav-link {
            @apply px-3 py-2 rounded-lg text-sm font-medium;
            @apply text-gray-600 hover:text-gray-900 dark:text-gray-300 dark:hover:text-white;
            @apply hover:bg-gray-100 dark:hover:bg-gray-800;
            @apply transition-all duration-200;
        }
        .nav-link-active {
            @apply bg-brand-50 dark:bg-brand-400/10 text-brand-600 dark:text-brand-300;
        }

        /* ===== ANIMATIONS ===== */
        .animate-fade-in-up {
            animation: fadeInUp 0.6s ease-out forwards;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-pulse-glow {
            animation: pulseGlow 2s ease-in-out infinite;
        }

        @keyframes pulseGlow {
            0%, 100% {
                box-shadow: 0 0 20px rgba(11, 122, 61, 0.25);
            }
            50% {
                box-shadow: 0 0 40px rgba(11, 122, 61, 0.45);
            }
        }

        /* ===== RESPONSIVE TABLE ===== */
        .table-responsive {
            @apply overflow-x-auto -mx-4 px-4 sm:mx-0 sm:px-0;
        }

        /* ===== CUSTOM SCROLL ===== */
        .custom-scroll::-webkit-scrollbar {
            width: 4px;
        }
        .custom-scroll::-webkit-scrollbar-track {
            @apply bg-gray-100 dark:bg-gray-900 rounded-full;
        }
        .custom-scroll::-webkit-scrollbar-thumb {
            @apply bg-brand-500 dark:bg-brand-400 rounded-full;
        }
        .custom-scroll::-webkit-scrollbar-thumb:hover {
            @apply bg-brand-600 dark:bg-brand-300;
        }
    </style>

    <!-- ============================================================
         ALPINE JS (Interactivity)
         ============================================================ -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- ============================================================
         CHART JS (For Dashboard Charts)
         ============================================================ -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</head>
<body class="font-sans antialiased min-h-screen bg-gray-50 dark:bg-gray-950 text-gray-900 dark:text-gray-100">

    <!-- ============================================================
         NAVBAR
         ============================================================ -->
    <nav class="fixed top-0 left-0 right-0 z-50 bg-white/80 dark:bg-gray-950/80 backdrop-blur-sm border-b border-gray-200 dark:border-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">

                <!-- LOGO -->
                <div class="flex items-center gap-2">
                    <img src="{{ asset('images/fleetgo.png') }}" alt="FleetGo" class="h-8 w-auto">
                    <span class="text-xl font-bold text-gray-900 dark:text-white">FleetGo</span>
                    @auth
                        <span class="ml-2 text-xs px-2 py-0.5 rounded-full bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-300">
                            {{ auth()->user()->isAdmin() ? 'Admin' : 'Approver' }}
                        </span>
                    @endauth
                </div>

                <!-- RIGHT SIDE -->
                <div class="flex items-center gap-3">

                    <!-- THEME TOGGLE -->
                    <div class="relative flex items-center p-1 rounded-full bg-gray-200 dark:bg-gray-800 border border-gray-300/60 dark:border-gray-700">
                        <!-- Sliding indicator -->
                        <span class="absolute top-1 bottom-1 w-8 rounded-full bg-white dark:bg-gray-950 shadow-sm transition-all duration-300 ease-out {{ $isDark ? 'translate-x-8' : 'translate-x-0' }}"></span>

                        <a href="?theme=light" aria-label="Light mode"
                           class="relative z-10 w-8 h-8 flex items-center justify-center rounded-full transition-colors duration-200 {{ !$isDark ? 'text-gray-900 dark:text-white' : 'text-gray-400 dark:text-gray-500' }}">
                            <i class="fas fa-sun text-sm"></i>
                        </a>
                        <a href="?theme=dark" aria-label="Dark mode"
                           class="relative z-10 w-8 h-8 flex items-center justify-center rounded-full transition-colors duration-200 {{ $isDark ? 'text-gray-900 dark:text-white' : 'text-gray-400 dark:text-gray-500' }}">
                            <i class="fas fa-moon text-sm"></i>
                        </a>
                    </div>

                    @auth
                        <span class="text-sm text-gray-700 dark:text-gray-300 hidden sm:inline">{{ auth()->user()->name }}</span>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="text-sm text-gray-500 hover:text-red-500 dark:text-gray-400 dark:hover:text-red-400 transition-colors">
                                <i class="fas fa-sign-out-alt mr-1"></i>
                                <span class="hidden sm:inline">Logout</span>
                            </button>
                        </form>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- ============================================================
         MAIN CONTENT
         ============================================================ -->
    <main class="pt-20 pb-8 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto animate-fade-in-up">

        <!-- Flash Messages -->
        @if(session('success'))
            <div class="mb-4 p-4 rounded-lg bg-emerald-50 dark:bg-emerald-400/10 border border-emerald-200 dark:border-emerald-800/50 text-emerald-800 dark:text-emerald-300">
                <i class="fas fa-check-circle mr-2"></i>
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-4 p-4 rounded-lg bg-red-50 dark:bg-red-400/10 border border-red-200 dark:border-red-800/50 text-red-800 dark:text-red-300">
                <i class="fas fa-exclamation-circle mr-2"></i>
                {{ session('error') }}
            </div>
        @endif

        @yield('content')
    </main>

    <!-- ============================================================
         FOOTER
         ============================================================ -->
    <footer class="text-center py-6 text-sm text-gray-400 dark:text-gray-500 border-t border-gray-200 dark:border-gray-800">
        &copy; {{ date('Y') }} FleetGo. All rights reserved.
    </footer>

</body>
</html>