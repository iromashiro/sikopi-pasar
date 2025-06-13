<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use RuntimeException;

class AuditLog extends Model
{
    public $timestamps = false;          // immutable
    protected $fillable = [
        'user_id',
        'action',
        'entity',
        'entity_id',
        'before',
        'after',
        'ip',
        'ua'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function save(array $options = [])
    {
        if ($this->exists) {
            throw new RuntimeException('Audit logs are immutable');
        }
        return parent::save($options);
    }
}
