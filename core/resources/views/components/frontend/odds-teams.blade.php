@props(['game', 'marketTitle' => null])
<div class="sports-card-left">
    <div class="sports-card-heading">
        @if ($game->is_outright == Status::NO && $game->isInPlay)
            <p class="sports-card__info mb-0">
                <span class="sports-card__stream">
                    <i class="fa-regular fa-circle-play text--danger"></i>
                </span>
                <span class="sports-card__info-text">@lang('Live Now')</span>
            </p>
        @elseif($game->is_outright == Status::NO)
            <span class="sports-card__info-text">{{ carbonParse($game->start_time, 'd M, h:i') }}</span>
        @else
            <span class="sports-card__info-text empty"></span>
        @endif
    </div>

    <div class="sports-card-body">
        @if (!$marketTitle)
            @if ($game->teamOne)
                <x-frontend.odds-team :team='$game->teamOne' />
            @endif

            @if ($game->teamTwo)
                <x-frontend.odds-team :team='$game->teamTwo' />
            @endif
        @else
            {{ __($marketTitle) }}</span>
        @endif
        <div class="sports-card-left-bottom">
            {{-- 'All Markets' link removed per client request --}}
        </div>
    </div>
</div>

@once
    @push('style')
        <style>
            .empty {
                padding: 6px 0px;
            }
            .view-stream-btn {
                background: linear-gradient(90deg, #ff6600, #ff914d);
                color: #fff;
                border: none;
                box-shadow: 0 6px 18px rgba(255,102,0,0.15);
                padding: 6px 10px;
                border-radius: 8px;
                font-weight: 700;
            }

            .markets-btn {
                color: #ff914d;
                border-color: rgba(255,145,77,0.2);
                background: transparent;
                padding: 6px 10px;
                border-radius: 8px;
                font-weight: 600;
            }
        </style>
    @endpush
@endonce
