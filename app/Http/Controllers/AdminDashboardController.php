<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // ============================================================
        // STATISTIK CARD
        // ============================================================
        $totalVehicles = Vehicle::count();
        $thisMonthBookings = Booking::whereMonth('created_at', now()->month)->count();
        $pendingApprovals = Booking::whereIn('status', ['pending_l1', 'pending_l2'])->count();
        $activeVehicles = Vehicle::where('status', 'in_use')->count();
        
        // ============================================================
        // GRAFIK 6 BULAN TERAKHIR
        // ============================================================
        $chartLabels = [];
        $chartData = [];
        
        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $chartLabels[] = $month->format('M Y');
            $chartData[] = Booking::whereYear('created_at', $month->year)
                                  ->whereMonth('created_at', $month->month)
                                  ->count();
        }
        
        // ============================================================
        // PEMESANAN TERBARU (10 data)
        // ============================================================
        $bookings = Booking::with(['vehicle', 'driver'])
                          ->latest()
                          ->take(10)
                          ->get();
        
        // ============================================================
        // KIRIM KE VIEW
        // ============================================================
        return view('admin.dashboard', compact(
            'totalVehicles',
            'thisMonthBookings',
            'pendingApprovals',
            'activeVehicles',
            'chartLabels',
            'chartData',
            'bookings'
        ));
    }
}