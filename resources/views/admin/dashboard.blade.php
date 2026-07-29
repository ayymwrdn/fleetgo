@extends('layouts.app')

@section('title', 'Dashboard - FleetGo')

@section('content')

<!-- ============================================================
     STATISTIK CARD
     ============================================================ -->
<div class="grid grid-cols-2 lg:grid-cols-4 gap-3 md:gap-4 mb-6">
    <!-- Total Kendaraan -->
    <div class="card p-4 md:p-5 hover:shadow-lg transition-shadow duration-300">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs md:text-sm text-gray-500 dark:text-gray-400">Total Kendaraan</p>
                <p class="text-xl md:text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ $totalVehicles ?? 0 }}</p>
            </div>
            <div class="w-10 h-10 md:w-12 md:h-12 rounded-xl bg-green-100 dark:bg-green-900/30 flex items-center justify-center text-green-600 dark:text-green-400">
                <i class="fas fa-truck text-base md:text-lg"></i>
            </div>
        </div>
    </div>

    <!-- Pemesanan Bulan Ini -->
    <div class="card p-4 md:p-5 hover:shadow-lg transition-shadow duration-300">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs md:text-sm text-gray-500 dark:text-gray-400">Pemesanan Bulan Ini</p>
                <p class="text-xl md:text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ $thisMonthBookings ?? 0 }}</p>
            </div>
            <div class="w-10 h-10 md:w-12 md:h-12 rounded-xl bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center text-blue-600 dark:text-blue-400">
                <i class="fas fa-calendar-alt text-base md:text-lg"></i>
            </div>
        </div>
    </div>

    <!-- Menunggu Approval -->
    <div class="card p-4 md:p-5 hover:shadow-lg transition-shadow duration-300">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs md:text-sm text-gray-500 dark:text-gray-400">Menunggu Approval</p>
                <p class="text-xl md:text-2xl font-bold text-amber-600 dark:text-amber-400 mt-1">{{ $pendingApprovals ?? 0 }}</p>
            </div>
            <div class="w-10 h-10 md:w-12 md:h-12 rounded-xl bg-amber-100 dark:bg-amber-900/30 flex items-center justify-center text-amber-600 dark:text-amber-400">
                <i class="fas fa-clock text-base md:text-lg"></i>
            </div>
        </div>
    </div>

    <!-- Kendaraan Digunakan -->
    <div class="card p-4 md:p-5 hover:shadow-lg transition-shadow duration-300">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs md:text-sm text-gray-500 dark:text-gray-400">Kendaraan Digunakan</p>
                <p class="text-xl md:text-2xl font-bold text-emerald-600 dark:text-emerald-400 mt-1">{{ $activeVehicles ?? 0 }}</p>
            </div>
            <div class="w-10 h-10 md:w-12 md:h-12 rounded-xl bg-emerald-100 dark:bg-emerald-900/30 flex items-center justify-center text-emerald-600 dark:text-emerald-400">
                <i class="fas fa-play-circle text-base md:text-lg"></i>
            </div>
        </div>
    </div>
</div>

<!-- ============================================================
     GRAFIK + DATA BULAN
     ============================================================ -->
