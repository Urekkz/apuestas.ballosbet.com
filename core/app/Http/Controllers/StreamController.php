<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StreamController extends Controller
{
    /**
     * Muestra la página de stream en vivo
     */
    public function show()
    {
        // Ruta donde se almacena la URL del stream
        $filePath = storage_path('app/stream_url.txt');
        
        // Leer la URL si existe
        $url = '';
        if (file_exists($filePath)) {
            $url = trim(file_get_contents($filePath));
        }

        // 🔴 IMPORTANTE: Convertir RTMP a HLS si es necesario
        if (!empty($url) && strpos($url, 'rtmp://') !== false) {
            // Si está guardada como RTMP, convertir a HLS
            $url = $this->convertRtmpToHls($url);
        }

        return view('templates.basic.stream', [
            'url' => $url,
            'isAdmin' => auth()->check() && auth()->user()->is_admin
        ]);
    }

    /**
     * Actualiza la URL del stream (solo admin)
     */
    public function update(Request $request)
    {
        // Verificar que es admin
        if (!auth()->check() || !auth()->user()->is_admin) {
            return redirect()->back()->with('error', 'No tienes permisos para actualizar el stream.');
        }

        // Validar entrada
        $request->validate([
            'stream_url' => 'required|url|max:500'
        ], [
            'stream_url.required' => 'La URL del stream es obligatoria.',
            'stream_url.url' => 'Debes ingresar una URL válida.',
            'stream_url.max' => 'La URL no puede superar 500 caracteres.'
        ]);

        try {
            $inputUrl = $request->input('stream_url');

            // 🔴 CONVERTIR RTMP A HLS si es necesario
            if (strpos($inputUrl, 'rtmp://') !== false) {
                $url = $this->convertRtmpToHls($inputUrl);
            } else {
                $url = $inputUrl;
            }

            // Guardar la URL convertida en archivo de texto
            $filePath = storage_path('app/stream_url.txt');
            file_put_contents($filePath, $url);

            return redirect()->back()->with('success', 'URL del stream actualizada correctamente.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al guardar la URL: ' . $e->getMessage());
        }
    }

    /**
     * Convierte RTMP a HLS
     * Ejemplo: rtmp://72.61.2.120/live/pelea01 → https://stream.ballosbet.com/hls/pelea01.m3u8
     */
    private function convertRtmpToHls(string $rtmpUrl): string
    {
        // Extrae el nombre del stream de la URL RTMP
        // rtmp://ip:port/app/stream_name → stream_name
        $parts = explode('/', $rtmpUrl);
        $streamName = end($parts); // Obtiene el último segmento (stream_name)

        // Construye la URL HLS
        return "https://stream.ballosbet.com/hls/{$streamName}.m3u8";
    }

    /**
     * Endpoint para verificar si el stream está activo (AJAX)
     */
    public function checkAvailability()
    {
        $filePath = storage_path('app/stream_url.txt');
        
        if (!file_exists($filePath)) {
            return response()->json(['active' => false, 'message' => 'No stream configured']);
        }

        $url = trim(file_get_contents($filePath));

        // Hacer GET request a la URL para verificar que está disponible
        try {
            $ch = curl_init();
            curl_setopt_array($ch, [
                CURLOPT_URL => $url,
                CURLOPT_NOBODY => true,          // Solo headers
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_TIMEOUT => 5,
                CURLOPT_CONNECTTIMEOUT => 5,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_USERAGENT => 'Mozilla/5.0'
            ]);

            curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            // 200 = stream existe y está disponible
            $isActive = ($httpCode == 200);

            return response()->json([
                'active' => $isActive,
                'url' => $isActive ? $url : null,
                'httpCode' => $httpCode
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'active' => false,
                'message' => 'Error checking stream: ' . $e->getMessage()
            ], 500);
        }
    }
}