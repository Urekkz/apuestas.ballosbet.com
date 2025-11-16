@extends('admin.layouts.app')

@section('panel')
    @php
        $isGameDataExists = $game->id ?? false;
    @endphp

    <form action="{{ route('admin.game.store', $isGameDataExists ?? 0) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row justify-content-center">

            <div class="col-xl-8">
                <div class="card">

                    <x-ajax-preloader />

                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label>@lang('Event Type')</label>
                                    <select class="form-control select2 slug" name="event_type" required>
                                        <option value="" selected disabled hidden>@lang('Select One')</option>
                                        <option value="{{Status::EVENT_TYPE_INDIVIDUAL}}" @selected(@$game->is_outright === Status::NO)>@lang('Individual Match')</option>
                                        <option value="{{Status::EVENT_TYPE_OUTRIGHT}}" @selected(@$game->is_outright === Status::YES)>@lang('Outright')</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-12" id="leaguesWrapper">
                                <div class="form-group">
                                    <label>@lang('League')</label>
                                    <select class="form-control select2 slug" name="league_id" required>
                                        <option value="" selected disabled hidden>@lang('Select One')</option>
                                        @foreach ($categories as $category)
                                            <optgroup label="{{ $category->name }}">
                                                @foreach ($category->leagues as $league)
                                                    <option data-name="{{ $league->name }}" data-logo="{{ $league->logo() }}" data-category="{{ $league->category_id }}" value="{{ $league->id }}" @selected(@$game->league_id == $league->id)>{{ __($league->name) }}</option>
                                                @endforeach
                                            </optgroup>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label>@lang('Title')</label>
                                    <input class="form-control slug" name="title" type="text" value="{{ old('title', @$game->title) }}" required>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>@lang('Game Starts From')</label>
                                    <input name="start_time" type="datetime-local" class="form-control bg--white"
                                           value="{{ old('start_time', @$game->start_time) }}" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>@lang('Bet Starts From')</label>
                                    <input name="bet_start_time" type="datetime-local" class="form-control bg--white"
                                           value="{{ old('bet_start_time', @$game->bet_start_time) }}" required>
                                </div>
                            </div>

<!--  BLOQUE: Control de tiempo de apuesta -->
<div class="col-md-6">
    <div class="form-group">
        <label>Limite de tiempo de apuesta (minutos antes del inicio)</label>
        <input type="range"
               class="form-range"
               name="bet_time_limit"
               min="1"
               max="300"
               value="{{ old('bet_time_limit', @$game->bet_time_limit ?? 10) }}"
               id="betTimeLimitRange">
        <div>
            <output id="betTimeLimitValue" style="font-weight: bold;">{{ old('bet_time_limit', @$game->bet_time_limit ?? 10) }}</output> minutos
        </div>
        <small class="form-text text-muted d-block mt-1">
            Arrastra para definir cuantos minutos antes del inicio se cerraran las apuestas.
        </small>
    </div>
</div>
<!--  FIN BLOQUE -->

                            <div class="col-12">
                                <div class="form-group">
                                    <label>@lang('Anuncio del Juego')</label>
                                    <textarea class="form-control" name="announcement" rows="3" placeholder="Escribe un anuncio sobre este juego (opcional)...">{{ old('announcement', @$game->announcement) }}</textarea>
                                    <small class="text-muted">Este anuncio aparecerá en la página principal cuando el juego esté activo</small>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label>@lang('Slug')</label>
                                    <input class="form-control" name="slug" type="text" value="{{ old('slug', @$game->slug) }}" required>
                                </div>
                            </div>

                        </div>

                        <button class="btn btn--primary w-100 h-45" type="submit">@lang('Submit')</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@push('breadcrumb-plugins')
    <x-back route="{{ route('admin.game.index') }}"></x-back>
@endpush

@push('script-lib')
    <script src="{{ asset('assets/admin/js/moment.min.js') }}"></script>
    <script src="{{ asset('assets/global/js/daterangepicker.min.js') }}"></script>
@endpush

@push('style-lib')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/global/css/daterangepicker.css') }}">
@endpush

