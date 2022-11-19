<?php

namespace App\Helper;

use App\Models\Customer\Customer;
use App\Notifications\Customer\SendRequestNotification;
use Illuminate\Database\Eloquent\Model;

class RequestHelper
{
    /**
     * @param Customer $customer
     * @param string $sujet
     * @param string|null $comment
     * @param $model
     * @param int|null $model_id
     * @return Model
     */
    public static function create(Customer $customer, string $sujet, string $comment = null, $model = null, int $model_id = null)
    {
        $request = $customer->requests()->create([
            'reference' => generateReference(10),
            'sujet' => $sujet,
            'commentaire' => $comment,
            'link_model' => $model,
            'link_id' => $model_id,
            'customer_id' => $customer->id
        ]);

        $customer->info->notify(new SendRequestNotification($customer, $request));

        return $request;
    }
}
