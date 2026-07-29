@extends('layouts.app')

@section('title', 'Buat Pemesanan - FleetGo')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="card p-6 md:p-8">
        
        <div class="flex items-center gap-3 mb-6">
            <div class="w-10 h-10 rounded-lg bg-green-50 dark:bg-green-900/30 flex items-center justify-center text-green-600 dark:text-green-400">
                <i class="fas fa-plus-circle text-lg"></i>
            </div>
            <h2 class="text-xl font-bold text-gray-900 dark:text-white">Buat Pemesanan Kendaraan</h2>
        </div>
        
        <form method="POST" action="{{ route('admin.bookings.store') }}">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Vehicle -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Kendaraan</label>
                    <select name="vehicle_id" class="input" required>
                        <option value="">Pilih Kendaraan</option>
                        @foreach($vehicles ?? [] as $vehicle)
                            <option value="{{ $vehicle->id }}" {{ old('vehicle_id') == $vehicle->id ? 'selected' : '' }}>
                                {{ $vehicle->name }} - {{ $vehicle->plate_number }}
                                ({{ $vehicle->ownership }})
                            </option>
                        @endforeach
                    </select>
                    @error('vehicle_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Driver -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Driver</label>
                    <select name="driver_id" class="input" required>
                        <option value="">Pilih Driver</option>
                        @foreach($drivers ?? [] as $driver)
                            <option value="{{ $driver->id }}" {{ old('driver_id') == $driver->id ? 'selected' : '' }}>
                                {{ $driver->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('driver_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Approver Level 1 -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Approver Level 1</label>
                    <select name="approver1_id" class="input" required>
                        <option value="">Pilih Approver L1</option>
                        @foreach($approvers->where('approval_level', 1) ?? [] as $approver)
                            <option value="{{ $approver->id }}" {{ old('approver1_id') == $approver->id ? 'selected' : '' }}>
                                {{ $approver->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('approver1_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Approver Level 2 -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Approver Level 2</label>
                    <select name="approver2_id" class="input" required>
                        <option value="">Pilih Approver L2</option>
                        @foreach($approvers->where('approval_level', 2) ?? [] as $approver)
                            <option value="{{ $approver->id }}" {{ old('approver2_id') == $approver->id ? 'selected' : '' }}>
                                {{ $approver->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('approver2_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Start Date -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tanggal Mulai</label>
                    <input type="datetime-local" name="start_date" class="input" required
                           value="{{ old('start_date') }}">
                    @error('start_date')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- End Date -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tanggal Selesai</label>
                    <input type="datetime-local" name="end_date" class="input" required
                           value="{{ old('end_date') }}">
                    @error('end_date')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Purpose -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tujuan Pemesanan</label>
                    <textarea name="purpose" rows="3" class="input" required placeholder="Jelaskan tujuan pemesanan...">{{ old('purpose') }}</textarea>
                    @error('purpose')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <div class="flex flex-col sm:flex-row gap-3 pt-6 border-t border-gray-200 dark:border-gray-700 mt-4">
                <button type="submit" class="btn-primary flex-1">
                    <i class="fas fa-check mr-2"></i>
                    Simpan Pemesanan
                </button>
                <a href="{{ route('admin.dashboard') }}" class="btn-secondary flex-1 text-center">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Kembali
                </a>
            </div>
        </form>
    </div>
</div>
@endsection