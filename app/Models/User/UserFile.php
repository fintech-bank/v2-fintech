<?php

namespace App\Models\User;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\User\UserFile
 *
 * @property int $id
 * @property string $name
 * @property string $size
 * @property string $type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $user_folder_id
 * @property int $user_id
 * @property-read \App\Models\User\UserFolder $folder
 * @property-read User $user
 * @method static \Illuminate\Database\Eloquent\Builder|UserFile newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserFile newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserFile query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserFile whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserFile whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserFile whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserFile whereSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserFile whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserFile whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserFile whereUserFolderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserFile whereUserId($value)
 * @mixin \Eloquent
 */
class UserFile extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function folder()
    {
        return $this->belongsTo(UserFolder::class, 'user_folder_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
