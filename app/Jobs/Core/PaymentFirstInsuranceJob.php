<?php

namespace App\Jobs\Core;

use App\Helper\CustomerSepaHelper;
use App\Helper\CustomerTransactionHelper;
use App\Models\Customer\Customer;
use App\Models\Customer\CustomerInsurance;
use App\Models\Customer\CustomerWallet;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class PaymentFirstInsuranceJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public Customer $customer;
    public CustomerInsurance $insurance;
    public CustomerWallet $wallet;

    /**
     * Create a new job instance.
     *
     * @param Customer $customer
     * @param CustomerInsurance $insurance
     * @param CustomerWallet $wallet
     */
    public function __construct(Customer $customer, CustomerInsurance $insurance, CustomerWallet $wallet)
    {
        //
        $this->customer = $customer;
        $this->insurance = $insurance;
        $this->wallet = $wallet;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        return match ($this->insurance->type_prlv) {
            "mensuel" => $this->prlvMensuel(),
            "trim" => $this->prlvTrim(),
            "annuel" => $this->prlvAnnuel(),
            "ponctuel" => $this->prlvPonctuel()
        };
    }

    private function prlvMensuel()
    {
        for ($i = 1; $i <= 12; $i++) {
            CustomerSepaHelper::createPrlv(
                $this->insurance->mensuality,
                $this->wallet,
                "Prélèvement Souscription Assurance ".$this->insurance->package->name." / ".$this->insurance->reference." / ".Carbon::create(now()->year, now()->addMonths($i),1)->locale('fr_FR')->monthName,
                now()->addMonths($i));
        }
    }
    private function prlvTrim()
    {
        CustomerSepaHelper::createPrlv(
            $this->insurance->mensuality,
            $this->wallet,
            "Prélèvement Souscription Assurance ".$this->insurance->package->name." / ".$this->insurance->reference." / ".now()->locale('fr_FR')->monthName,
            now());

        CustomerSepaHelper::createPrlv(
            $this->insurance->mensuality,
            $this->wallet,
            "Prélèvement Souscription Assurance ".$this->insurance->package->name." / ".$this->insurance->reference." / ".Carbon::create(now()->year, now()->addMonths(3),1)->locale('fr_FR')->monthName,
            now()->addMonths(3));

        CustomerSepaHelper::createPrlv(
            $this->insurance->mensuality,
            $this->wallet,
            "Prélèvement Souscription Assurance ".$this->insurance->package->name." / ".$this->insurance->reference." / ".Carbon::create(now()->year, now()->addMonths(6),1)->locale('fr_FR')->monthName,
            now()->addMonths(6));

        CustomerSepaHelper::createPrlv(
            $this->insurance->mensuality,
            $this->wallet,
            "Prélèvement Souscription Assurance ".$this->insurance->package->name." / ".$this->insurance->reference." / ".Carbon::create(now()->year, now()->addMonths(9),1)->locale('fr_FR')->monthName,
            now()->addMonths(9));

        CustomerSepaHelper::createPrlv(
            $this->insurance->mensuality,
            $this->wallet,
            "Prélèvement Souscription Assurance ".$this->insurance->package->name." / ".$this->insurance->reference." / ".Carbon::create(now()->year, now()->addMonths(12),1)->locale('fr_FR')->monthName,
            now()->addMonths(12));
    }

    private function prlvAnnuel()
    {
        CustomerSepaHelper::createPrlv(
            $this->insurance->mensuality,
            $this->wallet,
            "Prélèvement Souscription Assurance ".$this->insurance->package->name." / ".$this->insurance->reference." / ".now()->year,
            now());
    }

    private function prlvPonctuel()
    {
        CustomerSepaHelper::createPrlv(
            $this->insurance->mensuality,
            $this->wallet,
            "Prélèvement Souscription Assurance ".$this->insurance->package->name." / ".$this->insurance->reference,
            now());
    }
}
