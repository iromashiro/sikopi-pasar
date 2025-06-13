<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Levy extends Model
{
    protected $fillable = [
        'trader_kiosk_id',
        'period_month',
        'due_date',
        'amount',
        'status',
        'formula_version'
    ];

    protected $casts = [
        'due_date' => 'date',
    ];

    // relationships
    public function traderKiosk()
    {
        return $this->belongsTo(TraderKiosk::class);
    }
    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    // scopes
    public function scopeCurrentPeriod($q, string $period)
    {
        return $q->where('period_month', $period);
    }
}
