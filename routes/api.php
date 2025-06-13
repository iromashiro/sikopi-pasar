<?php

use Illuminate\Support\Facades\Route;

Route::prefix('v1')->middleware('auth:sanctum')->group(function () {
    Route::get(
        'levies/current',
        [\App\Http\Controllers\Api\Trader\LevyController::class, 'current']
    );
    Route::get(
        'payments/history',
        [\App\Http\Controllers\Api\Trader\PaymentController::class, 'history']
    );
});
