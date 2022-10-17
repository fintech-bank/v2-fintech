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
            \Log::$type($message);
            $user->notify(new LogNotification($type, $message, $content));
        }
    }

    public static function getTypeTitle($type)
    {
        switch ($type) {
            case 'emergency': return 'Urgence';
            case 'alert': return 'Alerte';
            case 'critical': return 'Critique';
            case 'error': return 'Erreur';
            case 'warning': return 'Avertissement';
            case 'notice': return 'Notice';
            case 'info': return 'Information';
            default: return 'Debug';
        }
    }

    public static function getTypeTitleColor($type)
    {
        switch ($type) {
            case 'emergency' || 'critical' || 'error': return 'danger';
            case 'alert' || 'warning': return 'warning';
            case 'notice': return 'primary';
            case 'info': return 'info';
            default: return 'light';
        }
    }

    public static function getTypeTitleIcon($type)
    {
        switch ($type) {
            case 'emergency' || 'critical': return 'radiation';
            case 'alert' || 'warning': return 'triangle-exclamation';
            case 'error': return 'xmark';
            case 'notice': return 'exclamation';
            case 'info': return 'info';
            default: return 'bug';
        }
    }

    public static function error(string $exception, $t = null)
    {
        \Log::error($exception, $t);
    }

    public static function insertLogSystem($type, $message,User $user = null)
    {
        LogBanque::create(['type' => $type, 'message' => $message, 'user_id' => isset($user) ? $user->id : null]);
    }
}
