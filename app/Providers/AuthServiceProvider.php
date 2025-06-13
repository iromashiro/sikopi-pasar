<?php

namespace App\Providers;

use App\Models\Kiosk;
use App\Models\Market;
use App\Models\Trader;
use App\Policies\KioskPolicy;
use App\Policies\MarketPolicy;
use App\Policies\TraderPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Trader::class => TraderPolicy::class,
        Market::class => MarketPolicy::class,
        Kiosk::class  => KioskPolicy::class,
    ];

    public function boot(): void
    {
        $this->registerPolicies();
    }
}
