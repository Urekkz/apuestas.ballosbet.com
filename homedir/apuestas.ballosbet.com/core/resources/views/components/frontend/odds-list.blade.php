@props(['marketType', 'game', 'betPlacedIds' => []])


@php
    $market = $game->markets->firstWhere('market_type', $marketType);
    $outcomeOne = $market?->outcomes->first();
    $outcomeTwo = $market?->outcomes->skip(1)->first();

    $nameOne = $outcomeOne?->name ?? 'Gallo 1';
    $nameTwo = $outcomeTwo?->name ?? 'Gallo 2';
@endphp

{{-- Temporizador: cuenta regresiva hasta el cierre de apuestas --}}
@php
    use Carbon\Carbon;

    // Zona horaria explícita si quieres (opcional):
    // $now = Carbon::now('America/Bogota');
    $now = Carbon::now();

    // Tomar hora de inicio de apuestas (debe existir)
    $betStart = isset($game->bet_start_time) ? Carbon::parse($game->bet_start_time) : null;
    $limitMinutes = isset($game->bet_time_limit) ? intval($game->bet_time_limit) : 10;

    // Estado por defecto
    $timerState = 'closed';
    $remainingSeconds = 0;

    if ($betStart) {
        $betStart = $betStart; // Carbon instance
        $betEnd = $betStart->copy()->addMinutes($limitMinutes);

        if ($now->lt($betStart)) {
            // Apuestas aún no han empezado
            $timerState = 'not_started';
            $remainingSeconds = $now->diffInSeconds($betStart);
        } elseif ($now->between($betStart, $betEnd, true)) {
            // Periodo de apuestas activo
            $timerState = 'open';
            $remainingSeconds = $now->diffInSeconds($betEnd);
        } else {
            // Ya pasó el periodo de apuestas
            $timerState = 'closed';
            $remainingSeconds = 0;
        }
    } else {
        // Sin bet_start definido: considerar cerrado
        $timerState = 'closed';
        $remainingSeconds = 0;
    }
@endphp

{{-- Sección dedicada del cronómetro --}}
<div class="timer-section">
    <div class="timer-box">
        <div class="timer-icon">
            <i class="las la-clock"></i>
        </div>
        <div
            class="countdown-timer"
            id="countdown-{{ $game->id }}"
            data-remaining="{{ $remainingSeconds }}"
            data-state="{{ $timerState }}"
        >
            {{-- JS llenará el contenido --}}
        </div>
    </div>
</div>

@if(optional($market)->favoritismo_label)
    <div class="favoritismo-box text-center mt-3" style="margin-left: 70px;">
        <span class="favoritismo-label">{{ $market->favoritismo_label }}</span>
    </div>
@endif

<div class="sports-card-body d-flex flex-column align-items-center justify-content-center">
    <x-frontend.odds-button 
        :outcome="$outcomeOne" 
        :marketIsLocked="@$market->locked"
        :betPlacedIds="$betPlacedIds"
        label="Izquierda"
    />
    <x-frontend.odds-button 
        :outcome="$outcomeTwo" 
        :marketIsLocked="@$market->locked"
        :betPlacedIds="$betPlacedIds"
        label="Derecha"
    />
</div> 
        {{-- Botones de montos debajo --}}
        <div class="bet-amount-buttons text-center w-100">
            <div class="d-flex justify-content-center gap-3 flex-wrap mb-3">
                <button class="btn btn-outline-success bet-amount-btn fw-semibold" data-amount="20">$20</button>
                <button class="btn btn-outline-success bet-amount-btn fw-semibold" data-amount="30">$30</button>
                 <button class="btn btn-outline-success bet-amount-btn fw-semibold" data-amount="40">$40</button>
                <button class="btn btn-outline-success bet-amount-btn fw-semibold" data-amount="50">$50</button>
                <button class="btn btn-outline-warning custom-bet fw-semibold">Apuesta personalizada</button>
            </div>
    </div>
</div>

{{-- Modal para monto personalizado --}}
<div class="custom-modal" id="customModal-{{ $game->id }}" style="display:none;">
    <div class="custom-modal-content text-center">
        <h6 class="mb-3">Monto personalizado</h6>
        <input type="number" class="form-control text-center mb-3 custom-bet-input" placeholder="Ej: 50" min="1" step="1">
        <div class="d-flex justify-content-center gap-2">
            <button class="btn btn-primary btn-sm save-custom-bet">Aceptar</button>
            <button class="btn btn-secondary btn-sm cancel-custom-bet">Cancelar</button>
        </div>
    </div>
</div>

<style>
/* Centrado del contenedor */
.sports-card-inner {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
}

.option-odd-lists {
    flex-wrap: wrap;
}