@push('script')
    <script>
        (function($) {
            "use strict";

            let isExistTeamOne = "{{ $isGameDataExists ? $game->team_one_id : old('team_one_id') }}";
            let isExistTeamTwo = "{{ $isGameDataExists ? $game->team_two_id : old('team_two_id') }}";

            let counter = false;

            @if (old('league_id'))
                $('[name=league_id]').val({{ old('league_id') }})
            @endif

            $('[name="event_type"]').on('change', function() {
                const type = $(this).val();
                if (type == `{{Status::EVENT_TYPE_INDIVIDUAL}}`) {
                    removeTeams();
                    setIndvidualTeams();
                    getTeamsByCategory();
                } else {
                    removeTeams();
                }
            }).change();

            function setIndvidualTeams() {
                let teamOne = teamComponent('@lang('Team One')', 'team_one_id');
                let teamTwo = teamComponent('@lang('Team Two')', 'team_two_id');

                $('#leaguesWrapper').after(teamOne);
                $(teamOne).after(teamTwo);

                initializeSelect2($('.teamInput select'));
            }

            function removeTeams() {
                $('.teamInput').remove();
            }

            function teamComponent(label, name) {
                return $(`
                <div class="col-sm-6 teamInput">
                    <div class="form-group">
                        <label class="required">${label}</label>
                        <select class="form-control teams slug" name="${name}" required>
                            <option value="" selected disabled>@lang('Select One')</option>
                        </select>
                    </div>
                </div>`);
            }

            function initializeSelect2(elements) {
                elements.each(function(i, e) {
                    $(e).wrap(`<div class="position-relative"></div>`).select2({
                        dropdownParent: $(this).parent(),
                    });
                });
            }

            function getTeamsByCategory() {
                let categoryId = $('[name=league_id]').find(":selected").data('category');
                if(!categoryId) return;

                $('.ajax-preloader').removeClass('d-none');

                $.ajax({
                    type: "get",
                    url: `{{ route('admin.game.teams', '') }}/${categoryId}`,
                    dataType: "json",
                    success: function(response) {
                        if (response.teams) {
                            $('.teams').removeAttr('disabled');
                            $('[name=team_one_id]').html(`<option value="" disabled {{ $isGameDataExists ? '' : 'selected' }}>@lang('Select One')</option>`);
                            $('[name=team_two_id]').html(`<option value="" disabled {{ $isGameDataExists ? '' : 'selected' }}>@lang('Select One')</option>`);
                            $.each(response.teams, function(i, team) {
                                $('[name=team_one_id]').append(`<option value="${team.id}" ${(isExistTeamOne == team.id) ? 'selected' : ''}> ${team.name}</option>`);
                                $('[name=team_two_id]').append(`<option value="${team.id}" ${(isExistTeamTwo == team.id) ? 'selected' : ''}> ${team.name}</option>`);
                            });
                            $('.ajax-preloader').addClass('d-none');
                        } else {
                            $('[name=team_one_id], [name=team_two_id]').html(`<option value="" selected disabled>@lang('Select One')</option>`);
                            $('.ajax-preloader').addClass('d-none');
                            notify('error', response.error);
                        }
                    }
                });
            }

            $('[name=league_id]').on('change', function() {
                if (!this.value) return;
                if($('[name="event_type"]').val() == `{{Status::EVENT_TYPE_INDIVIDUAL}}`) {
                    getTeamsByCategory();
                }
            }).change();

            $(document).on('change', '[name=team_one_id]', function() {
                let teamOneValue = this.value;
                let teamTwoValue = $('[name=team_two_id]').val();

                if (teamOneValue == teamTwoValue) {
                    $('[name=team_one_id]').val('');
                    notify('error', "Same team can't be opponent");
                }
                makeTitle();
            });

            $(document).on('change', '[name=team_two_id]', function() {
                let teamOneValue = $('[name=team_one_id]').val();
                let teamTwoValue = this.value;

                if (teamOneValue == teamTwoValue) {
                    $('[name=team_two_id]').val('');
                    notify('error', "Same team can't be opponent");
                }
                makeTitle();
            });

            $(document).on('change', '.slug', function() {
                makeGameSlug();
            });

function makeTitle() {
    let title = ``;
    if ($(document).find('[name=team_one_id]').val()) {
        title += `${$(document).find('[name=team_one_id]').find(':selected').html()} `;
    }
    if ($('[name=team_two_id]').val()) {
        title += `${' vs ' + $('[name=team_two_id]').find(':selected').html()} `;
    }
    $('[name=title]').val(title.trim());
}

function makeGameSlug() {
    let slug = ``;
    if ($('[name=league_id]').val()) {
        slug = `${$('[name=league_id]').find(':selected').data('name')} `;
    }
    let title = $('[name=title]').val();
    if (title) slug += title;
    slug = slug.trim().replace(/\s+/g, '-').toLowerCase();
    $('[name=slug]').val(slug);
}

// 🧩 Sincroniza el valor del control de rango con el texto mostrado
$('#betTimeLimitRange').on('input change', function() {
    $('#betTimeLimitValue').text(this.value);
});

})(jQuery)

    </script>
@endpush
