<?php

namespace Database\Seeders;

use App\Models\Driver;
use Illuminate\Database\Seeder;

class DriverSeeder extends Seeder
{
    public function run()
    {
        $drivers = [
            ['name' => 'Agus Wijaya', 'license_number' => 'SIM-001-2024', 'phone' => '081234567890'],
            ['name' => 'Budi Santoso', 'license_number' => 'SIM-002-2024', 'phone' => '081234567891'],
            ['name' => 'Siti Rahayu', 'license_number' => 'SIM-003-2024', 'phone' => '081234567892'],
            ['name' => 'Dedi Kurniawan', 'license_number' => 'SIM-004-2024', 'phone' => '081234567893'],
            ['name' => 'Rina Susanti', 'license_number' => 'SIM-005-2024', 'phone' => '081234567894'],
            ['name' => 'Herman Setiawan', 'license_number' => 'SIM-006-2024', 'phone' => '081234567895'],
            ['name' => 'Yuni Astuti', 'license_number' => 'SIM-007-2024', 'phone' => '081234567896'],
            ['name' => 'Rudi Hartono', 'license_number' => 'SIM-008-2024', 'phone' => '081234567897'],
        ];

        foreach ($drivers as $driver) {
            Driver::create($driver);
        }
    }
}