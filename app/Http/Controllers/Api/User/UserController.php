<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{

    public function lists(Request $request)
    {
        if($request->get('action') == 'suggest') {
            $users = User::where('id', '!=', $request->get('user_id'))->get();
            $ar = [];

            foreach ($users as $user) {
                $ar[] = [
                    'value' => $user->id,
                    'name' => $user->name,
                    'avatar' => $user->avatar_symbol,
                    'email' => $user->email
                ];
            }

            return response()->json($ar);
        }
    }
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
