<?php

namespace App\Services;

use App\DTO\TodayStatsDTO;
use App\Exceptions\IdempotentKeyExistsException;
use App\Http\Requests\Api\v1\StoreRequest;
use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Database\Query\Expression;

class EventService
{
    public function getAllEventsForToday(): TodayStatsDTO
    {
        $now = Carbon::now();

        $eventData = Event::query()
            ->whereBetween('ts', [
                $now->clone()->startOfDay()->toIso8601String(),
                $now->clone()->endOfDay()->toIso8601String(),
            ])
            ->groupBy('type')
            ->select(['type', new Expression('count(type) as event_cnt')])
            ->toBase()
            ->get()
            ->pluck('event_cnt', 'type');

        $totalCount = $eventData->reduce(fn($carry, $item) => $carry + $item, 0);

        return new TodayStatsDTO(compact('eventData', 'totalCount'));
    }

    /**
     * @throws IdempotentKeyExistsException
     * @throws \Throwable
     */
    public function storeEvent(StoreRequest $request): void
    {
        $idempotencyKey = $request->header(
            config('app.idempotent_key')
        );

        if (Event::query()->where('idempotency_key', $idempotencyKey)->exists()) {
            throw new IdempotentKeyExistsException();
        }

        $eventModel = new Event($request->validated());
        $eventModel->idempotency_key = $idempotencyKey;

        $eventModel->saveOrFail();
    }
}
