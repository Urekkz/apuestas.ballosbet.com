@extends($activeTemplate . 'layouts.frontend')
@section('frontend')
    @php
        $loginContent = getContent('login.content', true);
    @endphp
    <div class="login-page section" style="background-image: url({{ frontendImage('login', @$loginContent->data_values->background_image, '1920x1070') }}); position: relative; overflow: hidden; min-height: 100vh;">
        <!-- Overlay con degradado -->
        <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: linear-gradient(135deg, rgba(255, 138, 0, 0.15) 0%, rgba(26, 26, 26, 0.85) 50%, rgba(0, 0, 0, 0.95) 100%); z-index: 1;"></div>
        
        <div class="container" style="position: relative; z-index: 2;">
            <div class="row g-4 align-items-center justify-content-lg-between justify-content-center min-vh-100 py-5">
                <!-- Imagen lado izquierdo -->
                <div class="col-lg-6 d-lg-block d-none">
                    <div class="login-image-wrapper" style="animation: fadeInLeft 0.8s ease-out;">
                        <img class="login-page__img img-fluid" src="{{ frontendImage('login', @$loginContent->data_values->image, '1380x1150') }}" alt="@lang('image')" style="filter: drop-shadow(0 20px 60px rgba(255, 138, 0, 0.3)); border-radius: 20px;">
                        
                        <div class="welcome-text mt-4 text-center">
                            <h2 style="color: #ff8a00; font-weight: 800; font-size: 2.5rem; text-shadow: 2px 2px 8px rgba(0,0,0,0.5);">
                                ¡Bienvenido de vuelta!
                            </h2>
                            <p style="color: #fff; font-size: 1.1rem; text-shadow: 1px 1px 4px rgba(0,0,0,0.7);">
                                Las mejores peleas te esperan
                            </p>
                        </div>
                    </div>
                </div>
                
                <!-- Formulario lado derecho -->
                <div class="col-lg-6 col-xl-5 col-md-8">
                    <div class="login-form mt-0" style="background: rgba(26, 26, 26, 0.95); border: 2px solid #ff8a00; border-radius: 20px; padding: 40px; box-shadow: 0 20px 60px rgba(255, 138, 0, 0.2), 0 0 100px rgba(0, 0, 0, 0.5); backdrop-filter: blur(10px); animation: fadeInRight 0.8s ease-out;">
                        <div class="text-center mb-4">
                            <div style="display: inline-block; padding: 15px; background: linear-gradient(135deg, #ff8a00 0%, #ff6b35 100%); border-radius: 50%; box-shadow: 0 8px 20px rgba(255, 138, 0, 0.4);">
                                <i class="las la-user" style="font-size: 3rem; color: #fff;"></i>
                            </div>
                        </div>
                        
                        <div class="col-12 mb-4">
                            <h3 class="login-form__title text-center" style="color: #ff8a00; font-weight: 800; font-size: 2rem; text-transform: uppercase; letter-spacing: 2px; margin-bottom: 10px;">
                                {{ __(@$loginContent->data_values->heading) }}
                            </h3>
                            <p class="text-center" style="color: #999; font-size: 0.95rem;">
                                Accede a tu cuenta para continuar apostando
                            </p>
                        </div>
                        
                        @include($activeTemplate . 'partials.login')
                        @include($activeTemplate . 'partials.social_login')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
