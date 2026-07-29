@extends('layouts.app')

@section('title', 'Login - FleetGo')

@section('content')
<div class="min-h-[80vh] flex items-center justify-center px-4">
    <div class="w-full max-w-md">

        <!-- Card Login dengan Glassmorphism -->
        <div class="relative overflow-hidden rounded-2xl bg-white/10 dark:bg-gray-900/30 backdrop-blur-xl border border-white/20 dark:border-gray-700/50 shadow-2xl p-8">

            <!-- Decorative Elements -->
            <div class="absolute -top-20 -right-20 w-40 h-40 rounded-full bg-green-400/20 blur-2xl"></div>
            <div class="absolute -bottom-20 -left-20 w-40 h-40 rounded-full bg-emerald-400/20 blur-2xl"></div>

            <!-- LOGO -->
            <div class="relative text-center mb-8">
                <img src="{{ asset('images/fleetgo.png') }}" alt="FleetGo" class="h-20 w-auto mx-auto mb-4">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Welcome Back</h2>
                <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">Sign in to manage your fleet</p>
            </div>

            <!-- Form Login -->
            <form method="POST" action="{{ route('login') }}" class="relative">
                @csrf

                <div class="space-y-4">
                    <!-- Email -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            <i class="fas fa-envelope mr-2 text-green-600 dark:text-green-400"></i>
                            Email Address
                        </label>
                        <input type="email" name="email" value="{{ old('email') }}"
                               class="w-full px-4 py-3 bg-white/50 dark:bg-gray-800/50 border border-gray-200 dark:border-gray-700 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition text-gray-900 dark:text-white placeholder-gray-400"
                               placeholder="admin@fleetgo.com" required autofocus>
                        @error('email')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            <i class="fas fa-lock mr-2 text-green-600 dark:text-green-400"></i>
                            Password
                        </label>
                        <input type="password" name="password"
                               class="w-full px-4 py-3 bg-white/50 dark:bg-gray-800/50 border border-gray-200 dark:border-gray-700 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition text-gray-900 dark:text-white placeholder-gray-400"
                               placeholder="••••••••" required>
                        @error('password')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Remember Me -->
                    <div class="flex items-center justify-between">
                        <label class="flex items-center text-sm text-gray-600 dark:text-gray-400">
                            <input type="checkbox" name="remember" class="rounded border-gray-300 dark:border-gray-600 text-green-600 focus:ring-green-500">
                            <span class="ml-2">Remember me</span>
                        </label>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="w-full py-3 bg-gradient-to-r from-green-600 to-emerald-500 hover:from-green-700 hover:to-emerald-600 text-white font-semibold rounded-xl transition-all duration-300 transform hover:scale-[1.02] shadow-lg shadow-green-500/30">
                        <i class="fas fa-sign-in-alt mr-2"></i>
                        Sign In
                    </button>
                </div>
            </form>

            <!-- Demo Credentials -->
            <div class="relative mt-6 pt-6 border-t border-gray-200/50 dark:border-gray-700/50">
                <p class="text-xs text-center text-gray-400 dark:text-gray-500 mb-3">
                    <i class="fas fa-users mr-1"></i>
                    Demo Accounts
                </p>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-2">
                    <!-- Admin -->
                    <div class="text-center p-3 rounded-xl bg-white/30 dark:bg-gray-800/30 backdrop-blur-sm border border-white/20 dark:border-gray-700/30 hover:bg-white/50 dark:hover:bg-gray-800/50 transition cursor-pointer group" onclick="document.querySelector('input[name=email]').value='admin@fleetgo.com'; document.querySelector('input[name=password]').value='password'">
                        <div class="w-8 h-8 rounded-full bg-green-100 dark:bg-green-900/30 flex items-center justify-center text-green-600 dark:text-green-400 mx-auto mb-1">
                            <i class="fas fa-user-cog text-xs"></i>
                        </div>
                        <p class="font-semibold text-gray-700 dark:text-gray-300 text-xs">Admin</p>
                        <p class="text-[10px] text-gray-400 dark:text-gray-500 truncate">admin@fleetgo.com</p>
                    </div>

                    <!-- Approver L1 -->
                    <div class="text-center p-3 rounded-xl bg-white/30 dark:bg-gray-800/30 backdrop-blur-sm border border-white/20 dark:border-gray-700/30 hover:bg-white/50 dark:hover:bg-gray-800/50 transition cursor-pointer group" onclick="document.querySelector('input[name=email]').value='sissy@fleetgo.com'; document.querySelector('input[name=password]').value='password'">
                        <div class="w-8 h-8 rounded-full bg-yellow-100 dark:bg-yellow-900/30 flex items-center justify-center text-yellow-600 dark:text-yellow-400 mx-auto mb-1">
                            <i class="fas fa-user-check text-xs"></i>
                        </div>
                        <p class="font-semibold text-gray-700 dark:text-gray-300 text-xs">Approver L1</p>
                        <p class="text-[10px] text-gray-400 dark:text-gray-500 truncate">sissy@fleetgo.com</p>
                    </div>

                    <!-- Approver L2 -->
                    <div class="text-center p-3 rounded-xl bg-white/30 dark:bg-gray-800/30 backdrop-blur-sm border border-white/20 dark:border-gray-700/30 hover:bg-white/50 dark:hover:bg-gray-800/50 transition cursor-pointer group" onclick="document.querySelector('input[name=email]').value='ayudya@fleetgo.com'; document.querySelector('input[name=password]').value='password'">
                        <div class="w-8 h-8 rounded-full bg-purple-100 dark:bg-purple-900/30 flex items-center justify-center text-purple-600 dark:text-purple-400 mx-auto mb-1">
                            <i class="fas fa-user-shield text-xs"></i>
                        </div>
                        <p class="font-semibold text-gray-700 dark:text-gray-300 text-xs">Approver L2</p>
                        <p class="text-[10px] text-gray-400 dark:text-gray-500 truncate">ayudya@fleetgo.com</p>
                    </div>
                </div>
                <p class="text-[10px] text-center text-gray-400 dark:text-gray-500 mt-2">
                    <i class="fas fa-mouse-pointer mr-1"></i>
                    Klik card untuk auto-fill
                </p>
            </div>

            <!-- Footer -->
            <div class="relative text-center mt-4">
                <p class="text-[10px] text-gray-400 dark:text-gray-500">
                    <i class="fas fa-lock mr-1"></i>
                    All demo accounts use password: <span class="font-mono text-green-600 dark:text-green-400">password</span>
                </p>
            </div>
        </div>
    </div>
</div>

<!-- Auto-fill script -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.cursor-pointer.group').forEach(card => {
        card.addEventListener('click', function() {
            const email = this.querySelector('p.text-gray-400').textContent.trim();
            document.querySelector('input[name=email]').value = email;
            document.querySelector('input[name=password]').value = 'password';

            this.style.borderColor = '#22c55e';
            setTimeout(() => {
                this.style.borderColor = '';
            }, 1000);
        });
    });
});
</script>
@endsection