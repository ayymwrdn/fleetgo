@extends('layouts.app')

@section('title', 'Monitoring Kendaraan - FleetGo')

@section('content')
<div class="max-w-7xl mx-auto space-y-6">

    <!-- HEADER -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-lg bg-blue-50 dark:bg-blue-900/30 flex items-center justify-center text-blue-600 dark:text-blue-400">
                <i class="fas fa-truck text-lg"></i>
            </div>
            <div>
                <h2 class="text-xl font-bold text-gray-900 dark:text-white">Monitoring Kendaraan</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400">Total {{ $vehicles->count() }} kendaraan</p>
            </div>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('admin.vehicles.create') }}" class="btn-primary text-sm">
                <i class="fas fa-plus mr-1"></i>
                Tambah Kendaraan
            </a>
            <a href="{{ route('admin.dashboard') }}" class="btn-secondary text-sm">
                <i class="fas fa-arrow-left mr-1"></i>
                Kembali
            </a>
        </div>
    </div>

    <!-- STATISTIK CARD -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
        <div class="card p-3 text-center">
            <p class="text-xs text-gray-500 dark:text-gray-400">Total</p>
            <p class="text-xl font-bold text-gray-900 dark:text-white">{{ $totalVehicles ?? $vehicles->count() }}</p>
        </div>
        <div class="card p-3 text-center border-l-4 border-green-500">
            <p class="text-xs text-gray-500 dark:text-gray-400">Tersedia</p>
            <p class="text-xl font-bold text-green-600 dark:text-green-400">{{ $availableVehicles ?? $vehicles->where('status', 'available')->count() }}</p>
        </div>
        <div class="card p-3 text-center border-l-4 border-yellow-500">
            <p class="text-xs text-gray-500 dark:text-gray-400">Digunakan</p>
            <p class="text-xl font-bold text-yellow-600 dark:text-yellow-400">{{ $inUseVehicles ?? $vehicles->where('status', 'in_use')->count() }}</p>
        </div>
        <div class="card p-3 text-center border-l-4 border-red-500">
            <p class="text-xs text-gray-500 dark:text-gray-400">Perbaikan</p>
            <p class="text-xl font-bold text-red-600 dark:text-red-400">{{ $maintenanceVehicles ?? $vehicles->where('status', 'maintenance')->count() }}</p>
        </div>
    </div>

    <!-- FILTER & SEARCH -->
    <div class="card p-4">
        <form method="GET" action="{{ route('admin.vehicles.index') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
            <div>
                <label class="block text-xs text-gray-500 dark:text-gray-400 mb-1">Cari</label>
                <input type="text" name="search" value="{{ request('search') }}" 
                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-white text-sm focus:ring-2 focus:ring-green-500"
                       placeholder="Nama / Plat...">
            </div>
            
            <div>
                <label class="block text-xs text-gray-500 dark:text-gray-400 mb-1">Region</label>
                <select name="region" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-white text-sm focus:ring-2 focus:ring-green-500">
                    <option value="">Semua Region</option>
                    @foreach($regions ?? [] as $region)
                        <option value="{{ $region->id }}" {{ request('region') == $region->id ? 'selected' : '' }}>
                            {{ $region->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <div>
                <label class="block text-xs text-gray-500 dark:text-gray-400 mb-1">Status</label>
                <select name="status" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-white text-sm focus:ring-2 focus:ring-green-500">
                    <option value="">Semua Status</option>
                    <option value="available" {{ request('status') == 'available' ? 'selected' : '' }}>Tersedia</option>
                    <option value="in_use" {{ request('status') == 'in_use' ? 'selected' : '' }}>Digunakan</option>
                    <option value="maintenance" {{ request('status') == 'maintenance' ? 'selected' : '' }}>Perbaikan</option>
                </select>
            </div>
            
            <div class="flex items-end gap-2">
                <button type="submit" class="btn-primary text-sm w-full">
                    <i class="fas fa-search mr-1"></i>
                    Filter
                </button>
                <a href="{{ route('admin.vehicles.index') }}" class="btn-secondary text-sm w-full text-center">
                    <i class="fas fa-undo mr-1"></i>
                    Reset
                </a>
            </div>
        </form>
    </div>

    <!-- TABEL KENDARAAN -->
    <div class="card p-4 md:p-6">
        @if($vehicles->isEmpty())
            <div class="text-center py-8 text-gray-400 dark:text-gray-500">
                <i class="fas fa-inbox text-4xl block mb-2"></i>
                <p>Belum ada data kendaraan</p>
                <a href="{{ route('admin.vehicles.create') }}" class="btn-primary text-sm mt-2 inline-block">
                    <i class="fas fa-plus mr-1"></i>
                    Tambah Kendaraan
                </a>
            </div>
        @else
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-gray-200 dark:border-gray-700">
                        <th class="text-left py-3 px-3 text-gray-500 dark:text-gray-400 font-medium">Kendaraan</th>
                        <th class="text-left py-3 px-3 text-gray-500 dark:text-gray-400 font-medium hidden md:table-cell">Merek</th>
                        <th class="text-left py-3 px-3 text-gray-500 dark:text-gray-400 font-medium hidden md:table-cell">Plat</th>
                        <th class="text-left py-3 px-3 text-gray-500 dark:text-gray-400 font-medium hidden lg:table-cell">Region</th>
                        <th class="text-left py-3 px-3 text-gray-500 dark:text-gray-400 font-medium">Status</th>
                        <th class="text-left py-3 px-3 text-gray-500 dark:text-gray-400 font-medium">BBM</th>
                        <th class="text-left py-3 px-3 text-gray-500 dark:text-gray-400 font-medium hidden sm:table-cell">Service</th>
                        <th class="text-left py-3 px-3 text-gray-500 dark:text-gray-400 font-medium">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($vehicles as $vehicle)
                    <tr class="border-b border-gray-100 dark:border-gray-800 hover:bg-gray-50 dark:hover:bg-gray-800/50 transition">
                        <td class="py-3 px-3 font-medium text-gray-900 dark:text-white">
                            {{ $vehicle->name }}
                            @if($vehicle->next_service_date && \Carbon\Carbon::parse($vehicle->next_service_date)->diffInDays(now()) <= 30)
                                <span class="ml-2 text-xs px-2 py-0.5 rounded-full bg-orange-100 dark:bg-orange-900/30 text-orange-600 dark:text-orange-400">
                                    ⚠️ Service
                                </span>
                            @endif
                        </td>
                        <td class="py-3 px-3 hidden md:table-cell text-gray-600 dark:text-gray-400">{{ $vehicle->brand ?? '-' }}</td>
                        <td class="py-3 px-3 hidden md:table-cell text-gray-600 dark:text-gray-400">{{ $vehicle->plate_number }}</td>
                        <td class="py-3 px-3 hidden lg:table-cell text-gray-600 dark:text-gray-400">{{ $vehicle->region->name ?? '-' }}</td>
                        <td class="py-3 px-3">
                            <span class="badge 
                                @if($vehicle->status == 'available') badge-approved
                                @elseif($vehicle->status == 'in_use') badge-pending-l1
                                @else badge-rejected @endif">
                                {{ $vehicle->status }}
                            </span>
                        </td>
                        <td class="py-3 px-3 text-gray-600 dark:text-gray-400">{{ $vehicle->fuel_consumption ?? '-' }}</td>
                        <td class="py-3 px-3 hidden sm:table-cell text-gray-600 dark:text-gray-400">
                            {{ $vehicle->last_service_date ? \Carbon\Carbon::parse($vehicle->last_service_date)->format('d M Y') : '-' }}
                        </td>
                        <td class="py-3 px-3">
                            <div class="flex gap-2">
                                <!-- Detail -->
                                <a href="{{ route('admin.vehicles.show', $vehicle->id) }}" class="text-blue-600 dark:text-blue-400 hover:underline" title="Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <!-- Edit -->
                                <a href="{{ route('admin.vehicles.edit', $vehicle->id) }}" class="text-yellow-600 dark:text-yellow-400 hover:underline" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <!-- Delete -->
                                <form method="POST" action="{{ route('admin.vehicles.destroy', $vehicle->id) }}" class="inline" onsubmit="return confirm('Yakin ingin menghapus kendaraan {{ $vehicle->name }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 dark:text-red-400 hover:underline" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-submit search
    const searchInput = document.querySelector('input[name="search"]');
    if (searchInput) {
        searchInput.addEventListener('keyup', function() {
            if (this.value.length > 2 || this.value.length === 0) {
                this.closest('form').submit();
            }
        });
    }
});
</script>
@endsection