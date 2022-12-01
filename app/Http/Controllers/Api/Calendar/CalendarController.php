<?php

namespace App\Http\Controllers\Api\Calendar;

use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Controller;
use App\Models\Core\Agent;
use App\Models\Core\Event;
use App\Models\User;
use App\Notifications\Customer\NewAppointmentNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CalendarController extends ApiController
{
    /**
     * @OA\POST(
     *      path="/v1/calendar/list",
     *      operationId="listAllCalendar",
     *      tags={"Tests"},

     *      summary="Liste des évènement d'un utilisateur",
     *      description="Retourne la liste des évènement propre à un utilisateur",
     *      @OA\Response(
     *          response=200,
     *          description="Succès",
     *          @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     * @OA\Response(
     *      response=400,
     *      description="Bad Request"
     *   ),
     * @OA\Response(
     *      response=404,
     *      description="not found"
     *   ),
     *  )
     */
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

    public function store(Request $request)
    {
        $agent = Agent::find($request->get('agent_id'));
        $start_at = Carbon::createFromTimestamp(strtotime($request->get('start_at')));
        $reason = Event::getDataReason()->where('id', $request->get('reason_id'))->first();

        if($agent->events()->where('start_at', $start_at)->count() != 0) {
            return $this->sendWarning("Votre agent est déjà en rendez-vous à la date du ".formatDateFrench($start_at, true));
        }

        $event = Event::create([
            'type' => $request->get('type'),
            'reason' => $reason['value'],
            'subreason' => $request->get('subreason'),
            'question' => $request->get('question'),
            'canal' => $request->get('canal'),
            'lieu' => $request->get('canal') == 'agency' ? $agent->agency->name : '',
            'start_at' => $start_at,
            'end_at' => $request->get('canal') == 'phone' ? $start_at->addMinutes(30) : $start_at->addHour(),
            'allDay' => false,
            'agent_id' => $agent->id,
            'user_id' => $request->get('user_id')
        ]);

        $event->user->customers->info->notify(new NewAppointmentNotification($event->user->customers, $event, 'Contact avec ma banque'));

        return response()->json();

    }

    public function subreason(Request $request)
    {
        $subreasons = Event::getDataSubreason()->where('reason_id', $request->get('reason_id'));
        ob_start();
        ?>
        <div class="mb-10">
            <label for="subreason_id" class="form-label">Et plus particulierement</label>
            <select class="form-control form-control-solid" name="subreason_id" onchange="showQuestion(this)">
                <option value=""></option>
                <?php foreach ($subreasons as $subreason): ?>
                    <option value="<?= $subreason['name'] ?>"><?= $subreason['name'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <?php
        return response()->json(ob_get_clean());
    }

    public function disponibility(Request $request)
    {
        $calendars = collect();
        $user = Agent::find($request->get('agent_id'));
        $count_day = Carbon::createFromTimestamp(strtotime($request->get('start')))->diffInDays(Carbon::createFromTimestamp(strtotime($request->get('end'))));
        for ($i = 0; $i <= $count_day; $i++) {
            $invalid = collect();
            $start = Carbon::createFromTimestamp(strtotime($request->get('start')))->addDays($i)->startOfDay();
            $end = Carbon::createFromTimestamp(strtotime($request->get('start')))->addDays($i)->endOfDay();
            foreach ($user->events()->whereBetween('start_at', [$start, $end])->get() as $event) {
                $invalid->push([
                    'start' => $event->start_at->toJSON(),
                    'end' => $event->end_at->toJSON()
                ]);
            }

            $calendars->push([
                'd' => $start->toJSON(),
                'nr' => $i,
                "invalid" => $invalid->toArray()
            ]);
        }

        return response()->json($calendars);
    }
}
