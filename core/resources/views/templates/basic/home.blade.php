@extends($activeTemplate . 'layouts.bet')

@section('bet')
@php
    $betPlacedIds = collect(session()->get('bets'))
        ->pluck('outcome_id')
        ->toArray();

    // URL fija del stream desde VPS Hostinger
    $streamUrl = 'https://stream.ballosbet.com/hls/stream.m3u8';
    
    // Variable para verificar si hay stream activo
    $isStreamActive = false; // Cambia a true cuando estés transmitiendo
@endphp

{{-- Slider --}}
<div class="col-12 mb-3">
    @include($activeTemplate . 'partials.slider')
</div>

{{-- Banner principal animado --}}
<div class="live-banner">
    EVENTOS EN VIVO <span class="live-dot">●</span>
</div>

{{-- Visualizador de Stream --}}
<div class="col-12 mb-4">
    <h3 class="text-center stream-title" style="color:#fff;margin-bottom:15px;font-weight:700;letter-spacing:.2px;">
        Transmisión en Vivo
        @if($streamUrl)
            <span style="display:inline-block;width:10px;height:10px;margin-left:.5rem;background:#ff3b30;border-radius:50%;vertical-align:middle;"></span>
        @endif
    </h3>

    <div class="stream-frame" style="max-width:900px;margin:auto;">
        @if($streamUrl)
            <video
                id="liveVideo"
                controls
                autoplay
                playsinline
                muted
                style="width:100%;height:480px;border-radius:10px;background:#000;">
            </video>
        @else
            <p class="no-stream-message text-center" style="color:#fff;">Esperando transmisión en vivo...</p>
        @endif
    </div>
</div>

