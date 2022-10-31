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
    private Guard $auth;
    private Registrar $registrar;
    private AuthyService $authy;

    /**
     * Create a new controller instance.
     * @param Guard $auth
     * @param Registrar $registrar
     * @param AuthyService $authy
     */
    public function __construct(Guard $auth, Registrar $registrar, AuthyService $authy)
    {

        $this->middleware('guest')->except('logout');
        $this->auth = $auth;
        $this->registrar = $registrar;
        $this->authy = $authy;
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
     * Handle a login request to the application.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (\Auth::validate($credentials)) {
            $user = User::where('email', '=', $request->input('email'))->firstOrFail();

            Session::put('password_validated', true);
            Session::put('user_id', $user->id);

            if ($this->authy->verifyUserStatus($user->authy_id)->registered) {
                $uuid = $this->authy->sendOneTouch($user->authy_id, 'Request to Login to Twilio demo app');
                $user->update([
                    'authy_one_touch_uuid' => $uuid
                ]);
                Session::put('one_touch_uuid', $uuid);

                return response()->json(['status' => "ok"]);
            } else {
                return response()->json(['status' => 'verify']);
            }
        } else {
            return response()->json([
                "status" => "failed",
                "message" => "La combinaison e-mail et mot de passe que vous avez saisie est incorrecte."
            ]);
        }
    }

    public function getTwoFactor()
    {
        $message = Session::get('message');

        return view('auths.auth.verify', ['message' => $message]);
    }

    public function postTwoFactor(Request $request)
    {
        if (!Session::get('password_validated') || !Session::get('id')) {
            return redirect('/auth/login');
        }

        if (isset($_POST['token'])) {
            $user = User::find(Session::get('id'));
            if ($this->authy->verifyToken($user->authy_id, $request->input('token'))) {
                Auth::login($user);
                return redirect()->intended('/redirect');
            } else {
                return redirect('/auth/verify')->withErrors([
                    'token' => 'The token you entered is incorrect',
                ]);
            }
        }
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
