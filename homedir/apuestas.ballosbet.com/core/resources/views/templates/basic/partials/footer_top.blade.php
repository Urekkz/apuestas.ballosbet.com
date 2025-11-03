@php
    $footerContent = getContent('footer.content', true);
@endphp

<div class="row g-4 justify-content-center align-items-center text-center">

    <!-- LOGO -->
    <div class="col-12 mb-4">
        <img src="{{ asset('assets/images/logo-footer.png') }}" 
             alt="{{ __(gs('site_name')) }}" 
             style="max-width:240px; height:auto;">
    </div>

    <!-- MENÚ DE ENLACES -->
    <div class="col-12">
        <nav class="footer-links d-flex justify-content-center flex-wrap">
            @php
                $contactUrl   = \Illuminate\Support\Facades\Route::has('contact') ? route('contact') : url('/contact');
                $faqUrl       = \Illuminate\Support\Facades\Route::has('faq') ? route('faq') : url('/faq');
                $termsUrl     = \Illuminate\Support\Facades\Route::has('terms') ? route('terms') : url('/terms');
                $benefitsUrl  = url('/beneficios');
            @endphp

            <a href="{{ $contactUrl }}" class="footer-link">CONTACTO</a>
            <a href="{{ $faqUrl }}" class="footer-link">PREGUNTAS FRECUENTES</a>
            <a href="{{ $termsUrl }}" class="footer-link">TÉRMINOS Y CONDICIONES</a>
            <a href="{{ $benefitsUrl }}" class="footer-link">BENEFICIOS</a>
        </nav>
    </div>

    <!-- TEXTO DESCRIPTIVO -->
    <div class="col-12 mt-4">
        <p class="footer-text">
            {{ __(@$footerContent->data_values->details) ?: 'El uso de este sitio está sujeto a las condiciones de la empresa al utilizar este sitio, define tus límites. Juega legal y con responsabilidad. Prohibida la venta a menores de edad.' }}
        </p>
    </div>

</div>

@push('style')
<style>
    /* ===== ESTILO GENERAL FOOTER SUPERIOR ===== */
    .footer-links {
        gap: 60px;
        margin-top: 20px;
        margin-bottom: 15px;
    }

    .footer-link {
        color: #fff;
        text-transform: uppercase;
        text-decoration: none;
        font-size: 1rem; /* ≈16px */
        letter-spacing: 3px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .footer-link:hover {
        color: hsl(var(--base));
    }

    .footer-text {
        max-width: 700px;
        margin: 0 auto;
        color: #d0d0d0;
        font-size: 0.9rem;
        line-height: 1.8;
        font-weight: 500;
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 992px) {
        .footer-links { gap: 40px; }
        .footer-link { font-size: 0.95rem; letter-spacing: 2px; }
    }

    @media (max-width: 576px) {
        .footer-links { gap: 25px; }
        .footer-link { font-size: 0.9rem; display: block; }
        .footer-text { font-size: 0.85rem; }
    }
</style>
@endpush
