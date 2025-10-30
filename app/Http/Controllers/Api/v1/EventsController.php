<?php

namespace App\Http\Controllers\Api\v1;

use App\Exceptions\IdempotentKeyExistsException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\StoreRequest;
use App\Services\EventService;
use Dedoc\Scramble\Attributes\HeaderParameter;
use Throwable;

class EventsController extends Controller
{
    /**
     * Store new event
     */
    #[HeaderParameter(name: 'X-Idempotency-Key', required: true)]
    public function store(StoreRequest $request, EventService $eventService)
    {
        try {
            $eventService->storeEvent($request);

            return response()->json([
                'status' => 'info',
                'message' => 'Event was created'
            ], 201);
        } catch (IdempotentKeyExistsException) {
            return response()->json([
                'status' => 'warning',
                'message' => 'Event with this idempotent key exists'
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unexpected server error'
            ], 400);
        }
    }
}
