@extends('layouts.app')

@section('title', 'Tambah Kendaraan - FleetGo')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="card p-6 md:p-8">
        
        <div class="flex items-center gap-3 mb-6">
            <div class="w-10 h-10 rounded-lg bg-blue-50 dark:bg-blue-900/30 flex items-center justify-center text-blue-600 dark:text-blue-400">
                <i class="fas fa-plus-circle text-lg"></i>
            </div>
            <h2 class="text-xl font-bold text-gray-900 dark:text-white">Tambah Kendaraan Baru</h2>
        </div>
        
        <form method="POST" action="{{ route('admin.vehicles.store') }}">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Nama -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nama Kendaraan *</label>
                    <input type="text" name="name" value="{{ old('name') }}" class="input" required>
                    @error('name') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>
                
                <!-- Merek -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Merek</label>
                    <input type="text" name="brand" value="{{ old('brand') }}" class="input">
                    @error('brand') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>
                
                <!-- Plat -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Plat Nomor *</label>
                    <input type="text" name="plate_number" value="{{ old('plate_number') }}" class="input" required>
                    @error('plate_number') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>
                
                <!-- Tahun -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tahun</label>
                    <input type="number" name="year" value="{{ old('year') }}" class="input" min="2000" max="{{ date('Y') + 1 }}">
                    @error('year') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>
                
                <!-- Tipe -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tipe *</label>
                    <select name="type" class="input" required>
                        <option value="people" {{ old('type') == 'people' ? 'selected' : '' }}>Angkutan Orang</option>
                        <option value="goods" {{ old('type') == 'goods' ? 'selected' : '' }}>Angkutan Barang</option>
                    </select>
                    @error('type') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>
                
                <!-- Kapasitas -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Kapasitas (ton/orang)</label>
                    <input type="number" name="capacity" value="{{ old('capacity') }}" class="input" min="1">
                    @error('capacity') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>
                
                <!-- Kepemilikan -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Kepemilikan *</label>
                    <select name="ownership" class="input" required>
                        <option value="company" {{ old('ownership') == 'company' ? 'selected' : '' }}>Perusahaan</option>
                        <option value="rental" {{ old('ownership') == 'rental' ? 'selected' : '' }}>Sewa</option>
                    </select>
                    @error('ownership') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>
                
                <!-- Status -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Status *</label>
                    <select name="status" class="input" required>
                        <option value="available" {{ old('status') == 'available' ? 'selected' : '' }}>Tersedia</option>
                        <option value="in_use" {{ old('status') == 'in_use' ? 'selected' : '' }}>Digunakan</option>
                        <option value="maintenance" {{ old('status') == 'maintenance' ? 'selected' : '' }}>Perbaikan</option>
                    </select>
                    @error('status') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>
                
                <!-- BBM -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Konsumsi BBM (km/L)</label>
                    <input type="number" name="fuel_consumption" value="{{ old('fuel_consumption') }}" class="input" step="0.01" min="0">
                    @error('fuel_consumption') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>
                
                <!-- Odometer -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Odometer (km)</label>
                    <input type="number" name="odometer" value="{{ old('odometer') }}" class="input" min="0">
                    @error('odometer') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>
                
                <!-- Service Terakhir -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Service Terakhir</label>
                    <input type="date" name="last_service_date" value="{{ old('last_service_date') }}" class="input">
                    @error('last_service_date') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>
                
                <!-- Service Berikutnya -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Service Berikutnya</label>
                    <input type="date" name="next_service_date" value="{{ old('next_service_date') }}" class="input">
                    @error('next_service_date') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>
                
                <!-- Asuransi -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Asuransi Berakhir</label>
                    <input type="date" name="insurance_expiry" value="{{ old('insurance_expiry') }}" class="input">
                    @error('insurance_expiry') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>
                
                <!-- Region -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Region</label>
                    <select name="region_id" class="input">
                        <option value="">Pilih Region</option>
                        @foreach($regions as $region)
                            <option value="{{ $region->id }}" {{ old('region_id') == $region->id ? 'selected' : '' }}>
                                {{ $region->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('region_id') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>
            </div>
            
            <!-- Tombol -->
            <div class="flex flex-col sm:flex-row gap-3 pt-6 border-t border-gray-200 dark:border-gray-700 mt-4">
                <button type="submit" class="btn-primary flex-1">
                    <i class="fas fa-save mr-2"></i>
                    Simpan
                </button>
                <a href="{{ route('admin.vehicles.index') }}" class="btn-secondary flex-1 text-center">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Kembali
                </a>
            </div>
        </form>
    </div>
</div>
@endsection