@extends($activeTemplate . 'layouts.frontend')
@section('frontend')
    <div class="login-page section d-flex align-items-center justify-content-center" style="min-height: 100vh;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-5">
                    <div class="login-form text-center p-4">
                        <form action="{{ route('user.data.submit') }}" method="POST" id="userDataForm">
                            @csrf
                            <h4 class="login-form__title">{{ __($pageTitle) }}</h4>
                            <p class="text-muted">@lang('Para disfrutar de una experiencia de apuestas sin interrupciones en nuestra plataforma, complete su perfil.')</p>

                            {{-- COUNTRY --}}
                            <div class="form-group mb-3 text-start">
                                <label class="form-label">@lang('País')</label>
                                <select name="country" class="form-control form--control select2" required>
                                    @foreach ($countries as $key => $country)
                                        <option data-mobile_code="{{ $country->dial_code }}" 
                                                value="{{ $country->country }}" 
                                                data-code="{{ $key }}">
                                            {{ __($country->country) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- MOBILE (also used as username) --}}
                            <div class="form-group text-start">
                                <label class="form-label">@lang('Celular')</label>
                                <div class="input-group">
                                    <span class="input-group-text mobile-code"></span>
                                    <input type="hidden" name="mobile_code">
                                    <input type="hidden" name="country_code">
                                    <input type="number" name="mobile" id="mobile" 
                                           value="{{ old('mobile') }}" 
                                           class="form-control form--control checkUser" required 
                                           placeholder="@lang('Enter your mobile number')">
                                </div>
                                <small class="text--danger mobileExist"></small>
                            </div>

                            {{-- Hidden username field (auto-filled) --}}
                            <input type="hidden" name="username" id="username">

                            {{-- SUBMIT --}}
                            <div class="mt-3">
                                <button type="submit" class="btn btn--xl btn--base w-100">
                                    @lang('Enviar')
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('style')
<style>
    .login-form {
        background: hsl(var(--white));
        border-radius: 5px;
        box-shadow: 0px 3px 18px #ddddddab;
        border: 1px solid #ddddddad;
    }
</style>
@endpush

@push('script')
<script>
"use strict";
(function($) {

    @if ($mobileCode)
        $(`option[data-code={{ $mobileCode }}]`).attr('selected', '');
    @endif

   
    $('select[name=country]').on('change', function() {
        $('input[name=mobile_code]').val($('select[name=country] :selected').data('mobile_code'));
        $('input[name=country_code]').val($('select[name=country] :selected').data('code'));
        $('.mobile-code').text('+' + $('select[name=country] :selected').data('mobile_code'));
    });

    $('input[name=mobile_code]').val($('select[name=country] :selected').data('mobile_code'));
    $('input[name=country_code]').val($('select[name=country] :selected').data('code'));
    $('.mobile-code').text('+' + $('select[name=country] :selected').data('mobile_code'));

    // numero auto
    $('#mobile').on('input', function() {
        $('#username').val($(this).val());
    });

    $('.checkUser').on('focusout', function(e) {
        var value = $(this).val();
        checkUser(value);
    });

    function checkUser(value) {
        var url = '{{ route('user.checkUser') }}';
        var token = '{{ csrf_token() }}';
        var data = {
            mobile: value,
            username: value, // usa el mismo valor
            mobile_code: $('.mobile-code').text().substr(1),
            _token: token
        };

        $.post(url, data, function(response) {
            if (response.data != false) {
                $('.mobileExist').text(`${response.field} already exists`);
            } else {
                $('.mobileExist').text('');
            }
        });
    }

    // 
    $('#userDataForm').on('submit', function() {
        $('#username').val($('#mobile').val());
    });

})(jQuery);
</script>
@endpush
