<?php

namespace App\Services\Levy;

use App\Models\Levy;
use App\Models\TraderKiosk;
use App\Services\Contracts\BaseService;
use App\Services\AuditService;
use App\Events\LevyGenerated;

class LevyService extends BaseService
{
    public function __construct(
        private LevyCalculationService $calc,
        private AuditService $audit
    ) {}

    public function generateFor(TraderKiosk $tk, string $period, \DateTimeInterface $due): Levy
    {
        return $this->withTransaction(function () use ($tk, $period, $due) {

            $amount = $this->calc->calculate($tk);
            $formulaVersion = $this->calc->getStrategy()->getFormula()->version ?? 1;

            $levy = Levy::updateOrCreate(
                ['trader_kiosk_id' => $tk->id, 'period_month' => $period],
                [
                    'due_date' => $due,
                    'amount' => $amount,
                    'status' => 'pending',
                    'formula_version' => $formulaVersion,
                ]
            );

            $this->audit->log('created', $levy);
            LevyGenerated::dispatch($levy);

            return $levy;
        });
    }
}
