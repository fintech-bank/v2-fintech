<?php

namespace App\Models;

use App\Helper\CustomerHelper;
use App\Models\Core\Agency;
use App\Models\Core\DocumentCategory;
use App\Models\Core\Event;
use App\Models\Core\EventAttendee;
use App\Models\Core\LogBanque;
use App\Models\Core\Package;
use App\Models\Core\TicketConversation;
use App\Models\Customer\Customer;
use App\Models\Reseller\Reseller;
use App\Models\User\UserFile;
use App\Models\User\UserFolder;
use App\Models\User\UserNotificationSetting;
use App\Models\User\UserSubscription;
use Carbon\Carbon;
use Creativeorange\Gravatar\Facades\Gravatar;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Sanctum\HasApiTokens;
use NotificationChannels\WebPush\HasPushSubscriptions;
use RTippin\Messenger\Contracts\MessengerProvider;
use RTippin\Messenger\Traits\Messageable;

/**
 * App\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $two_factor_secret
 * @property string|null $two_factor_recovery_codes
 * @property string|null $two_factor_confirmed_at
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $admin
 * @property int $agent
 * @property int $customer
 * @property string|null $identifiant
 * @property string|null $last_seen
 * @property int|null $agency_id
 * @property-read Agency|null $agency
 * @property-read Customer|null $customers
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read Package|null $package
 * @property-read \Illuminate\Database\Eloquent\Collection|\NotificationChannels\WebPush\PushSubscription[] $pushSubscriptions
 * @property-read int|null $push_subscriptions_count
 * @property-read \Illuminate\Database\Eloquent\Collection|TicketConversation[] $ticket
 * @property-read int|null $ticket_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Sanctum\PersonalAccessToken[] $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\UserFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereAdmin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereAgencyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereAgent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCustomer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereIdentifiant($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereLastSeen($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereTwoFactorConfirmedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereTwoFactorRecoveryCodes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereTwoFactorSecret($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @mixin \Eloquent
 * @mixin IdeHelperUser
 * @property-read Reseller|null $reseller
 * @property string|null $stripe_id
 * @property string|null $pm_type
 * @property string|null $pm_last_four
 * @property string|null $trial_ends_at
 * @property-read Reseller|null $revendeur
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePmLastFour($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePmType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereReseller($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereStripeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereTrialEndsAt($value)
 * @property string|null $pushbullet_device_id
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePushbulletDeviceId($value)
 * @property string|null $avatar
 * @method static Builder|User whereAvatar($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|LogBanque[] $log
 * @property-read int|null $log_count
 * @property-read \Illuminate\Database\Eloquent\Collection|UserFile[] $files
 * @property-read int|null $files_count
 * @property-read \Illuminate\Database\Eloquent\Collection|UserFolder[] $folder
 * @property-read int|null $folder_count
 * @property-read mixed $avatar_symbol
 * @property-read mixed $email_verified
 * @property-read \Illuminate\Database\Eloquent\Collection|EventAttendee[] $attendees
 * @property-read int|null $attendees_count
 * @property-read \Illuminate\Database\Eloquent\Collection|Event[] $events
 * @property-read int|null $events_count
 * @property-read mixed $user_group_color
 * @property-read mixed $user_group_label
 * @property-read mixed $user_group_text
 * @property-read \Illuminate\Database\Eloquent\Collection|UserNotificationSetting[] $settingnotification
 * @property-read int|null $settingnotification_count
 * @property string|null $authy_id
 * @property string|null $authy_status
 * @property string|null $authy_one_touch_uuid
 * @method static Builder|User whereAuthyId($value)
 * @method static Builder|User whereAuthyOneTouchUuid($value)
 * @method static Builder|User whereAuthyStatus($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|UserSubscription[] $subscriptions
 * @property-read int|null $subscriptions_count
 * @property-read mixed $next_debit_package
 * @property-read mixed $alert_same_default_password
 * @property string|null $type_customer
 * @method static Builder|User whereTypeCustomer($value)
 * @property string|null $api_token
 * @method static Builder|User whereApiToken($value)
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasPushSubscriptions;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $appends = ['avatar_symbol', 'email_verified', 'user_group_label', 'alert_same_default_password'];

    public function routeNotificationForPushbullet()
    {
        return new \NotificationChannels\Pushbullet\Targets\Device($this->pushbullet_device_id);
    }

    /**
     * Route notifications for the Slack channel.
     *
     * @param  \Illuminate\Notifications\Notification  $notification
     * @return string
     */
    public function routeNotificationForSlack($notification)
    {
        return 'https://hooks.slack.com/services/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';
    }

    public function customers()
    {
        return $this->hasOne(Customer::class);
    }

    public function package()
    {
        return $this->hasOne(Package::class);
    }

    public function ticket()
    {
        return $this->hasMany(TicketConversation::class);
    }

    public function agency()
    {
        return $this->belongsTo(Agency::class);
    }

    public function revendeur()
    {
        return $this->hasOne(Reseller::class);
    }

    public function log()
    {
        return $this->hasMany(LogBanque::class);
    }

    public function folder()
    {
        return $this->hasMany(UserFolder::class);
    }

    public function files()
    {
        return $this->hasMany(UserFile::class);
    }

    public function events()
    {
        return $this->hasMany(Event::class);
    }

    public function attendees()
    {
        return $this->hasMany(EventAttendee::class);
    }

    public function settingnotification()
    {
        return $this->hasOne(UserNotificationSetting::class);
    }

    public function subscriptions()
    {
        return $this->hasMany(UserSubscription::class);
    }

    public static function boot()
    {
        parent::boot();

        static::created(function ($user) {
            Storage::disk('public')->makeDirectory('gdd/'.$user->id.'/documents');
            Storage::disk('public')->makeDirectory('gdd/'.$user->id.'/account');
            Storage::disk('public')->makeDirectory('gdd/'.$user->id.'/personnel');

            foreach (DocumentCategory::all() as $doc) {
                Storage::disk('public')->makeDirectory('gdd/'.$user->id.'/documents/'.$doc->slug);
            }
        });
    }

    public function getAvatarSymbolAttribute()
    {
        if(\Gravatar::exists($this->email)) {
            return "<img src='".Gravatar::get($this->email)."' class='rounded-circle h-40px me-3' alt='' />";
        } else {
            return '<div class="symbol-label fs-2 fw-bold text-'.random_color().'">'.\Str::limit($this->name, 2).'</div>';
        }
    }

    public function getUserGroupTextAttribute()
    {
        if($this->admin == 1) {
            return 'Administrateur';
        } elseif($this->agent == 1) {
            return "Agent Commercial";
        } elseif($this->reseller == 1) {
            return "Revendeur / Distributeur";
        } else {
            return "Client";
        }
    }

    public function getUserGroupColorAttribute()
    {
        if($this->admin == 1) {
            return 'danger';
        } elseif($this->agent == 1) {
            return "warning";
        } elseif($this->reseller == 1) {
            return "info";
        } else {
            return "success";
        }
    }

    public function getUserGroupLabelAttribute()
    {
        return '<span class="badge badge-'.$this->getUserGroupColorAttribute().'">'.$this->getUserGroupTextAttribute().'</span>';
    }

    public function getEmailVerifiedAttribute()
    {
        if(filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            return '<i class="fa-solid fa-check-circle text-success" data-bs-toggle="tooltip" title="Vérifié"></i>';
        } else {
            return '<i class="fa-solid fa-xmark-circle text-danger" data-bs-toggle="tooltip" title="Email invalide"></i>';
        }
    }

    public function pushNotificationVerifier($notificationClass)
    {
        if($this->settingnotification->mail) {
            \Notification::route('mail', $this->email)
                ->notify($notificationClass);
        }
        if($this->settingnotification->app) {
            \Notification::route('fcm', $this->customers->info->mobile)
                ->notify($notificationClass);
        }
        if($this->settingnotification->site) {
            \Notification::route('webpush', $this)
                ->route('database', $this)
                ->notify($notificationClass);
        }
        if($this->settingnotification->sms) {
            \Notification::route('sms', $this->customers->info->mobile)
                ->notify($notificationClass);
        }
    }

    public function getAlertSameDefaultPasswordAttribute()
    {
        if($this->created_at->startOfDay() == $this->updated_at->startOfDay()) {
            ob_start();
            ?>
            <div class="d-flex flex-row align-items-center rounded bg-gradient-primary rounded-2 p-5 mb-10">
                <i class="fa-solid fa-info-circle fs-2tx text-white me-5"></i>
                <div class="d-flex flex-column">
                    <div class="fs-1 text-white fw-bolder">Information sur le mot de passe</div>
                    <div class="fs-3 text-white">Le mot de passe par default est toujours actif pour ce client.</div>
                </div>
                <button class="position-absolute position-sm-relative m-2 m-sm-0 top-0 end-0 btn btn-outline btn-outline-light ms-sm-auto btnNotifyPassword">
                    <span class="indicator-label">
                        Notifier le client
                    </span>
                    <span class="indicator-progress">
                        Veuillez patienter... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                    </span>
                </button>
            </div>
            <?php
            return ob_get_clean();
        }
    }

}
