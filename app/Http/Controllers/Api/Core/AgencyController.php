<?php

namespace App\Http\Controllers\Api\Core;

use App\Http\Controllers\Controller;
use App\Models\Core\Agency;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AgencyController extends Controller
{
    public function info($agency_id)
    {
        $agence = Agency::find($agency_id);

        $calc = 0;

        if($agence->users->count() != 0) {
            foreach ($agence->users as $user) {
                if($user->customers) {
                    $calc += $user->customers->wallets()->where('type', 'compte')->orWhere('type', 'epargne')->where('status', 'active')->sum('balance_actual');
                }
            }
        }

        $arr = [
            "name" => $agence->name,
            "agenceSl" => Str::limit($agence->name, 2, ''),
            "address" => $agence->address."<br>".$agence->postal." ".$agence->city."<br>".$agence->country,
            "communication" => $this->formatCommunication($agence),
            "agence_type" => $agence->online_label,
            "count" => $agence->users->count(),
            "sum_all_wallet" => eur($calc)
        ];

        return response()->json($arr);
    }

    private function formatCommunication(Agency $agence)
    {
        ?>
        <a href="tel:<?= $agence->phone; ?>"><i class="fa-solid fa-phone me-3"></i>: <?= $agence->phone; ?></a>
        <?php

        return ob_get_clean();
    }
}
