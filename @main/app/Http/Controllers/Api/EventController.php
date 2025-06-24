<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\EventAttendee;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class EventController extends Controller
{
    /**
     * @OA\Get(
     *    path="/events",
     *    operationId="getEvents",
     *    tags={"Event"},
     *    summary="Get events",
     *    description="Get events",
     *    @OA\Response(
     *       response=200, description="Success",
     *       @OA\JsonContent(
     *         @OA\Property(property="status", type="integer", example="200"),
     *         @OA\Property(property="data",type="object")
     *       )
     *    )
     *  )
     */
    public function getEvents(Request $request)
    {
        $data = Event::with(['category', 'authors', 'attendees'])
            ->get();
        return response()->json([
            'data' => $data,
        ]);
    }

    /**
     * @OA\Get(
     *    path="/events/upcoming",
     *    operationId="getUpcomingEvents",
     *    tags={"Event"},
     *    summary="Get upcoming events",
     *    description="Get upcoming events",
     *    @OA\Response(
     *       response=200, description="Success",
     *       @OA\JsonContent(
     *         @OA\Property(property="status", type="integer", example="200"),
     *         @OA\Property(property="data",type="object")
     *       )
     *    )
     *  )
     */
    public function getUpcomingEvents(Request $request)
    {
        $data = Event::with(['category', 'authors', 'attendees'])
            ->whereDate('end_datetime', '>=', Carbon::now())
            ->get();
        return response()->json([
            'data' => $data,
        ]);
    }

    /**
     * @OA\Get(
     *    path="/events/past",
     *    operationId="getPastEvents",
     *    tags={"Event"},
     *    summary="Get events",
     *    description="Get events",
     *    @OA\Response(
     *       response=200, description="Success",
     *       @OA\JsonContent(
     *         @OA\Property(property="status", type="integer", example="200"),
     *         @OA\Property(property="data",type="object")
     *       )
     *    )
     *  )
     */
    public function getPastEvents(Request $request)
    {
        $data = Event::with(['category', 'authors', 'attendees'])
            ->whereDate('end_datetime', '<=', Carbon::now())
            ->get();
        return response()->json([
            'data' => $data,
        ]);
    }

    /**
     * @OA\Get(
     *    path="/events/{event}/details",
     *    operationId="getEventDetails",
     *    tags={"Event"},
     *    summary="Get a event details",
     *    description="Get a event details",
     *    @OA\Parameter(name="event", in="path", description="event", example="1", required=true,
     *        @OA\Schema(type="integer")
     *    ),
     *    @OA\Response(
     *       response=200, description="Success",
     *       @OA\JsonContent(
     *         @OA\Property(property="status", type="integer", example="200"),
     *         @OA\Property(property="data",type="object")
     *       )
     *    )
     *  )
     */
    public function getEventDetails(Event $event, Request $request)
    {
        return response()->json([
            'data' => $event,
        ]);
    }

    /**
     * @OA\Get(
     *    path="/events/details",
     *    operationId="getEventDetailsFromSlug",
     *    tags={"Event"},
     *    summary="Get event details",
     *    description="Get event details", 
     *    @OA\Parameter(name="slug", in="query", description="slug", example="hello-world", required=true,
     *        @OA\Schema(type="string")
     *    ),
     *    @OA\Response(
     *       response=200, description="Success",
     *       @OA\JsonContent(
     *         @OA\Property(property="status", type="integer", example="200"),
     *         @OA\Property(property="data",type="object")
     *       )
     *    )
     *  )
     */
    public function getEventDetailsFromSlug(Request $request)
    {
        $event = Event::with('authors')
            ->with('attendees')
            ->with('category')
            ->where('slug', [$request->slug])
            ->first();
        
        if( !empty($event->id) )
        {
            $event['attendeesCount'] = EventAttendee::where('event_id', $event->id)
                ->count();
        }
        
        return response()->json([
            'data' => $event,
        ]);
    }
}
