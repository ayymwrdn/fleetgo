<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'approval_level',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isApprover()
    {
        return $this->role === 'approver';
    }

    public function isLevel1()
    {
        return $this->isApprover() && $this->approval_level === 1;
    }

    public function isLevel2()
    {
        return $this->isApprover() && $this->approval_level === 2;
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class, 'user_id');
    }

    public function logs()
    {
        return $this->hasMany(ActivityLog::class);
    }
}