<?php

namespace App\Exports;

use App\Models\Booking;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class BookingsExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Booking::with(['vehicle', 'driver', 'user'])
                     ->get()
                     ->map(function($booking) {
                         return [
                             'ID' => $booking->id,
                             'Kendaraan' => $booking->vehicle->name,
                             'Driver' => $booking->driver->name,
                             'Admin' => $booking->user->name,
                             'Tanggal Mulai' => $booking->start_date,
                             'Tanggal Selesai' => $booking->end_date,
                             'Tujuan' => $booking->purpose,
                             'Status' => $booking->getStatusLabel(),
                         ];
                     });
    }
    
    public function headings(): array
    {
        return [
            'ID', 'Kendaraan', 'Driver', 'Admin Input', 
            'Tanggal Mulai', 'Tanggal Selesai', 'Tujuan', 'Status'
        ];
    }
}