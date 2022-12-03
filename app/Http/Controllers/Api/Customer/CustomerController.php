<?php

namespace App\Http\Controllers\Api\Customer;

use App\Helper\CustomerInfoHelper;
use App\Helper\LogHelper;
use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Controller;
use App\Jobs\Customer\AlertCustomerJob;
use App\Jobs\Customer\NewSponsorshipJob;
use App\Jobs\User\DroitAccessJob;
use App\Jobs\User\GrpdPortabilityJob;
use App\Mail\Customer\SendSignateDocumentRequestMail;
use App\Models\Core\Sponsorship;
use App\Models\Customer\Customer;
use App\Models\Customer\CustomerDocument;
use App\Models\Customer\CustomerGrpdDemande;
use App\Models\Customer\CustomerInfo;
use App\Models\User;
use App\Notifications\Agent\NewGrpdNotification;
use App\Notifications\Customer\GrpdNewDroitAcceNotification;
use App\Notifications\Customer\GrpdUpdateDroitAcceNotification;
use App\Notifications\Customer\SendGeneralCodeNotification;
use App\Notifications\Customer\Sending\SendVerifyAddressCustomerLinkNotification;
use App\Notifications\Customer\Sending\SendVerifyIdentityCustomerLinkNotification;
use App\Notifications\Customer\Sending\SendVerifyIncomeCustomerLinkNotification;
use App\Scope\VerifCNITrait;
use App\Services\Persona;
use App\Services\Twilio\Lookup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Redis;

class CustomerController extends ApiController
{
    public function search(Request $request)
    {
        dd($request->all());
    }

    public function subscribe(Request $request)
    {
        return match ($request->get('action')) {
            'alerta' => $this->subscribeAlerta(),
            'dailyInsurance' => $this->subscribeDailyInsurance(),
            'dab' => $this->subscribeDab(),
            'overdraft' => $this->subscribeOverdraft($request->get('overdraft_amount')),
            'card_code' => $this->subscribeCardCode(),
            'offert' => $this->subscribeOffert(),
            default => null,
        };
    }

    public function signateDocument(Request $request)
    {
        $document = CustomerDocument::find($request->get('document_id'));
        $customer = $document->customer;

        Mail::to($customer->user)->send(new SendSignateDocumentRequestMail($customer, base64_encode($request->get('document_id'))));

        return response()->json($document);
    }

    public function verifySign(Request $request)
    {
        $document = CustomerDocument::find($request->get('document_id'));
        $document->update([
            'signed_by_client' => true
        ]);

        return response()->json();
    }

    public function verifSecure(Request $request, $code)
    {
        $customer = Customer::find($request->get('customer_id'));
        $code_customer = base64_decode($customer->auth_code);

        if ($code == $code_customer) {
            return response()->json();
        } else {
            return response()->json(['errors' => ['Le code SECURPASS est invalide']], 401);
        }
    }

    public function reinitPass($customer_id)
    {
        $password = \Str::random(8);
        $customer = Customer::find($customer_id);

        try {
            $customer->user->update([
                'password' => \Hash::make($password)
            ]);

            $customer->user->notify(new SendPasswordNotification($customer, $password));
        } catch (\Exception $exception) {
            LogHelper::notify('critical', $exception->getMessage(), $exception);
            return response()->json($exception->getMessage(), 500);
        }

        return response()->json();
    }

    public function reinitCode($customer_id)
    {
        $code = random_numeric(4);
        $customer = Customer::find($customer_id);

        try {
            $customer->update([
                'auth_code' => base64_encode($code),
            ]);

            $customer->user->notify(new SendSecurePassCodeNotification($code));
        } catch (\Exception $exception) {
            LogHelper::notify('critical', $exception->getMessage(), $exception);
            return response()->json($exception->getMessage(), 500);
        }
        return response()->json();
    }

    public function verifAllSolde($customer_id)
    {
        $customer = Customer::find($customer_id);
        $wallets = [];

        foreach ($customer->wallets as $wallet) {
            if ($wallet->balance_actual < 0 && $wallet->decouvert == 0) {
                $wallets[] = [
                    'compte' => $wallet->number_account,
                    'status' => 'outdated',
                ];
            } else {
                $wallets[] = [
                    'compte' => $wallet->number_account,
                    'status' => 'ok',
                ];
            }
        }

        return $wallets;
    }