@if($streamUrl)
    <script src="https://cdn.jsdelivr.net/npm/hls.js@latest"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const video = document.getElementById('liveVideo');
            const src = @json($streamUrl);

            if (Hls.isSupported()) {
                // Configuración ULTRA ESTABLE - buffer 20 seg, sin caídas
                const hls = new Hls({
                    enableWorker: true,
                    lowLatencyMode: false,
                    
                    // Buffer grande para máxima estabilidad (20-30 seg)
                    maxBufferLength: 30,
                    maxMaxBufferLength: 60,
                    maxBufferSize: 120 * 1000 * 1000,
                    backBufferLength: 120,
                    
                    // Sin sincronización agresiva - flujo natural
                    liveSyncDurationCount: 10,
                    liveMaxLatencyDurationCount: 20,
                    liveDurationInfinity: true,
                    
                    // Timeouts muy tolerantes
                    manifestLoadingTimeOut: 30000,
                    manifestLoadingMaxRetry: 15,
                    manifestLoadingRetryDelay: 3000,
                    levelLoadingTimeOut: 30000,
                    levelLoadingMaxRetry: 15,
                    levelLoadingRetryDelay: 2000,
                    fragLoadingTimeOut: 40000,
                    fragLoadingMaxRetry: 15,
                    fragLoadingRetryDelay: 2000,
                    
                    // Calidad adaptativa conservadora
                    abrEwmaDefaultEstimate: 500000,
                    abrBandWidthFactor: 0.8,
                    abrBandWidthUpFactor: 0.5,
                    abrMaxWithRealBitrate: true,
                    
                    // Inicio suave
                    startLevel: -1,
                    startPosition: -1,
                    autoStartLoad: true,
                    
                    debug: false
                });

                hls.loadSource(src);
                hls.attachMedia(video);

                let errorCount = 0;
                let lastErrorTime = 0;
                let isRecovering = false;

                // Reproducir cuando esté listo
                hls.on(Hls.Events.MANIFEST_PARSED, function() {
                    console.log('Stream cargado - reproduciendo...');
                    video.play().catch(e => {
                        console.log('Click en play para reproducir');
                    });
                });

                // Evento cuando carga bien
                hls.on(Hls.Events.FRAG_LOADED, function() {
                    errorCount = 0;
                    isRecovering = false;
                });

                // Manejo ultra tolerante de errores
                hls.on(Hls.Events.ERROR, function(event, data) {
                    
                    // Solo procesar errores fatales
                    if (!data.fatal) return;
                    
                    const now = Date.now();
                    
                    // Resetear contador después de 60 segundos sin errores
                    if (now - lastErrorTime > 60000) {
                        errorCount = 0;
                    }
                    
                    lastErrorTime = now;
                    errorCount++;

                    console.log('Error detectado:', data.type, '- Intento', errorCount, 'de 10');
                    
                    // Evitar múltiples recuperaciones simultáneas
                    if (isRecovering) {
                        console.log('Ya está recuperando, espera...');
                        return;
                    }
                    
                    isRecovering = true;

                    switch(data.type) {
                        case Hls.ErrorTypes.NETWORK_ERROR:
                            if (errorCount < 10) {
                                console.log('Error de red, reintentando en 3 segundos...');
                                setTimeout(() => {
                                    hls.startLoad();
                                    isRecovering = false;
                                }, 3000);
                            } else {
                                console.log('Demasiados errores de red, recargando página en 5 segundos...');
                                setTimeout(() => location.reload(), 5000);
                            }
                            break;
                            
                        case Hls.ErrorTypes.MEDIA_ERROR:
                            if (errorCount < 10) {
                                console.log('Error de medio, recuperando...');
                                hls.recoverMediaError();
                                setTimeout(() => {
                                    isRecovering = false;
                                }, 2000);
                            } else {
                                console.log('Demasiados errores de medio, recargando página en 5 segundos...');
                                setTimeout(() => location.reload(), 5000);
                            }
                            break;
                            
                        default:
                            console.log('Error crítico, recargando página en 5 segundos...');
                            setTimeout(() => location.reload(), 5000);
                            break;
                    }
                });

                // Mostrar estado de buffer (para debug)
                hls.on(Hls.Events.BUFFER_APPENDING, function() {
                    errorCount = 0; // Todo va bien
                });

                // Auto-reconexión cuando el stream se detiene y vuelve a iniciar
                hls.on(Hls.Events.ERROR, function(event, data) {
                    if (data.fatal) {
                        switch(data.type) {
                            case Hls.ErrorTypes.NETWORK_ERROR:
                                console.log('Stream detenido, intentando reconectar en 5 segundos...');
                                setTimeout(() => {
                                    console.log('Reconectando stream...');
                                    hls.loadSource(src);
                                    hls.startLoad();
                                }, 5000);
                                break;
                        }
                    }
                });

                // NO forzar sincronización - dejar buffer natural trabajar

            } else if (video.canPlayType('application/vnd.apple.mpegurl')) {
                // Para Safari (iOS/macOS)
                video.src = src;
                video.addEventListener('loadedmetadata', () => video.play());
            } else {
                video.outerHTML = '<p style="color:#fff;text-align:center;">Tu navegador no soporta HLS.</p>';
            }
        });
    </script>
@endif


{{-- Verificación de usuario --}}
@auth
    @if(auth()->user()->status == 1)
        {{-- ✅ Usuario activo --}}
        @if(!$streamUrl)
            <div class="no-stream-message">
                <svg width="38" height="38" viewBox="0 0 24 24" fill="none" aria-hidden="true"
                    style="display:block;margin:0 auto;color:#ff6600;">
                    <path d="M3 5h18v14H3z" stroke="currentColor" stroke-width="1.5"></path>
                    <path d="M10 9l5 3-5 3V9z" fill="currentColor"></path>
                </svg>
                <p style="margin:8px 0 0;font-weight:700;letter-spacing:.2px;">No hay en vivos por ahora</p>
            </div>
        @endif
    @else
        {{-- 🚫 Usuario inactivo --}}
        <div class="inactive-message">
            <p>Tu cuenta está inactiva. Contacta con soporte.</p>
            <form method="POST" action="{{ route('user.logout') }}">
                @csrf
                <button type="submit" class="btn btn-danger mt-2">Cerrar sesión</button>
            </form>
        </div>
    @endif
