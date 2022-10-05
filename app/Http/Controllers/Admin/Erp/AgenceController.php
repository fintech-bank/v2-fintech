<?php

namespace App\Http\Controllers\Admin\Erp;

use App\Helper\AgencyHelper;
use App\Helper\LogHelper;
use App\Http\Controllers\Controller;
use App\Models\Core\Agency;
use Illuminate\Http\Request;

class AgenceController extends Controller
{
    public function index()
    {
        return view("admin.erp.agence.index", [
            'agences' => Agency::all()
        ]);
    }

    public function store(Request $request)
    {
        try {
            $agence = Agency::create([
                'name' => $request->get('name'),
                'bic' => AgencyHelper::generateBic($request->get('name')),
                'address' => $request->get('address'),
                'postal' => $request->get('postal'),
                'city' => $request->get('city'),
                'country' => $request->get('country'),
                'phone' => $request->get('phone'),
                'online' => $request->has('online') ? 1 : 0,
                'code_agence' => mt_rand(10000,99999),
                'code_banque' => mt_rand(10000,99999),
            ]);
            LogHelper::insertLogSystem('success', "Création d'une nouvelle agence: $agence->name");

            return response()->json($agence);
        }catch (\Exception $exception) {
            LogHelper::notify('critical', $exception);
            return response()->json(null, 500);
        }
    }

    public function edit($agency_id)
    {
        $agency = Agency::find($agency_id);

        return view('admin.erp.agence.edit', compact('agency'));
    }
}