    public function updateBusiness($customer_id, Request $request)
    {
        $customer = Customer::find($customer_id);
        if ($request->has('ca')) {
            $customer->business->result -= $customer->business->ca;
            $customer->business->result += $request->get('ca');

            $customer->business->result_finance -= $customer->business->apport_personnel;
            $customer->business->result_finance += $request->get('apport_personnel');
        } elseif ($request->has('achat')) {
            $customer->business->result += $customer->business->achat;
            $customer->business->result -= $request->get('achat');
        } elseif ($request->has('frais')) {
            $customer->business->result += $customer->business->frais;
            $customer->business->result -= $request->get('frais');
        } elseif ($request->has('salaire')) {
            $customer->business->result += $customer->business->salaire;
            $customer->business->result -= $request->get('salaire');
        } elseif ($request->has('impot')) {
            $customer->business->result += $customer->business->impot;
            $customer->business->result -= $request->get('impot');
        } elseif ($request->has('other_charge')) {
            $customer->business->result += $customer->business->other_charge;
            $customer->business->result -= $request->get('other_charge');
        } elseif ($request->has('other_product')) {
            $customer->business->result -= $customer->business->other_product;
            $customer->business->result += $request->get('other_product');

            $customer->business->result_finance -= $customer->business->apport_personnel;
            $customer->business->result_finance += $request->get('apport_personnel');
        } elseif ($request->has('apport_personnel')) {
            $customer->business->result_finance -= $customer->business->apport_personnel;
            $customer->business->result_finance += $request->get('apport_personnel');
        } elseif ($request->has('finance')) {
            $customer->business->result_finance -= $customer->business->finance;
            $customer->business->result_finance += $request->get('finance');
        }

        $customer->business->update($request->except('_token'));

        $calc = intval($customer->business->result_finance / ($customer->business->result + $customer->business->result_finance) * 100);
        if ($calc <= 20) {
            $customer->business->update(['indicator' => false]);
        } else {
            $customer->business->update(['indicator' => true]);
        }

        return response()->json($customer);
    }

    public function alert($customer_id, Request $request)
    {
        match ($request->get('action')) {
            $request->get('action') => dispatch(new AlertCustomerJob($customer_id, $request->get('action'), now()->addMinute()))
        };

        return response()->json();
    }

    public function verify(Request $request)
    {
        $customer = Customer::find($request->get('customer_id'));
        switch ($request->get('verify')) {
            case 'identity':
                $customer->info->notify(new SendVerifyIdentityCustomerLinkNotification($customer, "Sécurité"));
                break;

            case 'address':
                $customer->info->notify(new SendVerifyAddressCustomerLinkNotification($customer, "Sécurité"));
                break;

            case 'income':
                $customer->info->notify(new SendVerifyIncomeCustomerLinkNotification($customer, "Sécurité"));
                break;

            case 'cni':
                $cn = $this->verifyCni(
                    $request->get('cni_number'),
                    $request->get('cni_version')
                );

                return response()->json($cn);

            case 'phone':
                $verify = CustomerInfoHelper::verifyMobilePhone($customer, $request->get('mobile'), $request->get('code'));
                if ($verify->count() == 0) {
                    $customer->info->update([
                        'mobile' => $request->get('mobile'),
                        'mobileVerified' => true
                    ]);

                    return $this->sendSuccess();
                } else {
                    return $this->sendWarning($verify->first, $verify->toArray());
                }

            case 'phoneCode':
                $phone = $request->get('mobile');
                $code = random_numeric(6);
                $customer->setting->update(['code_auth' => base64_encode($phone . '/' . $code)]);
                $customer->info->notify(new SendGeneralCodeNotification($customer, $code));

                return response()->json();

            case 'pass':
                if (\Hash::check($request->get('pass'), $customer->user->password)) {
                    return $this->sendSuccess();
                } else {
                    return $this->sendError();
                }

            case 'securePassLogin':
                $customer->setting->update([
                    'securpass' => true,
                    'securpass_model' => $request->get('agent'),
                    'securpass_key' => base64_encode($request->get('agent') . '/' . $customer->auth_code)
                ]);

                return $this->sendSuccess();

            case 'updatePass':
                if (\Hash::check($request->get('password'), $customer->user->password)) {
                    if ($request->get('new_password') == $request->get('new_password_confirm')) {
                        $customer->user->update([
                            'password' => \Hash::make($request->get('new_password'))
                        ]);
                    } else {
                        return $this->sendWarning("Les mots de passe ne correspond pas !");
                    }
                } else {
                    return $this->sendWarning("Le mot de passe actuel est invalide");
                }

            case 'updateMail':
                $customer->user->update(['email' => $request->get('email')]);
                $customer->info->update(['email' => $request->get('email')]);

                return $this->sendSuccess("L'adresse mail à été mise à jours");

            case 'secure':
                if ($customer->setting->securpass_model == $request->get('agent')) {
                    return $this->sendSuccess();
                } else {
                    return $this->sendError();
                }
        }

        return response()->json();
    }

