<?php

namespace App\Http\Controllers\User\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    /**
     * Mostrar el formulario de registro.
     */
    public function showRegistrationForm()
    {
        $pageTitle = "Register";
        return view('templates.basic.user.auth.register', compact('pageTitle'));
    }

    /**
     * Registrar un nuevo usuario y redirigirlo a un enlace externo sin iniciar sesión.
     */
    public function register(Request $request)
    {
        // Validar los datos del formulario
        $validator = Validator::make($request->all(), [
            'firstname' => 'required|string|max:60',
            'lastname'  => 'required|string|max:60',
            'email'     => 'required|string|email|max:160|unique:users',
            'mobile'    => 'required|numeric|digits_between:7,15|unique:users',
            'password'  => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Crear el usuario sin iniciar sesión
        $user = User::create([
            'firstname'     => $request->firstname,
            'lastname'      => $request->lastname,
            'email'         => $request->email,
            'mobile'        => $request->mobile, // ✅ ahora se guarda correctamente
            'dial_code'     => $request->dial_code ?? null,
            'country_code'  => $request->country_code ?? null,
            'country_name'  => $request->country_name ?? null,
            'password'      => Hash::make($request->password),
        ]);

        // Disparar evento de registro (opcional)
        event(new Registered($user));

        // Redirigir al usuario a una página externa tras registrarse
        $externalUrl = 'https://apuestas.ballosbet.com/user/banned'; // puedes cambiar esta URL si deseas
        return redirect()->away($externalUrl);
    }
}
