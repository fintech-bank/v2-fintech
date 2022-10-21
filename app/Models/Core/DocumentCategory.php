<?php

namespace App\Models\Core;

use App\Helper\LogHelper;
use App\Models\Customer\CustomerDocument;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Core\DocumentCategory
 *
 * @property int $id
 * @property string $name
 * @property-read \Illuminate\Database\Eloquent\Collection|CustomerDocument[] $documents
 * @property-read int|null $documents_count
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentCategory whereName($value)
 * @mixin \Eloquent
 * @mixin IdeHelperDocumentCategory
 * @property string $slug
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentCategory whereSlug($value)
 */
class DocumentCategory extends Model
{
    use HasFactory;

    protected $guarded = [];

    public $timestamps = false;

    public function documents()
    {
        return $this->hasMany(CustomerDocument::class);
    }

    public static function boot()
    {
        parent::boot();

        static::created(function ($category) {
            LogHelper::insertLogSystem('success', "La catégorie de document à été ajouté: " . $category->name);
        });

        static::updated(function ($category) {
            LogHelper::insertLogSystem('success', "La catégorie de document à été édité: " . $category->name);
        });

        static::deleted(function () {
            LogHelper::insertLogSystem('success', "Une catégorie de document à été supprimé");
        });
    }
}
