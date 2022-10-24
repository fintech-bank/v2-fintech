<?php

namespace App\Models\Core;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Core\MailboxTmpReceiver
 *
 * @property int $id
 * @property int $mailbox_id
 * @property int $receiver_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Core\Mailbox $mailbox
 * @property-read User $user
 * @method static \Illuminate\Database\Eloquent\Builder|MailboxTmpReceiver newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MailboxTmpReceiver newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MailboxTmpReceiver query()
 * @method static \Illuminate\Database\Eloquent\Builder|MailboxTmpReceiver whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MailboxTmpReceiver whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MailboxTmpReceiver whereMailboxId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MailboxTmpReceiver whereReceiverId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MailboxTmpReceiver whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class MailboxTmpReceiver extends Model
{
    use HasFactory;
    protected $table = 'mailbox_tmp_receiver';
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
