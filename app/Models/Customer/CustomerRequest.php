<?php

namespace App\Models\Customer;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Customer\CustomerRequest
 *
 * @property int $id
 * @property string $sujet
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $customer_id
 * @property-read \App\Models\Customer\Customer $customer
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Customer\CustomerRequestDocument[] $documents
 * @property-read int|null $documents_count
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerRequest newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerRequest newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerRequest query()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerRequest whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerRequest whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerRequest whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerRequest whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerRequest whereSujet($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerRequest whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string $reference
 * @property string|null $commentaire
 * @property string|null $link_model
 * @property int|null $link_id
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerRequest whereCommentaire($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerRequest whereLinkId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerRequest whereLinkModel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerRequest whereReference($value)
 */
class CustomerRequest extends Model
{
    protected $guarded = [];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function documents()
    {
        return $this->hasMany(CustomerRequestDocument::class);
    }
}
