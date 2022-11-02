<?php


namespace App\Services;


use App\Models\Customer\Customer;
use Illuminate\Support\Str;

class Persona
{
    protected $endpoint;
    protected $api_key;

    public function __construct()
    {
        $this->endpoint = 'https://withpersona.com/api/v1/';
        $this->api_key = config('persona-kyc.api_key');
    }

    /**
     * @param string $type
     * @param Customer $customer
     * @return string
     */
    public function verificationLink(Customer $customer, string $type = 'kyc'): string
    {
        return match ($type) {
            'kyc' => "https://fintech.withpersona.com/verify?inquiry-template-id=itmpl_dtC4KRK6GMLCzXtRcRZ68gVv&environment-id=env_4dTQPEjvQqhdSBciNzE7YzBi&fields[name-first]=".$customer->info->firstname."&fields[name-last]=".$customer->info->lastname."&fields[birthdate]=".$customer->info->datebirth->format('Y-m-d')."&fields[address-street-1]=".$customer->info->address."&fields[address-city]=".$customer->info->city."&fields[address-postal-code]=".$customer->info->postal."&fields[address-country-code]=".Str::upper(Str::limit($customer->info->firstname, 2, ''))."&fields[phone-number]=".$customer->info->mobile."&fields[email-address]=".$customer->user->email,
            'domicile' => "https://fintech.withpersona.com/verify?inquiry-template-id=itmpl_qvuQuXt48aMJYd6o345x7Ldm&environment-id=env_4dTQPEjvQqhdSBciNzE7YzBi&fields[name-first]=".$customer->info->firstname."&fields[name-last]=".$customer->info->lastname."&fields[birthdate]=".$customer->info->datebirth->format('Y-m-d')."&fields[address-street-1]=".$customer->info->address."&fields[address-city]=".$customer->info->city."&fields[address-postal-code]=".$customer->info->postal."&fields[address-country-code]=".Str::upper(Str::limit($customer->info->firstname, 2, ''))."&fields[phone-number]=".$customer->info->mobile."&fields[email-address]=".$customer->user->email,
            'revenue' => "https://fintech.withpersona.com/verify?inquiry-template-id=itmpl_1KZgojcfDHDbq185tYBTkdUQ&environment-id=env_4dTQPEjvQqhdSBciNzE7YzBi&fields[name-first]=".$customer->info->firstname."&fields[name-last]=".$customer->info->lastname."&fields[birthdate]=".$customer->info->datebirth->format('Y-m-d')."&fields[address-street-1]=".$customer->info->address."&fields[address-city]=".$customer->info->city."&fields[address-postal-code]=".$customer->info->postal."&fields[address-country-code]=".Str::upper(Str::limit($customer->info->firstname, 2, ''))."&fields[phone-number]=".$customer->info->mobile."&fields[email-address]=".$customer->user->email,
            default => "https://fintech.withpersona.com/",
        };
    }


}
