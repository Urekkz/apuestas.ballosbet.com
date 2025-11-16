@extends('admin.layouts.master')
@section('content')
<div class="login-main"
    style="background-image: url('{{ asset('assets/admin/images/fondoadmin.jpg') }}'); background-size: cover; background-position: center center; background-repeat: no-repeat; min-height: 100vh; position: relative;">
    <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0, 0, 0, 0.7);"></div>
    <div class="container custom-container" style="position: relative; z-index: 1;">
        <div class="row justify-content-center align-items-center" style="min-height: 100vh;">
            <div class="col-xxl-4 col-xl-5 col-lg-6 col-md-7 col-sm-10">
                <div class="login-area">
                    <div class="login-wrapper" style="background: #1a1a1a; border: 1px solid #ff8a00; border-radius: 10px; box-shadow: 0 10px 40px rgba(0, 0, 0, 0.5); overflow: hidden;">
                        <div class="login-wrapper__top" style="background: #ff8a00; padding: 35px 30px; text-align: center;">
                            <h3 class="title" style="font-size: 1.75rem; font-weight: 700; color: #000; margin-bottom: 5px;">@lang('Ballos Bet')</h3>
                            <p style="color: #000; font-size: 0.9rem; margin-bottom: 0; font-weight: 500;">@lang('Panel de Administración')</p>
                        </div>
                        <div class="login-wrapper__body" style="padding: 35px 30px;">
                            <form action="{{ route('admin.login') }}" method="POST"
                                class="cmn-form verify-gcaptcha login-form">
                                @csrf
                                <div class="form-group" style="margin-bottom: 20px;">
                                    <label style="color: #fff; font-weight: 500; margin-bottom: 8px; font-size: 0.95rem;">@lang('Usuario')</label>
                                    <input type="text" class="form-control" value="{{ old('username') }}" name="username" required style="background: #000; border: 1px solid #333; color: #fff; padding: 12px 15px; border-radius: 5px; transition: all 0.3s;">
                                </div>
                                <div class="form-group" style="margin-bottom: 20px;">
                                    <label style="color: #fff; font-weight: 500; margin-bottom: 8px; font-size: 0.95rem;">@lang('Contraseña')</label>
                                    <input type="password" class="form-control" name="password" required style="background: #000; border: 1px solid #333; color: #fff; padding: 12px 15px; border-radius: 5px; transition: all 0.3s;">
                                </div>
                                <div style="text-align: right; margin-bottom: 20px;">
                                    <a href="{{ route('admin.password.reset') }}" class="forget-text" style="color: #ff8a00; font-size: 0.9rem; font-weight: 500; text-decoration: none;">@lang('¿Olvidaste tu contraseña?')</a>
                                </div>
                                <x-captcha />
                                <button type="submit" class="btn cmn-btn w-100" style="background: #ff8a00; border: none; padding: 13px; font-size: 1rem; font-weight: 700; border-radius: 5px; color: #000; margin-top: 10px; transition: all 0.3s;">@lang('INICIAR SESIÓN')</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .login-main .form-control:focus {
        background: #000 !important;
        border-color: #ff8a00 !important;
        box-shadow: 0 0 0 3px rgba(255, 138, 0, 0.15) !important;
        outline: none;
    }
    
    .login-main .form-control:hover {
        border-color: #555 !important;
    }
    
    .login-main .btn:hover {
        background: #ff9d1a !important;
        transform: translateY(-1px);
        box-shadow: 0 5px 15px rgba(255, 138, 0, 0.4);
    }
    
    .forget-text:hover {
        color: #ff9d1a !important;
    }
</style>
@endsection
