<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TraderKiosk extends Model
{
    protected $table = 'trader_kiosk';
    public $timestamps = true;

    protected $fillable = ['trader_id', 'kiosk_id', 'start_date', 'end_date'];
    protected $dates   = ['start_date', 'end_date'];

    public function trader()
    {
        return $this->belongsTo(Trader::class);
    }
    public function kiosk()
    {
        return $this->belongsTo(Kiosk::class);
    }
}
