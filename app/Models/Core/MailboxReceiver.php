<?php

namespace App\Models\Core;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Core\MailboxReceiver
 *
 * @property int $id
 * @property int $mailbox_id
 * @property int $receiver_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Core\Mailbox $mailbox
 * @property-read User $user
 * @method static \Illuminate\Database\Eloquent\Builder|MailboxReceiver newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MailboxReceiver newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MailboxReceiver query()
 * @method static \Illuminate\Database\Eloquent\Builder|MailboxReceiver whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MailboxReceiver whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MailboxReceiver whereMailboxId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MailboxReceiver whereReceiverId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MailboxReceiver whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class MailboxReceiver extends Model
{
    use HasFactory;
    protected $table = 'mailbox_receiver';
    protected $guarded = [];

    public function mailbox()
    {
        return $this->belongsTo(Mailbox::class, 'mailbox_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }
}
