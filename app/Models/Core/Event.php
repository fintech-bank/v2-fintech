<?php

namespace App\Models\Core;

use App\Models\User;
use App\Notifications\Agent\NewEventNotification;
use App\Notifications\Customer\NewAppointmentNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Core\Event
 *
 * @property-read User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|Event newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Event newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Event query()
 * @mixin \Eloquent
 * @property int $id
 * @property string $type
 * @property string $title
 * @property string $description
 * @property \Illuminate\Support\Carbon $start_at
 * @property \Illuminate\Support\Carbon $end_at
 * @property string|null $lieu
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $user_id
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereEndAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereLieu($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereStartAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereUserId($value)
 * @property int $allDay
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereAllDay($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Core\EventAttendee[] $attendees
 * @property-read int|null $attendees_count
 * @property-read mixed $type_cl
 * @property-read mixed $type_color
 * @property string $reason
 * @property string $subreason
 * @property string|null $question
 * @property string $canal
 * @property int $agent_id
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereAgentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereCanal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereQuestion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereSubreason($value)
 * @property-read User $agent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Core\EventMessage[] $messages
 * @property-read int|null $messages_count
 */
class Event extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $dates = ['created_at', 'updated_at', 'start_at', 'end_at'];
    protected $appends = ['type_color', 'type_cl'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function attendees()
    {
        return $this->hasMany(EventAttendee::class);
    }

    public function agent()
    {
        return $this->belongsTo(Agent::class, 'agent_id');
    }

    public function messages()
    {
        return $this->hasMany(EventMessage::class);
    }

    public function getTypeColorAttribute()
    {
        switch ($this->type) {
            case 'customer': return 'bg-success text-white';
            case 'internal': return 'bg-danger text-white';
            case 'external': return 'bg-info text-white';
        }
    }

    public function getTypeClAttribute()
    {
        switch ($this->type) {
            case 'customer': return 'success';
            case 'internal': return 'danger';
            case 'external': return 'info';
        }
    }

    public function getCanal($format = '')
    {
        if($format == 'text') {
            return match($this->canal) {
                "agency" => "En agence",
                "phone" => "Par téléphone",
                default => "Par un autre moyen"
            };
        } else {
            return match($this->canal) {
                "agency" => "fa-building",
                "phone" => "fa-phone",
                default => "fa-ellipsis"
            };
        }
    }

    public static function boot()
    {
        parent::boot();

        static::created(function (Event $event) {
            $event->agent->user->notify(new NewEventNotification($event));
            $event->user->customers->info->notify(new NewAppointmentNotification($event->user->customers, $event, 'Contact avec ma banque'));
        });
    }

    public static function  getDataReason()
    {
        $ar = collect();

        $ar->push(['id' => 0, "value" => "Gérer vos comptes & moyens de paiement"]);
        $ar->push(['id' => 1, "value" => "Ouvrir un compte"]);
        $ar->push(['id' => 2, "value" => "Epargner ou placer"]);
        $ar->push(['id' => 3, "value" => "Emprunter ou gérer vos crédits"]);
        $ar->push(['id' => 4, "value" => "Etre assuré ou protégé"]);
        $ar->push(['id' => 5, "value" => "Autre"]);

        return $ar;
    }

    public static function getDataSubreason()
    {
        $ar = collect();

        $ar->push(['id' => 0, "reason_id" => 0, "name" => "Gérer vos moyens de paiement"]);
        $ar->push(['id' => 1, "reason_id" => 0, "name" => "Avoir des informations sur un découvert"]);
        $ar->push(['id' => 2, "reason_id" => 0, "name" => "Transférer un compte"]);
        $ar->push(['id' => 3, "reason_id" => 0, "name" => "Autre"]);

        $ar->push(['id' => 4, "reason_id" => 1, "name" => "Ouvrir un compte supplémentaire"]);
        $ar->push(['id' => 5, "reason_id" => 1, "name" => "Ouvrir un compte/livret pour un mineur"]);
        $ar->push(['id' => 6, "reason_id" => 1, "name" => "Ouvrir un compte professionnel"]);
        $ar->push(['id' => 7, "reason_id" => 1, "name" => "Autre"]);

        $ar->push(['id' => 8, "reason_id" => 2, "name" => "Découvrir nos solutions d'épargne et de placement"]);
        $ar->push(['id' => 9, "reason_id" => 2, "name" => "Obtenir un conseil personnalisé pour votre épargne ou vos placements"]);
        $ar->push(['id' => 10, "reason_id" => 2, "name" => "Autre"]);

        $ar->push(['id' => 11, "reason_id" => 3, "name" => "Financer un véhicule, un voyage, des travaux."]);
        $ar->push(['id' => 12, "reason_id" => 3, "name" => "Financer des études"]);
        $ar->push(['id' => 13, "reason_id" => 3, "name" => "Echanger sur votre futur projet immobilier"]);
        $ar->push(['id' => 14, "reason_id" => 3, "name" => "Constituer votre dossier de crédit immobilier"]);
        $ar->push(['id' => 15, "reason_id" => 3, "name" => "Autre"]);
        $ar->push(['id' => 16, "reason_id" => 3, "name" => "Suivre ma demande de financement immobilier"]);
        $ar->push(['id' => 17, "reason_id" => 3, "name" => "Gérer mon crédit"]);

        $ar->push(['id' => 18, "reason_id" => 4, "name" => "Assurer un véhicule"]);
        $ar->push(['id' => 19, "reason_id" => 4, "name" => "Obtenir de l'information sur l'assurance 2 roue"]);
        $ar->push(['id' => 20, "reason_id" => 4, "name" => "Assurer un 2 roues"]);
        $ar->push(['id' => 21, "reason_id" => 4, "name" => "Assurer une habitation"]);
        $ar->push(['id' => 22, "reason_id" => 4, "name" => "Découvrir nos solutions d'assurance et de protection"]);
        $ar->push(['id' => 23, "reason_id" => 4, "name" => "Obtenir un conseil personnalisé pour vous protéger ou protéger vos proches"]);
        $ar->push(['id' => 24, "reason_id" => 4, "name" => "Autre"]);

        return $ar;
    }
}
