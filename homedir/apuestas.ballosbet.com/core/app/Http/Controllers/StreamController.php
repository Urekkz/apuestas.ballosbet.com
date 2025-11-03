<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StreamController extends Controller
{
    /**
     * Mostrar el stream actual.
     */
    public function index()
    {
        // 🔒 Validar autenticación
        if (!auth()->check()) {
            return redirect()->route('user.login')
                ->with('error', 'Debes iniciar sesión para ver el stream.');
        }

        // 🔒 Validar que el usuario esté activo
        if (auth()->user()->status != 1) {
            auth()->logout();
            return redirect()->route('user.login')
                ->with('error', 'Tu cuenta está inactiva. Contacta con soporte.');
        }

        // ✅ Leer URL desde storage/app/stream_url.txt
        $path = storage_path('app/stream_url.txt');
        $streamUrl = file_exists($path) ? trim(file_get_contents($path)) : '';

        return view('home', compact('streamUrl')); // ← asegúrate de pasar la variable correcta
    }

    /**
     * Guardar o actualizar la URL del stream (solo admin).
     */
    public function update(Request $request)
    {
        // 🔒 Seguridad básica
        if (!auth()->check()) {
            return redirect()->route('user.login')
                ->with('error', 'Debes iniciar sesión para actualizar el stream.');
        }

        if (auth()->user()->status != 1) {
            auth()->logout();
            return redirect()->route('user.login')
                ->with('error', 'Tu cuenta está inactiva. Contacta con soporte.');
        }

        // ✅ Validar campo
        $request->validate([
            'stream_url' => ['required', 'string', 'max:255'],
        ]);

        $raw = trim($request->stream_url);

        /**
         * Si el admin pega: rtmp://72.61.2.120/live/nombre
         * Convertimos a HLS HTTPS: https://stream.ballosbet.com/hls/nombre.m3u8
         */
        if (str_starts_with($raw, 'rtmp://72.61.2.120/live')) {
            $withoutScheme = str_replace('rtmp://', '', $raw);
            $parts = explode('/', $withoutScheme);
            $key  = $parts[2] ?? 'stream';
            $finalUrl = "https://stream.ballosbet.com/hls/{$key}.m3u8"; // 🔒 usa HTTPS
        } else {
            $finalUrl = $raw;
        }

        // 📝 Guardar en storage/app/stream_url.txt
        file_put_contents(storage_path('app/stream_url.txt'), $finalUrl);

        return redirect()->route('stream')->with('success', 'Stream actualizado correctamente');
    }
}
