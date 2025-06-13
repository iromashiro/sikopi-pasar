<?php

namespace App\Services;

use App\Models\AuditLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class AuditService
{
    public function log(string $action, Model $model, ?array $before = null): void
    {
        $req = app(Request::class);
        AuditLog::create([
            'user_id'   => auth()->id(),
            'action'    => $action,
            'entity'    => $model::class,
            'entity_id' => $model->getKey(),
            'before'    => $before,
            'after'     => $model->toArray(),
            'ip'        => $req->ip(),
            'ua'        => substr($req->userAgent(), 0, 512),
        ]);
    }
}
