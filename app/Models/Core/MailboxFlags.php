<?php

namespace App\Models\Core;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Core\MailboxFlags
 *
 * @property int $id
 * @property int $is_unread
 * @property int $is_important
 * @property int $mailbox_id
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|MailboxFlags newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MailboxFlags newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MailboxFlags query()
 * @method static \Illuminate\Database\Eloquent\Builder|MailboxFlags whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MailboxFlags whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MailboxFlags whereIsImportant($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MailboxFlags whereIsUnread($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MailboxFlags whereMailboxId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MailboxFlags whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MailboxFlags whereUserId($value)
 * @mixin \Eloquent
 */
class MailboxFlags extends Model
{
    use HasFactory;
    protected $table = 'mailbox_flags';
    protected $guarded = [];
}
