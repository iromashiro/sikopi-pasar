<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TraderKiosk extends Model
{
    use HasFactory;

    protected $table = 'trader_kiosk'; // Eksplisit set nama tabel

    protected $fillable = [
        'trader_id',
        'kiosk_id',
        'start_date',
        'end_date',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function trader()
    {
        return $this->belongsTo(Trader::class);
    }

    public function kiosk()
    {
        return $this->belongsTo(Kiosk::class);
    }
}
