<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
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
         TAILWIND CSS (CDN - No build needed!)
         ============================================================ -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- ============================================================
         CUSTOM STYLES (Glassmorphism, Cards, Buttons, Badges)
         ============================================================ -->
    <style>
        /* ===== BASE ===== */
        * {
            transition: background-color 0.3s, color 0.3s, border-color 0.3s;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            @apply bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100 antialiased;
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        ::-webkit-scrollbar-track {
            @apply bg-gray-100 dark:bg-gray-800 rounded-full;
        }
        ::-webkit-scrollbar-thumb {
            @apply bg-green-500 dark:bg-green-400 rounded-full;
        }
        ::-webkit-scrollbar-thumb:hover {
            @apply bg-green-600 dark:bg-green-300;
        }

        /* ===== GLASSMORPHISM ===== */
        .glass {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.18);
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.10);
        }

        .glass-dark {
            background: rgba(11, 122, 61, 0.10);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.08);
        }

        /* ===== CARDS ===== */
        .card {
            @apply bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700;
            @apply hover:shadow-md transition-shadow duration-200;
        }

        .card-glass {
            @apply glass rounded-xl p-6 hover:shadow-xl transition-all duration-300;
            @apply dark:glass-dark;
        }

        /* ===== BUTTONS ===== */
        .btn-primary {
            @apply px-4 py-2.5 bg-green-600 hover:bg-green-700 dark:bg-green-500 dark:hover:bg-green-600;
            @apply text-white font-medium rounded-lg;
            @apply transition-all duration-200;
            @apply focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 dark:focus:ring-offset-gray-900;
        }

        .btn-secondary {
            @apply px-4 py-2.5 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600;
            @apply text-gray-700 dark:text-gray-200 font-medium rounded-lg;
            @apply transition-all duration-200;
        }

        .btn-success {
            @apply px-4 py-2 bg-emerald-500 hover:bg-emerald-600 text-white font-medium rounded-lg;
            @apply transition-all duration-200;
        }

        .btn-danger {
            @apply px-4 py-2 bg-red-500 hover:bg-red-600 text-white font-medium rounded-lg;
            @apply transition-all duration-200;
        }

        .btn-outline {
            @apply px-4 py-2.5 border border-gray-300 dark:border-gray-600;
            @apply text-gray-700 dark:text-gray-300 font-medium rounded-lg;
            @apply hover:bg-gray-50 dark:hover:bg-gray-700;
            @apply transition-all duration-200;
        }

        /* ===== INPUTS ===== */
        .input {
            @apply w-full px-4 py-2.5 bg-white dark:bg-gray-800;
            @apply border border-gray-300 dark:border-gray-600 rounded-lg;
            @apply text-gray-900 dark:text-gray-100;
            @apply focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent;
            @apply transition-all duration-200;
        }

        .input-dark {
            @apply w-full px-4 py-2.5 bg-gray-800/50 dark:bg-gray-700/50;
            @apply border border-gray-600/50 dark:border-gray-600 rounded-lg;
            @apply text-gray-100 placeholder-gray-400;
            @apply focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent;
            @apply transition-all duration-200;
        }

        /* ===== BADGES ===== */
        .badge {
            @apply px-2.5 py-0.5 rounded-full text-xs font-medium;
        }
        .badge-pending-l1 {
            @apply bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300;
        }
        .badge-pending-l2 {
            @apply bg-orange-100 text-orange-800 dark:bg-orange-900/30 dark:text-orange-300;
        }
        .badge-approved {
            @apply bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300;
        }
        .badge-rejected {
            @apply bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300;
        }
        .badge-completed {
            @apply bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300;
        }

        /* ===== STATS ICON ===== */
        .stat-icon {
            @apply w-12 h-12 rounded-lg flex items-center justify-center;
            @apply bg-green-50 dark:bg-green-900/30 text-green-600 dark:text-green-400;
        }

        /* ===== NAV LINKS ===== */
        .nav-link {
            @apply px-3 py-2 rounded-lg text-sm font-medium;
            @apply text-gray-600 hover:text-gray-900 dark:text-gray-300 dark:hover:text-white;
            @apply hover:bg-gray-100 dark:hover:bg-gray-700;
            @apply transition-all duration-200;
        }
        .nav-link-active {
            @apply bg-green-50 dark:bg-green-900/30 text-green-600 dark:text-green-400;
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
                box-shadow: 0 0 20px rgba(11, 122, 61, 0.2);
            }
            50% {
                box-shadow: 0 0 40px rgba(11, 122, 61, 0.4);
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
            @apply bg-gray-100 dark:bg-gray-800 rounded-full;
        }
        .custom-scroll::-webkit-scrollbar-thumb {
            @apply bg-green-500 dark:bg-green-400 rounded-full;
        }
        .custom-scroll::-webkit-scrollbar-thumb:hover {
            @apply bg-green-600 dark:bg-green-300;
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
<body class="font-sans antialiased min-h-screen bg-gray-50 dark:bg-gray-900">

    <!-- ============================================================
         NAVBAR
         ============================================================ -->
    <nav class="fixed top-0 left-0 right-0 z-50 bg-white/80 dark:bg-gray-900/80 backdrop-blur-sm border-b border-gray-200 dark:border-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">

                <!-- LOGO -->
                <div class="flex items-center gap-2">
                    <img src="{{ asset('images/fleetgo.png') }}" alt="FleetGo" class="h-8 w-auto">
                    <span class="text-xl font-bold text-gray-900 dark:text-white">FleetGo</span>
                    @auth
                        <span class="ml-2 text-xs px-2 py-0.5 rounded-full bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300">
                            {{ auth()->user()->isAdmin() ? 'Admin' : 'Approver' }}
                        </span>
                    @endauth
                </div>

                <!-- RIGHT SIDE -->
                <div class="flex items-center gap-3">

                    <!-- Theme Toggle -->
                    <button id="theme-toggle" class="w-9 h-9 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors flex items-center justify-center text-gray-600 dark:text-gray-300">
                        <!-- Sun icon (visible in dark mode) -->
                        <svg class="w-5 h-5 hidden dark:block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                        <!-- Moon icon (visible in light mode) -->
                        <svg class="w-5 h-5 dark:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                        </svg>
                    </button>

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
            <div class="mb-4 p-4 rounded-lg bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-800 text-green-800 dark:text-green-300">
                <i class="fas fa-check-circle mr-2"></i>
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-4 p-4 rounded-lg bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-800 text-red-800 dark:text-red-300">
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

    <!-- ============================================================
         SCRIPTS
         ============================================================ -->
    <script>
        // ===== THEME TOGGLE =====
        document.addEventListener('DOMContentLoaded', function() {
            const themeToggle = document.getElementById('theme-toggle');
            const html = document.documentElement;

            // Check saved theme
            const savedTheme = localStorage.getItem('theme');
            if (savedTheme) {
                html.classList.toggle('dark', savedTheme === 'dark');
            } else {
                // Default: follow system preference
                const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
                html.classList.toggle('dark', prefersDark);
            }

            // Toggle theme on button click
            if (themeToggle) {
                themeToggle.addEventListener('click', function() {
                    html.classList.toggle('dark');
                    localStorage.setItem('theme', html.classList.contains('dark') ? 'dark' : 'light');
                });
            }
        });
    </script>

</body>
</html>