<?php

use App\Http\Controllers\Api\v1\EventsController;
use App\Http\Controllers\Api\v1\TodayStatsController;
use App\Http\Middleware\EnsureIdemponentKey;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'v1'], function () {
    Route::get('stats/today', TodayStatsController::class);
    Route::apiResource('events', EventsController::class)
        ->middleware([EnsureIdemponentKey::class])
        ->only(['store']);
});