    public function endettement($customer_id)
    {
        $customer = Customer::find($customer_id);
        $income = $customer->income->pro_incoming;
        $charge = $customer->charge->rent + $customer->charge->credit + $customer->charge->divers + $customer->prets()->where('status', 'progress')->sum('mensuality');

        $reste_vivre = $customer->income->pro_incoming - $charge;
        $end = $charge / $income * 100;

        return response()->json([
            'reste' => $reste_vivre,
            'percent' => round($end, 2),
            'income' => $income,
            'charge' => $charge
        ]);
    }

    public function gauge($customer_id)
    {
        $customer = Customer::find($customer_id);
        $setting = $customer->setting;

        $start = $setting->gauge_start;
        $end = $setting->gauge_end;
        $solde = $setting->wallet->solde_remaining;
        if ($end < $solde) {
            $end = $solde;
        } else {
            $end = $setting->gauge_end;
        }

        $percent = $solde / $end * 100;

        return response()->json([
            'start' => $start,
            'end' => $end,
            'solde' => $solde,
            'percent' => $percent
        ]);
    }

    public function updateGauge($customer_id, Request $request)
    {
        $setting = Customer::find($customer_id)->setting;

        $setting->update([
            'gauge' => $request->has('gauge'),
            'gauge_show_solde' => $request->has('gauge_show_solde'),
            'gauge_show_op_waiting' => $request->has('gauge_show_op_waiting'),
            'gauge_show_last_op' => $request->has('gauge_show_last_op'),
            'gauge_start' => $request->get('gauge_start'),
            'gauge_end' => $request->get('gauge_end'),
            'customer_wallet_id' => $request->get('customer_wallet_id'),
        ]);

        return response()->json();
    }

    public function update($user_id, Request $request)
    {
        $user = User::find($user_id);
        return match ($request->get('action')) {
            "mail" => $this->updateMail($user, $request),
            "phone" => $this->updatePhone($user, $request),
            "address" => $this->updateAddress($user, $request),
            "grpd_consent" => $this->updateGrpdConsent($user, $request),
            "grpd_rip" => $this->updateGrpdRip($user, $request),
            'droit_acces' => $this->accessDroitAcces($user, $request),
            'inacurate' => $this->accessInacurate($user, $request),
            'com_prospecting' => $this->comProspecting($user, $request),
            'erasure' => $this->erasure($user, $request),
            'limit' => $this->limit($user, $request),
            'portability' => $this->portability($user, $request)
        };
    }

    public function delete($user_id, Request $request)
    {
        $user = User::find($user_id);
        return match ($request->get('action')) {
            "cancelRequest" => $this->cancelRequest($user, $user->customers->grpd_demande()->find($request->get('id')))
        };
    }

    public function sponsorship($user_id, Request $request)
    {
        $code = \Str::upper(\Str::random(6));
        $user = User::find($user_id);

        if (CustomerInfo::where('firstname', $request->get('firstname'))
                ->where('lastname', $request->get('lastname'))
                ->orWhere('email', $request->get('email'))->count() != 0) {
            return $this->sendWarning("Ce client existe déjà chez nous !");
        } else {
            $sponsor = Sponsorship::create([
                'civility' => $request->get('civility'),
                'firstname' => $request->get('firstname'),
                'lastname' => $request->get('lastname'),
                'email' => $request->get('email'),
                'postal' => $request->get('postal'),
                'city' => $request->get('city'),
                'code' => base64_encode($request->get('email') . '/' . $code),
                'customer_id' => $user->customers->id
            ]);

            dispatch(new NewSponsorshipJob($sponsor))->delay(now()->addMinute());

            return $this->sendSuccess("Votre nouveau filleul à été ajouté et un email lui à été envoyer");
        }
    }

