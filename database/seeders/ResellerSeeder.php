<?php

namespace Database\Seeders;

use App\Models\Reseller\Reseller;
use Illuminate\Database\Seeder;

class ResellerSeeder extends Seeder
{
    public function run()
    {
        Reseller::create([
            'status' => 'active',
            'limit_incoming' => 1000000,
            'limit_outgoing' => 1000000,
            'user_id' => 4,
            'customer_withdraw_dabs_id' => 1
        ]);
    }
}
