<?php

namespace App\Http\Controllers\Auth;

use App\Helper\LogHelper;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use App\Services\Authy\Authy;
use App\Services\Authy\AuthyService;
use App\Services\Registrar;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;


    public function __construct()
    {

        $this->middleware('guest')->except('logout');
    }

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function showLoginForm()
    {
        return view('auths.login');
    }


    /**
     * The user has been authenticated.
     *
     * @param \Illuminate\Http\Request $request
     * @param mixed $user
     */
    protected function authenticated(Request $request, $user)
    {
        LogHelper::insertLogSystem('success', "Un utilisateur c'est connecter", $user);
    }

    /**
     * Log the user out of the application.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        LogHelper::insertLogSystem('success', "Un utilisateur c'est déconnecté", $request->user());
        $this->guard()->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        if ($response = $this->loggedOut($request)) {

            return $response;
        }

        return $request->wantsJson()
            ? new JsonResponse([], 204)
            : redirect('/');
    }

}
