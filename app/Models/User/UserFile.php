<?php

namespace App\Models\User;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
