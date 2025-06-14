<?php
// app/Models/Market.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Market extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'location',
        'status',
    ];

    public function kiosks()
    {
        return $this->hasMany(Kiosk::class);
    }

    public function activeKiosks()
    {
        return $this->hasMany(Kiosk::class)->where('status', '!=', 'inactive');
    }

    public function occupiedKiosks()
    {
        return $this->hasMany(Kiosk::class)->where('status', 'occupied');
    }
}
