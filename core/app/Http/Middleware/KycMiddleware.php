<?php

namespace App\Http\Middleware;

use App\Constants\Status;
use Closure;
use Illuminate\Http\Request;

class KycMiddleware
{
    /**
     * Handle an incoming request.
     *
     * Si en el .env pones KYC_REQUIRED=false, esta middleware
     * se saltará las validaciones KYC y permitirá continuar.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Permite desactivar KYC desde .env (valor por defecto: true)
        // Añade KYC_REQUIRED=false en .env para desactivar completamente la validación.
        if (env('KYC_REQUIRED', true) == false) {
            return $next($request);
        }

        $user = auth()->user();

        // Si no hay usuario autenticado, no intentamos validar KYC aquí.
        if (!$user) {
            return $next($request);
        }

        // Para llamadas API devolvemos JSON con error (si aplica)
        if ($request->is('api/*') && ($user->kv == Status::KYC_UNVERIFIED || $user->kv == Status::KYC_PENDING)) {
            $notify[] = 'You are unable to withdraw due to KYC verification';
            return response()->json([
                'remark'  => 'kyc_verification',
                'status'  => 'error',
                'message' => ['error' => $notify],
            ]);
        }

        // Si usuario no verificado => lo mandamos al formulario KYC (web)
        if ($user->kv == Status::KYC_UNVERIFIED) {
            $notify[] = ['error', 'You are not KYC verified. For being KYC verified, please provide these information'];
            return to_route('user.kyc.form')->withNotify($notify);
        }

        // Si está pendiente => aviso y lo mandamos al home
        if ($user->kv == Status::KYC_PENDING) {
            $notify[] = ['warning', 'Your documents for KYC verification is under review. Please wait for admin approval'];
            return to_route('user.home')->withNotify($notify);
        }

        return $next($request);
    }
}
