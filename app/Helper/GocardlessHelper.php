<?php

namespace App\Helper;

use App\Models\Customer\Customer;

class GocardlessHelper extends \App\Services\GoCardless\Api
{
    // Client
    public function createCustomer(Customer $customer): \GoCardlessPro\Resources\Customer
    {
        return $this->client->customers()->create([
            'params' => [
                'email' => $customer->user->email,
                'given_name' => $customer->info->type == 'part' ? $customer->info->lastname : null,
                'family_name' => $customer->info->type == 'part' ? $customer->info->firstname : null,
                'address_line1' => $customer->info->address,
                'address_line2' => $customer->info->addressbis,
                'city' => $customer->info->city,
                'company_name' => $customer->info->type != 'part' ? $customer->info->company : null,
                'country_code' => $customer->info->country,
                'phone_number' => $customer->info->mobile,
                'postal_code' => $customer->info->postal,
            ]
        ]);
    }
    public function getCustomer($go_customer_id): \GoCardlessPro\Resources\Customer
    {
        return $this->client->customers()->get($go_customer_id);
    }
    public function updateCustomer($go_customer_id, Customer $customer): \GoCardlessPro\Resources\Customer
    {
        return $this->client->customers()->update($go_customer_id, [
            'params' => [
                'email' => $customer->user->email,
                'given_name' => $customer->info->type == 'part' ? $customer->info->lastname : null,
                'family_name' => $customer->info->type == 'part' ? $customer->info->firstname : null,
                'address_line1' => $customer->info->address,
                'address_line2' => $customer->info->addressbis,
                'city' => $customer->info->city,
                'company_name' => $customer->info->type != 'part' ? $customer->info->company : null,
                'country_code' => $customer->info->country,
                'phone_number' => $customer->info->mobile,
                'postal_code' => $customer->info->postal,
            ]
        ]);
    }
    public function deleteCustomer($go_customer_id): \GoCardlessPro\Resources\Customer
    {
        return $this->client->customers()->remove($go_customer_id);
    }
}
