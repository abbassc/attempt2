<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DonationStatus extends Model
{
    use HasFactory;

    protected $fillable = [
        'donation_id',
        'status',
        'notes',
        'updated_by',
    ];

    public function donation()
    {
        return $this->belongsTo(Donation::class);
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
} 