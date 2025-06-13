<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */

    protected $listen = [
        LevyGenerated::class    => [SendLevyNotification::class],
        PaymentRecorded::class  => [SendPaymentNotification::class, GenerateReceiptPdfJob::class],
    ];

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
