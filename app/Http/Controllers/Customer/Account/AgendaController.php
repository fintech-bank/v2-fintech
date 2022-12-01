<?php

namespace App\Http\Controllers\Customer\Account;

use App\Http\Controllers\Controller;
use App\Models\Core\Event;
use App\Models\Customer\Customer;


class AgendaController extends Controller
{
    public function index()
    {
        return view('customer.account.agenda.index', [
            'events' => Customer::find(auth()->user()->customers->id)->user->events
        ]);
    }

    public function show($agenda_id)
    {
        $event = Event::find($agenda_id);
    }
}
