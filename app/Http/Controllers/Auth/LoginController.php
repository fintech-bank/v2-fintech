<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Services\Authy\Authy;
use App\Services\Registrar;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

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
    /**
     * @var Registrar
     */
    private $registrar;
    /**
     * @var Authy
     */
    private $authy;

    /**
     * Create a new controller instance.
     *
     * @param Guard $auth
     * @param Registrar $registrar
     * @param Authy $authy
     */
    public function __construct(Guard $auth, Registrar $registrar, Authy $authy)
    {
        $this->auth = $auth;
        $this->registrar = $registrar;
        $this->authy = $authy;
        $this->middleware('guest')->except('logout');
    }

    /**
     * The user has been authenticated.
     *
     * @param \Illuminate\Http\Request $request
     * @param mixed $user
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {
        //
    }

    public function postLogin(Request $request)
    {
        $credentials = $request->only('email', 'password');
        if (Auth::validate($credentials)) {
            $user = User::where('email', '=', $request->input('email'))->firstOrFail();

            Session::set('password_validated', true);
            Session::set('id', $user->id);

            if ($this->authy->verifyUserStatus($user->authy_id)->registered) {
                $uuid = $this->authy->sendOneTouch($user->authy_id, 'Request to Login to Twilio demo app');

                OneTouch::create(['uuid' => $uuid]);

                Session::set('one_touch_uuid', $uuid);

                return response()->json(['status' => 'ok']);
            } else
                return response()->json(['status' => 'verify']);

        } else {
            return response()->json(['status' => 'failed',
                'message' => 'The email and password combination you entered is incorrect.']);
        }
    }

    public function getTwoFactor()
    {
        $message = Session::get('message');

        return view('auth/two-factor', ['message' => $message]);
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
                return redirect()->intended('/home');
            } else {
                return redirect('/auth/two-factor')->withErrors([
                    'token' => 'The token you entered is incorrect',
                ]);
            }
        }
    }

    public function postRegister(Request $request)
    {
        $validator = $this->registrar->validator($request->all());
        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
            );
        }
        $user = $this->registrar->create($request->all());

        Session::set('password_validated', true);
        Session::set('id', $user->id);

        $authy_id = $this->authy->register($user->email, $user->phone_number, $user->country_code);

        $user->updateAuthyId($authy_id);

        if ($this->authy->verifyUserStatus($authy_id)->registered)
            $message = "Open Authy app in your phone to see the verification code";
        else {
            $this->authy->sendToken($authy_id);
            $message = "You will receive an SMS with the verification code";
        }

        return redirect('/auth/two-factor')->with('message', $message);
    }
}
