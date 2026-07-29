<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\BookingApproval;
use App\Models\Vehicle;
use App\Models\Driver;
use App\Models\User;
use App\Models\Region;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class BookingSeeder extends Seeder
{
    public function run()
    {
        $admin = User::where('email', 'admin@fleetgo.com')->first();
        $approver1 = User::where('email', 'sissy@fleetgo.com')->first();
        $approver2 = User::where('email', 'ayudya@fleetgo.com')->first();
        $vehicles = Vehicle::all();
        $drivers = Driver::all();
        $regions = Region::all();

        $bookings = [];
        $statuses = ['pending_l1', 'pending_l2', 'approved', 'rejected', 'completed'];
        $purposes = [
            'Pengangkutan bijih nikel dari tambang ke stockpile',
            'Pengiriman hasil tambang ke pelabuhan ekspor',
            'Mobilisasi alat berat ke lokasi tambang baru',
            'Survey geologi di area tambang',
            'Pengiriman dokumen penting ke kantor pusat',
            'Rapat koordinasi dengan dinas pertambangan',
            'Pengangkutan material tambang ke site B',
            'Pemantauan lingkungan di area pertambangan',
            'Pengiriman spare part ke bengkel tambang',
            'Inspeksi keselamatan kerja di lokasi tambang',
            'Pengangkutan nikel ke smelter',
            'Pengiriman sampel tanah ke laboratorium',
            'Pengambilan BBM di depot',
            'Pengiriman laporan ke kantor cabang',
            'Mobilisasi tim geologi ke site D',
            'Pengangkutan peralatan tambang',
            'Rapat evaluasi produksi tambang',
            'Pengiriman konsentrat nikel ke buyer',
            'Pengangkutan limbah tambang',
            'Pengiriman alat safety ke lokasi tambang',
        ];

        // Buat 50+ booking tersebar di 6 bulan terakhir
        for ($i = 0; $i < 55; $i++) {
            $monthOffset = rand(0, 5);
            $day = rand(1, 28);
            $month = Carbon::now()->subMonths($monthOffset);
            
            $startDate = Carbon::create($month->year, $month->month, $day, rand(6, 10), rand(0, 59), 0);
            $endDate = (clone $startDate)->addHours(rand(4, 12));
            
            $status = $statuses[array_rand($statuses)];
            $vehicle = $vehicles->random();
            $driver = $drivers->random();
            $region = $regions->random();

            $booking = Booking::create([
                'user_id' => $admin->id,
                'vehicle_id' => $vehicle->id,
                'driver_id' => $driver->id,
                'approver1_id' => $approver1->id,
                'approver2_id' => $approver2->id,
                'region_id' => $region->id,
                'start_date' => $startDate,
                'end_date' => $endDate,
                'purpose' => $purposes[array_rand($purposes)],
                'status' => $status,
                'created_at' => $startDate,
            ]);

            // ===== APPROVAL RECORDS =====
            if (in_array($status, ['pending_l2', 'approved', 'rejected', 'completed'])) {
                // Level 1
                $l1_status = in_array($status, ['approved', 'completed']) ? 'approved' : ($status == 'pending_l2' ? 'pending' : 'rejected');
                BookingApproval::create([
                    'booking_id' => $booking->id,
                    'approver_id' => $approver1->id,
                    'level' => 1,
                    'status' => $l1_status,
                    'approved_at' => in_array($status, ['approved', 'completed']) ? $startDate->addHours(2) : null,
                ]);
                
                // Level 2
                if (in_array($status, ['approved', 'completed'])) {
                    BookingApproval::create([
                        'booking_id' => $booking->id,
                        'approver_id' => $approver2->id,
                        'level' => 2,
                        'status' => 'approved',
                        'approved_at' => $startDate->addHours(4),
                    ]);
                } elseif ($status == 'pending_l2') {
                    BookingApproval::create([
                        'booking_id' => $booking->id,
                        'approver_id' => $approver2->id,
                        'level' => 2,
                        'status' => 'pending',
                        'approved_at' => null,
                    ]);
                } elseif ($status == 'rejected') {
                    BookingApproval::create([
                        'booking_id' => $booking->id,
                        'approver_id' => $approver2->id,
                        'level' => 2,
                        'status' => 'rejected',
                        'approved_at' => $startDate->addHours(3),
                    ]);
                }
            } else {
                // pending_l1
                BookingApproval::create([
                    'booking_id' => $booking->id,
                    'approver_id' => $approver1->id,
                    'level' => 1,
                    'status' => 'pending',
                    'approved_at' => null,
                ]);
                BookingApproval::create([
                    'booking_id' => $booking->id,
                    'approver_id' => $approver2->id,
                    'level' => 2,
                    'status' => 'pending',
                    'approved_at' => null,
                ]);
            }
        }

        // Tambah 5 booking aktif (hari ini)
        for ($i = 0; $i < 5; $i++) {
            $startDate = Carbon::now()->addDays($i + 1)->setHour(rand(6, 10));
            $endDate = (clone $startDate)->addHours(rand(4, 12));
            $vehicle = $vehicles->random();
            $driver = $drivers->random();
            $region = $regions->random();

            $booking = Booking::create([
                'user_id' => $admin->id,
                'vehicle_id' => $vehicle->id,
                'driver_id' => $driver->id,
                'approver1_id' => $approver1->id,
                'approver2_id' => $approver2->id,
                'region_id' => $region->id,
                'start_date' => $startDate,
                'end_date' => $endDate,
                'purpose' => $purposes[array_rand($purposes)],
                'status' => 'pending_l1',
                'created_at' => Carbon::now(),
            ]);

            BookingApproval::create([
                'booking_id' => $booking->id,
                'approver_id' => $approver1->id,
                'level' => 1,
                'status' => 'pending',
                'approved_at' => null,
            ]);
            BookingApproval::create([
                'booking_id' => $booking->id,
                'approver_id' => $approver2->id,
                'level' => 2,
                'status' => 'pending',
                'approved_at' => null,
            ]);
        }
    }
}