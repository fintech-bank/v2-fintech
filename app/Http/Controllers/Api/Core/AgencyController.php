<?php

namespace App\Http\Controllers\Api\Core;

use App\Helper\LogHelper;
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

    public function update(Request $request, $agency_id)
    {
        $agency = Agency::find($agency_id);

        try {
            $agency->update($request->except('_token'));
            LogHelper::insertLogSystem('success', "Edition de l'agence ".$agency->name);

            return response()->json($agency);
        }catch (\Exception $exception) {
            LogHelper::notify('critical', $exception->getMessage(), $exception);
            return response()->json($exception, 500);
        }
    }

    public function delete($agency_id)
    {
        $agency = Agency::find($agency_id);
        if($agency->users->count() == 0) {
            try {
                $agency->delete();

                LogHelper::insertLogSystem('success', "Suppression de l'agence ".$agency->name);

                return response()->json($agency);
            }catch (\Exception $exception) {
                LogHelper::notify('critical', $exception->getMessage(), $exception);
                return response()->json($exception, 500);
            }
        } else {
            LogHelper::insertLogSystem('warning', "L'agence $agency->name ne peut être supprimer car elle comporte des clients.");
            return response()->json($agency, 408);
        }
    }

    private function formatCommunication(Agency $agence)
    {
        ?>
        <a href="tel:<?= $agence->phone; ?>"><i class="fa-solid fa-phone me-3"></i>: <?= $agence->phone; ?></a>
        <?php

        return ob_get_clean();
    }
}
