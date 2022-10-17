<?php

namespace App\Models\User;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
