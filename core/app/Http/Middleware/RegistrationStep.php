<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RegistrationStep
{
    /**
     * Middleware desactivado: permite continuar sin redirecciones.
     */
    public function handle(Request $request, Closure $next)
    {
        return $next($request);
    }
}
