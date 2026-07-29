<?php

namespace Database\Seeders;

use App\Models\Vehicle;
use App\Models\Region;
use Illuminate\Database\Seeder;

class VehicleSeeder extends Seeder
{
    public function run()
    {
        $regions = Region::all();

        $vehicles = [
            // ===== KENDARAAN ANGKUTAN BARANG =====
            // 1. Dump Truck - Tambang A
            [
                'name' => 'Dump Truck Hino 500',
                'brand' => 'Hino',
                'plate_number' => 'KT 1234 NK',
                'type' => 'goods',
                'year' => 2023,
                'capacity' => 30,
                'ownership' => 'company',
                'status' => 'available',
                'fuel_consumption' => 5.2,
                'odometer' => 45000,
                'last_service_date' => '2026-07-01',
                'next_service_date' => '2026-10-01',
                'insurance_expiry' => '2027-01-15',
                'region_id' => $regions->where('name', 'Tambang A - Kalimantan')->first()->id,
            ],
            // 2. Dump Truck - Tambang B
            [
                'name' => 'Dump Truck Mitsubishi Fuso',
                'brand' => 'Mitsubishi',
                'plate_number' => 'KT 5678 NK',
                'type' => 'goods',
                'year' => 2022,
                'capacity' => 28,
                'ownership' => 'company',
                'status' => 'available',
                'fuel_consumption' => 5.5,
                'odometer' => 52000,
                'last_service_date' => '2026-06-15',
                'next_service_date' => '2026-09-15',
                'insurance_expiry' => '2026-12-10',
                'region_id' => $regions->where('name', 'Tambang B - Sulawesi')->first()->id,
            ],
            // 3. Dump Truck - Tambang C
            [
                'name' => 'Dump Truck Scania R450',
                'brand' => 'Scania',
                'plate_number' => 'KT 9012 NK',
                'type' => 'goods',
                'year' => 2024,
                'capacity' => 35,
                'ownership' => 'rental',
                'status' => 'available',
                'fuel_consumption' => 4.8,
                'odometer' => 18000,
                'last_service_date' => '2026-07-10',
                'next_service_date' => '2026-10-10',
                'insurance_expiry' => '2027-02-01',
                'region_id' => $regions->where('name', 'Tambang C - Sumatera')->first()->id,
            ],
            // 4. Wheel Loader - Tambang D
            [
                'name' => 'Wheel Loader Caterpillar 966',
                'brand' => 'Caterpillar',
                'plate_number' => 'KT 3456 NK',
                'type' => 'goods',
                'year' => 2022,
                'capacity' => 8,
                'ownership' => 'company',
                'status' => 'available',
                'fuel_consumption' => 3.5,
                'odometer' => 28000,
                'last_service_date' => '2026-05-20',
                'next_service_date' => '2026-08-20',
                'insurance_expiry' => '2026-11-05',
                'region_id' => $regions->where('name', 'Tambang D - Papua')->first()->id,
            ],
            // 5. Excavator - Tambang E
            [
                'name' => 'Excavator Komatsu PC400',
                'brand' => 'Komatsu',
                'plate_number' => 'KT 7890 NK',
                'type' => 'goods',
                'year' => 2023,
                'capacity' => 10,
                'ownership' => 'company',
                'status' => 'available',
                'fuel_consumption' => 3.2,
                'odometer' => 32000,
                'last_service_date' => '2026-06-01',
                'next_service_date' => '2026-09-01',
                'insurance_expiry' => '2026-12-20',
                'region_id' => $regions->where('name', 'Tambang E - Maluku')->first()->id,
            ],
            // 6. Bulldozer - Tambang F
            [
                'name' => 'Bulldozer Komatsu D85',
                'brand' => 'Komatsu',
                'plate_number' => 'KT 1122 NK',
                'type' => 'goods',
                'year' => 2021,
                'capacity' => 12,
                'ownership' => 'company',
                'status' => 'available',
                'fuel_consumption' => 3.0,
                'odometer' => 48000,
                'last_service_date' => '2026-04-15',
                'next_service_date' => '2026-07-15',
                'insurance_expiry' => '2026-10-10',
                'region_id' => $regions->where('name', 'Tambang F - Nusa Tenggara')->first()->id,
            ],
            // 7. Truk Nikel - Cabang
            [
                'name' => 'Truk Nikel Hino 700',
                'brand' => 'Hino',
                'plate_number' => 'KT 3344 NK',
                'type' => 'goods',
                'year' => 2023,
                'capacity' => 40,
                'ownership' => 'company',
                'status' => 'available',
                'fuel_consumption' => 4.5,
                'odometer' => 38000,
                'last_service_date' => '2026-06-20',
                'next_service_date' => '2026-09-20',
                'insurance_expiry' => '2027-01-20',
                'region_id' => $regions->where('type', 'cabang')->first()->id,
            ],
            // 8. Truk Nikel - Pusat
            [
                'name' => 'Truk Nikel Mitsubishi Fuso',
                'brand' => 'Mitsubishi',
                'plate_number' => 'KT 5566 NK',
                'type' => 'goods',
                'year' => 2024,
                'capacity' => 35,
                'ownership' => 'rental',
                'status' => 'available',
                'fuel_consumption' => 4.8,
                'odometer' => 15000,
                'last_service_date' => '2026-07-01',
                'next_service_date' => '2026-10-01',
                'insurance_expiry' => '2027-02-15',
                'region_id' => $regions->where('type', 'pusat')->first()->id,
            ],
            // ===== KENDARAAN ANGKUTAN ORANG =====
            // 9. Double Cabin - Tambang A
            [
                'name' => 'Toyota Hilux Double Cabin',
                'brand' => 'Toyota',
                'plate_number' => 'KT 7788 NK',
                'type' => 'people',
                'year' => 2023,
                'capacity' => 5,
                'ownership' => 'company',
                'status' => 'available',
                'fuel_consumption' => 12.5,
                'odometer' => 25000,
                'last_service_date' => '2026-06-10',
                'next_service_date' => '2026-09-10',
                'insurance_expiry' => '2026-12-15',
                'region_id' => $regions->where('name', 'Tambang A - Kalimantan')->first()->id,
            ],
            // 10. Double Cabin - Tambang C
            [
                'name' => 'Mitsubishi Triton Double Cabin',
                'brand' => 'Mitsubishi',
                'plate_number' => 'KT 9900 NK',
                'type' => 'people',
                'year' => 2022,
                'capacity' => 5,
                'ownership' => 'company',
                'status' => 'available',
                'fuel_consumption' => 13.0,
                'odometer' => 35000,
                'last_service_date' => '2026-05-15',
                'next_service_date' => '2026-08-15',
                'insurance_expiry' => '2026-11-20',
                'region_id' => $regions->where('name', 'Tambang C - Sumatera')->first()->id,
            ],
            // 11. SUV - Pusat
            [
                'name' => 'Toyota Fortuner',
                'brand' => 'Toyota',
                'plate_number' => 'KT 2233 NK',
                'type' => 'people',
                'year' => 2024,
                'capacity' => 7,
                'ownership' => 'company',
                'status' => 'available',
                'fuel_consumption' => 10.2,
                'odometer' => 12000,
                'last_service_date' => '2026-07-05',
                'next_service_date' => '2026-10-05',
                'insurance_expiry' => '2027-02-01',
                'region_id' => $regions->where('type', 'pusat')->first()->id,
            ],
            // 12. SUV - Cabang
            [
                'name' => 'Mitsubishi Pajero Sport',
                'brand' => 'Mitsubishi',
                'plate_number' => 'KT 4455 NK',
                'type' => 'people',
                'year' => 2023,
                'capacity' => 7,
                'ownership' => 'company',
                'status' => 'available',
                'fuel_consumption' => 9.8,
                'odometer' => 28000,
                'last_service_date' => '2026-06-25',
                'next_service_date' => '2026-09-25',
                'insurance_expiry' => '2027-01-10',
                'region_id' => $regions->where('type', 'cabang')->first()->id,
            ],
        ];

        foreach ($vehicles as $vehicle) {
            Vehicle::create($vehicle);
        }
    }
}