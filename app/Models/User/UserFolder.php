<?php

namespace App\Models\User;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\User\UserFolder
 *
 * @property int $id
 * @property string $name
 * @property int $parent
 * @property int|null $parent_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $user_id
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User\UserFile[] $files
 * @property-read int|null $files_count
 * @property-read User $user
 * @method static \Illuminate\Database\Eloquent\Builder|UserFolder newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserFolder newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserFolder query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserFolder whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserFolder whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserFolder whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserFolder whereParent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserFolder whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserFolder whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserFolder whereUserId($value)
 * @mixin \Eloquent
 */
class UserFolder extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function files()
    {
        return $this->hasMany(UserFile::class);
    }

    /**
     * @param $path
     * @return array
     */
    public static function getSizeAllFolder($path)
    {
        $dirs = scandir($path);
        $count_size = 0;
        $count = 0;
        foreach ($dirs as $key => $filename) {
            if ($filename != ".." && $filename != ".") {
                if (is_dir($path . "/" . $filename)) {
                    $new_foldersize = self::getSizeAllFolder($path . "/" . $filename);
                    $count_size = $count_size + $new_foldersize;
                } else if (is_file($path . "/" . $filename)) {
                    $count_size = $count_size + filesize($path . "/" . $filename);
                    $count++;
                }
            }
        }

        return [
            'size' => sizeFormat($count_size),
            'count' => $count
        ];
    }


    public static function getFolderInfo($folder)
    {
        return pathinfo($folder);
    }
}
