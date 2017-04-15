<?php
namespace VueFin\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use VueFin\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    use AuthenticatesUsers;

    public function accessToken(Request $request)
    {

        $this->validateLogin($request);

        if($this->hasTooManyLoginAttempts($request)){
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        $credentials = $this->credentials($request);

        if ($token = Auth::guard('api')->attempt($credentials)) {
            return $this->sendLoginResponse($request, $token);
        }

        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    protected function sendLoginResponse(Request $request, $token)
    {
        $this->clearLoginAttempts($request);
        return response()->json([
            'token' => $token
        ]);
    }

    protected function sendLockoutResponse(Request $request)
    {
        $seconds = $this->limiter()->availableIn(
            $this->throttleKey($request)
        );

        $message = Lang::get('auth.throttle', ['seconds' => $seconds]);

        return response()->json([
            'message' => $message
        ], 403);
    }

    protected function sendFailedLoginResponse(Request $request)
    {
        return response()->json([
            'message' => Lang::get('auth.failed')
        ],401);
    }

    public function logout(Request $request)
    {

        $this->guard()->logout();

        $request->session()->flush();

        $request->session()->regenerate();

        return redirect(env('URL_ADMIN_LOGIN'));
    }

}