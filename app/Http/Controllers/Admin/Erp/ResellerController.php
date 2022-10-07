<?php

namespace App\Http\Controllers\Admin\Erp;

use App\Helper\DocumentFile;
use App\Helper\GeoHelper;
use App\Helper\LogHelper;
use App\Helper\UserHelper;
use App\Http\Controllers\Controller;
use App\Models\Core\Agency;
use App\Models\Customer\CustomerWithdrawDab;
use App\Models\Reseller\Reseller;
use App\Models\User;
use App\Notifications\Reseller\WelcomeNotification;
use App\Services\GeoPortailLook;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Illuminate\Http\Request;

class ResellerController extends Controller
{
    public function index()
    {
        return view('admin.erp.reseller.index', [
            'resellers' => Reseller::all()
        ]);
    }

    public function store(Request $request)
    {
        $agence = Agency::find(1);
        $password = \Str::random(8);
        try {
            $user = User::create([
                'name' => $request->get('name'),
                'email' => $request->get('email'),
                'password' => \Hash::make($password),
                'customer' => 0,
                'reseller' => 1,
                'identifiant' => UserHelper::generateID(),
                'agency_id' => 1
            ]);

            $dab = CustomerWithdrawDab::create([
                'type' => $request->get('type'),
                'name' => $request->get('name'),
                'address' => $request->get('address'),
                'postal' => $request->get('postal'),
                'city' => $request->get('city'),
                'latitude' => GeoPortailLook::call($request->get('address').' '.$request->get('postal').' '.$request->get('city'))->features[0]->geometry->coordinates[0],
                'longitude' => GeoPortailLook::call($request->get('address').' '.$request->get('postal').' '.$request->get('city'))->features[0]->geometry->coordinates[1],
                'img' => '/storage/reseller/'.$user->id.'/'.$user->id.'.'.$request->file('logo')->getClientOriginalExtension(),
                'open' => $request->get('open'),
                'phone' => $request->get('phone')
            ]);

            $reseller = Reseller::create([
                'limit_outgoing' => $request->get('limit_outgoing'),
                'limit_incoming' => $request->get('limit_incoming'),
                'user_id' => $user->id,
                'customer_withdraw_dabs_id' => $dab->id
            ]);
        }catch (\Exception $exception) {
            LogHelper::notify('critical', $exception);
            return redirect()->back()->with('error', "Erreur lors de l'execution de l'appel, consulter les logs ou contacter un administrateur");
        }

        try {
            $request->file('logo')->storeAs('public/reseller/'.$user->id.'/', $user->id.'.'.$request->file('logo')->getClientOriginalExtension());
        }catch (\Exception $exception) {
            LogHelper::notify('critical', $exception);
            return redirect()->back()->with('error', "Erreur lors de l'execution de l'appel, consulter les logs ou contacter un administrateur");
        }

        // Création du contrat
        $document = null;

        try {

            $pdf = PDF::setOptions([
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true,
                'chroot' => [
                    realpath(base_path()).'/public/css',
                    realpath(base_path()).'/storage/logo',
                ],
                'enable-local-file-access' => true,
                'viewport-size' => '1280x1024',
            ])->loadView('pdf.reseller.contrat' , [
                'agence' => $agence,
                'title' => $document != null ? $document->name : 'Document',
                'reseller' => $reseller
            ]);

            $pdf->save(public_path('storage/reseller/'.$user->id.'/contrat.pdf'));
        }catch (\Exception $exception) {
            LogHelper::notify('critical', $exception);
            return redirect()->back()->with('error', "Erreur lors de l'execution de l'appel, consulter les logs ou contacter un administrateur");
        }

        $reseller->user->notify(new WelcomeNotification($reseller, $password));

        return redirect()->back()->with('success', 'Le distributeur '.$reseller->dab->name.' à été créer avec succès');
    }
}
