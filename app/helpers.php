<?php

if (!function_exists('eur')) {
    function eur($value)
    {
        return number_format($value, 2, ',', ' ') . ' €';
    }
}

if (!function_exists('random_color')) {
    function random_color()
    {
        $color = ['primary', 'secondary', 'success', 'info', 'warning', 'danger', 'dark', 'bank'];

        return $color[rand(0, 7)];
    }
}

if (!function_exists('random_string_alpha_upper')) {
    function random_string_alpha_upper($len = 10)
    {
        $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $var_size = strlen($chars);
        $random_str = '';
        for ($x = 0; $x < $len; $x++) {
            $random_str .= $chars[rand(0, $var_size - 1)];
        }

        return $random_str;
    }
}

if (!function_exists('random_numeric')) {
    function random_numeric($len = 10)
    {
        $chars = '0123456789';
        $var_size = strlen($chars);
        $random_str = '';
        for ($x = 0; $x < $len; $x++) {
            $random_str .= $chars[rand(0, $var_size - 1)];
        }

        return $random_str;
    }
}

if (!function_exists('api_error')) {
    function api_error($code, $message, $type = 'critical', $detail = null, $help = null)
    {
        \App\Helper\LogHelper::notify(
            $type,
            $code . ' - ' . $message . ($detail != null ? ' - ' . $detail . ' - ' : '') . ($help != null ? $help : ''));

        return [
            'error' => $code,
            'message' => $message,
            'detail' => $detail,
            'help' => $help,
        ];
    }
}

if (!function_exists('getLatestVersion')) {
    function getLatestVersion()
    {
        $version = \App\Models\Core\Version::where('publish', 1)->orderBy('id', 'desc')->first();
        if ($version) {
            return \App\Models\Core\Version::where('publish', 1)->orderBy('id', 'desc')->first()->name;
        } else {
            return 'None';
        }
    }
}

if (!function_exists('getUnreadMessages')) {
    function getUnreadMessages($user_id = null)
    {
        $folder = \App\Models\Core\MailboxFolder::where('title', 'Inbox')->first();

        if (isset($user_id)) {
            return \App\Models\Core\Mailbox::join('mailbox_receiver', 'mailbox_receiver.mailbox_id', '=', 'mailbox.id')
                ->join('mailbox_user_folder', 'mailbox_user_folder.user_id', '=', 'mailbox_receiver.receiver_id')
                ->join('mailbox_flags', 'mailbox_flags.user_id', '=', 'mailbox_user_folder.user_id')
                ->where('mailbox_receiver.receiver_id', Auth::user()->id)
                ->where('mailbox_flags.is_unread', 1)
                ->where('mailbox_user_folder.folder_id', $folder->id)
                ->where('sender_id', '!=', Auth::user()->id)
                ->whereRaw('mailbox.id=mailbox_receiver.mailbox_id')
                ->whereRaw('mailbox.id=mailbox_flags.mailbox_id')
                ->whereRaw('mailbox.id=mailbox_user_folder.mailbox_id')
                ->select(["*", "mailbox.id as id"])
                ->get();
        } else {
            return \App\Models\Core\Mailbox::join('mailbox_receiver', 'mailbox_receiver.mailbox_id', '=', 'mailbox.id')
                ->join('mailbox_user_folder', 'mailbox_user_folder.user_id', '=', 'mailbox_receiver.receiver_id')
                ->join('mailbox_flags', 'mailbox_flags.user_id', '=', 'mailbox_user_folder.user_id')
                ->where('mailbox_receiver.receiver_id', $user_id)
                ->where('mailbox_flags.is_unread', 1)
                ->where('mailbox_user_folder.folder_id', $folder->id)
                ->where('sender_id', '!=', $user_id)
                ->whereRaw('mailbox.id=mailbox_receiver.mailbox_id')
                ->whereRaw('mailbox.id=mailbox_flags.mailbox_id')
                ->whereRaw('mailbox.id=mailbox_user_folder.mailbox_id')
                ->select(["*", "mailbox.id as id"])
                ->get();
        }
    }
}

if (!function_exists('sizeFormat')) {
    function sizeFormat($bytes)
    {
        $kb = 1024;
        $mb = $kb * 1024;
        $gb = $mb * 1024;
        $tb = $gb * 1024;

        if (($bytes >= 0) && ($bytes < $kb)) {
            return $bytes . ' B';

        } elseif (($bytes >= $kb) && ($bytes < $mb)) {
            return ceil($bytes / $kb) . ' KB';

        } elseif (($bytes >= $mb) && ($bytes < $gb)) {
            return ceil($bytes / $mb) . ' MB';

        } elseif (($bytes >= $gb) && ($bytes < $tb)) {
            return ceil($bytes / $gb) . ' GB';

        } elseif ($bytes >= $tb) {
            return ceil($bytes / $tb) . ' TB';
        } else {
            return $bytes . ' B';
        }
    }
}

if (!function_exists('formatDateFrench')) {
    function formatDateFrench($date, $hours = false)
    {
        $dayName = $date->locale('fr_FR')->dayName;
        $day = $date->day;
        $monthName = $date->locale('fr_FR')->monthName;

        if ($hours) {
            return $dayName . " " . $day . " " . $monthName . " " . $date->year . " " . $date->format('H:i');
        } else {
            return $dayName . " " . $day . " " . $monthName . " " . $date->year;
        }
    }
}

if (!function_exists('generateReference')) {
    function generateReference($length = 8)
    {
        return Str::upper(Str::random($length));
    }
}

/**
 * check directory exists and try to create it
 *
 *
 * @param $directory
 */
function checkDirectory($directory)
{
    try {
        if (!file_exists(public_path('uploads/' . $directory))) {
            Storage::disk('public')->makeDirectory('uploads/' . $directory);
            Storage::disk('public')->setVisibility('uploads/' . $directory, 'public');
        }
    } catch (\Exception $e) {
        die($e->getMessage());
    }
}
