<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Market extends Model
{
    protected $fillable = ['name', 'location', 'status'];

    public function kiosks()
    {
        return $this->hasMany(Kiosk::class);
    }
}
