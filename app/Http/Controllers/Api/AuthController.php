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

    public function getUser(Request $request)
    {

        $credentials = $this->credentials($request);

        return response()->json([
            'user' => $credentials
        ]);
    }

    public function logout()
    {
        Auth::guard('api')->logout();

        return response()->json([], 204);
    }

    public function refreshToken(Request $request){
        $token = Auth::guard('api')->refresh();
        return $this->sendLoginResponse($request, $token);
    }

    protected function sendFailedLoginResponse(Request $request)
    {
        return response()->json([
            'message' => Lang::get('auth.failed')
        ],401);
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

    protected function sendLoginResponse(Request $request, $token)
    {
        $this->clearLoginAttempts($request);
        return response()->json([
            'token' => $token
        ]);
    }

}