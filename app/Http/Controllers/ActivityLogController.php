<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    /**
     * Menampilkan semua aktivitas log
     */
    public function index()
    {
        // Ambil semua log dengan relasi user dan booking
        // Urutkan dari yang terbaru, paginate 20 per halaman
        $logs = ActivityLog::with(['user', 'booking'])
                          ->latest()
                          ->paginate(20);
        
        return view('admin.logs', compact('logs'));
    }
}