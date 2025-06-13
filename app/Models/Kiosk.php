<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kiosk extends Model
{
    protected $fillable = [
        'market_id',
        'kiosk_no',
        'category',
        'area_m2',
        'status'
    ];

    public function market()
    {
        return $this->belongsTo(Market::class);
    }

    public function traderAssignments()
    {
        return $this->hasMany(TraderKiosk::class);
    }

    public function scopeActive($q)
    {
        return $q->where('status', 'available')
            ->whereDoesntHave('traderAssignments', fn($s) => $s->whereNull('end_date'));
    }
}