/* Variables base */
:root {
    --base: 24 89% 55%;
    --white: 0 0% 100%;
}
.favoritismo-box {
  background: #1a1f2b;
  border: 1px solid #ff8a00;          /* mantenemos el borde visible */
  border-radius: 10px;
  min-width: 200px;
  padding: 8px 12px;
  box-shadow: 0 0 6px rgba(255,138,0,0.3);
  text-align: center;                 
  display: block;                     
  width: max-content;                 
  margin: 0 auto;                     
}

/* 🔹 Fuerza el centrado en todos los casos */
.favoritismo-box[style] {
  margin-left: auto !important;
  margin-right: auto !important;
  display: block !important;
}

/* 🔹 Ajuste móvil */
@media (max-width: 768px) {
  .favoritismo-box {
    width: 90%;
    max-width: 300px;
    margin: 10px auto !important;
    box-sizing: border-box;
  }
}
.favoritismo-label {
    color: #ff8a00;
    font-weight: 700;
    font-size: 1rem;
    letter-spacing: 0.5px;
}



/* Botones de monto de apuesta */
.bet-amount-buttons .bet-amount-btn {
    min-width: 92px;
    padding: 10px 14px;
    border-radius: 10px;
    background: hsl(var(--base));
    color: hsl(var(--white));
    border: 1px solid hsl(var(--base));
    font-weight: 700;
    box-shadow: 0 3px 10px rgba(0, 0, 0, 0.18);
    transition: transform 0.12s ease, box-shadow 0.12s ease, background 0.12s ease, color 0.12s ease;
    cursor: pointer;
}

.bet-amount-buttons .bet-amount-btn:hover,
.bet-amount-buttons .bet-amount-btn:focus {
    background: linear-gradient(180deg, rgba(255,159,67,1) 0%, rgba(255,122,0,1) 100%);
    color: hsl(var(--white));
    border-color: hsl(var(--base));
    transform: translateY(-3px);
    box-shadow: 0 12px 30px rgba(255,159,67,0.18);
    outline: none;
}

.bet-amount-buttons .bet-amount-btn:active {
    transform: translateY(-1px);
    box-shadow: 0 6px 14px rgba(0, 0, 0, 0.12);
}

/* Botón personalizado */
.bet-amount-buttons .custom-bet {
    padding: 10px 16px;
    border-radius: 10px;
    border: none;
    background: hsl(var(--base));
    color: hsl(var(--white));
    font-weight: 800;
    box-shadow: 0 10px 28px rgba(255,159,67,0.18);
    transition: transform 0.12s ease, box-shadow 0.12s ease, opacity 0.12s ease;
}

.bet-amount-buttons .custom-bet:hover,
.bet-amount-buttons .custom-bet:focus {
    transform: translateY(-3px);
    box-shadow: 0 16px 36px rgba(255,122,0,0.22);
    opacity: 0.98;
}

/* Botones del modal */
.save-custom-bet {
    background: #ff7a00 !important;
    border-color: #ff7a00 !important;
    color: #111 !important;
}

.cancel-custom-bet {
    background: #2b2b2b !important;
    color: #fff !important;
    border: none !important;
}

/* Modal */
.custom-modal {
    position: fixed;
    top: 0; left: 0;
    width: 100%; height: 100%;
    background: rgba(0, 0, 0, 0.6);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 9999;
}

.custom-modal-content {
    background: #ffffff;
    padding: 22px 20px;
    border-radius: 12px;
    width: 320px;
    max-width: calc(100% - 40px);
    box-shadow: 0 12px 40px rgba(0, 0, 0, 0.35);
}

/* ⏱️ Sección dedicada del cronómetro */
.timer-section {
    width: 100%;
    margin-bottom: 20px;
    padding: 0;
}

.timer-box {
    background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
    border: 2px solid #ff8a00;
    border-radius: 12px;
    padding: 16px 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 12px;
    box-shadow: 0 4px 15px rgba(255, 138, 0, 0.2);
    transition: all 0.3s ease;
}

.timer-box:hover {
    box-shadow: 0 6px 20px rgba(255, 138, 0, 0.3);
    transform: translateY(-2px);
}

.timer-icon {
    font-size: 28px;
    color: #ff8a00;
    animation: pulse 2s ease-in-out infinite;
}

@keyframes pulse {
    0%, 100% { opacity: 1; transform: scale(1); }
    50% { opacity: 0.7; transform: scale(1.1); }
}

.countdown-timer {
    color: #ffcc00;
    font-size: 22px;
    font-weight: 700;
    letter-spacing: 1px;
    text-align: center;
    min-width: 150px;
}

/* Estados del temporizador */
.countdown-timer.text-success {
    color: #4caf50 !important;
}

.countdown-timer.text-warning {
    color: #ffcc00 !important;
}

.countdown-timer.text-danger {
    color: #ff4444 !important;
}

