<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'phone',
        'type',
        'description',
        'occasion',
        'location',
        'date',
        'time',
        'status',
        'donor_id',
        'volunteer_id'
    ];

    protected $casts = [
        'needs_car' => 'boolean',
    ];

    public function donor()
    {
        return $this->belongsTo(User::class, 'donor_id');
    }

    public function volunteer()
    {
        return $this->belongsTo(User::class, 'volunteer_id');
    }

    public function assignments()
    {
        return $this->hasMany(DonationAssignment::class);
    }

    public function statuses()
    {
        return $this->hasMany(DonationStatus::class);
    }

    public function isAssigned()
    {
        return !is_null($this->volunteer_id);
    }

    public function isCollected()
    {
        return $this->status === 'collected';
    }

    public function isPending()
    {
        return $this->status === 'pending';
    }
} 