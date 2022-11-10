<?php

namespace App\Http\Controllers\Agent\Account;

use App\Helper\LogHelper;
use App\Http\Controllers\Controller;
use App\Models\Core\Event;
use App\Notifications\Customer\Customer\Calendar\NewEventNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        return view('agent.account.event.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'type' => 'required',
            'description' => 'required',
            'start_at' => 'required|date',
            'end_at' => 'required|date'
        ]);

        try {
            $event = Event::create([
                'title' => $request->get('title'),
                'type' => $request->get('type'),
                'description' => $request->get('description'),
                'start_at' => $request->has('allday') ? Carbon::parse($request->get('start_at').' '.$request->get('start_at_time')) : Carbon::parse($request->get('start_at')),
                'end_at' => $request->has('allday') ? Carbon::parse($request->get('end_at').' '.$request->get('start_end_time')) : Carbon::parse($request->get('end_at')),
                'lieu' => $request->get('lieu'),
                'allDay' => $request->has('allday'),
                'user_id' => auth()->user()->id,
            ]);

            if(count($request->get('attendees')) > 0) {
                foreach ($request->get('attendees') as $attendee) {
                    $att = $event->attendees()->create([
                        'event_id' => $event->id,
                        'user_id' => $attendee
                    ]);

                    $notif = new NewEventNotification($event, $att);
                    $att->user->pushNotificationVerifier($notif);
                }
            }
        }catch (\Exception $exception) {
            LogHelper::notify('critical', $exception);
            return response()->json($exception->getMessage(), 500);
        }

        return response()->json();
    }
}
