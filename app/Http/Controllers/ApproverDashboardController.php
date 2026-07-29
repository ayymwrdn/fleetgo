<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\ActivityLog;
use App\Models\BookingApproval;
use Illuminate\Http\Request;

class ApproverDashboardController extends Controller
{
    /**
     * Menampilkan dashboard approver dengan semua data
     */
    public function index()
    {
        $user = auth()->user();
        
        // ============================================================
        // 1. BOOKINGS YANG MENUNGGU PERSETUJUAN
        // ============================================================
        if ($user->isLevel1()) {
            // Approver Level 1: lihat booking dengan status pending_l1
            $bookings = Booking::where('approver1_id', $user->id)
                              ->where('status', 'pending_l1')
                              ->with(['vehicle', 'driver', 'user'])
                              ->get();
        } elseif ($user->isLevel2()) {
            // Approver Level 2: lihat booking dengan status pending_l2
            $bookings = Booking::where('approver2_id', $user->id)
                              ->where('status', 'pending_l2')
                              ->with(['vehicle', 'driver', 'user'])
                              ->get();
        } else {
            $bookings = collect();
        }

        // ============================================================
        // 2. STATISTIK
        // ============================================================
        // Total pemesanan yang melibatkan approver ini
        $totalBookings = Booking::where(function($query) use ($user) {
            $query->where('approver1_id', $user->id)
                  ->orWhere('approver2_id', $user->id);
        })->count();

        // Jumlah yang menunggu persetujuan
        $pendingBookings = $bookings->count();

        // Jumlah yang sudah disetujui
        $approvedBookings = Booking::where(function($query) use ($user) {
            $query->where('approver1_id', $user->id)
                  ->orWhere('approver2_id', $user->id);
        })->where('status', 'approved')->count();

        // ============================================================
        // 3. PEMESANAN TERBARU (5 data)
        // ============================================================
        $recentBookings = Booking::with(['vehicle', 'driver'])
                                ->where(function($query) use ($user) {
                                    $query->where('approver1_id', $user->id)
                                          ->orWhere('approver2_id', $user->id);
                                })
                                ->latest()
                                ->take(5)
                                ->get();

        // ============================================================
        // 4. ACTIVITY LOGS TERBARU (5 data)
        // ============================================================
        $recentLogs = ActivityLog::with(['user'])
                                ->latest()
                                ->take(5)
                                ->get();

        // ============================================================
        // 5. KIRIM KE VIEW
        // ============================================================
        return view('approver.dashboard', compact(
            'bookings',           // Data booking yang menunggu persetujuan
            'totalBookings',      // Total pemesanan
            'pendingBookings',    // Jumlah menunggu persetujuan
            'approvedBookings',   // Jumlah sudah disetujui
            'recentBookings',     // 5 pemesanan terbaru
            'recentLogs'          // 5 aktivitas terbaru
        ));
    }
    
    /**
     * Menyetujui pemesanan
     */
    public function approve($id, Request $request)
    {
        $booking = Booking::findOrFail($id);
        $user = auth()->user();
        
        // Cek apakah approver berhak menyetujui
        if ($user->isLevel1() && $booking->approver1_id == $user->id && $booking->isPendingL1()) {
            // Level 1 menyetujui → lanjut ke level 2
            $booking->status = 'pending_l2';
            $message = 'Approval Level 1 disetujui! Menunggu approval Level 2.';
            
            // Update approval record level 1
            BookingApproval::where('booking_id', $booking->id)
                          ->where('level', 1)
                          ->update([
                              'status' => 'approved',
                              'approved_at' => now(),
                          ]);
            
        } elseif ($user->isLevel2() && $booking->approver2_id == $user->id && $booking->isPendingL2()) {
            // Level 2 menyetujui → final
            $booking->status = 'approved';
            $message = 'Booking #' . $booking->id . ' telah disetujui!';
            
            // Update approval record level 2
            BookingApproval::where('booking_id', $booking->id)
                          ->where('level', 2)
                          ->update([
                              'status' => 'approved',
                              'approved_at' => now(),
                          ]);
            
        } else {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses untuk menyetujui booking ini.');
        }
        
        $booking->save();
        
        // Log aktivitas
        ActivityLog::create([
            'user_id' => $user->id,
            'booking_id' => $booking->id,
            'action' => 'approve_booking',
            'description' => $user->name . ' menyetujui booking #' . $booking->id,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);
        
        return redirect()->back()->with('success', $message);
    }
    
    /**
     * Menolak pemesanan
     */
    public function reject($id, Request $request)
    {
        $booking = Booking::findOrFail($id);
        $user = auth()->user();
        
        // Cek apakah approver berhak menolak
        if (($user->isLevel1() && $booking->approver1_id == $user->id && $booking->isPendingL1()) ||
            ($user->isLevel2() && $booking->approver2_id == $user->id && $booking->isPendingL2())) {
            
            $booking->status = 'rejected';
            $booking->save();
            
            // Update approval record
            $level = $user->isLevel1() ? 1 : 2;
            BookingApproval::where('booking_id', $booking->id)
                          ->where('level', $level)
                          ->update([
                              'status' => 'rejected',
                              'approved_at' => now(),
                          ]);
            
            // Log aktivitas
            ActivityLog::create([
                'user_id' => $user->id,
                'booking_id' => $booking->id,
                'action' => 'reject_booking',
                'description' => $user->name . ' menolak booking #' . $booking->id,
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);
            
            return redirect()->back()->with('success', 'Booking #' . $booking->id . ' telah ditolak.');
        }
        
        return redirect()->back()->with('error', 'Anda tidak memiliki akses untuk menolak booking ini.');
    }
}