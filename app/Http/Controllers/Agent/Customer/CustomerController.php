<?php

namespace App\Http\Controllers\Agent\Customer;

use App\Helper\CustomerHelper;
use App\Helper\DocumentFile;
use App\Helper\LogHelper;
use App\Http\Controllers\Controller;
use App\Models\Core\Package;
use App\Models\Customer\Customer;
use App\Notifications\Customer\LogNotification;
use App\Notifications\Customer\UpdateStatusAccountNotification;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        return view('agent.customer.index', [
            "customers" => Customer::all()
        ]);
    }

    public function start()
    {
        return view('agent.customer.create.start');
    }

    public function finish(Request $request)
    {
        $session = (object) session()->all();
        $help = new CustomerHelper();

        if($request->has('refresh')) {
            $customer = Customer::find($request->get('customer_id'));
        } else {
            $create = $help->createCustomer($session);
            $customer = $create->customers;
            session()->forget('perso');
            session()->forget('rent');
            session()->forget('package');
            session()->forget('card');
            session()->forget('subscribe');
        }

        return view('agent.customer.create.finish', compact('customer'));
    }

    public function show($id)
    {
        $customer = Customer::find($id);

        return view('agent.customer.show', [
            'customer' => $customer
        ]);
    }

    public function update(Request $request, $customer_id)
    {
        $customer = Customer::find($customer_id);

        try {
            switch ($request->get('control')) {
                case 'address':
                    $customer->info->update([
                        'address' => $request->get('address') ? $request->get('address') : $customer->info->address,
                        'addressbis' => $request->get('addressbis') ? $request->get('addressbis') : $customer->info->addressbis,
                        'postal' => $request->get('postal') ? $request->get('postal') : $customer->info->postal,
                        'city' => $request->get('city') != null ? $request->get('city') : $customer->info->city,
                        'country' => $request->get('country') != null ? $request->get('country') : $customer->info->country,
                    ]);
                    break;

                case 'coordonnee':
                    $customer->user->update([
                        'email' => $request->get('email') && $customer->user->email !== $request->get('email') ? $request->get('email') : $customer->user->email,
                    ]);

                    $customer->info->update([
                        'phone' => $request->has('phone') && $customer->info->phone !== $request->get('phone') ? $request->get('phone') : $customer->info->phone,
                        'mobile' => $request->has('mobile') && $customer->info->mobile !== $request->get('mobile') ? $request->get('mobile') : $customer->info->mobile,
                    ]);
                    break;

                case 'situation':
                    $customer->situation->update([
                        'legal_capacity' => $request->has('legal_capacity') && $customer->situation->legal_capacity !== $request->get('legal_capacity') ? $request->get('legal_capacity') : $customer->situation->legal_capacity,
                        'family_situation' => $request->has('family_situation') && $customer->situation->family_situation !== $request->get('family_situation') ? $request->get('family_situation') : $customer->situation->family_situation,
                        'logement' => $request->has('logement') && $customer->situation->logement !== $request->get('logement') ? $request->get('logement') : $customer->situation->logement,
                        'logement_at' => $request->has('logement_at') && $customer->situation->logement_at !== $request->get('logement_at') ? $request->get('logement_at') : $customer->situation->logement_at,
                        'child' => $request->has('child') && $customer->situation->child !== $request->get('child') ? $request->get('child') : $customer->situation->child,
                        'person_charged' => $request->has('person_charged') && $customer->situation->person_charged !== $request->get('person_charged') ? $request->get('person_charged') : $customer->situation->person_charged,
                        'pro_category' => $request->has('pro_category') && $customer->situation->pro_category !== $request->get('pro_category') ? $request->get('pro_category') : $customer->situation->pro_category,
                        'pro_profession' => $request->has('pro_profession') && $customer->situation->pro_profession !== $request->get('pro_profession') ? $request->get('pro_profession') : $customer->situation->pro_profession,
                    ]);

                    $customer->income->update([
                        'pro_incoming' => $request->has('pro_incoming') && $customer->income->pro_incoming !== $request->get('pro_incoming') ? $request->get('pro_incoming') : $customer->income->pro_incoming,
                        'patrimoine' => $request->has('patrimoine') && $customer->income->patrimoine !== $request->get('patrimoine') ? $request->get('patrimoine') : $customer->income->patrimoine,
                    ]);

                    $customer->charge->update([
                        'rent' => $request->has('rent') && $customer->charge->rent !== $request->get('rent') ? $request->get('rent') : $customer->charge->rent,
                        'divers' => $request->has('divers') && $customer->charge->divers !== $request->get('divers') ? $request->get('divers') : $customer->charge->divers,
                        'nb_credit' => $request->has('nb_credit') && $customer->charge->nb_credit !== $request->get('nb_credit') ? $request->get('nb_credit') : $customer->charge->nb_credit,
                        'credit' => $request->has('credit') && $customer->charge->credit !== $request->get('credit') ? $request->get('credit') : $customer->charge->credit,
                    ]);
                    break;

                case 'communication':
                    $customer->setting->update([
                        'notif_sms' => $request->has('notif_sms') ? 1 : 0,
                        'notif_app' => $request->has('notif_app') ? 1 : 0,
                        'notif_mail' => $request->has('notif_mail') ? 1 : 0,
                    ]);
                    break;

                case 'status':
                    return $this->updateStatus($customer, $request);
                case 'type':
                    return $this->updateType($customer, $request);

            }
        }catch (\Exception $exception) {
            LogHelper::notify('critical', "Erreur Système", $exception->getMessage());
            return redirect()->back()->with('error', "Erreur lors de l'exécution de l'appel.<br>Contacter un administrateur.");
        }

        LogHelper::notify('notice', 'Mise à jours des informations du client: '.$customer->user->name);
        $customer->user->notify(new LogNotification('info', 'Vos informations personnel ont été mise à jours', null));
        return redirect()->back()->with('success', 'Les informations du client ont été mise à jours.');

    }

    public function createPret($customer_id)
    {
        $customer = Customer::find($customer_id);

        return view('agent.customer.wallet.pret.create', compact('customer'));
    }

    private function updateStatus(Customer $customer, Request $request)
    {
        if ($request->get('status_open_account') == 'closed') {
            DocumentFile::createDoc(
                $customer,
                'account close',
                'Cloture du compte',
                5,
                null,
                false,
                false,
                false,
                true
            );
        }
        try {
            $customer->update([
                'status_open_account' => $request->get('status_open_account')
            ]);

            $customer->user->notify(new UpdateStatusAccountNotification($customer, $customer->status_text));

        }catch (\Exception $exception) {
            LogHelper::notify('critical', $exception->getMessage());
            return response()->json($exception->getMessage(), 500);
        }

        return response()->json(['status' => $customer->status_text]);
    }

    private function updateType(Customer $customer, Request $request)
    {
        if ($customer->package_id != $request->get('package_id')) {
            $customer->package_id = $request->get('package_id');
            $customer->save();

            $package = Package::find($request->get('package_id'));

            $doc = DocumentFile::createDoc(
                $customer,
                'convention part',
                'Avenant Contrat Particulier',
                3,
                null,
                true,
                true,
                true,
                true,
            );

            LogHelper::insertLogSystem('success', "Avenant à un contrat bancaire pour le client {$customer->info->full_name}", auth()->user());

            // Notification Client
            $customer->user->notify(new \App\Notifications\Customer\Customer\Customer\UpdateTypeAccountNotification($customer, $package, $doc->url_forlder));
        }
        return response()->json();
    }
}
