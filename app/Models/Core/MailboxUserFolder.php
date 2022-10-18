<?php

namespace App\Models\Core;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Core\MailboxUserFolder
 *
 * @property int $id
 * @property int $user_id
 * @property int $mailbox_id
 * @property int $folder_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Core\MailboxFolder $folder
 * @method static \Illuminate\Database\Eloquent\Builder|MailboxUserFolder newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MailboxUserFolder newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MailboxUserFolder query()
 * @method static \Illuminate\Database\Eloquent\Builder|MailboxUserFolder whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MailboxUserFolder whereFolderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MailboxUserFolder whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MailboxUserFolder whereMailboxId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MailboxUserFolder whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MailboxUserFolder whereUserId($value)
 * @mixin \Eloquent
 */
class MailboxUserFolder extends Model
{
    use HasFactory;
    protected $table = 'mailbox_user_folder';
    protected $guarded = [];

    public function folder()
    {
        return $this->belongsTo(MailboxFolder::class, 'folder_id');
    }
}
