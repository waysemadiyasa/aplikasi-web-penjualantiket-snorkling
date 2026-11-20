<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'booking_code',
        'user_id',
        'customer_name',
        'email',
        'phone',
        'total_amount',
        'status',
        'notes'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function details()
    {
        return $this->hasMany(BookingDetail::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}