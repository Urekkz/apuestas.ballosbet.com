@extends($activeTemplate . 'layouts.frontend')

@section('frontend')
    @php
        $registerContent = getContent('register.content', true);
    @endphp
    <div class="login-page section" style="background-image: url({{ asset('assets/images/frontend/register/fondo-registro.jpg') }}); background-size: cover; background-position: center center; background-repeat: no-repeat;">
        <div class="container">
            <div class="row g-3 align-items-center justify-content-lg-between justify-content-center">
                <div class="col-lg-6 d-lg-block d-none">
                    <img class="login-page__img img-fluid" src="{{ frontendImage('register', @$registerContent->data_values->image, '1380x1150') }}" alt="@lang('image')">
                </div>

                <div class="col-lg-6 col-xl-5 col-md-8">
                    <div class="login-form mt-0">
                        <div class="col-12">
                            <h4 class="login-form__title">@lang('Registrarse')</h4>
                        </div>

                        <form class="verify-gcaptcha disableSubmission" action="{{ route('user.register') }}" method="POST">
                            @csrf
                            <div class="row">
                                @if (session()->get('reference') != null)
                                    <div class="form-group">
                                        <label class="form-label">@lang('Id Referencia')</label>
                                        <input class="form-control form--control" type="text" value="{{ session()->get('reference') }}" readonly>
                                    </div>
                                @endif

                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label class="form-label">@lang('First Name')</label>
                                        <input class="form-control form--control" name="firstname" type="text" value="{{ old('firstname') }}" required>
                                    </div>
                                </div>

                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label class="form-label">@lang('Last Name')</label>
                                        <input class="form-control form--control" name="lastname" type="text" value="{{ old('lastname') }}" required>
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label class="form-label">@lang('Email Address')</label>
                                        <input class="form-control form--control checkUser" name="email" type="email" value="{{ old('email') }}" required>
                                    </div>
                                </div>

                                {{-- 🔧 Campo corregido: Número de Celular --}}
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label class="form-label">@lang('Numero de Celular')</label>
                                        <input class="form-control form--control"
                                               name="mobile"
                                               type="text"
                                               value="{{ old('mobile') }}"
                                               inputmode="numeric"
                                               pattern="[0-9]*"
                                               required
                                               style="margin-bottom: 4px;">
                                        <small style="color: #fff; display: block; margin-top: 2px; font-size: 13px; line-height: 1.2;">
                                            @lang('-')
                                        </small>
                                    </div>
                                </div>
                                {{-- 🔧 Fin campo corregido --}}

                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label class="form-label">@lang('Password')</label>
                                        <div class="input-group input--group">
                                            <input class="form-control form--control @if (gs('secure_password')) secure-password @endif" name="password" type="password" required>
                                            <span class="input-group-text pass-toggle"><i class="las la-eye"></i></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label class="form-label">@lang('Confirm Password')</label>
                                        <div class="input-group input--group">
                                            <input class="form-control form--control" name="password_confirmation" type="password" required>
                                            <span class="input-group-text pass-toggle"><i class="las la-eye"></i></span>
                                        </div>
                                    </div>
                                </div>

                                <x-captcha />

                                @if (gs('agree'))
                                    @php
                                        $policyElements = getContent('policy_pages.element', orderById: true);
                                    @endphp
                                    <div class="col-12">
                                        <div class="form-group form-check d-flex align-items-start gap-2 mt-2">
                                            <input class="form-check-input custom--check" id="agree" name="agree" type="checkbox" @checked(old('agree')) required>
                                            <label class="form-check-label" for="agree">
                                                <span class="text-light">@lang('Estoy de acuerdo con')</span>
                                                @foreach ($policyElements as $policy)
                                                    <a href="{{ route('policy.pages', $policy->slug) }}" target="_blank" class="link-terms">
                                                        {{ __(@$policy->data_values->title) }}
                                                    </a>
                                                    @if (!$loop->last), @endif
                                                @endforeach
                                            </label>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <button class="btn btn--xl btn--base w-100 mt-3" type="submit">@lang('Registrarme')</button>

                            <div class="d-flex justify-content-center align-items-center gap-2 mt-2">
                                <span class="d-inline-block sm-text">@lang('No tienes una cuenta?')</span>
                                <a class="t-link d-inline-block t-link--base base-clr sm-text lh-1 text-center text-end" href="{{ route('user.login') }}">
                                    @lang('Acceder')
                                </a>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@if (gs('secure_password'))
    @push('script-lib')
        <script src="{{ asset('assets/global/js/secure_password.js') }}"></script>
    @endpush
@endif

@push('script')
    <script>
        "use strict";
        (function($) {
            $('.checkUser').on('focusout', function(e) {
                var url = '{{ route('user.checkUser') }}';
                var value = $(this).val();
                var token = '{{ csrf_token() }}';
                var data = { email: value, _token: token };
                $.post(url, data, function(response) {
                    if (response.data != false) {
                        $('#existModalCenter').modal('show');
                    }
                });
            });
        })(jQuery);
    </script>
@endpush
