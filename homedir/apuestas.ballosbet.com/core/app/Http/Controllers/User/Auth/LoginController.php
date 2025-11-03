<?php

namespace App\Http\Controllers\User\Auth;

use App\Http\Controllers\Controller;
use App\Lib\Intended;
use App\Models\UserLogin;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Status;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $username;

    public function __construct()
    {
        parent::__construct();
        $this->username = $this->findUsername();
    }

    public function showLoginForm()
    {
        $pageTitle = "Login";
        Intended::identifyRoute();
        return view('Template::user.auth.login', compact('pageTitle'));
    }

    public function login(Request $request)
    {
        $this->validateLogin($request);

        if (!verifyCaptcha()) {
            $notify[] = ['error', 'Captcha inválido.'];
            return back()->withNotify($notify);
        }

        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);
            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
            $user = $this->guard()->user();

            // 🚫 Bloquear acceso si el usuario no está activo o no tiene email verificado
            if ($user->status != 1) {
                $this->guard()->logout();
                $notify[] = ['error', 'Tu cuenta aún no ha sido aprobada por el administrador.'];
                return back()->withNotify($notify);
            }

            if ($user->ev != 1) {
                $this->guard()->logout();
                $notify[] = ['error', 'Espera a que el administrador apruebe tu inicio de sesión.'];
                return back()->withNotify($notify);
            }

            return $this->sendLoginResponse($request);
        }

        $this->incrementLoginAttempts($request);
        Intended::reAssignSession();

        $notify[] = ['error', 'Credenciales incorrectas.'];
        return back()->withNotify($notify);
    }

    public function findUsername()
    {
        $login = request()->input('username');
        $fieldType = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        request()->merge([$fieldType => $login]);
        return $fieldType;
    }

    public function username()
    {
        return $this->username;
    }

    protected function validateLogin($request)
    {
        $validator = Validator::make($request->all(), [
            $this->username() => 'required|string',
            'password'        => 'required|string',
        ]);

        if ($validator->fails()) {
            Intended::reAssignSession();
            $validator->validate();
        }
    }

    public function logout()
    {
        $this->guard()->logout();
        request()->session()->invalidate();

        // ✅ Notificación al cerrar sesión
        $notify[] = ['success', 'Has cerrado sesión correctamente.'];
        return to_route('user.login')->withNotify($notify);
    }

    public function authenticated(Request $request, $user)
    {
        // 🚫 No permitir usuarios bloqueados o no verificados
        if ($user->status != 1 || $user->ev != 1) {
            $this->guard()->logout();
            $notify[] = ['error', 'Tu cuenta no está activa o no ha sido verificada.'];
            return redirect()->route('user.login')->withNotify($notify);
        }

        // Registro de sesión del usuario
        $user->tv = $user->ts == Status::VERIFIED ? Status::UNVERIFIED : Status::VERIFIED;
        $user->save();

        $ip = getRealIP();
        $exist = UserLogin::where('user_ip', $ip)->first();
        $userLogin = new UserLogin();

        if ($exist) {
            $userLogin->longitude    = $exist->longitude;
            $userLogin->latitude     = $exist->latitude;
            $userLogin->city         = $exist->city;
            $userLogin->country_code = $exist->country_code;
            $userLogin->country      = $exist->country;
        } else {
            $info = json_decode(json_encode(getIpInfo()), true);
            $userLogin->longitude    = @$info['long'] ?? null;
            $userLogin->latitude     = @$info['lat'] ?? null;
            $userLogin->city         = @$info['city'] ?? null;
            $userLogin->country_code = @$info['code'] ?? null;
            $userLogin->country      = @$info['country'] ?? null;
        }

        $userAgent = osBrowser();
        $userLogin->user_id = $user->id;
        $userLogin->user_ip = $ip;
        $userLogin->browser = @$userAgent['browser'] ?? 'N/A';
        $userLogin->os      = @$userAgent['os_platform'] ?? 'N/A';
        $userLogin->save();

        $redirection = Intended::getRedirection();
        if ($redirection) {
            return $redirection;
        } elseif ($request->location && session()->get('bets')) {
            return redirect()->to($request->location);
        } else {
            // 🔸 Solo redirige sin mensaje de bienvenida
            return redirect()->to('https://apuestas.ballosbet.com');
        }
    }
}
