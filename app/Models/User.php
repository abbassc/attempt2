<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'location',
        'role',
        'availability'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function donations()
    {
        return $this->hasMany(Donation::class, 'donor_id');
    }

    public function assignedDonations()
    {
        return $this->hasMany(Donation::class, 'volunteer_id');
    }

    public function donationAssignments()
    {
        return $this->hasMany(DonationAssignment::class, 'volunteer_id');
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isVolunteer()
    {
        return $this->role === 'volunteer';
    }

    public function isDonor()
    {
        return $this->role === 'donor';
    }
} 