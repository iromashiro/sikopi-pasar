<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LevyFormula extends Model
{
    protected $fillable = [
        'base_rate',
        'category_mult',
        'area_mult',
        'overrides',
        'version',
        'effective_date'
    ];

    protected $casts = [
        'overrides' => 'array',
        'effective_date' => 'date',
    ];
}
