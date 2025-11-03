@extends($activeTemplate . 'layouts.bet')

@section('bet')
@php
    $betPlacedIds = collect(session()->get('bets'))
        ->pluck('outcome_id')
        ->toArray();

    $path = storage_path('app/stream_url.txt');
    $streamUrl = file_exists($path) ? trim(file_get_contents($path)) : '';
@endphp

{{-- Slider --}}
<div class="col-12 mb-3">
    @include($activeTemplate . 'partials.slider')
</div>

{{-- Banner principal animado --}}
<div class="live-banner">
    PELEA DE GALLOS EN VIVO <span class="live-dot">●</span>
</div>

{{-- Visualizador de Stream --}}
<div class="col-12 mb-4">
    <h3 class="text-center" style="color:#fff;margin-bottom:15px;font-weight:700;letter-spacing:.2px;">
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
                const hls = new Hls();
                hls.loadSource(src);
                hls.attachMedia(video);
                hls.on(Hls.Events.MANIFEST_PARSED, () => video.play());
            } else if (video.canPlayType('application/vnd.apple.mpegurl')) {
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
                        {{-- Nueva estructura horizontal --}}
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

                        {{-- Anuncio del Juego (si existe) --}}
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

{{-- 🎨 Estilos --}}
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
        background: #1b1b1b;
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
        background: #232834;
        border-radius: 12px;
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

    /* responsive */
@media (max-width: 768px) {
    .stream-frame {
        max-width: 100% !important;
        width: 100%;
        padding: 0;
        border: none;
    }

    .stream-frame iframe {
        width: 100% !important;
        height: auto;
        aspect-ratio: 16 / 9;
        border-radius: 0;
    }

    .live-banner {
        font-size: 1rem;
        padding: 8px;
        border-radius: 0;
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


