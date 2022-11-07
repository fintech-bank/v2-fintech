<?php

namespace App\Http\Controllers;

use App\Events\Core\PersonnaWebbhookEvent;
use App\Helper\LogHelper;
use App\Helper\UserHelper;
use App\Models\Core\Agency;
use App\Models\Core\Event;
use App\Models\Core\LoanPlan;
use App\Models\Core\Package;
use App\Models\Customer\Customer;
use App\Models\Reseller\Reseller;
use App\Models\User;
use App\Models\User\UserFolder;
use App\Notifications\Customer\UpdateStatusAccountNotification;
use App\Services\CotationClient;
use App\Services\GeoPortailLook;
use App\Services\PushbulletApi;
use App\Services\Twilio\Lookup;
use App\Services\Twilio\Messaging\Whatsapp;
use App\Services\YousignApi;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Jenssegers\Agent\Agent;
use RTippin\Messenger\Messenger;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function index()
    {
        return redirect()->to('/particulier');
    }

    public function redirect()
    {
        if (auth()->user()->admin == 1) {
            return redirect()->route('admin.dashboard');
        } elseif (auth()->user()->agent == 1) {
            return redirect()->route('agent.dashboard');
        } elseif(auth()->user()->reseller == 1) {
            return redirect()->route('reseller.dashboard');
        } else {
            if (auth()->user()->customers->status_open_account == 'terminated') {
                return redirect()->route('customer.dashboard');
            } else {
                session()->put(['user' => auth()->user()]);

                return redirect()->route('auth.register.suivi');
            }
        }
    }

    public function push(Request $request)
    {
        try {
            $this->validate($request, [
                'endpoint' => 'required',
                'keys.auth' => 'required',
                'keys.p256dh' => 'required'
            ]);
        } catch (ValidationException $e) {
            return response()->json($e->errors(), 422);
        }

        $endpoint = $request->endpoint;
        $token = $request->keys['auth'];
        $key = $request->keys['p256dh'];
        $user = Auth::user();
        $user->updatePushSubscription($endpoint, $key, $token);

        return response()->json(['success' => true],200);
    }

    public function test()
    {
        $user = User::find(4);
        dd($user->subscriptions()->first()->sub);
    }
}
