<?php

namespace App\Http\Middleware;

use Auth;
use Closure;

class CheckStatus
{
    /**
     * Maneja las solicitudes entrantes y valida que el usuario esté activo
     * y tenga el correo electrónico verificado.
     */
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            $user = auth()->user();

            // ✅ Solo se exige que el usuario esté activo y tenga el email verificado
            if ($user->status && $user->ev) {
                return $next($request);
            }

            // 🚫 Si el usuario no cumple con los requisitos
            if ($request->is('api/*')) {
                $notify[] = 'Debes verificar tu correo electrónico antes de continuar.';
                return response()->json([
                    'remark'  => 'unverified',
                    'status'  => 'error',
                    'message' => ['error' => $notify],
                    'data'    => [
                        'user' => $user,
                    ],
                ]);
            } else {
                // Cierra sesión y redirige al login con mensaje de error
                Auth::logout();
                return redirect()->route('user.login')
                    ->with('error', 'Debes verificar tu correo electrónico antes de acceder al panel.');
            }
        }

        // 🚫 Si no hay usuario autenticado, denegar acceso
        abort(403, 'Acceso no autorizado.');
    }
}
