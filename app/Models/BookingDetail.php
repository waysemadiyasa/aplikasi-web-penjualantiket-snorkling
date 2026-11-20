<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookingDetail extends Model
{
    protected $fillable = [
        'booking_id',
        'package_id',
        'schedule_id',
        'quantity',
        'price',
        'subtotal'
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }
}