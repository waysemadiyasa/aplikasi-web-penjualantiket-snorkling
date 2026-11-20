<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'booking_id',
        'payment_method',
        'payment_provider',
        'transaction_id',
        'amount',
        'status',
        'paid_at',
        'proof_of_payment',
        'payment_notes',
        'verified_at'
    ];

    protected $casts = [
        'paid_at' => 'datetime',
        'verified_at' => 'datetime'
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
