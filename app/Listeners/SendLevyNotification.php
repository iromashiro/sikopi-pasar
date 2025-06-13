<?php

namespace App\Listeners;

use App\Events\LevyGenerated;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendLevyNotification implements ShouldQueue
{
    public function handle(LevyGenerated $event): void
    {
        $trader = $event->levy->traderKiosk->trader;
        $trader->notify(new \App\Notifications\LevyCreatedNotification($event->levy));
    }
}
