<?php

namespace Database\Seeders;

use App\Models\Region;
use Illuminate\Database\Seeder;

class RegionSeeder extends Seeder
{
    public function run()
    {
        $regions = [
            ['name' => 'Kantor Pusat Jakarta', 'type' => 'pusat', 'location' => 'Jakarta'],
            ['name' => 'Kantor Cabang Surabaya', 'type' => 'cabang', 'location' => 'Surabaya'],
            ['name' => 'Tambang A - Kalimantan', 'type' => 'tambang', 'location' => 'Kalimantan'],
            ['name' => 'Tambang B - Sulawesi', 'type' => 'tambang', 'location' => 'Sulawesi'],
            ['name' => 'Tambang C - Sumatera', 'type' => 'tambang', 'location' => 'Sumatera'],
            ['name' => 'Tambang D - Papua', 'type' => 'tambang', 'location' => 'Papua'],
            ['name' => 'Tambang E - Maluku', 'type' => 'tambang', 'location' => 'Maluku'],
            ['name' => 'Tambang F - Nusa Tenggara', 'type' => 'tambang', 'location' => 'Nusa Tenggara'],
        ];

        foreach ($regions as $region) {
            Region::create($region);
        }
    }
}