<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Traits\EmailVerification;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

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
    use EmailVerification;
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout', 'me');
    }
    /**
     * @param Request $request
     * @return array|\Illuminate\Http\JsonResponse|void
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(Request $request)
    {
        $this->validateLogin($request);
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);
            return $this->sendLockoutResponse($request);
        }
        if ($this->attemptLogin($request)) {
            if ($this->emailNotVerified($request)) {
                return $this->sendEmailNotVerifiedResponse();
            }
            return $this->sendLoginResponse($request);
        }
        $this->incrementLoginAttempts($request);
        return $this->sendFailedLoginResponse();
    }
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        $user = $request->user();
        $user->unsetApiToken();
        return response([], 200);
    }
    /**
     * @param Request $request
     * @return array
     */
    public function me(Request $request)
    {
        $user = $request->user();
        $token = $user->api_token;
        return compact('user', 'token');
    }
    /**
     * Send successful login response
     *
     * @param $request
     * @return array
     */
    private function sendLoginResponse($request)
    {
        $this->clearLoginAttempts($request);
        $user = User::where('email', $request->email)->first();
        $user->setApiToken();
        $token = $user->api_token;
        return compact('user', 'token');
    }
    /**
     * Send failed login response
     *
     * @return \Illuminate\Http\JsonResponse
     */
    private function sendFailedLoginResponse()
    {
        return response()->json('Uw opgegeven email of wachtwoord is niet juist!', Response::HTTP_UNAUTHORIZED);
    }

}
