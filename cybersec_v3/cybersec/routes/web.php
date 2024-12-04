<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GoogleAuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Controllers\Auth\TwoFactorController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');

})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/admin-dashboard', function () {
    return view('admin-dashboard');

})->middleware(['auth', 'verified'])->name('admin-dashboard');

Route::post('twofactor/verify', [TwoFactorController::class, 'verify'])->name('twofactor.verify');

Route::get('/twofactor', function () {
    return view('auth.twoFactor');

})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
        // verificar se o controller ficou com o mesmo nome
        Route::get('/dashboard', [DashboardController::class, 'showWelcomePage'])->name('dashboard');
        Route::middleware(AdminMiddleware::class)->group(function () {
        Route::get('/admin-dashboard', [DashboardController::class, 'showAdminDashboard'])->name('admin-dashboard');
    });
});

Route::get('auth/google',[GoogleAuthController::class,'redirect'])->name('google-auth');
Route::get('auth/google/call-back',[GoogleAuthController::class,'callbackGoogle']);

require __DIR__.'/auth.php';
