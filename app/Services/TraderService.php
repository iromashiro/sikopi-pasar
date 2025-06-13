<?php

namespace App\Services;

use App\Models\Trader;
use App\Models\TraderKiosk;
use App\Models\Kiosk;
use App\Services\Contracts\BaseService;
use Illuminate\Validation\ValidationException;

class TraderService extends BaseService
{
    public function __construct(protected AuditService $audit) {}

    public function store(array $data): Trader
    {
        return $this->withTransaction(function () use ($data) {
            $trader = Trader::create($data);
            $this->audit->log('created', $trader);
            return $trader;
        });
    }

    public function assignKiosk(Trader $trader, Kiosk $kiosk, string $startDate): TraderKiosk
    {
        return $this->withTransaction(function () use ($trader, $kiosk, $startDate) {
            $inUse = TraderKiosk::where('kiosk_id', $kiosk->id)
                ->whereNull('end_date')
                ->lockForUpdate()
                ->first();
            if ($inUse) {
                throw ValidationException::withMessages(['kiosk_id' => 'Kiosk already assigned.']);
            }

            $assignment = TraderKiosk::create([
                'trader_id' => $trader->id,
                'kiosk_id' => $kiosk->id,
                'start_date' => $startDate,
            ]);

            $kiosk->update(['status' => 'occupied']);
            $this->audit->log('assigned_kiosk', $assignment);
            \Log::info('Kiosk assigned', [
                'assignment_id' => $assignment->id,
                'by' => auth()->id()
            ]);
            return $assignment;
        });
    }
}
