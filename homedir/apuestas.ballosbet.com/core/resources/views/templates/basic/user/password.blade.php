@extends($activeTemplate . 'layouts.master')
@section('master')
    <div class="card custom--card">
        <div class="card-body">
            <div class="mb-3">
                <h5 class="card-title">@lang('Actualiza tu contraseña')</h5>
                <small class="text-muted">@lang('Actualiza tu contraseña para mantener tu cuenta segura. Introduce tu contraseña actual y elige una nueva a continuación.')</small>
            </div>
            <form method="post">
                @csrf
                <div class="form-group">
                    <label class="form-label">@lang('Contraseña actual')</label>
                    <input type="password" class="form-control form--control" name="current_password" required autocomplete="current-password">
                </div>
                <div class="form-group">
                    <label class="form-label">@lang('Nueva Contraseña')</label>
                    <input type="password" class="form-control form--control @if (gs('secure_password')) secure-password @endif" name="password" required autocomplete="current-password">
                </div>
                <div class="form-group">
                    <label class="form-label">@lang('Confirmar Contraseña')</label>
                    <input type="password" class="form-control form--control" name="password_confirmation" required autocomplete="current-password">
                </div>
                <div class="text-end">
                    <button type="submit" class="btn btn--base w-100">@lang('Enviar')</button>
                </div>
            </form>
        </div>
    </div>
@endsection
@if (gs('secure_password'))
    @push('script-lib')
        <script src="{{ asset('assets/global/js/secure_password.js') }}"></script>
    @endpush
@endif
