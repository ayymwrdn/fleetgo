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
         FONT & ICON
         ============================================================ -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- ============================================================
         CSS LANGSUNG (Tanpa Vite)
         ============================================================ -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <!-- ============================================================
         JS (Alpine & Chart.js)
         ============================================================ -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="{{ asset('js/app.js') }}" defer></script>
</head>
<body class="font-sans antialiased min-h-screen bg-gray-50 dark:bg-gray-900">

    <!-- NAVBAR -->
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

                <!-- RIGHT -->
                <div class="flex items-center gap-3">

                    <!-- Theme Toggle -->
                    <button id="theme-toggle" class="w-9 h-9 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors flex items-center justify-center text-gray-600 dark:text-gray-300">
                        <svg class="w-5 h-5 hidden dark:block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
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

    <!-- MAIN CONTENT -->
    <main class="pt-20 pb-8 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto animate-fade-in">

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

    <!-- FOOTER -->
    <footer class="text-center py-6 text-sm text-gray-400 dark:text-gray-500 border-t border-gray-200 dark:border-gray-800">
        &copy; {{ date('Y') }} FleetGo. All rights reserved.
    </footer>

    <!-- Theme Toggle Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const themeToggle = document.getElementById('theme-toggle');
            const html = document.documentElement;

            const savedTheme = localStorage.getItem('theme');
            if (savedTheme) {
                html.classList.toggle('dark', savedTheme === 'dark');
            } else {
                const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
                html.classList.toggle('dark', prefersDark);
            }

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