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
            </div>
        </div>

        <div class="betslip">
            <div class="betslip-header">
                <div class="list-group bet-type justify-content-center">
                    <label for="mybets-btn" class="bet-type__btn">
                        <input id="mybets-btn" type="radio" name="bet-type" checked>
                        <span>@lang('Mis apuestas')</span>
                    </label>
                </div>
            </div>

            <div class="mybet-container betslip-inner">
                @include($activeTemplate . 'partials.my_bets')
            </div>
        </div>

        @include($activeTemplate . 'partials.mobile_menu')
    </main>

    {{-- Footer FUERA del home-page para que aparezca abajo --}}
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
@endsection


