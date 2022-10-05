<?php

namespace App\Models\Core;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Core\LogBanque
 *
 * @property int $id
 * @property string $type
 * @property string $message
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $user_id
 * @property-read mixed $type_label
 * @property-read User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|LogBanque newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LogBanque newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LogBanque query()
 * @method static \Illuminate\Database\Eloquent\Builder|LogBanque whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LogBanque whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LogBanque whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LogBanque whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LogBanque whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LogBanque whereUserId($value)
 * @mixin \Eloquent
 */
class LogBanque extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $appends = ['type_label'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getTypeLabelAttribute()
    {
        switch ($this->type) {
            case 'error': return '<span class="badge badge-danger "><i class="fa-solid fa-xmark text-white me-3"></i> Erreur</span>';
            case 'warning': return '<span class="badge badge-warning"><i class="fa-regular fa-triangle-exclamation text-white me-3"></i> Attention</span>';
            case 'success': return '<span class="badge badge-success"><i class="fa-regular fa-check-circle text-white me-3"></i> Réussi</span>';
            case 'info': return '<span class="badge badge-primary"><i class="fa-regular fa-circle-exclamation text-white me-3"></i> Information</span>';
            default : return '<span class="badge badge-light"><i class="fa-regular fa-exclamation text-white me-3"></i> Inconnue</span>';
        }
    }
}