<div class="grid grid-cols-1 lg:grid-cols-4 gap-6 mb-6">

    <!-- GRAFIK (3/4) -->
    <div class="lg:col-span-3 card p-4 md:p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-300">
                <i class="fas fa-chart-bar mr-2 text-green-500"></i>
                Statistik Pemesanan 6 Bulan Terakhir
            </h3>
            <span class="text-xs text-gray-400 dark:text-gray-500">
                <i class="fas fa-calendar-alt mr-1"></i>
                {{ now()->subMonths(5)->format('M Y') }} - {{ now()->format('M Y') }}
            </span>
        </div>

        @if(empty($chartLabels) || empty($chartData) || count($chartData) == 0)
            <div class="text-center py-8 text-gray-400 dark:text-gray-500">
                <i class="fas fa-chart-simple text-4xl block mb-2"></i>
                <p>Belum ada data pemesanan</p>
            </div>
        @else
            <div class="relative" style="height: 240px;">
                <canvas id="bookingChart"></canvas>
            </div>
        @endif
    </div>

    <!-- DATA BULAN (1/4) -->
    <div class="lg:col-span-1 card p-4 md:p-6">
        <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">
            <i class="fas fa-info-circle mr-2 text-blue-500"></i>
            Detail Bulan
        </h3>
        <p class="text-xs text-gray-400 dark:text-gray-500 mb-3">Klik bulan untuk detail</p>

        <div id="monthDetail" class="space-y-2 max-h-[220px] overflow-y-auto pr-1 custom-scroll">
            @if(!empty($chartLabels) && !empty($chartData) && count($chartData) > 0)
                @php
                    $maxData = max($chartData) > 0 ? max($chartData) : 1;
                @endphp
                @foreach($chartLabels as $index => $label)
                <div class="month-item p-2.5 rounded-xl cursor-pointer transition-all duration-200 border-2 border-transparent hover:border-green-500 dark:hover:border-green-400 bg-gray-50 dark:bg-gray-800/50 hover:bg-green-50 dark:hover:bg-green-900/20"
                     data-month="{{ $label }}"
                     data-count="{{ $chartData[$index] ?? 0 }}"
                     onclick="showMonthDetail('{{ $label }}', '{{ $chartData[$index] ?? 0 }}', this)">
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ $label }}</span>
                        <span class="text-sm font-bold text-green-600 dark:text-green-400">{{ $chartData[$index] ?? 0 }}</span>
                    </div>
                    <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-1.5 mt-1">
                        <div class="bg-gradient-to-r from-green-400 to-emerald-500 dark:from-green-500 dark:to-emerald-400 h-1.5 rounded-full transition-all duration-700"
                             style="width: {{ max(5, ($chartData[$index] ?? 0) / $maxData * 100) }}%"></div>
                    </div>
                </div>
                @endforeach
            @else
                <div class="text-center py-6 text-gray-400 dark:text-gray-500">
                    <i class="fas fa-inbox text-2xl block mb-2"></i>
                    <p class="text-sm">Belum ada data</p>
                </div>
            @endif
        </div>

        <!-- Total footer -->
        <div class="mt-3 pt-3 border-t border-gray-200 dark:border-gray-700">
            <div class="flex justify-between text-sm">
                <span class="text-gray-500 dark:text-gray-400">Total 6 Bulan</span>
                <span class="font-bold text-gray-900 dark:text-white">{{ array_sum($chartData ?? []) }}</span>
            </div>
        </div>
    </div>
</div>

<!-- ============================================================
     PEMESANAN TERBARU + TOMBOL
     ============================================================ -->
