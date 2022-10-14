<?php

namespace App\Http\Controllers\Admin\Account;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use function Illuminate\Session\userId;

class NotifyController extends Controller
{
    public function index()
    {
        return view('admin.account.notify.index', [
            'user' => auth()->user()
        ]);
    }

    public function show($notify_id)
    {
        return view('admin.account.notify.show', [
            'user' => auth()->user(),
            'notify' => auth()->user()->notifications()->find($notify_id)
        ]);
    }
}
