@extends($activeTemplate . 'layouts.master')
@section('master')
    <div class="table-responsive">
        <table class="table-responsive--md custom--table table">
            <thead>
                <tr>
                    <th>@lang('Asunto')</th>
                    <th>@lang('Estado')</th>
                    <th>@lang('Prioridad')</th>
                    <th>@lang('Última respuesta')</th>
                    <th>@lang('Acción')</th>
            </thead>

            <tbody>
                @forelse($supports as $support)
                    <tr>
                        <td>
                            <a class="t-link--base" href="{{ route('ticket.view', $support->ticket) }}">[@lang('Ticket')#{{ $support->ticket }}] {{ __($support->subject) }}</a>
                        </td>
                        <td>
                            @php echo $support->statusBadge; @endphp
                        </td>
                        <td>
                            @if ($support->priority == Status::PRIORITY_LOW)
                                <span class="badge badge--dark">@lang('Baja')</span>
                            @elseif($support->priority == Status::PRIORITY_MEDIUM)
                                <span class="badge badge--warning">@lang('Media')</span>
                            @elseif($support->priority == Status::PRIORITY_HIGH)
                                <span class="badge badge--danger">@lang('Alta')</span>
                            @endif
                        </td>
                        <td>{{ diffForHumans($support->last_reply) }} </td>
                        <td>
                            <a class="btn btn--sm btn-outline--base" href="{{ route('ticket.view', $support->ticket) }}">
                                <i class="las la-desktop"></i> @lang('Ver')
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td class="text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4 align-items-center pagination-wrapper">
        {{ $supports->links() }}
    </div>
@endsection

@push('breadcrumb-items')
    <a class="btn btn--base" href="{{ route('ticket.open') }}">
        <span class="dashboard-menu__text"><i class="la la-plus"></i> @lang('Abrir nuevo Ticket')</span>
    </a>
@endpush
