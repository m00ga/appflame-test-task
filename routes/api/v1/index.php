<?php

use App\Http\Controllers\Api\v1\TodayStatsController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'v1'], function () {
    Route::get('stats/today', TodayStatsController::class);
});
