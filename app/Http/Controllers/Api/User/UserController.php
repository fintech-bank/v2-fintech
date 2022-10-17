<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function info($user_id)
    {
        $user = User::find($user_id);
        $info = [
            "user" => $user,
            "notifications" => [
                'count' => $user->notifications->count(),
                'unread' => $user->unreadNotifications()->count(),
                'unreadLists' => $user->unreadNotifications(),
                'all' => $user->notifications
            ]
        ];

        return response()->json($info);
    }
}
