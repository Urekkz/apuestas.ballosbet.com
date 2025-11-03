@extends($activeTemplate . 'layouts.master')
@section('master')
    <div class="card custom--card">

        <div class="card-body text-center">
            <h5 class="card-title mb-3">
                @lang('Vista previa de pago')
            </h5>

            <h6> @lang('POR FAVOR, ENVÍE EXACTAMENTE') <span class="text--base"> {{ $data->amount }}</span> {{ __($data->currency) }}</h6>
            <h5 class="mb-4">@lang('PARA') <span class="text--base"> {{ $data->sendto }}</span></h5>
            <img src="{{ $data->img }}" alt="@lang('Image')">
            <h5 class="text--base">@lang('ESCANEAR PARA ENVIAR')</h5>
        </div>
    </div>
@endsection
