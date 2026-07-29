@extends('layouts.app')

@section('title', 'Detail Kendaraan - FleetGo')

@section('content')
<div class="max-w-5xl mx-auto">
    <div class="card p-6">
        
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg bg-blue-50 dark:bg-blue-900/30 flex items-center justify-center text-blue-600 dark:text-blue-400">
                    <i class="fas fa-truck text-lg"></i>
                </div>
                <div>
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white">{{ $vehicle->name }}</h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ $vehicle->plate_number }}</p>
                </div>
            </div>
            <a href="{{ route('admin.vehicles.index') }}" class="btn-secondary text-sm">
                <i class="fas fa-arrow-left mr-1"></i>
                Kembali
            </a>
        </div>
        
        <!-- Info Kendaraan -->
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4 mb-6">
            <div class="p-3 rounded-lg bg-gray-50 dark:bg-gray-800/50 text-center">
                <p class="text-xs text-gray-500 dark:text-gray-400">Status</p>
                <p class="font-semibold text-gray-900 dark:text-white">
                    <span class="badge 
                        @if($vehicle->status == 'available') badge-approved
                        @elseif($vehicle->status == 'in_use') badge-pending-l1
                        @else badge-rejected @endif">
                        {{ $vehicle->status }}
                    </span>
                </p>
            </div>
            <div class="p-3 rounded-lg bg-gray-50 dark:bg-gray-800/50 text-center">
                <p class="text-xs text-gray-500 dark:text-gray-400">BBM</p>
                <p class="font-semibold text-gray-900 dark:text-white">{{ $vehicle->fuel_consumption ?? '-' }} km/L</p>
            </div>
            <div class="p-3 rounded-lg bg-gray-50 dark:bg-gray-800/50 text-center">
                <p class="text-xs text-gray-500 dark:text-gray-400">Service</p>
                <p class="font-semibold text-gray-900 dark:text-white">{{ $vehicle->last_service_date ? \Carbon\Carbon::parse($vehicle->last_service_date)->format('d M Y') : '-' }}</p>
            </div>
            <div class="p-3 rounded-lg bg-gray-50 dark:bg-gray-800/50 text-center">
                <p class="text-xs text-gray-500 dark:text-gray-400">Tipe</p>
                <p class="font-semibold text-gray-900 dark:text-white">{{ $vehicle->type }}</p>
            </div>
            <div class="p-3 rounded-lg bg-gray-50 dark:bg-gray-800/50 text-center">
                <p class="text-xs text-gray-500 dark:text-gray-400">Kepemilikan</p>
                <p class="font-semibold text-gray-900 dark:text-white">{{ $vehicle->ownership }}</p>
            </div>
        </div>
        
        <!-- Riwayat Pemakaian -->
        <div>
            <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-4">
                <i class="fas fa-history mr-2"></i>
                Riwayat Pemakaian (10 terakhir)
            </h3>
            
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-gray-200 dark:border-gray-700">
                            <th class="text-left py-2 px-2 text-gray-500 dark:text-gray-400">Driver</th>
                            <th class="text-left py-2 px-2 text-gray-500 dark:text-gray-400 hidden sm:table-cell">Tanggal</th>
                            <th class="text-left py-2 px-2 text-gray-500 dark:text-gray-400 hidden md:table-cell">Tujuan</th>
                            <th class="text-left py-2 px-2 text-gray-500 dark:text-gray-400">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($bookings as $booking)
                        <tr class="border-b border-gray-100 dark:border-gray-800">
                            <td class="py-2 px-2 text-gray-900 dark:text-white">{{ $booking->driver->name }}</td>
                            <td class="py-2 px-2 hidden sm:table-cell text-gray-600 dark:text-gray-400">{{ $booking->start_date->format('d M Y') }}</td>
                            <td class="py-2 px-2 hidden md:table-cell text-gray-600 dark:text-gray-400 text-xs">{{ Str::limit($booking->purpose, 30) }}</td>
                            <td class="py-2 px-2">
                                <span class="badge {{ $booking->getStatusBadgeClass() }}">
                                    {{ $booking->getStatusLabel() }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-4 text-gray-400 dark:text-gray-500">
                                Belum ada riwayat pemakaian
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