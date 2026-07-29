<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Vehicle;
use App\Models\Driver;
use App\Models\User;
use App\Models\ActivityLog;
use App\Models\BookingApproval;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\BookingsExport;

class BookingController extends Controller
{
    /**
     * Menampilkan form pemesanan kendaraan
     */
    public function create()
    {
        // Ambil kendaraan yang tersedia
        $vehicles = Vehicle::where('status', 'available')->get();
        
        // Ambil driver yang tersedia
        $drivers = Driver::where('status', 'available')->get();
        
        // Ambil semua approver
        $approvers = User::where('role', 'approver')->get();
        
        return view('admin.create-booking', compact('vehicles', 'drivers', 'approvers'));
    }
    
    /**
     * Menyimpan pemesanan baru
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'vehicle_id' => 'required|exists:vehicles,id',
            'driver_id' => 'required|exists:drivers,id',
            'approver1_id' => 'required|exists:users,id',
            'approver2_id' => 'required|exists:users,id',
            'start_date' => 'required|date|after:now',
            'end_date' => 'required|date|after:start_date',
            'purpose' => 'required|string|min:10',
        ]);

        // 1. Buat booking
        $booking = Booking::create([
            'user_id' => auth()->id(),
            'vehicle_id' => $request->vehicle_id,
            'driver_id' => $request->driver_id,
            'approver1_id' => $request->approver1_id,
            'approver2_id' => $request->approver2_id,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'purpose' => $request->purpose,
            'status' => 'pending_l1',
        ]);

        // 2. Buat approval record level 1
        BookingApproval::create([
            'booking_id' => $booking->id,
            'approver_id' => $request->approver1_id,
            'level' => 1,
            'status' => 'pending',
        ]);

        // 3. Buat approval record level 2
        BookingApproval::create([
            'booking_id' => $booking->id,
            'approver_id' => $request->approver2_id,
            'level' => 2,
            'status' => 'pending',
        ]);

        // 4. Update status kendaraan menjadi in_use
        Vehicle::where('id', $request->vehicle_id)->update(['status' => 'in_use']);
        
        // 5. Update status driver menjadi assigned
        Driver::where('id', $request->driver_id)->update(['status' => 'assigned']);

        // 6. Log aktivitas
        ActivityLog::create([
            'user_id' => auth()->id(),
            'booking_id' => $booking->id,
            'action' => 'create_booking',
            'description' => auth()->user()->name . ' membuat pemesanan #' . $booking->id,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        // Redirect dengan pesan sukses
        return redirect()->route('admin.dashboard')
                         ->with('success', 'Pemesanan berhasil dibuat! Menunggu approval level 1.');
    }
    
    /**
     * Export data booking ke Excel
     */
    public function export()
    {
        return Excel::download(new BookingsExport, 'bookings-' . date('Y-m-d') . '.xlsx');
    }
}