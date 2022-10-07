<?php

namespace App\Http\Controllers\Api\Core;

use App\Helper\LogHelper;
use App\Http\Controllers\Controller;
use App\Models\Reseller\Reseller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ResellerController extends Controller
{
    public function get($reseller_id)
    {
        $reseller = Reseller::find($reseller_id);
    }

    public function delete($reseller_id)
    {
        $reseller = Reseller::find($reseller_id);

        try {
            $reseller->user->delete();
            $reseller->dab->delete();
            $reseller->delete();

            try {
                Storage::disk('public')->deleteDirectory('reseller/'.$reseller->user->id);
            }catch (\Exception $exception) {
                LogHelper::notify('critical', $exception);
                return response()->json(null, 500);
            }

            return response()->json();
        }catch (\Exception $exception) {
            LogHelper::notify('critical', $exception);
            return response()->json(null, 500);
        }
    }
}