    private function subscribeAlerta()
    {
        session()->put('subscribe.alerta', true);
        return response()->json(['offer' => 'Alerta']);
    }

    private function subscribeDailyInsurance()
    {
        session()->put('subscribe.daily_insurance', true);
        return response()->json(['offer' => 'Mon Assurance au quotidien']);
    }

    private function subscribeDab()
    {
        session()->put('subscribe.dab', true);
        return response()->json(['offer' => 'Retrait DAB Illimité']);
    }

    private function subscribeOverdraft($amount)
    {
        session()->put('subscribe.overdraft', true);
        session()->put('subscribe.overdraft_amount', $amount);

        return response()->json(['offer' => 'Facilité de caisse']);
    }

    private function subscribeCardCode()
    {
        session()->put('subscribe.card_code', true);

        return response()->json(['offer' => 'Choisir son code secret']);
    }

    private function subscribeOffert()
    {
        session()->put('subscribe.offert', true);

        return response()->json(['offer' => "Offre de bienvenue"]);
    }

    private function verifyCni(string $cni, string $versionCNI = '1995')
    {
        $cni_array = explode(',', $cni);
        if ($versionCNI == '1995') {
            return VerifCNITrait::version1992($cni_array[0], $cni_array[1]);
        } else {
            return VerifCNITrait::version2021($cni_array[0], $cni_array[1]);
        }

    }

    private function updateMail(User $user, Request $request)
    {
        $user->update(['email' => $request->get('email')]);
        $user->customers->info->update(['email' => $request->get('email')]);

        return $this->sendSuccess("L'adresse mail pricipal à été mise à jours");
    }

    private function updatePhone(\Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Collection|array|User|\LaravelIdea\Helper\App\Models\_IH_User_C|null $user, Request $request)
    {
        $lookup = new Lookup();
        if ($lookup->verify($request->get('phone'))) {
            $user->customers->info->update(['phone' => $request->get('phone'), "phoneVerified" => true]);
        } else {
            $user->customers->info->update(['phone' => $request->get('phone'), "phoneVerified" => false]);
        }

        if ($lookup->verify($request->get('mobile'))) {
            $user->customers->info->update(['mobile' => $request->get('mobile'), "mobileVerified" => true]);
        } else {
            $user->customers->info->update(['mobile' => $request->get('mobile'), "mobileVerified" => false]);
        }

        return $this->sendSuccess("Numéro de téléphone mise à jours");

    }

    private function updateAddress(\Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Collection|array|User|\LaravelIdea\Helper\App\Models\_IH_User_C|null $user, Request $request)
    {
        $user->customers->info->update([
            'address' => $request->get('address'),
            'addressbis' => $request->get('addressbis'),
            'postal' => $request->get('postal'),
            'city' => $request->get('city'),
            'country' => $request->get('country'),
        ]);

        return $this->sendSuccess("Adresse postal modifié avec succès, veuillez faire vérifier votre adresse postal");
    }

    private function updateGrpdConsent(\Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Collection|array|User|\LaravelIdea\Helper\App\Models\_IH_User_C|null $user, Request $request)
    {
        $user->customers->grpd->update($request->except('_token', 'action', '_method'));

        return $this->sendSuccess("Consentement GRPD mis à jour");
    }

    private function updateGrpdRip(\Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Collection|array|User|\LaravelIdea\Helper\App\Models\_IH_User_C|null $user, Request $request)
    {
        $user->customers->grpd->update($request->except('_token', 'action', '_method'));

        return $this->sendSuccess("GRPD Communication mis à jour");
    }

    private function accessDroitAcces(\Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Collection|array|User|\LaravelIdea\Helper\App\Models\_IH_User_C|null $user, Request $request)
    {
        $req = $user->customers->grpd_demande()->create([
            'type' => 'personal_data',
            'object' => $request->get('type'),
            'comment' => $request->get('type') == 'other' ? "<p>{$request->get('object_comment')}</p> <p>{$request->get('comment')}</p>" : 'Aucune informations disponible',
            'customer_id' => $user->customers->id
        ]);
        // Création d'un job pour traité l'information si != other

        if ($request->get('type') != 'other') {
            dispatch(new DroitAccessJob($user, $req, $request->get('type')))->delay(now()->addHours(rand(1, 6)));
        }

        // Notification
        $user->customers->info->notify(new GrpdNewDroitAcceNotification($user->customers, $req, 'Contact avec votre banque'));
        return $this->sendSuccess("Votre demande à bien été transmis");
    }