/* Responsive */
@media (max-width: 768px) {
    .timer-box {
        padding: 12px 16px;
    }
    
    .timer-icon {
        font-size: 24px;
    }
    
    .countdown-timer {
        font-size: 18px;
        min-width: 120px;
    }
}
</style>

@push('script')
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.countdown-timer, .countdown-timer-banner').forEach(timerEl => {
        let remaining = parseInt(timerEl.dataset.remaining, 10) || 0;
        let state = timerEl.dataset.state || 'closed';
        const gameId = timerEl.id.replace('countdown-', '');

        const gameCard = timerEl.closest('.sports-card-inner') 
                      || timerEl.closest('.sports-card') 
                      || timerEl.closest('.game-card')
                      || timerEl.closest('.col-12');

        const getAllButtons = () => {
            const localButtons = gameCard ? gameCard.querySelectorAll('.oddBtn, .custom-bet, .bet-amount-btn') : [];
            const openBetButtons = document.querySelectorAll(`.btn-match-bet[data-game-id="${gameId}"]`);
            return [...localButtons, ...openBetButtons];
        };

        const disableAll = () => {
            getAllButtons().forEach(btn => {
                btn.disabled = true;
                btn.classList.add('disabled', 'locked');
                btn.style.pointerEvents = 'none';
                btn.style.opacity = '0.5';
                btn.style.cursor = 'not-allowed';
            });
        };

        const enableAll = () => {
            getAllButtons().forEach(btn => {
                if (!btn.classList.contains('locked-backend')) {
                    btn.disabled = false;
                    btn.classList.remove('disabled', 'locked');
                    btn.style.pointerEvents = '';
                    btn.style.opacity = '';
                    btn.style.cursor = '';
                }
            });
        };

        const isBanner = timerEl.classList.contains('countdown-timer-banner');
        
        const renderClosed = () => {
            if (isBanner) {
                timerEl.innerHTML = '<i class="las la-lock"></i> APUESTAS CERRADAS';
                timerEl.className = 'countdown-timer-banner state-closed';
            } else {
                timerEl.textContent = 'Apuestas cerradas';
                timerEl.classList.remove('text-warning', 'text-success');
                timerEl.classList.add('text-danger');
            }
            disableAll();
        };

        const renderNotStarted = (ts) => {
            if (isBanner) {
                timerEl.innerHTML = `<i class="las la-clock"></i> INICIA EN ${ts}`;
                timerEl.className = 'countdown-timer-banner state-not_started';
            } else {
                timerEl.textContent = `Inicia en ${ts}`;
                timerEl.classList.remove('text-danger', 'text-success');
                timerEl.classList.add('text-warning');
            }
            disableAll();
        };

        const renderOpen = (ts) => {
            if (isBanner) {
                timerEl.innerHTML = `<i class="las la-fire"></i> TIEMPO RESTANTE: ${ts}`;
                timerEl.className = 'countdown-timer-banner state-open';
            } else {
                timerEl.textContent = `Tiempo restante: ${ts}`;
                timerEl.classList.remove('text-danger', 'text-warning');
                timerEl.classList.add('text-success');
            }
            enableAll();
        };

        const formatSeconds = (sec) => {
            sec = Math.max(0, Math.floor(sec));
            const m = Math.floor(sec / 60);
            const s = sec % 60;
            return `${String(m).padStart(2,'0')}:${String(s).padStart(2,'0')}`;
        };

        if (remaining <= 0) {
            renderClosed();
            return;
        }

        if (state === 'closed') {
            renderClosed();
            return;
        } else if (state === 'not_started') {
            renderNotStarted(formatSeconds(remaining));
        } else if (state === 'open') {
            renderOpen(formatSeconds(remaining));
        }

        const interval = setInterval(() => {
            remaining--;

            if (remaining <= 0) {
                if (state === 'not_started') {
                    state = 'open';
                    const duration = parseInt(timerEl.dataset.duration, 10) || 0;
                    remaining = duration;
                    renderOpen(formatSeconds(remaining));
                } else if (state === 'open') {
                    state = 'closed';
                    renderClosed();
                    clearInterval(interval);
                }
                return;
            }

            if (state === 'not_started') {
                renderNotStarted(formatSeconds(remaining));
            } else if (state === 'open') {
                renderOpen(formatSeconds(remaining));
            }
        }, 1000);
    });

    // 🧩 Apertura y cierre del modal personalizado
    document.querySelectorAll('.custom-bet').forEach(btn => {
        btn.addEventListener('click', function() {
            const modal = document.querySelector('.custom-modal');
            if (modal) {
                modal.style.display = 'flex';
            }
        });
    });

    document.querySelectorAll('.cancel-custom-bet, .save-custom-bet').forEach(btn => {
        btn.addEventListener('click', function() {
            const modal = document.querySelector('.custom-modal');
            if (modal) {
                modal.style.display = 'none';
            }
        });
    });
});
</script>
@endpush





