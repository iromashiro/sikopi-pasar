<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Trader extends Model
{
    use SoftDeletes;

    protected $fillable = ['nik', 'name', 'address', 'phone', 'status'];
    protected $hidden   = ['nik'];                 // keep PII out of JSON
    protected $appends  = ['nik_masked'];

    /* Relations */
    public function kiosks()
    {
        return $this->belongsToMany(Kiosk::class, 'trader_kiosk')
            ->withPivot('start_date', 'end_date')
            ->withTimestamps();
    }
    public function activeKiosks()
    {
        return $this->kiosks()->wherePivotNull('end_date');
    }

    /* Accessor */
    public function getNikMaskedAttribute(): string
    {
        return substr($this->nik, 0, 6) . '******' . substr($this->nik, -4);
    }

    /* Override Array for SuperAdmin visibility */
    public function toArray()
    {
        $arr = parent::toArray();
        if (auth()->user()?->hasRole('SuperAdmin')) {
            $arr['nik_full'] = $this->nik;
        }
        return $arr;
    }
}
