<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DonationAssignment extends Model
{
    use HasFactory;

    protected $fillable = [
        'donation_id',
        'volunteer_id',
        'status',
        'assigned_at',
        'collected_at',
        'notes',
    ];

    protected $casts = [
        'assigned_at' => 'datetime',
        'collected_at' => 'datetime',
    ];

    public function donation()
    {
        return $this->belongsTo(Donation::class);
    }

    public function volunteer()
    {
        return $this->belongsTo(User::class, 'volunteer_id');
    }

    public function isCollected()
    {
        return !is_null($this->collected_at);
    }
} 