@extends($activeTemplate . 'layouts.bet')
@section('bet')
    @php
        $outcomesId = collect(session()->get('bets'))->pluck('outcome_id')->toArray();
    @endphp
    <div class="odd-list pt-0">
        <div class="odd-list__title">@lang('Mercados')</div>
        <div class="row gx-0 pd-lg-15 gx-lg-3 gy-3">
            <div class="col-12">
                <div class="odd-list__head">
                    @if ($game->teamOne && $game->teamTwo)
                        <div class="odd-list__team">
                            <div class="odd-list__team-name">{{ __($game->teamOne->name) }}</div>
                            <div class="odd-list__team-img">
                                <img class="odd-list__team-img-is" src="{{ $game->teamOne->teamImage() }}" alt="image" />
                            </div>
                        </div>

                        <div class="odd-list__team-divide">@lang('VS')</div>
                        

                        <div class="odd-list__team justify-content-end">
                            <div class="odd-list__team-img">
                                <img class="odd-list__team-img-is" src="{{ $game->teamTwo->teamImage() }}" alt="image" />
                            </div>
                            <div class="odd-list__team-name">{{ __($game->teamTwo->name) }}</div>
                        </div>
                    @else
                        <div class="odd-list__team-name">{{ __($game->league->name) }}</div>
                    @endif
                </div>
                {{-- Visualizador de Stream --}}
@php
    $path = storage_path('app/stream_url.txt');
    $streamUrl = file_exists($path) ? trim(file_get_contents($path)) : '';
@endphp
<div class="col-12 mb-4">
    <h3 class="text-center" style="color:#fff;margin-bottom:15px;font-weight:700;letter-spacing:.2px;">
        En Vivo
        @if($streamUrl)
            <span style="display:inline-block;width:10px;height:10px;margin-left:.5rem;background:#ff3b30;border-radius:50%;vertical-align:middle;"></span>
        @endif
    </h3>

    <div style="
        max-width:900px;
        margin:auto;
        border:1px solid rgba(255,255,255,.08);
        border-radius:14px;
        background:#1d2026;
        padding:14px;
        text-align:center;
        min-height:506px;
        display:flex;
        align-items:center;
        justify-content:center;
        color:#eaeaea;
        font-size:18px;
        font-weight:600;
        box-shadow:0 10px 24px rgba(0,0,0,.35), inset 0 1px 0 rgba(255,255,255,.03);
        position:relative;
        overflow:hidden;
    ">
        @if($streamUrl)
            <div style="
                width:100%;
                aspect-ratio:16/9;
                border-radius:12px;
                overflow:hidden;
                background:#232834;
                border:1px solid rgba(255,255,255,.06);
                box-shadow:0 6px 18px rgba(0,0,0,.35);
            ">
                <iframe
                    src="https://www.facebook.com/plugins/video.php?href={{ urlencode($streamUrl) }}&show_text=false&autoplay=true"
                    style="width:100%;height:100%;border:0;display:block;border-radius:12px;"
                    scrolling="no"
                    frameborder="0"
                    allowfullscreen="true"
                    allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share">
                </iframe>
            </div>
        @else
            <div style="opacity:.9;">
                <svg width="38" height="38" viewBox="0 0 24 24" fill="none" aria-hidden="true" style="display:block;margin:0 auto;color:#ff6600;">
                    <path d="M3 5h18v14H3z" stroke="currentColor" stroke-width="1.5"></path>
                    <path d="M10 9l5 3-5 3V9z" fill="currentColor"></path>
                </svg>
                <p style="margin:8px 0 0;font-weight:700;letter-spacing:.2px;">No hay en vivos por ahora</p>
            </div>
        @endif
    </div>
</div>


                <div class="odd-list__body">
                    <div class="odd-list__body-content">
                        @forelse ($game->markets as $market)
                            <div class="accordion accordion--odd">
                                <div class="accordion-item ">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#market-{{ $market->id }}" aria-expanded="true">
                                            {{ __($market->title ?? $market->market_title) }}
                                        </button>
                                    </h2>
                                    <div id="market-{{ $market->id }}" class="accordion-collapse collapse show">
                                        <div class="accordion-body">
                                            <ul class="odd-list__outcomes">
                                                @forelse ($market->outcomes as $outcome)
                                                    <li class="flex-between">
                                                        <span class="odd-list__outcome-text">
                                                            {{ __($outcome->name) }}
                                                            @if ($outcome->point)
                                                                ({{ $outcome->point }})
                                                            @endif
                                                        </span>
                                                        <button class="odd-list__outcome oddBtn @if (in_array($outcome->id, $outcomesId)) active @endif @if ($outcome->locked || $market->locked) locked @endif" data-outcome_id="{{ $outcome->id }}">
                                                            <span class="odd-list__outcome-ratio">{{ rateData($outcome->odds) }} </span>
                                                        </button>
                                                    </li>
                                                @empty
                                                    <small class="text-muted"> @lang('No odds available for now')</small>
                                                @endforelse
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="empty-message mt-3">
                                <img class="img-fluid" src="{{ asset($activeTemplateTrue . '/images/empty_message.png') }}" alt="@lang('image')">
                                <p>@lang('No hay mercados disponibles por ahora')</p>
                            </div>

                        @endforelse
                    </div>
                </div>
            </div>

            {{-- Sección de Apuestas Abiertas (usuarios pueden tapar) --}}
            <div class="col-12">
                <x-frontend.open-bets :game="$game" />
            </div>
        </div>
    </div>
@endsection




