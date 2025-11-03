<?php

namespace App\Http\Controllers\User;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Http\Controllers\Controller;
use App\Constants\Status;
use App\Lib\Intended;

class AuthorizationController extends Controller
{
    /**
     * Verifica si el código aún es válido (expira en X minutos)
     */
    protected function checkCodeValidity($user, $addMin = 2)
    {
        if (!$user->ver_code_send_at) {
            return false;
        }

        return $user->ver_code_send_at->addMinutes($addMin) >= Carbon::now();
    }

    /**
     * Muestra la vista de verificación de correo
     */
    public function authorizeForm()
    {
        $user = auth()->user();

        // Si ya está verificado, redirige al dashboard
        if ($user->ev) {
            return to_route('user.home');
        }

        $pageTitle = 'Verify Email';
        $type = 'email';
        $notifyTemplate = 'EVER_CODE';

        // Si el código expiró, genera uno nuevo
        if (!$this->checkCodeValidity($user)) {
            $user->ver_code = verificationCode(6);
            $user->ver_code_send_at = Carbon::now();
            $user->save();

            notify($user, $notifyTemplate, [
                'code' => $user->ver_code
            ], [$type]);
        }

        return view('Template::user.auth.authorization.email', compact('user', 'pageTitle'));
    }

    /**
     * Envía un nuevo código de verificación por correo
     */
    public function sendVerifyCode()
    {
        $user = auth()->user();

        if ($this->checkCodeValidity($user)) {
            $targetTime = $user->ver_code_send_at->addMinutes(2)->timestamp;
            $delay = $targetTime - time();
            throw ValidationException::withMessages([
                'resend' => 'Please try again after ' . $delay . ' seconds'
            ]);
        }

        $user->ver_code = verificationCode(6);
        $user->ver_code_send_at = Carbon::now();
        $user->save();

        notify($user, 'EVER_CODE', [
            'code' => $user->ver_code
        ], ['email']);

        $notify[] = ['success', 'Verification code sent successfully'];
        return back()->withNotify($notify);
    }

    /**
     * Verifica el código introducido por el usuario
     */
    public function emailVerification(Request $request)
    {
        $request->validate([
            'code' => 'required'
        ]);

        $user = auth()->user();

        if ($user->ver_code == $request->code) {
            $user->ev = Status::VERIFIED;
            $user->ver_code = null;
            $user->ver_code_send_at = null;
            $user->save();

            $notify[] = ['success', 'Email verified successfully'];
            $redirection = Intended::getRedirection();

            return $redirection ? $redirection : to_route('user.home');
        }

        throw ValidationException::withMessages([
            'code' => "Verification code didn't match!"
        ]);
    }
}