    private function accessInacurate(\Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Collection|array|User|\LaravelIdea\Helper\App\Models\_IH_User_C|null $user, Request $request)
    {
        $req = $user->customers->grpd_demande()->create([
            'type' => 'inacurate',
            'object' => $request->get('object'),
            'comment' => $request->get('comment'),
            'customer_id' => $user->customers->id
        ]);

        $user->customers->agent->user->notify(new NewGrpdNotification($req));
        $user->customers->info->notify(new GrpdNewDroitAcceNotification($user->customers, $req, 'Contact avec votre banque'));

        return $this->sendSuccess("Votre demande de rectification à bien été prise en comptes");
    }

    private function comProspecting(\Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Collection|array|User|\LaravelIdea\Helper\App\Models\_IH_User_C|null $user, Request $request)
    {
        $req = $user->customers->grpd_demande()->create([
            'type' => 'com_prospecting',
            'object' => $request->get('object'),
            'comment' => $request->get('comment'),
            'customer_id' => $user->customers->id
        ]);

        $user->customers->agent->user->notify(new NewGrpdNotification($req));
        $user->customers->info->notify(new GrpdNewDroitAcceNotification($user->customers, $req, 'Contact avec votre banque'));

        return $this->sendSuccess("Votre demande d'opposition nous à bien été transmis et sera traiter dans les plus bref délai");
    }

    private function erasure(\Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Collection|array|User|\LaravelIdea\Helper\App\Models\_IH_User_C|null $user, Request $request)
    {
        $req = $user->customers->grpd_demande()->create([
            'type' => 'com_prospecting',
            'object' => $request->get('object'),
            'comment' => $request->get('comment'),
            'customer_id' => $user->customers->id
        ]);

        $user->customers->agent->user->notify(new NewGrpdNotification($req));
        $user->customers->info->notify(new GrpdNewDroitAcceNotification($user->customers, $req, 'Contact avec votre banque'));

        return $this->sendSuccess("Votre demande de suppression nous à bien été transmis et sera traiter dans les plus bref délai");
    }

    private function limit(\Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Collection|array|User|\LaravelIdea\Helper\App\Models\_IH_User_C|null $user, Request $request)
    {
        $req = $user->customers->grpd_demande()->create([
            'type' => 'com_prospecting',
            'object' => $request->get('object'),
            'comment' => $request->get('comment'),
            'customer_id' => $user->customers->id
        ]);

        $user->customers->agent->user->notify(new NewGrpdNotification($req));
        $user->customers->info->notify(new GrpdNewDroitAcceNotification($user->customers, $req, 'Contact avec votre banque'));

        return $this->sendSuccess("Votre demande de limitation d'utilisation de vos données nous à bien été transmis et sera traiter dans les plus bref délai");
    }

    private function portability(\Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Collection|array|User|\LaravelIdea\Helper\App\Models\_IH_User_C|null $user, Request $request)
    {
        $req = $user->customers->grpd_demande()->create([
            'type' => 'portability',
            'object' => "Demande de Portabilité",
            'comment' => "Aucune description",
            'customer_id' => $user->customers->id
        ]);

        dispatch(new GrpdPortabilityJob($user, $req))->delay(now()->addMinutes(rand(1, 300)));

        $user->customers->info->notify(new GrpdNewDroitAcceNotification($user->customers, $req, 'Contact avec votre banque'));

        return $this->sendSuccess("Votre demande de document à bien été transmis et sera bientôt disponible");
    }

    private function cancelRequest(\Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Collection|array|User|\LaravelIdea\Helper\App\Models\_IH_User_C|null $user, CustomerGrpdDemande $find)
    {
        $request = $find;

        $request->update(['status' => 'cancel']);

        $user->customers->info->notify(new GrpdUpdateDroitAcceNotification($user->customers, $request, 'Contact avec votre banque'));

        return $this->sendSuccess("Votre demande à bien été annulé");
    }
}
