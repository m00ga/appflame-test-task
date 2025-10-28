<?php

namespace App\Http\Resources;

use App\DTO\TodayStatsDTO;
use App\Enum\EventTypeEnum;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin TodayStatsDTO */
class TodayStatsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        self::withoutWrapping();

        return [
            'date' => Carbon::now()->format('Y-m-d'),
            'counts' => array_reduce(EventTypeEnum::cases(), function($carry, $case) {
                $carry[$case->value] = $this->eventData->get($case->value, 0);
                return $carry;
            }, []),
            'total' => $this->totalCount
        ];
    }
}
