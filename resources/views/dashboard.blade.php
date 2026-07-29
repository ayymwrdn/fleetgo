@extends('layouts.app')

@section('title', 'Dashboard - FleetGo')

@section('content')
<div class="space-y-6">
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="glass-card">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-text-light/60 dark:text-text-dark/60">Total Kendaraan</p>
                    <p class="text-3xl font-bold text-text-light dark:text-text-dark">{{ $totalVehicles }}</p>
                </div>
                <div class="text-3xl">🚗</div>
            </div>
        </div>
        
        <div class="glass-card">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-text-light/60 dark:text-text-dark/60">Pemesanan Bulan Ini</p>
                    <p class="text-3xl font-bold text-text-light dark:text-text-dark">{{ $thisMonthBookings }}</p>
                </div>
                <div class="text-3xl">📋</div>
            </div>
        </div>
        
        <div class="glass-card">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-text-light/60 dark:text-text-dark/60">Menunggu Approval</p>
                    <p class="text-3xl font-bold text-yellow-500">{{ $pendingApprovals }}</p>
                </div>
                <div class="text-3xl">⏳</div>
            </div>
        </div>
        
        <div class="glass-card">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-text-light/60 dark:text-text-dark/60">Kendaraan Digunakan</p>
                    <p class="text-3xl font-bold text-emerald-500">{{ $activeVehicles }}</p>
                </div>
                <div class="text-3xl">🔄</div>
            </div>
        </div>
    </div>
    
    <!-- Chart -->
    <div class="glass-card">
        <h3 class="text-lg font-semibold text-text-light dark:text-text-dark mb-4">📊 Statistik Pemesanan 6 Bulan Terakhir</h3>
        <canvas id="bookingChart" height="80"></canvas>
    </div>
    
    <!-- Recent Bookings -->
    <div class="glass-card">
        <div class="flex flex-wrap justify-between items-center mb-4 gap-2">
            <h3 class="text-lg font-semibold text-text-light dark:text-text-dark">📋 Pemesanan Terbaru</h3>
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('admin.bookings.create') }}" class="btn-primary text-sm">
                    + Buat Pemesanan
                </a>
                <a href="{{ route('admin.bookings.export') }}" class="btn-secondary text-sm">
                    📥 Export Excel
                </a>
                <a href="{{ route('admin.logs') }}" class="btn-secondary text-sm">
                    📜 Logs
                </a>
            </div>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-text-light/10 dark:border-text-dark/10">
                        <th class="text-left py-3 px-2 text-text-light/60 dark:text-text-dark/60">Kendaraan</th>
                        <th class="text-left py-3 px-2 text-text-light/60 dark:text-text-dark/60">Driver</th>
                        <th class="text-left py-3 px-2 text-text-light/60 dark:text-text-dark/60">Tanggal</th>
                        <th class="text-left py-3 px-2 text-text-light/60 dark:text-text-dark/60">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bookings as $booking)
                    <tr class="border-b border-text-light/5 dark:border-text-dark/5 hover:bg-white/5 transition">
                        <td class="py-3 px-2">{{ $booking->vehicle->name }}</td>
                        <td class="py-3 px-2">{{ $booking->driver->name }}</td>
                        <td class="py-3 px-2">{{ $booking->start_date->format('d M Y') }}</td>
                        <td class="py-3 px-2">
                            <span class="badge {{ $booking->getStatusBadgeClass() }}">
                                {{ $booking->getStatusLabel() }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center py-8 text-text-light/50 dark:text-text-dark/50">
                            Belum ada pemesanan
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('bookingChart').getContext('2d');
    const isDark = document.documentElement.classList.contains('dark');
    
    const textColor = isDark ? '#E8F0EC' : '#1A2E24';
    const gridColor = isDark ? 'rgba(255,255,255,0.1)' : 'rgba(0,0,0,0.1)';
    
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($chartLabels) !!},
            datasets: [{
                label: 'Jumlah Pemesanan',
                data: {!! json_encode($chartData) !!},
                backgroundColor: isDark ? 'rgba(6, 78, 43, 0.7)' : 'rgba(11, 122, 61, 0.7)',
                borderColor: isDark ? '#064E2B' : '#0B7A3D',
                borderWidth: 2,
                borderRadius: 8,
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    labels: { color: textColor }
                }
            },
            scales: {
                y: {
                    ticks: { color: textColor },
                    grid: { color: gridColor }
                },
                x: {
                    ticks: { color: textColor },
                    grid: { color: gridColor }
                }
            }
        }
    });
});
</script>
@endsection