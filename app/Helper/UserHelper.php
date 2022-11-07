<?php

namespace App\Helper;

use Akibatech\FreeMobileSms\Notifications\FreeMobileChannel;
use App\Models\User;
use App\Models\User\UserNotificationSetting;
use Creativeorange\Gravatar\Facades\Gravatar;
use Illuminate\Support\Facades\Hash;
use NotificationChannels\Twilio\TwilioChannel;

class UserHelper
{
    public static function getGroupNamed($user)
    {
        if($user->admin == 1) {
            return 'Administrateur';
        } elseif ($user->agent == 1) {
            return 'Agent';
        } elseif ($user->customer == 1) {
            return 'Client';
        } else {
            return 'Distributeur';
        }
    }

    public static function getInfoOnline($user)
    {
        if (\Cache::has('user-is-online-'.$user->id)) {
            return '<span class="bullet bullet-dot bg-success me-1"></span>Connecter';
        } else {
            return '<span class="bullet bullet-dot bg-danger me-1"></span>Déconnecter';
        }
    }

    public static function getAvatar($email)
    {
        if (Gravatar::exists($email) == true) {
            return "<img src='".Gravatar::get($email)."' alt='' />";
        } else {
            $user = User::where('email', $email)->first();

            return '<div class="symbol-label fs-2 fw-bold text-'.random_color().'">'.\Str::limit($user->name, 2).'</div>';
        }
    }

    public static function generateID()
    {
        return 'ID'.\Str::upper(\Str::random(6)).'I'.rand(0, 9);
    }

    public static function emailObscurate($email)
    {
        $pattern = "/^([\w_]{1})(.+)([\w_]{1}@)/u";
        $replacement = '$1*$3***$4';

        return preg_replace($pattern, $replacement, $email);
    }

    public static function createUser(array $data)
    {
        $password = \Str::random(10);
        return User::create([
            'name' => $data['firstname'].' '.$data['lastname'],
            'email' => $data['email'],
            'password' => Hash::make($password),
            'identifiant' => self::generateID(),
            'agency_id' => 1
        ]);
    }

    public static function getChannelNotification(UserNotificationSetting $settingNotification)
    {
        $channel = collect();
        if($settingNotification->mail) {
            $channel->push('mail');
        } else {
            $mail = null;
        }

        if($settingNotification->site) {
            $channel->push('database');
        } else {
            $site = null;
        }

        if(isset($settingNotification->sms)) {
            if(config('app.env') == 'local') {
                $channel->push(FreeMobileChannel::class);
            } else {
                $channel->push(TwilioChannel::class);
            }
        } else {
            $sms = null;
        };

        $const = $channel->map(function ($item) {
            return [$item];
        })->toArray();

        //$chan = implode(',', $const);

        dd($const);
    }
}
