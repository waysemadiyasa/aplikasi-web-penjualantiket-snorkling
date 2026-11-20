<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $fillable = [
        'package_id',
        'travel_date',
        'departure_time',
        'quota',
        'available_seats',
        'is_active'
    ];

    protected $casts = [
        'travel_date' => 'date',
        'is_active' => 'boolean'
    ];

    public function package()
    {
        return $this->belongsTo(Package::class);
    }
}