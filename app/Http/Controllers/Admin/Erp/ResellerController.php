<?php

namespace App\Http\Controllers\Admin\Erp;

use App\Helper\DocumentFile;
use App\Helper\GeoHelper;
use App\Helper\LogHelper;
use App\Helper\UserHelper;
use App\Http\Controllers\Controller;
use App\Models\Core\Agency;
use App\Models\Core\Shipping;
use App\Models\Core\ShippingTrack;
use App\Models\Customer\CustomerWithdrawDab;
use App\Models\Reseller\Reseller;
use App\Models\User;
use App\Notifications\Reseller\ShipTpeNotification;
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

        // Création du distributeur
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

        // Création de l'envoie du TPE
        try {
            $shipTPE = Shipping::create([
                'number_ship' => \Str::random(18),
                'product' => "TPE Distributeur",
                'date_delivery_estimated' => now()->addDays(5),
            ]);

            ShippingTrack::create([
                'state' => 'ordered',
                'shipping_id' => $shipTPE->id
            ]);

            $reseller->shippings()->attach($shipTPE->id);

            $reseller->user->notify(new ShipTpeNotification($reseller, $shipTPE));
        }catch (\Exception $exception) {
            LogHelper::notify('critical', $exception);
            return redirect()->back()->with('error', "Erreur lors de l'execution de l'appel, consulter les logs ou contacter un administrateur");
        }

        // Enregistrement du logo
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

    public function show($reseller_id)
    {
        $reseller = Reseller::find($reseller_id);

        return view('admin.erp.reseller.show', [
            'reseller' => $reseller
        ]);
    }

    public function edit($reseller_id)
    {
        return view('admin.erp.reseller.edit', [
            'reseller' => Reseller::find($reseller_id)
        ]);
    }

    public function update(Request $request, $reseller_id)
    {
        $reseller = Reseller::find($reseller_id);

        try {
            $reseller->user()->update([
                'email' => $request->get('email')
            ]);

            $reseller->dab()->update([
                'type' => $request->has('type') ? $request->get('type'): null,
                'name' => $request->has('name') ? $request->get('name'): null,
                'address' => $request->has('address') ? $request->get('address'): null,
                'postal' => $request->has('postal') ? $request->get('postal'): null,
                'city' => $request->has('city') ? $request->get('city'): null,
                'latitude' => $request->has('address') ? GeoPortailLook::call($request->get('address').' '.$request->get('postal').' '.$request->get('city'))->features[0]->geometry->coordinates[0] : null,
                'longitude' => $request->has('address') ? GeoPortailLook::call($request->get('address').' '.$request->get('postal').' '.$request->get('city'))->features[0]->geometry->coordinates[1] : null,
                'img' => $request->has('logo') ? '/storage/reseller/'.$reseller->user->id.'/'.$reseller->user->id.'.'.$request->file('logo')->getClientOriginalExtension() : null,
                'open' => $request->has('open') ? $request->get('open'): null,
                'phone' => $request->has('phone') ? $request->get('phone'): null
            ]);

            $reseller->update([
                'limit_outgoing' => $request->has('limit_outgoing') ? $request->get('limit_outgoing'): null,
                'limit_incoming' => $request->has('limit_incoming') ? $request->get('limit_incoming'): null
            ]);
        }catch (\Exception $exception) {
            LogHelper::notify('critical', $exception);
            return redirect()->back()->with('error', "Erreur lors de l'execution de l'appel, consulter les logs ou contacter un administrateur");
        }

        // Enregistrement du logo
        try {
            if($request->has('logo')) {
                $request->file('logo')->storeAs('public/reseller/'.$reseller->user->id.'/', $reseller->user->id.'.'.$request->file('logo')->getClientOriginalExtension());
            }
        }catch (\Exception $exception) {
            LogHelper::notify('critical', $exception);
            return redirect()->back()->with('error', "Erreur lors de l'execution de l'appel, consulter les logs ou contacter un administrateur");
        }

        return redirect()->back()->with('success', 'Le distributeur '.$reseller->dab->name.' à été éditer avec succès');
    }
}
