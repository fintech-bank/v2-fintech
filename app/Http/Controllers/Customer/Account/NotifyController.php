<?php

namespace App\Http\Controllers\Customer\Account;

use App\Http\Controllers\Controller;
use App\Models\Customer\Customer;
use Illuminate\Notifications\DatabaseNotification;

class NotifyController extends Controller
{
    public function index()
    {
        return view('customer.account.notify.index', [
            'notifications' => Customer::find(auth()->user()->customers->id)->info->notifications
        ]);
    }

    public function show($notify_id)
    {
        $notify = DatabaseNotification::find($notify_id);
        $notify->markAsRead();

        return view('customer.account.notify.show', [
            'notification' => $notify
        ]);
    }
}
