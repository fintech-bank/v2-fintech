<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function info($userId)
    {
        $user = User::find($userId);
        $info = [
            "user" => $user,
            "notifications" => [
                'count' => $user->notifications->count(),
                'unread' => $user->unreadNotifications()->count(),
                'unreadLists' => $user->unreadNotifications(),
                'all' => $user->notifications
            ],
            'mailer' => [
                'unread_count' => count(getUnreadMessages())
            ]
        ];

        return response()->json($info);
    }
}
