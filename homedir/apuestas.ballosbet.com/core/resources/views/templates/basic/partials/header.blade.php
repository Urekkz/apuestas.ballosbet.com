<div class="header-fluid-custom-parent">

    <div class="logo">
        <a href="https://apuestas.ballosbet.com/">
            <img class="img-fluid" src="{{ siteLogo() }}" alt="@lang('logo')">
        </a>
    </div>

    <nav class="primary-menu-container">

        {{-- Menú solo con INICIO --}}
        <ul class="align-items-center justify-content-start gap-3 mb-0 p-0 list-unstyled d-none d-lg-flex">
            <li>
                <a href="https://apuestas.ballosbet.com/" class="text-white sm-text">
                    @lang('INICIO')
                </a>
            </li>
        </ul>

        <ul class="list list--row primary-menu justify-content-end align-items-center right-side-nav gap-3 gap-sm-4">


            <li class="d-flex align-items-center gap-2">
                <div class="d-flex align-items-center gap-1">
                    <img class="flag"
                         src="https://apuestas.ballosbet.com/assets/images/language/68fb99650de3d1761319269.jpg"
                         alt="Perú"
                         style="width: 20px; height: 14px; border-radius: 2px;">
                    <span class="text-white" style="font-size: 14px;">ES</span>
                </div>
            </li>

            {{-- Balance (mobile) --}}
            <li class="d-flex align-items-center">
                @auth
                    <div class="app-nav__menu-text text-white ps-2">@lang('Balance'): <strong id="mobileBalance">{{ showAmount(auth()->user()->balance) }}</strong></div>
                @endauth
            </li>

            {{-- Usuario --}}
            <li class="d-none d-lg-block">
                @if (auth()->check() && !request()->routeIs('user.*'))
                    <div class="dropdown-center user-profile-dropdown">
                        <button class="dropdown-toggle user-profile-btn" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="la la-user-circle"></i> {{ auth()->user()->username }}
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{route('user.profile.setting')}}">@lang('My Profile')</a></li>
                            <li><a class="dropdown-item" href="{{route('user.deposit.index')}}">@lang('Deposit Money')</a></li>
                            <li><a class="dropdown-item" href="{{route('user.logout')}}">@lang('Logout')</a></li>
                        </ul>
                    </div>
                @else
                    @if (Route::is('user.login'))
                        <a class="btn btn--signup" href="{{ route('user.register') }}"> @lang('Sign Up') </a>
                    @else
                        @if (in_array(request()->route()->getName(), ['home', 'category.games', 'game.markets']))
                            <button class="btn btn--signup" data-bs-toggle="modal" data-bs-target="#loginModal" type="button">
                                <i class="la la-sign-in"></i> @lang('Login')
                            </button>
                        @else
                            <a class="btn btn--signup" href="{{ route('user.login') }}">
                                <i class="la la-sign-in"></i> @lang('Salir')
                            </a>
                        @endif
                    @endif
                @endif
            </li>
        </ul>
    </nav>
</div>

@php
    $loginContent = getContent('login.content', true);
@endphp

@if (in_array(request()->route()->getName(), ['home', 'category.games', 'game.markets']))
    <div class="modal fade login-modal" id="loginModal" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body p-3 p-sm-5">
                    <span class="close" data-bs-dismiss="modal" type="button" aria-label="Close">
                        <i class="las la-times"></i>
                    </span>
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h4 class="mt-0">{{ __(@$loginContent->data_values->heading) }}</h4>
                    </div>
                    @include($activeTemplate . 'partials.login')
                </div>
            </div>
        </div>
    </div>
@endif

