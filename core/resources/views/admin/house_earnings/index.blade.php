@extends('admin.layouts.app')

@section('panel')
    <div class="row mb-3">
        <div class="col-lg-12">
            <div class="d-flex flex-wrap gap-3">
                <div class="flex-fill">
                    <x-widget 
                        style="6" 
                        link="javascript:void(0)" 
                        title="Ganancias Totales de la Casa" 
                        icon="las la-money-bill-wave" 
                        value="{{ showAmount($totalEarnings) }}" 
                        bg="success" 
                        type="2"
                    />
                </div>
                <div class="flex-fill">
                    <x-widget 
                        style="6" 
                        link="javascript:void(0)" 
                        title="Ganancias de Hoy" 
                        icon="las la-calendar-day" 
                        value="{{ showAmount($todayEarnings) }}" 
                        bg="primary" 
                        type="2"
                    />
                </div>
                <div class="flex-fill">
                    <x-widget 
                        style="6" 
                        link="javascript:void(0)" 
                        title="Este Mes" 
                        icon="las la-calendar-alt" 
                        value="{{ showAmount($thisMonthEarnings) }}" 
                        bg="info" 
                        type="2"
                    />
                </div>
                
                @if($filteredEarnings !== null)
                <div class="flex-fill">
                    <x-widget 
                        style="6" 
                        link="javascript:void(0)" 
                        title="Ganancias {{ $filterDateRange }}" 
                        icon="las la-filter" 
                        value="{{ showAmount($filteredEarnings) }}" 
                        bg="warning" 
                        type="2"
                    />
                </div>
                @endif
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="show-filter mb-3 text-end">
                <button type="button" class="btn btn-outline--primary showFilterBtn btn-sm">
                    <i class="las la-filter"></i> @lang('Filter')
                </button>
            </div>
            <div class="card responsive-filter-card mb-4">
                <div class="card-body">
                    <form action="">
                        <div class="d-flex flex-wrap gap-4">
                            <div class="flex-grow-1">
                                <label>@lang('Buscar')</label>
                                <input type="text" name="search" value="{{ request()->search }}" 
                                       class="form-control" placeholder="Número de apuesta o usuario">
                            </div>
                            <div class="flex-grow-1">
                                <label>@lang('Fecha Inicio')</label>
                                <input type="date" name="start_date" value="{{ request()->start_date }}" 
                                       class="form-control" max="{{ date('Y-m-d') }}">
                            </div>
                            <div class="flex-grow-1">
                                <label>@lang('Fecha Fin')</label>
                                <input type="date" name="end_date" value="{{ request()->end_date }}" 
                                       class="form-control" max="{{ date('Y-m-d') }}">
                            </div>
                            <div class="flex-grow-1 align-self-end">
                                <button class="btn btn--primary w-100 h-45"><i class="fas fa-filter"></i> @lang('Filtrar')</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card">
                <div class="card-body p-0">
                    <div class="table-responsive--lg table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                                <tr>
                                    <th>@lang('Fecha')</th>
                                    <th>@lang('Número de Apuesta')</th>
                                    <th>@lang('Usuario')</th>
                                    <th>@lang('Monto Apostado')</th>
                                    <th>@lang('Comisión') (%)</th>
                                    <th>@lang('Monto de Comisión')</th>
                                    <th>@lang('Tipo')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($earnings as $earning)
                                    <tr>
                                        <td>
                                            {{ showDateTime($earning->created_at, 'd M, Y') }}<br>
                                            <small class="text-muted">{{ diffForHumans($earning->created_at) }}</small>
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.report.transaction', $earning->user_id) }}?search={{ $earning->bet_number }}" class="fw-bold text--primary" title="Ver transacción">
                                                <i class="las la-external-link-alt"></i> {{ $earning->bet_number }}
                                            </a>
                                        </td>
                                        <td>
                                            <span class="fw-bold">{{ @$earning->user->fullname }}</span>
                                            <br>
                                            <span class="small">
                                                <a href="{{ route('admin.users.detail', $earning->user_id) }}">
                                                    <span>@</span>{{ @$earning->user->username }}
                                                </a>
                                            </span>
                                        </td>
                                        <td>
                                            <span class="fw-bold">{{ showAmount($earning->bet_amount) }}</span> 
                                            {{ __(gs('cur_text')) }}
                                        </td>
                                        <td>
                                            <span class="badge badge--dark">{{ getAmount($earning->commission_percent) }}%</span>
                                        </td>
                                        <td>
                                            <span class="fw-bold text--success">
                                                {{ showAmount($earning->commission_amount) }} {{ __(gs('cur_text')) }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($earning->type == 'bet_commission')
                                                <span class="badge badge--primary">@lang('Comisión de Apuesta')</span>
                                            @elseif($earning->type == 'win_commission')
                                                <span class="badge badge--success">@lang('Comisión de Ganancia')</span>
                                            @else
                                                <span class="badge badge--info">{{ ucfirst(str_replace('_', ' ', $earning->type)) }}</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                @if ($earnings->hasPages())
                    <div class="card-footer py-4">
                        {{ paginateLinks($earnings) }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('breadcrumb-plugins')
    <a href="{{ route('admin.dashboard') }}" class="btn btn-sm btn-outline--primary">
        <i class="la la-undo"></i> @lang('Back')
    </a>
@endpush

@push('script')
    <script>
        (function($) {
            "use strict";
            
            // Validar que la fecha de fin no sea menor que la fecha de inicio
            $('input[name="start_date"]').on('change', function() {
                var startDate = $(this).val();
                $('input[name="end_date"]').attr('min', startDate);
            });
            
            $('input[name="end_date"]').on('change', function() {
                var endDate = $(this).val();
                var startDate = $('input[name="start_date"]').val();
                
                if (startDate && endDate < startDate) {
                    alert('La fecha de fin no puede ser menor que la fecha de inicio');
                    $(this).val('');
                }
            });
        })(jQuery);
    </script>
@endpush
