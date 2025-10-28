<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;

class TodayStatsController extends Controller
{
    public function __invoke()
    {
        return response('test');
    }
}
