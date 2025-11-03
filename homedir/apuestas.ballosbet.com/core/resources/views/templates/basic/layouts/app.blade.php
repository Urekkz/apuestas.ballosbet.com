<!doctype html>
<html lang="{{ config('app.locale') }}" itemscope itemtype="http://schema.org/WebPage">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title> {{ gs()->siteName(__($pageTitle)) }}</title>
    @include('partials.seo')
    <link href="{{ asset('assets/global/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/global/css/all.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/global/css/custom-icon.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/global/css/line-awesome.min.css') }}">
    <link href="{{ asset($activeTemplateTrue . 'css/slick.css') }}" rel="stylesheet">
    <link href="{{ asset($activeTemplateTrue . 'css/magnific-popup.css') }}" rel="stylesheet">
    <link href="{{ asset($activeTemplateTrue . 'css/simplebar.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/global/css/select2.min.css') }}">
    <link href="{{ asset($activeTemplateTrue . 'css/main.css') }}" rel="stylesheet">
    @stack('style-lib')
    <link href="{{ asset($activeTemplateTrue . 'css/custom.css') }}" rel="stylesheet">
    @stack('style')
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'css/color.php') }}?color={{ gs('base_color') }}">
</head>

@php echo loadExtension('google-analytics') @endphp

<body>
    <div class="preloader">
        <div class="preloader__img">
            <img src="{{ siteFavicon() }}" alt="@lang('image')" />
        </div>
    </div>

    <div class="back-to-top">
        <span class="back-top">
            <i class="las la-angle-double-up"></i>
        </span>
    </div>

    <div class="body-overlay" id="body-overlay"></div>
    <div class="header-overlay"></div>

    @yield('content')

    @php
        $cookie = App\Models\Frontend::where('data_keys', 'cookie.data')->first();
    @endphp

    @if ($cookie->data_values->status == Status::ENABLE && !\Cookie::get('gdpr_cookie'))
        <div class="cookies-card text-center hide">
            <div class="cookies-card__icon bg--base">
                <i class="las la-cookie-bite"></i>
            </div>
            <p class="mt-4 cookies-card__content">{{ $cookie->data_values->short_desc }} <a href="{{ route('cookie.policy') }}" target="_blank">@lang('learn more')</a></p>
            <div class="cookies-card__btn mt-4">
                <a href="javascript:void(0)" class="btn btn--xl btn--base w-100 policy">@lang('Allow')</a>
            </div>
        </div>
    @endif

    @auth
        <div class="modal custom--modal" data-bs-backdrop="static" data-bs-keyboard="false" id="betModal" aria-hidden="true" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content" style="background: #1a1a1a; border: 2px solid #ff8a00; border-radius: 12px;">
                    <div class="modal-body" style="padding: 20px;">
                        <form id="betForm" action="{{ route('user.bet.place') }}" method="POST">
                            @csrf
                            <h3 class="text-center mb-3" style="color: #ff8a00; font-weight: 700; font-size: 1.4rem; text-transform: uppercase; letter-spacing: 1px;">
                                Confirmar Apuesta
                            </h3>

                            <input name="stake_amount" type="hidden">
                            <input name="type" type="hidden">
                            
                            <div style="background: #2d2d2d; padding: 18px; border-radius: 10px; margin-bottom: 15px; border: 1px solid #ff8a00;">
                                <div class="mb-2 pb-2" style="border-bottom: 1px solid #444;">
                                    <small style="color: #999; font-size: 0.8rem;">Balance Actual</small>
                                    <div class="d-flex align-items-center justify-content-between mt-1">
                                        <h5 class="m-0" id="userBalance" style="color: #fff; font-size: 1.1rem; font-weight: 600;">
                                            {{ showAmount(auth()->user()->balance) }}
                                        </h5>
                                        <a href="{{route('user.deposit.index')}}" class="btn btn--success btn-sm" style="background: #28a745; padding: 4px 10px; border-radius: 6px; font-size: 0.8rem; font-weight: 600;">
                                            <i class="la la-plus"></i> Agregar
                                        </a>
                                    </div>
                                </div>

                                <div class="mb-2 pb-2" style="border-bottom: 1px solid #444;">
                                    <small style="color: #999; font-size: 0.8rem;">Monto de la apuesta</small>
                                    <h4 class="m-0 mt-1" id="betStakeAmount" style="color: #ff8a00; font-size: 1.4rem; font-weight: 700;"></h4>
                                </div>
                                
                                <div class="mb-0">
                                    <small style="color: #999; font-size: 0.8rem;">Monto de devolucion</small>
                                    <h4 class="m-0 mt-1" id="betReturnAmount" style="color: #ff8a00; font-size: 1.6rem; font-weight: 700;"></h4>
                                </div>
                            </div>
                        </form>

                        <div class="alert mb-3" style="background: rgba(255, 138, 0, 0.1); border: 1px solid #ff8a00; border-radius: 8px; padding: 10px;">
                            <i class="la la-info-circle" style="color: #ff8a00; font-size: 1rem;"></i>
                            <span style="color: #fff; font-size: 0.85rem;">
                                Una vez confirmada, tu apuesta no se puede cancelar.
                            </span>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="button" class="btn flex-grow-1" data-bs-dismiss="modal" 
                                style="background: #2d2d2d; color: #fff; border: 2px solid #555; padding: 10px; font-size: 0.95rem; font-weight: 600; border-radius: 8px; transition: all 0.3s;">
                                Cancelar
                            </button>
                            <button type="submit" class="btn flex-grow-1" form="betForm"
                                style="background: linear-gradient(135deg, #ff8a00 0%, #ff6b35 100%); color: #fff; border: none; padding: 10px; font-size: 0.95rem; font-weight: 600; border-radius: 8px; box-shadow: 0 4px 12px rgba(255, 138, 0, 0.4); transition: all 0.3s;">
                                Confirmar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <script>
            // Hacer el balance del usuario disponible globalmente
            window.userBalance = {{ auth()->user()->balance }};
        </script>
        
        
        <style>
            /* Estilos para botones del modal */
            #betModal .btn:hover {
                transform: translateY(-2px);
                box-shadow: 0 6px 20px rgba(255, 138, 0, 0.5);
            }
            
            #betModal button[data-bs-dismiss="modal"]:hover {
                background: #3d3d3d !important;
                border-color: #ff8a00 !important;
            }
            
            /* Responsive para m車viles */
            @media (max-width: 767px) {
                #betModal .modal-dialog {
                    margin: 10px;
                    max-width: calc(100% - 20px);
                }
                
                #betModal .modal-body {
                    padding: 15px !important;
                }
                
                #betModal h3 {
                    font-size: 1.2rem !important;
                    letter-spacing: 1px !important;
                }
                
                #betModal h4 {
                    font-size: 1.1rem !important;
                }
                
                #betModal h5 {
                    font-size: 0.95rem !important;
                }
                
                #betModal small {
                    font-size: 0.75rem !important;
                }
                
                #betModal .btn {
                    padding: 10px !important;
                    font-size: 0.9rem !important;
                }
            }
            
            @media (max-width: 480px) {
                #betModal .modal-dialog {
                    margin: 5px;
                    max-width: calc(100% - 10px);
                }
                
                #betModal .modal-body {
                    padding: 12px !important;
                }
                
                #betModal h3 {
                    font-size: 1rem !important;
                }
                
                #betModal h4 {
                    font-size: 0.95rem !important;
                }
                
                #betModal .alert {
                    padding: 8px !important;
                    font-size: 0.75rem !important;
                }
            }
        </style>
    @endauth

    <script src="{{ asset('assets/global/js/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('assets/global/js/bootstrap.bundle.min.js') }}"></script>

    @stack('script-lib')

    @php echo loadExtension('tawk-chat') @endphp

    @include('partials.notify')

    @if (gs('pn'))
        @include('partials.push_script')
    @endif

    <script src="{{ asset($activeTemplateTrue . 'js/slick.js') }}"></script>
    <script src="{{ asset($activeTemplateTrue . 'js/jquery.magnific-popup.js') }}"></script>
    <script src="{{ asset($activeTemplateTrue . 'js/simplebar.min.js') }}"></script>
    <script src="{{ asset($activeTemplateTrue . 'js/jquery.stepcycle.js') }}"></script>
    <script src="{{ asset('assets/global/js/select2.min.js') }}"></script>
    <script src="{{ asset($activeTemplateTrue . 'js/app.js') }}"></script>
    @stack('script')

    <script>
        (function($) {
            "use strict";

            $(".langSel").on("click", function() {
                window.location.href = "{{ route('home') }}/change/" + $(this).data('code');
            });

            $(".oddsType").on("change", function() {
                window.location.href = `{{ route('odds.type', '') }}/${$(this).val()}`;
            });

            $('.policy').on('click', function() {
                $.get('{{ route('cookie.accept') }}', function(response) {
                    $('.cookies-card').addClass('d-none');
                });
            });

            setTimeout(function() {
                $('.cookies-card').removeClass('hide')
            }, 2000);

            var inputElements = $('[type=text],select,textarea');

            $.each(inputElements, function(index, element) {
                element = $(element);
                element.closest('.form-group').find('label').attr('for', element.attr('name'));
                element.attr('id', element.attr('name'))
            });

            $.each($('input:not([type=checkbox]):not([type=hidden]), select, textarea'), function(i, element) {
                var elementType = $(element);
                if (elementType.attr('type') != 'checkbox') {
                    if (element.hasAttribute('required')) {
                        $(element).closest('.form-group').find('label').addClass('required');
                    }
                }
            });

            let disableSubmission = false;

            $('.disableSubmission').on('submit', function(e) {
                if (disableSubmission) {
                    e.preventDefault()
                } else {
                    disableSubmission = true;
                }
            });

            $.each($(".select2"), function() {
                $(this).wrap(`<div class="position-relative"></div>`).select2({
                    dropdownParent: $(this).parent(),
                });
            });

            Array.from(document.querySelectorAll('table')).forEach(table => {
                let heading = table.querySelectorAll('thead tr th');
                Array.from(table.querySelectorAll('tbody tr')).forEach(row => {
                    Array.from(row.querySelectorAll('td')).forEach((column, i) => {
                        (column.colSpan == 100) || column.setAttribute('data-label', heading[i].innerText)
                    });
                });
            });

        })(jQuery);

        function showAmount(amount, decimal = 2, separate = true, exceptZeros = false, currencyFormat = true) {
            amount *= 1;

            const settings = {
                currencyFormat: @json(gs('currency_format')),
                currencySymbol: @json(gs('cur_sym')),
                currencyText: @json(gs('cur_text')),
            }

            let separator = separate ? ',' : '';
            let printAmount = amount.toFixed(decimal).replace(/\B(?=(\d{3})+(?!\d))/g, separator);

            if (exceptZeros) {
                let parts = printAmount.split('.');
                if (parseInt(parts[1]) === 0) {
                    printAmount = parts[0];
                } else {
                    printAmount = printAmount.replace(/0+$/, '');
                }
            }

            if (currencyFormat) {
                if (settings.currencyFormat === @json(Status::CUR_BOTH)) {
                    return settings.currencySymbol + printAmount + ' ' + settings.currencyText;
                } else if (settings.currencyFormat ===  @json(Status::CUR_TEXT)) {
                    return printAmount + ' ' + settings.currencyText;
                } else {
                    return settings.currencySymbol + printAmount;
                }
            }

            return printAmount;
        }
         function updateReturnAmount() {
        const stakeText = document.getElementById('betStakeAmount')?.textContent || '0';
        const stake = parseFloat(stakeText.replace(/[^\d.]/g, '')) || 0;

        // Si el favoritismo está disponible (del outcome seleccionado)
        let favoritismo = window.currentFavoritismo || 'Mano a mano';
        let multiplier = 1.95; // Valor por defecto

        if (favoritismo.includes('8')) {
            multiplier = 1.75;
        } else if (favoritismo.includes('7')) {
            multiplier = 1.65;
        }

        const totalReturn = stake * multiplier;
        const returnEl = document.getElementById('betReturnAmount');
        if (returnEl) {
            returnEl.textContent = showAmount(totalReturn, 2, true, false, true);
        }
    }

    // Llama esto cuando actualices el monto de apuesta o favoritismo
    // Ejemplo: al abrir el modal o modificar el stake
    document.addEventListener('DOMContentLoaded', function() {
        updateReturnAmount();
    });
    </script>
</body>

</html>

