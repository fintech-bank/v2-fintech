<?php

namespace App\Helper;

use App\Models\Customer\Customer;
use App\Models\Customer\CustomerInfo;
use App\Services\Twilio\Lookup;

class CustomerInfoHelper
{
    public static function getCivility($civility)
    {
        switch ($civility) {
            case 'M':
                return 'Monsieur';
            case 'Mme':
                return 'Madame';
            case 'Mlle':
                return 'Mademoiselle';
        }
    }

    public static function getAddress(CustomerInfo $info)
    {
        $address = $info->address . "<br>";
        $bis = $info->addressbis ? $info->addressbis . "<br>" : '';

        ob_start();
        ?>
        <?= $address; ?>
        <?= $bis; ?>
        <?= $info->postal; ?> <?= $info->city; ?>
        <?php

        return ob_get_clean();
    }

    public static function verifyMobilePhone(Customer $customer, string $mobile, string $code)
    {
        $error = collect();
        $key = decrypt(\Session::get('edit_phone_code'));
        $decode = explode('/', $key)[1];
        $lookup = new Lookup();
        if($code == $decode) {
            if($lookup->verify($mobile)) {
                return $error;
            } else {
                $error->push(["invalid_number" => "Le numéro de téléphone semble invalide"]);
            }
        } else {
            $error->push(["invalid_code" => "Le code instruit est invalide"]);
        }

        return $error;
    }
}