@else
    {{-- 🚪 Usuario no logueado --}}
    <div id="stream-login-placeholder" class="no-stream-message">
        <p>Inicia sesión para ver el stream en vivo</p>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            setTimeout(() => {
                const modal = document.querySelector('#loginModal');
                if (modal) {
                    const modalInstance = new bootstrap.Modal(modal);
                    modalInstance.show();
                } else {
                    console.warn('⚠️ No se encontró el #loginModal en la página.');
                }
            }, 1000);
        });
    </script>
@endauth

{{-- Leagues --}}
<div class="col-12 top-sticky mb-3">
    @include($activeTemplate . 'partials.leagues')
</div>

{{-- Juegos --}}
<div class="col-12">
    <div class="betting-body">
        <div class="row g-3">
            @foreach ($games as $game)
                @php
                    $outrightMarket = $game->markets->where('market_type', 'outrights')->first();
                @endphp

                @if ($outrightMarket)
                    <div class="col-12">
                        <div class="sports-card">
                            <div class="sports-card-wrapper sports-card-wrapper-lg">
                                <x-frontend.odds-teams :game="$game" :marketTitle="$outrightMarket->title" />
                                @foreach ($outrightMarket->outcomes as $outcome)
                                    <div class="sports-card-inner">
                                        <div class="sports-card-top-inner sports-card-heading">
                                            <span class="team-select-title">{{ $outcome->name }}</span>
                                        </div>
                                        <div class="sports-card-body">
                                            <div class="option-odd-lists text-center d-flex flex-column align-items-center">
                                                <x-frontend.odds-button :outcome="$outcome" />
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @else
                    <div class="col-12">
                        <div class="game-row-container">
                            {{-- Apuestas Abiertas (IZQUIERDA) --}}
                            <div class="open-bets-horizontal">
                                <x-frontend.open-bets :game="$game" />
                            </div>

                            {{-- Botones de Apostar (DERECHA) --}}
                            <div class="sports-card sports-card-horizontal">
                                <x-frontend.odds-list :game="$game" marketType="h2h" :betPlacedIds="$betPlacedIds" />
                            </div>
                        </div>

                        {{-- Anuncio del Juego--}}
                        @if($game->announcement)
                        <div class="announcement-box mt-2">
                            <div class="announcement-icon">
                                <i class="fas fa-bullhorn"></i>
                            </div>
                            <div class="announcement-content">
                                {{ $game->announcement }}
                            </div>
                        </div>
                        @endif
                    </div>
                @endif
            @endforeach
        </div>

        @if (blank($games))
            <div class="empty-message mt-3 text-center">
                <img class="img-fluid" src="{{ asset($activeTemplateTrue . 'images/empty_message.png') }}" alt="@lang('image')">
                <p>@lang('No game available')</p>
            </div>
        @endif
    </div>
</div>
@endsection

