<?php

namespace App\Models\Core;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Core\MailboxAttachment
 *
 * @property int $id
 * @property int $mailbox_id
 * @property string $attachment
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|MailboxAttachment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MailboxAttachment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MailboxAttachment query()
 * @method static \Illuminate\Database\Eloquent\Builder|MailboxAttachment whereAttachment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MailboxAttachment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MailboxAttachment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MailboxAttachment whereMailboxId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MailboxAttachment whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class MailboxAttachment extends Model
{
    use HasFactory;

    protected $table = 'mailbox_attachment';
    protected $guarded = [];


}
