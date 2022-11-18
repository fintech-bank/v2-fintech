<?php

namespace Database\Factories\Customer;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer\CustomerInfo>
 */
class CustomerInfoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $type = ['part', 'pro'];
        $tps = $type[rand(0, 1)];
        $civility = ['M', 'Mme', 'Mlle'];
        $civ = $civility[rand(0, 2)];

        $postal = \Str::replace(' ', '', $this->faker->postcode);

        //dd(Carbon::createFromTimestamp($this->faker->dateTimeBetween('1900-01-01', '2004-01-01')->getTimestamp()));
        return [
            'type' => $tps,
            'address' => $this->faker->streetAddress,
            'addressbis' => $this->faker->boolean == true ? $this->faker->streetAddress : null,
            'postal' => $postal,
            'city' => $this->faker->city,
            'country' => 'FR',
            'phone' => $this->faker->e164PhoneNumber(),
            'mobile' => "+33".rand(6,7).rand(10000000,99999999),
            'isVerified' => $this->faker->boolean,
        ];
    }
}
