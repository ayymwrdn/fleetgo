<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'plate_number',
        'type',
        'ownership',
        'status',
        'fuel_consumption',
        'last_service_date',
        'region_id', // Tambahkan ini
    ];

    protected $casts = [
        'last_service_date' => 'date',
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    // ===== RELASI KE REGION =====
    public function region()
    {
        return $this->belongsTo(Region::class);
    }
}