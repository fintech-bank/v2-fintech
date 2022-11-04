<?php


namespace App\Services\Twilio;


use App\Helper\LogHelper;

class Lookup extends Twilio
{
    public function verify($phone)
    {
        try {
            $result = $this->client->lookups->v1->phoneNumbers($phone)
                ->fetch();
        }catch (\Exception $exception) {
            LogHelper::notify('critical', 'Numéro Inconnue');
            return $exception->getMessage();
        }

        return $result;
    }
}
