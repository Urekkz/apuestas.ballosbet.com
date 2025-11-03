@extends('templates.basic.layout')

@section('content')
<div class="container text-center my-5">
    <h1 style="color:white;">📺 Transmisión en Vivo</h1>

    {{-- Solo admin puede actualizar la URL --}}
    @if(auth()->check() && auth()->user()->is_admin)
        <form action="{{ route('stream.update') }}" method="POST" class="mb-4" style="max-width:600px; margin:auto;">
            @csrf
            <input
                type="text"
                name="stream_url"
                value="{{ $url }}"
                class="form-control mb-2"
                placeholder="Ejemplo: rtmp://72.61.2.120/live/pelea01"
                required
            >
            <button type="submit" class="btn btn-primary w-100">Actualizar Stream</button>
        </form>
    @endif

    {{-- Mostrar el stream si existe --}}
    @if($url)
        <div class="mt-4" style="max-width: 900px; margin:auto;">
            <video
                id="liveVideo"
                controls
                autoplay
                style="width:100%; border-radius:10px; background:#000;"
            ></video>
        </div>
    @else
        <p class="mt-4" style="color:white;">No hay stream activo en este momento.</p>
    @endif
</div>

@if($url)
    {{-- HLS.js para reproducir el stream --}}
    <script src="https://cdn.jsdelivr.net/npm/hls.js@latest"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const video = document.getElementById('liveVideo');
            const src = @json($url); // Ejemplo: http://72.61.2.120/live/pelea01.m3u8

            if (Hls.isSupported()) {
                const hls = new Hls();
                hls.loadSource(src);
                hls.attachMedia(video);
                hls.on(Hls.Events.MANIFEST_PARSED, function () {
                    video.play();
                });
            } else if (video.canPlayType('application/vnd.apple.mpegurl')) {
                // Safari
                video.src = src;
                video.addEventListener('loadedmetadata', function () {
                    video.play();
                });
            } else {
                video.outerHTML = '<p style="color:white;">Tu navegador no soporta HLS.</p>';
            }
        });
    </script>
@endif
@endsection