{{--Estilos --}}
@push('style')
<style>
    /* pading */
    .live-banner {
        background: linear-gradient(90deg, #ff6600, #ff914d);
         color: hsl(var(--white));
        font-weight: 700;
        text-align: center;
        padding: 10px 0;
        border-radius: 10px;
        font-size: 1.2rem;
        letter-spacing: 0.5px;
        box-shadow: 0 4px 10px rgba(255,102,0,0.3);
        margin-bottom: 1rem;
        position: relative;
    }

    /* live */
    .live-dot {
        color: #ff0000;
        font-size: 1.2rem;
        margin-left: 8px;
        animation: blink 1s infinite;
    }
    @keyframes blink {
        0%, 100% { opacity: 1; }
        50% { opacity: 0; }
    }

    /*Marco de video */
    .stream-frame {
        background: #00000000;
        border: 2px solid rgba(255, 102, 0, 0.4);
        border-radius: 12px;
        padding: 10px;
        max-width: 950px;
        margin: 0 auto 2rem;
        box-shadow: 0 0 25px rgba(255, 102, 0, 0.2);
        transition: 0.3s ease-in-out;
    }
    .stream-frame:hover {
        box-shadow: 0 0 35px rgba(255, 102, 0, 0.4);
    }

    /* ️s */
    .sports-card {
  background: rgb(10 10 15 / 0%);
  border: 1px solid rgba(255, 255, 255, 0.05);
        padding: 1rem;
        color: #fff;
        box-shadow: 0 3px 10px rgba(0,0,0,0.3);
        transition: transform 0.25s ease, box-shadow 0.25s ease;
    }
    .sports-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 14px rgba(255,102,0,0.3);
    }

    .sports-card-heading {
        color: #ff914d;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .3px;
    }

    /* msj */
    .empty-message, .no-stream-message, .inactive-message {
        text-align: center;
        color: #ccc;
        font-weight: 600;
        padding: 1.5rem;
        border-radius: 10px;
        background: rgba(255,255,255,0.05);
        box-shadow: inset 0 0 15px rgba(255,102,0,0.1);
    }

    /* Ocultar barra de tiempo del video */
    #liveVideo::-webkit-media-controls-timeline {
        display: none !important;
    }
    #liveVideo::-webkit-media-controls-current-time-display,
    #liveVideo::-webkit-media-controls-time-remaining-display {
        display: none !important;
    }

    /* responsive */
@media (max-width: 768px) {
    .stream-title {
        font-size: 1rem !important;
        margin-bottom: 10px !important;
        padding: 0 10px;
    }
    
    .stream-frame {
        max-width: 100% !important;
        width: 100%;
        padding: 5px;
        border: 1px solid rgba(255, 102, 0, 0.3);
        margin-bottom: 1rem;
    }
    
    .stream-frame video,
    .stream-frame iframe {
        width: 100% !important;
        height: 220px !important;
        border-radius: 8px;
    }

    .live-banner {
        font-size: 0.85rem;
        padding: 6px;
        border-radius: 8px;
    }
    
    .live-dot {
        font-size: 0.85rem;
        margin-left: 5px;
    }
}
.announcement-box {
  padding: 4px 10px !important;
  margin: 0 !important;         
  gap: 6px;                     
}

.announcement-content {
  flex: 1;
  color: hsl(var(--white));
  font-size: 14px;
  font-weight: 600;
  line-height: 1.2;            
  text-align: left;
  z-index: 1;
  overflow: hidden;
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
}

/* 🔹 Ajuste móvil */
@media (max-width: 768px) {
  .announcement-box {
    padding: 3px 8px !important;  
    gap: 4px;
    margin-bottom: 4px !important;
  }

  .announcement-icon {
    width: 26px;
    height: 26px;
    font-size: 13px;
  }

</style>
@endpush

{{-- ⚙️ Scripts --}}
@push('script')
<script src="{{ asset($activeTemplateTrue . 'js/betting.js') }}"></script>
<script>
    (function($) {
        "use strict";
        const slider = $('.sports-card');
        let isDown = false, startX, scrollLeft;

        slider.on('mousedown', function(e) {
            isDown = true;
            startX = e.pageX - slider.offset().left;
            scrollLeft = slider.scrollLeft();
            slider.css('cursor', 'grabbing');
        });
        slider.on('mouseleave mouseup', function() {
            isDown = false;
            slider.css('cursor', 'grab');
        });
        slider.on('mousemove', function(e) {
            if(!isDown) return;
            e.preventDefault();
            const x = e.pageX - slider.offset().left;
            slider.scrollLeft(scrollLeft - (x - startX) * 2);
        });
    })(jQuery);
</script>
@endpush