<div class="card p-4 md:p-6 mb-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-4">
        <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-300">
            <i class="fas fa-list mr-2 text-blue-500"></i>
            Pemesanan Terbaru
        </h3>
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('admin.bookings.create') }}" class="btn-primary text-sm">
                <i class="fas fa-plus mr-1"></i>
                Buat Pemesanan
            </a>
            <a href="{{ route('admin.vehicles.index') }}" class="btn-secondary text-sm">
                <i class="fas fa-truck mr-1"></i>
                Monitoring
            </a>
            <a href="{{ route('admin.bookings.export') }}" class="btn-secondary text-sm">
                <i class="fas fa-file-excel mr-1"></i>
                Export
            </a>
            <a href="{{ route('admin.logs') }}" class="btn-secondary text-sm">
                <i class="fas fa-history mr-1"></i>
                Logs
            </a>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-gray-200 dark:border-gray-700">
                    <th class="text-left py-3 px-3 text-gray-500 dark:text-gray-400 font-medium">Kendaraan</th>
                    <th class="text-left py-3 px-3 text-gray-500 dark:text-gray-400 font-medium hidden sm:table-cell">Driver</th>
                    <th class="text-left py-3 px-3 text-gray-500 dark:text-gray-400 font-medium hidden md:table-cell">Tanggal</th>
                    <th class="text-left py-3 px-3 text-gray-500 dark:text-gray-400 font-medium">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($bookings ?? [] as $booking)
                <tr class="border-b border-gray-100 dark:border-gray-800 hover:bg-gray-50 dark:hover:bg-gray-800/50 transition">
                    <td class="py-3 px-3 font-medium text-gray-900 dark:text-white">{{ $booking->vehicle->name }}</td>
                    <td class="py-3 px-3 hidden sm:table-cell text-gray-600 dark:text-gray-400">{{ $booking->driver->name }}</td>
                    <td class="py-3 px-3 hidden md:table-cell text-gray-600 dark:text-gray-400">{{ $booking->start_date->format('d M Y') }}</td>
                    <td class="py-3 px-3">
                        <span class="badge {{ $booking->getStatusBadgeClass() }}">
                            {{ $booking->getStatusLabel() }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center py-8 text-gray-400 dark:text-gray-500">
                        <i class="fas fa-inbox text-2xl block mb-2"></i>
                        Belum ada pemesanan
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- ============================================================
     SCRIPT CHART.JS
     ============================================================ -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const canvas = document.getElementById('bookingChart');
    if (!canvas) return;

    const ctx = canvas.getContext('2d');
    const isDark = document.documentElement.classList.contains('dark');

    const labels = {!! json_encode($chartLabels ?? []) !!};
    const data = {!! json_encode($chartData ?? []) !!};

    if (labels.length === 0 || data.length === 0) {
        if (canvas.parentElement) {
            canvas.parentElement.innerHTML = `
                <div class="text-center py-8 text-gray-400 dark:text-gray-500">
                    <i class="fas fa-chart-simple text-4xl block mb-2"></i>
                    <p>Belum ada data pemesanan</p>
                    <p class="text-xs mt-1">Buat pemesanan atau jalankan seeder</p>
                </div>
            `;
        }
        return;
    }

    // Gradient warna
    const gradient = ctx.createLinearGradient(0, 0, 0, 200);
    gradient.addColorStop(0, isDark ? 'rgba(52, 211, 153, 0.9)' : 'rgba(16, 185, 129, 0.9)');
    gradient.addColorStop(1, isDark ? 'rgba(52, 211, 153, 0.1)' : 'rgba(16, 185, 129, 0.1)');

    const chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Jumlah Pemesanan',
                data: data,
                backgroundColor: gradient,
                borderColor: isDark ? '#34d399' : '#10b981',
                borderWidth: 2,
                borderRadius: 6,
                barPercentage: 0.55,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false,
                },
                tooltip: {
                    backgroundColor: isDark ? 'rgba(31, 41, 55, 0.9)' : 'rgba(255, 255, 255, 0.9)',
                    titleColor: isDark ? '#f3f4f6' : '#1f2937',
                    bodyColor: isDark ? '#d1d5db' : '#4b5563',
                    borderColor: isDark ? '#374151' : '#e5e7eb',
                    borderWidth: 1,
                    padding: 10,
                    cornerRadius: 8,
                    callbacks: {
                        label: function(context) {
                            return context.parsed.y + ' pemesanan';
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        color: isDark ? '#9ca3af' : '#6b7280',
                        font: { size: 10 },
                        stepSize: 1,
                        padding: 4
                    },
                    grid: {
                        color: isDark ? 'rgba(255,255,255,0.05)' : 'rgba(0,0,0,0.05)',
                        drawBorder: false
                    }
                },
                x: {
                    ticks: {
                        color: isDark ? '#9ca3af' : '#6b7280',
                        font: { size: 10 },
                        padding: 4,
                    },
                    grid: {
                        display: false
                    }
                }
            },
            onClick: function(event, elements) {
                if (elements && elements.length > 0) {
                    const index = elements[0].datasetIndex;
                    const label = this.data.labels[index];
                    const value = this.data.datasets[0].data[index];
                    showMonthDetail(label, value);
                }
            },
            animation: {
                duration: 800,
                easing: 'easeOutQuart'
            }
        }
    });

    window.showMonthDetail = function(label, count, element) {
        document.querySelectorAll('.month-item').forEach(el => {
            el.classList.remove('border-green-500', 'dark:border-green-400', 'bg-green-50', 'dark:bg-green-900/20');
            el.classList.add('border-transparent');
        });

        if (element) {
            element.classList.remove('border-transparent');
            element.classList.add('border-green-500', 'dark:border-green-400', 'bg-green-50', 'dark:bg-green-900/20');
        }

        alert(`📊 Detail Bulan: ${label}\n\nTotal Pemesanan: ${count} booking`);
    };
});

// Auto-highlight bulan dengan data terbanyak
document.addEventListener('DOMContentLoaded', function() {
    const items = document.querySelectorAll('.month-item');
    if (items.length > 0) {
        let maxCount = -1;
        let maxIndex = 0;
        items.forEach((item, index) => {
            const count = parseInt(item.dataset.count) || 0;
            if (count > maxCount) {
                maxCount = count;
                maxIndex = index;
            }
        });
        if (maxCount > 0) {
            const el = items[maxIndex];
            el.classList.add('border-green-500', 'dark:border-green-400', 'bg-green-50', 'dark:bg-green-900/20');
        }
    }
});
</script>

<style>
/* Animasi hover month item */
.month-item {
    transition: all 0.2s ease;
}
.month-item:hover {
    transform: translateX(4px);
}

/* Custom scroll detail bulan */
.custom-scroll::-webkit-scrollbar {
    width: 4px;
}
.custom-scroll::-webkit-scrollbar-track {
    background: #f3f4f6;
    border-radius: 9999px;
}
.dark .custom-scroll::-webkit-scrollbar-track {
    background: #1f2937;
}
.custom-scroll::-webkit-scrollbar-thumb {
    background: #22c55e;
    border-radius: 9999px;
}
.dark .custom-scroll::-webkit-scrollbar-thumb {
    background: #4ade80;
}
.custom-scroll::-webkit-scrollbar-thumb:hover {
    background: #16a34a;
}
.dark .custom-scroll::-webkit-scrollbar-thumb:hover {
    background: #22c55e;
}
</style>
@endsection