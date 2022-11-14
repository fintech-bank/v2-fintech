<?php

namespace App\Helper;

use App\Models\Core\LogBanque;
use App\Models\User;
use App\Notifications\Admin\LogNotification;

class LogHelper
{
    /**
     * @param $type
     * @param $message
     * @param null $content
     * @return void
     */
    public static function notify($type, $message, $content = null)
    {
        $users = User::where('admin', 1)->orWhere('agent', 1)->get();

        foreach ($users as $user) {
            \Log::$type($message, $content);
            $user->notify(new LogNotification($type, $message, $content));
        }
    }

    public static function getTypeTitle($type)
    {
        $t = null;
        switch ($type) {
            case 'emergency': $t = 'Urgence'; break;
            case 'alert': $t = 'Alerte'; break;
            case 'critical': $t = 'Critique'; break;
            case 'error': $t = 'Erreur'; break;
            case 'warning': $t = 'Avertissement'; break;
            case 'notice': $t = 'Notice'; break;
            case 'info': $t = 'Information'; break;
            default: $t = 'Debug';
        }

        return $t;
    }

    public static function getTypeTitleColor($type)
    {
        $t = null;
        switch ($type) {
            case 'emergency' || 'critical' || 'error': $t = 'danger'; break;
            case 'alert' || 'warning': $t = 'warning'; break;
            case 'notice': $t = 'primary'; break;
            case 'info': $t = 'info'; break;
            default: $t = 'light';
        }

        return $t;
    }

    public static function getTypeTitleIcon($type)
    {
        $t = null;
        switch ($type) {
            case 'emergency' || 'critical': $t =  'radiation'; break;
            case 'alert' || 'warning': $t =  'triangle-exclamation'; break;
            case 'error': $t =  'xmark'; break;
            case 'notice': $t =  'exclamation'; break;
            case 'info': $t =  'info'; break;
            default: return 'bug';
        }

        return $t;
    }

    public static function error(string $exception, $t = null)
    {
        \Log::error($exception, $t);
    }

    /**
     * @param $type || error, warning, success, info
     * @param $message
     * @param User|null $user
     * @return void
     */
    public static function insertLogSystem($type, $message, User $user = null)
    {
        LogBanque::create(['type' => $type, 'message' => $message, 'user_id' => isset($user) ? $user->id : null]);
    }
}
