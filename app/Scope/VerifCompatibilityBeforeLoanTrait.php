<?php

namespace App\Scope;

use App\Helper\LogHelper;
use App\Models\Customer\Customer;
use App\Models\Customer\CustomerCreditCard;

trait VerifCompatibilityBeforeLoanTrait
{
    public static function verify(Customer $customer, $isRevolving = false, CustomerCreditCard $card = null): bool
    {
        $score = 0; // En pourcentage

        $acc = self::verifDebitAllWalletAccount($customer) < self::verifCreditAllWalletAccount($customer) ? $score += 100 : $score -= 100;
        $ficp = self::verifFICP($customer) ? $score += 100 : $score -= 100;
        $cotation = self::verifCotation($customer) ? $score += 100 : $score -= 100;
        $solde_account = self::verifAllSoldeWalletAccount($customer) ? $score += 100 : $score -= 100;
        $solde_epargne = self::verifAllSoldeEpargneAccount($customer) ? $score += 100 : $score -= 100;
        $alert = self::verifNbAlertOfAllWalletAccount($customer) ? $score += 100 : $score -= 100;
        $loan = self::verifNbLoan($customer) ? $score += 100 : $score -= 100;

        $calc = $score * 7 / 100;
        $serv = $calc >= 25 ? 'Reussi' : 'Echec';
        $color = $calc >= 25 ? 'success' : 'danger';

        if ($isRevolving) {
            $cards = self::creditCardIsNotClassicCard($card) ? $score += 100 : $score -= 100;
            $calc = $score * 8 / 100;
            $result = "
            Demande de crédit Facelia: Client: {$customer->info->full_name} | Score: {$calc} % | Resultat: <span class='text-{$color}'>{$serv}</span><br>
            <table class='table table-sm'>
                <tbody>
                    <tr>
                        <td>Resultat des débits et crédits bancaire:</td>
                        <td>{$acc}</td>
                    </tr>
                    <tr>
                        <td>Client FICP:</td>
                        <td>{$ficp}</td>
                    </tr>
                    <tr>
                        <td>Resultat de la cotation:</td>
                        <td>{$cotation}</td>
                    </tr>
                    <tr>
                        <td>Resultat des soldes des comptes courants:</td>
                        <td>{$solde_account}</td>
                    </tr>
                    <tr>
                        <td>Resultat des soldes des comptes épargnes:</td>
                        <td>{$solde_epargne}</td>
                    </tr>
                    <tr>
                        <td>Resultat du nombre d'alerte sur les comptes:</td>
                        <td>{$alert}</td>
                    </tr>
                    <tr>
                        <td>Resultat du nombre de pret contracté:</td>
                        <td>{$loan}</td>
                    </tr>
                    <tr>
                        <td>Resultat du type de carte contracté:</td>
                        <td>{$cards}</td>
                    </tr>
                </tbody>
            </table>
            ";
        }

        $result = "
            Demande de crédit: Client: {$customer->info->full_name} | Score: {$calc} % | Resultat: <span class='text-{$color}'>{$serv}</span><br>
            <table class='table table-sm'>
                <tbody>
                    <tr>
                        <td>Resultat des débits et crédits bancaire:</td>
                        <td>{$acc}</td>
                    </tr>
                    <tr>
                        <td>Client FICP:</td>
                        <td>{$ficp}</td>
                    </tr>
                    <tr>
                        <td>Resultat de la cotation:</td>
                        <td>{$cotation}</td>
                    </tr>
                    <tr>
                        <td>Resultat des soldes des comptes courants:</td>
                        <td>{$solde_account}</td>
                    </tr>
                    <tr>
                        <td>Resultat des soldes des comptes épargnes:</td>
                        <td>{$solde_epargne}</td>
                    </tr>
                    <tr>
                        <td>Resultat du nombre d'alerte sur les comptes:</td>
                        <td>{$alert}</td>
                    </tr>
                    <tr>
                        <td>Resultat du nombre de pret contracté:</td>
                        <td>{$loan}</td>
                    </tr>
                </tbody>
            </table>
            ";

        LogHelper::insertLogSystem('info', $result);

        return $calc >= 25;
    }

    public static function prerequestLoan(Customer $customer)
    {
        $message = collect();
        if(!$customer->info->isVerified) {
            $message->put(null, "Compte Non vérifié");
        }

        if(!$customer->info->addressVerified) {
            $message->put(null, "Adresse postal Non vérifié");
        }

        if(!$customer->info->incomeVerified) {
            $message->put(null, "Revenue non vérifié");
        }

        return $message;
    }

    private static function verifDebitAllWalletAccount(Customer $customer): mixed
    {
        $sum = 0;
        foreach ($customer->wallets()->where('type', 'compte')->where('status', 'active')->get() as $wallet) {
            $sum += $wallet->transactions()->where('amount', '<=', 0)->sum('amount');
        }

        return $sum;
    }

    private static function verifCreditAllWalletAccount(Customer $customer): string
    {
        $sum = 0;
        foreach ($customer->wallets()->where('type', 'compte')->where('status', 'active')->get() as $wallet) {
            $sum += $wallet->transactions()->where('amount', '>=', 0)->sum('amount');
        }

        return \Str::replace('-', '', $sum);
    }

    private static function verifAllSoldeWalletAccount(Customer $customer): bool
    {
        $balance = $customer->wallets()->where('type', 'compte')->where('status', 'active')->sum('balance_actual');
        $decouvert = $customer->wallets()->where('type', 'compte')->where('status', 'active')->sum('balance_decouvert');

        return $balance + $decouvert >= 0;
    }

    private static function verifAllSoldeEpargneAccount(Customer $customer): bool
    {
        $balance = $customer->wallets()->where('type', 'epargne')->where('status', 'active')->sum('balance_actual');

        return $balance >= 0;
    }

    private static function verifNbAlertOfAllWalletAccount(Customer $customer): bool
    {
        $alert = $customer->wallets()->where('type', 'compte')->where('status', 'active')->sum('nb_alert');

        return $alert == 0;
    }

    private static function verifNbLoan(Customer $customer)
    {
        $loans = $customer->wallets()->where('type', 'pret')->where('status', 'active')->count();

        return $loans <= 2;
    }

    private static function verifFICP(Customer $customer)
    {
        return $customer->ficp == 0;
    }

    private static function verifCotation(Customer $customer)
    {
        return $customer->cotation >= 6;
    }

    private static function creditCardIsNotClassicCard(CustomerCreditCard $card): bool
    {
        if ($card->wallet->customer->info->type == 'part') {
            return $card->support->slug != 'visa-classic';
        } else {
            return true;
        }
    }
}
