<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('levies', \App\Http\Controllers\Admin\LevyController::class)
        ->only(['index', 'store']);
    Route::post(
        'levies/regenerate',
        [\App\Http\Controllers\Admin\LevyController::class, 'regenerate']
    )
        ->name('levies.regenerate');

    Route::resource('payments', \App\Http\Controllers\Admin\PaymentController::class)
        ->only(['index', 'store']);
    Route::get('/admin/dashboard', \App\Http\Controllers\Admin\DashboardController::class)
        ->name('admin.dashboard');

    Route::prefix('admin/reports')->name('admin.reports.')
        ->middleware('role:Admin|SuperAdmin')
        ->group(function () {
            Route::get('{type}', [ReportController::class, 'show'])->name('show');
            Route::get('{type}/export', [ReportController::class, 'export'])->name('export');
        });
});

require __DIR__ . '/auth.php';
