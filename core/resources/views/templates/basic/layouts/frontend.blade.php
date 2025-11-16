@extends($activeTemplate . 'layouts.app')

@section('content')
    <header class="header-primary user-header-primary">
        <div class="container">
            @include($activeTemplate . 'partials.header')
        </div>
    </header>

    @yield('frontend')

    @include($activeTemplate . 'partials.footer')

    {{-- Banner de cookies (solo en el login y si no ha sido aceptado) --}}
    @if (request()->routeIs('login') && !Cookie::get('cookiesAccepted'))
        <div id="cookieBanner" class="cookie-banner" style="
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background-color: rgba(0,0,0,0.9);
            color: #fff;
            padding: 15px;
            text-align: center;
            z-index: 9999;
        ">
            <p style="margin: 0 0 10px 0;">
                Podemos utilizar cookies o cualquier otra tecnología de seguimiento cuando visite nuestro sitio web,
                incluido cualquier otro medio, sitio web móvil o aplicación móvil relacionada o conectada, para ayudar
                a personalizar el sitio y mejorar su experiencia.
                <a href="/politica-cookies" style="color: #ff6600; text-decoration: underline;">Leer Más</a>
            </p>
            <button id="acceptCookies" class="btn btn--base" style="
                background-color: #ff6600;
                border: none;
                color: #fff;
                padding: 8px 20px;
                border-radius: 4px;
                cursor: pointer;
            ">Permitir</button>
        </div>

        {{-- Script de control de cookies --}}
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const banner = document.getElementById('cookieBanner');
                const acceptBtn = document.getElementById('acceptCookies');

                if (acceptBtn) {
                    acceptBtn.addEventListener('click', function () {
                        fetch("{{ route('accept.cookies') }}")
                            .then(() => {
                                if (banner) banner.style.display = 'none';
                            })
                            .catch(() => {
                                if (banner) banner.style.display = 'none';
                            });
                    });
                }
            });
        </script>
    @endif
@endsection
