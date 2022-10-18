<?php

namespace App\Models\Core;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Core\Mailbox
 *
 * @property int $id
 * @property string $subject
 * @property string|null $body
 * @property int $sender_id
 * @property string $time_sent
 * @property int $parent_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Core\MailboxAttachment[] $attachments
 * @property-read int|null $attachments_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Core\MailboxFlags[] $flags
 * @property-read int|null $flags_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Core\MailboxReceiver[] $receivers
 * @property-read int|null $receivers_count
 * @property-read \Illuminate\Database\Eloquent\Collection|Mailbox[] $replies
 * @property-read int|null $replies_count
 * @property-read User $sender
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Core\MailboxTmpReceiver[] $tmpReceivers
 * @property-read int|null $tmp_receivers_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Core\MailboxUserFolder[] $userFolders
 * @property-read int|null $user_folders_count
 * @method static \Illuminate\Database\Eloquent\Builder|Mailbox newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Mailbox newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Mailbox query()
 * @method static \Illuminate\Database\Eloquent\Builder|Mailbox whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mailbox whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mailbox whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mailbox whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mailbox whereSenderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mailbox whereSubject($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mailbox whereTimeSent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mailbox whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Mailbox extends Model
{
    use HasFactory;

    protected $table = 'mailbox';
    protected $guarded = [];

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function receivers()
    {
        return $this->hasMany(MailboxReceiver::class);
    }

    public function tmpReceivers()
    {
        return $this->hasMany(MailboxTmpReceiver::class);
    }

    public function attachments()
    {
        return $this->hasMany(MailboxAttachment::class);
    }

    public function replies()
    {
        return $this->hasMany(self::class, 'parent_id')->where('parent_id', '<>', 0);
    }

    public function userFolders()
    {
        return $this->hasMany(MailboxUserFolder::class);
    }

    public function userFolder()
    {
        return $this->hasMany(MailboxUserFolder::class)->where('user_id', \Auth::user()->id)->first();
    }

    public function flags()
    {
        return $this->hasMany(MailboxFlags::class);
    }
    public function flag()
    {
        return $this->hasMany(MailboxFlags::class)->where('user_id', \Auth::user()->id)->first();
    }
}
