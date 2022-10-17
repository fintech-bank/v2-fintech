<?php

namespace App\Http\Controllers\Agent\Account;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use function Illuminate\Session\userId;

class NotifyController extends Controller
{
    public function index()
    {
        return view('agent.account.notify.index', [
            'user' => auth()->user()
        ]);
    }

    public function show($notifyId)
    {
        auth()->user()->notifications()->find($notifyId)->markAsRead();
        return view('agent.account.notify.show', [
            'user' => auth()->user(),
            'notify' => auth()->user()->notifications()->find($notifyId)
        ]);
    }
}
