@extends($activeTemplate . 'layouts.app')
@section('content')
    <header class="header-primary">
        <div class="container-fluid">
            @include($activeTemplate . 'partials.header')
        </div>
    </header>
    <main class="home-page">
        @include($activeTemplate . 'partials.category')
        <div class="sports-body">
            <div class="row g-3">
                @yield('bet')
                <div class="col-12">
                    <div class="footer footer--light">
                        @include($activeTemplate . 'partials.footer_top')
                    </div>
                </div>
                <div class="col-12">
                    <div class="footer-bottom">
                        <div class="container-fluid">
                            @include($activeTemplate . 'partials.footer_bottom')
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="betslip">
            <div class="betslip-header">
                <div class="list-group bet-type">
                    <label for="mybets-btn" class="bet-type__btn">
                        <input id="mybets-btn" type="radio" name="bet-type" @checked(request()->has('mybets') || true)>
                        <span>@lang('Mis Apuestas')</span>
                    </label>
                </div>
            </div>
            <div class="d-flex flex-column flex-md-row gap-3">
                <div class="mybet-container betslip-inner" style="flex:1; min-width:300px;">
                    @include($activeTemplate . 'partials.my_bets')
                </div>
            </div>
        </div>
        @include($activeTemplate . 'partials.mobile_menu')
    </main>
@endsection

@push('script')
<script src="{{ asset($activeTemplateTrue . 'js/betting.js') }}"></script>
<style>
/* Botón de odds seleccionado */
.oddBtn.selected-outcome {
    background: linear-gradient(135deg, #ff6b35 0%, #f7931e 100%) !important;
    color: #fff !important;
    border-color: #ff6b35 !important;
    box-shadow: 0 4px 15px rgba(255, 107, 53, 0.4) !important;
    transform: scale(1.08);
    font-weight: 700;
}

/* Botón de monto seleccionado */
.bet-amount-btn.btn-success {
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%) !important;
    border-color: #28a745 !important;
    color: #fff !important;
    box-shadow: 0 4px 12px rgba(40, 167, 69, 0.4) !important;
    transform: scale(1.05);
}

/* Asegurar que los botones tengan cursor pointer */
.oddBtn:not(.locked),
.bet-amount-btn,
.custom-bet {
    cursor: pointer !important;
}

/* Botones bloqueados */
.oddBtn.locked,
.oddBtn:disabled {
    opacity: 0.5;
    cursor: not-allowed !important;
}
</style>
@endpush





