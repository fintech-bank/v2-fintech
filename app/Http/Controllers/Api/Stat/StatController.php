<?php

namespace App\Http\Controllers\Api\Stat;

use App\Http\Controllers\Controller;
use App\Models\Core\Event;
use App\Models\Core\Mailbox;
use App\Models\Core\MailboxReceiver;
use App\Models\Customer\Customer;
use App\Models\Customer\CustomerPret;
use App\Models\Customer\CustomerTransaction;
use App\Models\Customer\CustomerWallet;
use App\Models\User;
use Illuminate\Http\Request;

class StatController extends Controller
{
    public function agentDashboard(Request $request)
    {
        sleep(2);
        $sum_withdraw = CustomerTransaction::where('type', 'retrait')->where('confirmed', true)->sum('amount');
        $sum_deposit = CustomerTransaction::where('type', 'depot')->where('confirmed', true)->sum('amount');
        $sum_agency = CustomerWallet::where('status', 'active')->sum('balance_actual');
        $sum_loan = CustomerPret::where('status', 'progress')->sum('amount_du');
        $according_pret_amount = ((config('app.fintech_loan_balance') + $sum_agency - $sum_loan) * 25 / 100) + (config('app.fintech_loan_balance') + $sum_agency);
        $events = Event::where('user_id', $request->get('user_id'))->whereBetween('start_at', [now(), now()->endOfDay()])->get();
        $notifies = User::find($request->get('user_id'))->unreadNotifications()->orderBy('created_at', 'desc')->limit(5)->get();
        $messages = Mailbox::where('sender_id', '!=', $request->get('user_id'))->orderBy('created_at', 'desc')->limit(5)->with('flags', 'sender')->get();
        return response()->json([
            'count_actif_customer' => Customer::where('status_open_account', 'terminated')->count(),
            'count_disable_customer' => Customer::where('status_open_account', 'closed')->count(),
            'count_deposit' => CustomerTransaction::where('type', 'depot')->where('confirmed', true)->count(),
            'count_withdraw' => CustomerTransaction::where('type', 'retrait')->where('confirmed', true)->count(),
            'count_loan' => CustomerPret::count(),
            'count_loan_study' => CustomerPret::where('status', 'study')->count(),
            'count_loan_progress' => CustomerPret::where('status', 'progress')->count(),
            'count_loan_terminated' => CustomerPret::where('status', 'terminated')->count(),
            'count_loan_rejected' => CustomerPret::where('status', 'refused')->count(),
            'sum_withdraw' => eur($sum_withdraw),
            'sum_deposit' => eur($sum_deposit),
            'sum_agency' => eur($sum_agency),
            'according_pret' => $according_pret_amount <= 0 ? false : true,
            'according_pret_text' => [
                'color' => $according_pret_amount <= 0 ? 'danger' : 'success',
                'text' => $according_pret_amount <= 0 ? 'Accord de pret impossible' : eur($according_pret_amount)
            ],
            'events' => $events,
            'notifies' => $notifies,
            'messages' => $messages
        ]);
    }
}
