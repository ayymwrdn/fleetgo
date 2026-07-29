@extends('layouts.app')

@section('title', 'Dashboard Approver - FleetGo')

@section('content')
<div class="max-w-7xl mx-auto space-y-6">
    
    <!-- Info Card -->
    <div class="card p-6">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-lg bg-yellow-50 dark:bg-yellow-900/30 flex items-center justify-center text-yellow-600 dark:text-yellow-400">
                <i class="fas fa-check-circle text-lg"></i>
            </div>
            <div>
                <h2 class="text-xl font-bold text-gray-900 dark:text-white">Dashboard Persetujuan</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    Anda adalah <strong>{{ auth()->user()->name }}</strong> - 
                    Approver Level {{ auth()->user()->approval_level }}
                    @if(auth()->user()->isLevel1())
                        (Menyetujui tahap pertama)
                    @else
                        (Menyetujui tahap akhir)
                    @endif
                </p>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        <div class="card p-5">
            <p class="text-sm text-gray-500 dark:text-gray-400">Total Pemesanan</p>
            <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $totalBookings ?? 0 }}</p>
        </div>
        <div class="card p-5">
            <p class="text-sm text-gray-500 dark:text-gray-400">Menunggu Approval</p>
            <p class="text-2xl font-bold text-yellow-600 dark:text-yellow-400">{{ $pendingBookings ?? 0 }}</p>
        </div>
        <div class="card p-5">
            <p class="text-sm text-gray-500 dark:text-gray-400">Sudah Disetujui</p>
            <p class="text-2xl font-bold text-emerald-600 dark:text-emerald-400">{{ $approvedBookings ?? 0 }}</p>
        </div>
    </div>

    <!-- Pending Approvals -->
    <div class="card p-6">
        <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-4">
            <i class="fas fa-clock mr-2 text-yellow-500"></i>
            Menunggu Persetujuan Anda
        </h3>
        
        @if($bookings->isEmpty())
            <div class="text-center py-8 text-gray-400 dark:text-gray-500">
                <i class="fas fa-check-circle text-3xl block mb-2"></i>
                Tidak ada pemesanan yang menunggu persetujuan
            </div>
        @else
            <div class="space-y-4">
                @foreach($bookings as $booking)
                <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4 hover:border-gray-300 dark:hover:border-gray-600 transition">
                    <div class="flex flex-col lg:flex-row justify-between gap-4">
                        
                        <div class="flex-1 space-y-2">
                            <div class="flex items-center gap-2">
                                <span class="text-lg font-semibold text-gray-900 dark:text-white">
                                    {{ $booking->vehicle->name }}
                                </span>
                                <span class="text-sm text-gray-400 dark:text-gray-500">
                                    {{ $booking->vehicle->plate_number }}
                                </span>
                            </div>
                            
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-1 text-sm text-gray-600 dark:text-gray-400">
                                <p><span class="text-gray-400 dark:text-gray-500">Driver:</span> {{ $booking->driver->name }}</p>
                                <p><span class="text-gray-400 dark:text-gray-500">Dibuat oleh:</span> {{ $booking->user->name }}</p>
                                <p><span class="text-gray-400 dark:text-gray-500">Tanggal:</span> {{ $booking->start_date->format('d M Y H:i') }}</p>
                                <p>
                                    <span class="text-gray-400 dark:text-gray-500">Status:</span>
                                    <span class="badge {{ $booking->getStatusBadgeClass() }} ml-1">
                                        {{ $booking->getStatusLabel() }}
                                    </span>
                                </p>
                            </div>
                            
                            <div class="text-sm">
                                <span class="text-gray-400 dark:text-gray-500">Tujuan:</span>
                                <p class="mt-1 p-2 rounded-lg bg-gray-50 dark:bg-gray-800 text-gray-700 dark:text-gray-300">
                                    {{ $booking->purpose }}
                                </p>
                            </div>
                        </div>
                        
                        <div class="flex flex-row lg:flex-col gap-2 min-w-[140px]">
                            <form method="POST" action="{{ route('approver.approve', $booking->id) }}" class="flex-1">
                                @csrf
                                <button type="submit" class="btn-success w-full">
                                    <i class="fas fa-check mr-1"></i>
                                    Setujui
                                </button>
                            </form>
                            <form method="POST" action="{{ route('approver.reject', $booking->id) }}" class="flex-1">
                                @csrf
                                <button type="submit" class="btn-danger w-full">
                                    <i class="fas fa-times mr-1"></i>
                                    Tolak
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @endif
    </div>

    <!-- Recent Bookings & Logs -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        
        <!-- Recent Bookings -->
        <div class="card p-6">
            <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-4">
                <i class="fas fa-list mr-2 text-blue-500"></i>
                Pemesanan Terbaru
            </h3>
            
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-gray-200 dark:border-gray-700">
                            <th class="text-left py-2 px-1 text-gray-500 dark:text-gray-400">Kendaraan</th>
                            <th class="text-left py-2 px-1 text-gray-500 dark:text-gray-400 hidden sm:table-cell">Driver</th>
                            <th class="text-left py-2 px-1 text-gray-500 dark:text-gray-400">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentBookings ?? [] as $booking)
                        <tr class="border-b border-gray-100 dark:border-gray-800">
                            <td class="py-2 px-1 text-gray-900 dark:text-white">{{ $booking->vehicle->name }}</td>
                            <td class="py-2 px-1 hidden sm:table-cell text-gray-600 dark:text-gray-400">{{ $booking->driver->name }}</td>
                            <td class="py-2 px-1">
                                <span class="badge {{ $booking->getStatusBadgeClass() }}">
                                    {{ $booking->getStatusLabel() }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="text-center py-4 text-gray-400 dark:text-gray-500">
                                Belum ada pemesanan
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Activity Logs -->
        <div class="card p-6">
            <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-4">
                <i class="fas fa-history mr-2 text-purple-500"></i>
                Aktivitas Terbaru
            </h3>
            
            <div class="overflow-x-auto max-h-60 overflow-y-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-gray-200 dark:border-gray-700">
                            <th class="text-left py-2 px-1 text-gray-500 dark:text-gray-400">User</th>
                            <th class="text-left py-2 px-1 text-gray-500 dark:text-gray-400 hidden sm:table-cell">Aksi</th>
                            <th class="text-left py-2 px-1 text-gray-500 dark:text-gray-400">Waktu</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentLogs ?? [] as $log)
                        <tr class="border-b border-gray-100 dark:border-gray-800">
                            <td class="py-2 px-1 text-gray-900 dark:text-white">{{ $log->user->name }}</td>
                            <td class="py-2 px-1 hidden sm:table-cell text-gray-600 dark:text-gray-400 text-xs">{{ $log->action }}</td>
                            <td class="py-2 px-1 text-gray-500 dark:text-gray-400 text-xs">{{ $log->created_at->format('d M H:i') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="text-center py-4 text-gray-400 dark:text-gray-500">
                                Belum ada aktivitas
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection