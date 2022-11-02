<?php

namespace App\Http\Controllers\Api\Calendar;

use App\Http\Controllers\Controller;
use App\Models\Core\Event;
use App\Models\User;
use Illuminate\Http\Request;

class CalendarController extends Controller
{
    public function list(Request $request)
    {
        $events = User::find($request->get('user_id'))->events;

        $arr = [];

        foreach ($events as $event) {
            $arr[] = [
                'id' => $event->id,
                'title' => $event->title,
                'description' => $event->description,
                'location' => $event->lieu,
                'start' => $event->start_at,
                'end' => $event->end_at,
                'className' => $event->type_color,
                'duration' => $event->start_at->shortAbsoluteDiffForHumans($event->end_at)
            ];
        }

        return response()->json($arr);
    }
}
