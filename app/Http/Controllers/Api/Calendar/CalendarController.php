<?php

namespace App\Http\Controllers\Api\Calendar;

use App\Http\Controllers\Controller;
use App\Models\Core\Agent;
use App\Models\Core\Event;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CalendarController extends Controller
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

    public function subreason(Request $request)
    {
        $subreasons = Event::getDataSubreason()->where('reason_id', $request->get('reason_id'));
        ob_start();
        ?>
        <div class="mb-10">
            <label for="subreason_id" class="form-label">Et plus particulierement</label>
            <select class="form-control form-control-solid" name="subreason" onchange="showQuestion(this)">
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
        $invalid = collect();
        $user = Agent::with('events')->find($request->get('agent_id'));

        dd($user);
    }
}
