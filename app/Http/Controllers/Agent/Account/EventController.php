<?php

namespace App\Http\Controllers\Agent\Account;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        return view('agent.account.event.index');
    }
}
