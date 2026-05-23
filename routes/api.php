<?php

use App\Http\Controllers\MassNotificationController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\SubscriberController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('/user', function (Request $request) {
    return $request->user();
})->name('user');

Route::prefix('notifications')->group(function () {
    Route::get('/', [NotificationController::class, 'index'])->name('notifications.index');
    Route::get('/{notification}', [NotificationController::class, 'show'])->name('notifications.show');
    Route::post('/', [NotificationController::class, 'store'])->name('notifications.store');
});

Route::prefix('massnotifications')->group(function () {
    Route::get('/', [MassNotificationController::class, 'index'])->name('massnotifications.index');
    Route::get('/{massnotification}', [MassNotificationController::class, 'show'])->name('massnotifications.show');
    Route::post('/', [MassNotificationController::class, 'store'])->name('massnotifications.store');
});

Route::prefix('subscribers')->group(function () {
    Route::get('/', [SubscriberController::class, 'index'])->name('subscribers.index');
    Route::get('/{subscriber}', [SubscriberController::class, 'show'])->name('subscribers.show');
});