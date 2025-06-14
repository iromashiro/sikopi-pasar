<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kiosk extends Model
{
    use HasFactory;

    protected $fillable = [
        'market_id',
        'kiosk_no',
        'category',
        'area_m2',
        'status',
    ];

    protected $casts = [
        'area_m2' => 'decimal:2',
    ];

    public function market()
    {
        return $this->belongsTo(Market::class);
    }

    public function assignments()
    {
        return $this->hasMany(TraderKiosk::class);
    }

    public function activeAssignments()
    {
        return $this->hasMany(TraderKiosk::class)->whereNull('end_date');
    }

    // Perbaikan relasi currentTrader
    public function currentTrader()
    {
        return $this->belongsToMany(
            Trader::class,
            'trader_kiosk', // nama tabel pivot yang benar
            'kiosk_id',
            'trader_id'
        )->whereNull('trader_kiosk.end_date')
            ->withPivot(['start_date', 'end_date'])
            ->latest('trader_kiosk.start_date')
            ->limit(1);
    }

    // Alternative: menggunakan hasOne melalui TraderKiosk
    public function currentAssignment()
    {
        return $this->hasOne(TraderKiosk::class)->whereNull('end_date');
    }

    // Accessor untuk mendapatkan trader saat ini
    public function getCurrentTraderAttribute()
    {
        return $this->currentAssignment?->trader;
    }
}
