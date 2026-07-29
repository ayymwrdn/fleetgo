<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'vehicle_id',
        'driver_id',
        'approver1_id',
        'approver2_id',
        'region_id', // Tambahkan ini
        'start_date',
        'end_date',
        'purpose',
        'status',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }

    public function approver1()
    {
        return $this->belongsTo(User::class, 'approver1_id');
    }

    public function approver2()
    {
        return $this->belongsTo(User::class, 'approver2_id');
    }

    // ===== RELASI KE REGION =====
    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    public function approvals()
    {
        return $this->hasMany(BookingApproval::class);
    }

    public function logs()
    {
        return $this->hasMany(ActivityLog::class);
    }

    public function isPendingL1()
    {
        return $this->status === 'pending_l1';
    }

    public function isPendingL2()
    {
        return $this->status === 'pending_l2';
    }

    public function getStatusLabel()
    {
        return match($this->status) {
            'pending_l1' => 'Menunggu Approval L1',
            'pending_l2' => 'Menunggu Approval L2',
            'approved' => 'Disetujui',
            'rejected' => 'Ditolak',
            'completed' => 'Selesai',
            default => $this->status,
        };
    }

    public function getStatusBadgeClass()
    {
        return match($this->status) {
            'pending_l1' => 'badge-pending-l1',
            'pending_l2' => 'badge-pending-l2',
            'approved' => 'badge-approved',
            'rejected' => 'badge-rejected',
            'completed' => 'badge-completed',
            default => '',
        };
    }
}