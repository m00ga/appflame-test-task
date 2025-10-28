<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\TodayStatsResource;
use App\Services\EventService;

class TodayStatsController extends Controller
{
    public function __invoke(EventService $eventService)
    {
        return TodayStatsResource::make(
            $eventService->getAllEventsForToday()
        );
    }
}
