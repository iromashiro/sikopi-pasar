<?php

namespace App\Services;

use App\Models\Market;
use App\Services\Contracts\BaseService;
use App\Services\AuditService;

class MarketService extends BaseService
{
    public function __construct(protected AuditService $audit) {}

    public function paginate(int $perPage = 20)
    {
        return Market::query()->latest()->paginate($perPage);
    }

    public function store(array $data): Market
    {
        return $this->withTransaction(function () use ($data) {
            $m = Market::create($data);
            $this->audit->log('created', $m);
            return $m;
        });
    }

    public function update(Market $market, array $data): Market
    {
        return $this->withTransaction(function () use ($market, $data) {
            $before = $market->replicate()->toArray();
            $market->update($data);
            $this->audit->log('updated', $market, $before);
            return $market;
        });
    }

    public function delete(Market $market): void
    {
        $this->withTransaction(function () use ($market) {
            $this->audit->log('deleted', $market, $market->toArray());
            $market->delete();
        });
    }
}
