<?php

namespace App\DTO;

use Illuminate\Support\Collection;

class TodayStatsDTO extends BaseDTO
{
    public Collection $eventData;
    public int $totalCount;
}
