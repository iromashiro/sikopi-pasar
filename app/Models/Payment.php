<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'levy_id',
        'paid_at',
        'amount',
        'method',
        'receipt_no',
        'collector_name'
    ];
    protected $casts = ['paid_at' => 'date'];

    public function levy()
    {
        return $this->belongsTo(Levy::class);
    }
    public function receipt()
    {
        return $this->hasOne(Receipt::class);
    }
}
