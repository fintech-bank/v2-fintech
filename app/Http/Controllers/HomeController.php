<?php

namespace App\Http\Controllers;

use App\Models\Customer\Customer;
use App\Services\PushbulletApi;
use App\Services\YousignApi;
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
        return redirect()->route('part.home');
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

    public function test()
    {
        dd(messenger()->getProvider(auth()->user()));
    }
}
