<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\TraderController;
use App\Http\Controllers\Admin\KioskController;
use App\Http\Controllers\Admin\MarketController;
use App\Http\Controllers\Admin\LevyController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Trader\DashboardController as TraderDashboardController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    if (auth()->user()->hasRole('Trader')) {
        return redirect()->route('trader.dashboard');
    }
    return redirect()->route('admin.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin Routes (tanpa throttle)
Route::middleware(['auth', 'role:Admin|SuperAdmin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Traders
    Route::resource('traders', TraderController::class);
    Route::post('traders/{trader}/assign-kiosk', [TraderController::class, 'assignKiosk'])->name('traders.assign-kiosk');
    Route::delete('traders/{trader}/unassign-kiosk/{kiosk}', [TraderController::class, 'unassignKiosk'])->name('traders.unassign-kiosk');

    // Kiosks
    Route::resource('kiosks', KioskController::class);

    // Markets
    Route::resource('markets', MarketController::class);

    // Levies
    Route::resource('levies', LevyController::class);
    Route::post('levies/regenerate', [LevyController::class, 'regenerate'])->name('levies.regenerate');

    // Payments
    Route::resource('payments', PaymentController::class);
    Route::get('payments/{payment}/receipt', [PaymentController::class, 'receipt'])->name('payments.receipt');
    Route::get('payments/export', [PaymentController::class, 'export'])->name('payments.export');

    // Reports
    Route::get('reports/{type}', [ReportController::class, 'show'])->name('reports.show');
    Route::get('reports/{type}/export/{format}', [ReportController::class, 'export'])->name('reports.export');
});

// Trader Routes
Route::middleware(['auth', 'role:Trader'])->prefix('trader')->name('trader.')->group(function () {
    Route::get('/dashboard', [TraderDashboardController::class, 'index'])->name('dashboard');
});

require __DIR__ . '/auth.php';
