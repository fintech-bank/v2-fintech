<?php

namespace App\Http\Controllers\Customer\Profil;

use App\Http\Controllers\Controller;
use App\Jobs\Customer\Transfer\TransferAgencyJob;
use App\Models\Customer\Customer;
use App\Notifications\Customer\NewTransferAgencyNotification;
use Illuminate\Http\Request;

class TransferAgencyController extends Controller
{
    public function index()
    {
        return view('customer.account.profil.transfer.index', [
            'customer' => Customer::find(auth()->user()->customers->id)
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'agency_id' => "required",
            "cni_principal" => "required|file"
        ]);

        $customer = Customer::find(auth()->user()->customers->id);

        $transfer = $customer->transfer()->create([
            'reference' => generateReference(),
            'transfer_account' => $request->has('transfer_account'),
            'transfer_joint' => $request->has('transfer_joint'),
            'transfer_all' => $request->has('transfer_all'),
            'customer_id' => $customer->id,
            'agency_id' => $request->get('agency_id')
        ]);

        $file_principal = $request->file('cni_principal');
        $file_principal->store(public_path('uploads/transfer_agency/'.$file_principal->getClientOriginalName()));

        if($request->hasFile('cni_secondaire')) {
            $file_secondaire = $request->file('cn_secondaire');
            $file_secondaire->store(public_path('uploads/transfer_agency/'.$file_principal->getClientOriginalName()));
        }

        $customer->info->notify(new NewTransferAgencyNotification($customer, $transfer, "Contact avec votre banque"));
        dispatch(new TransferAgencyJob($transfer))->delay(now()->addMinute());

        return redirect()->back()->with('success', "Votre demande de transfert d'agence nous à été transmis avec succès");

    }
}
