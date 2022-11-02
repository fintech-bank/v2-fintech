<?php

namespace App\Models\Core;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Core\MailboxFolder
 *
 * @property int $id
 * @property string $title
 * @property string $icon
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|MailboxFolder newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MailboxFolder newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MailboxFolder query()
 * @method static \Illuminate\Database\Eloquent\Builder|MailboxFolder whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MailboxFolder whereIcon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MailboxFolder whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MailboxFolder whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MailboxFolder whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class MailboxFolder extends Model
{
    use HasFactory;
    protected $table = 'mailbox_folder';
    protected $guarded = [];
}
