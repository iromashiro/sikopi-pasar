<?php

namespace App\Services;

use App\Models\Kiosk;
use App\Services\Contracts\BaseService;
use App\Services\AuditService;
use App\Exceptions\BusinessRuleException;

class KioskService extends BaseService
{
    public function __construct(protected AuditService $audit) {}

    public function store(array $data): Kiosk
    {
        return $this->withTransaction(function () use ($data) {
            $kiosk = Kiosk::create($data);
            $this->audit->log('created', $kiosk);
            return $kiosk;
        });
    }

    public function update(Kiosk $kiosk, array $data): Kiosk
    {
        return $this->withTransaction(function () use ($kiosk, $data) {
            $before = $kiosk->replicate()->toArray();
            $kiosk->update($data);
            $this->audit->log('updated', $kiosk, $before);
            return $kiosk;
        });
    }

    public function delete(Kiosk $kiosk): void
    {
        if ($kiosk->status === 'occupied') {
            throw new BusinessRuleException('BR-KIOSK-01', 'Cannot delete occupied kiosk');
        }

        $this->withTransaction(function () use ($kiosk) {
            $this->audit->log('deleted', $kiosk, $kiosk->toArray());
            $kiosk->delete();
        });
    }
}
