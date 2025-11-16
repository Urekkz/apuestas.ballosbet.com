<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['game']));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter((['game']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<?php
    // Obtener TODAS las apuestas del juego actual para debug
    $allBets = App\Models\Bet::where('status', 2) // App\Constants\Status::BET_PENDING
        ->whereHas('bets.market', function($query) use ($game) {
            $query->where('game_id', $game->id);
        })
        ->with(['user', 'bets.outcome', 'bets.market', 'matchedByUser'])
        ->orderBy('created_at', 'desc')
        ->get();
    
    // Filtrar apuestas abiertas
    $openBets = $allBets->filter(function($bet) {
        // Solo apuestas marcadas como abiertas
        if (!isset($bet->is_open)) {
            return false; // El campo no existe
        }
        
        // Apuestas abiertas sin tapar
        if ($bet->is_open == 1 && empty($bet->matched_bet_id)) {
            return true;
        }
        
        // Apuestas tapadas recientemente (últimas 24 horas)
        if ($bet->is_open == 1 && !empty($bet->matched_bet_id) && $bet->matched_at) {
            try {
                if ($bet->matched_at instanceof \Carbon\Carbon && $bet->matched_at->gte(now()->subDay())) {
                    return true;
                }
            } catch (\Exception $e) {
                // Ignorar errores de fecha
            }
        }
        
        return false;
    });

    // Separar apuestas por outcome (Izquierda/Derecha - Gallo 1/Gallo 2)
    $market = $game->markets->first();
    $outcomeOne = $market?->outcomes->first();
    $outcomeTwo = $market?->outcomes->skip(1)->first();
?>

 

<?php if($openBets->isNotEmpty()): ?>
<div class="open-bets-section mt-4">
    <div class="open-bets-header text-center mb-3">
        <h5 class="text-warning fw-bold">
            <i class="las la-fire"></i> Apuestas Abiertas
        </h5>
        <p class="text-muted small">Tapa una apuesta apostando al lado contrario</p>
    </div>

    <div class="row g-3">
        
        <div class="col-md-6">
            <div class="side-panel left-side">
                <div class="side-panel-header">
                    <span class="side-label"><?php echo e(__($outcomeOne?->name ?? 'Izquierda')); ?></span>
                </div>
                <div class="side-panel-body">
                    <?php
                        $leftBets = $openBets->filter(function($bet) use ($outcomeOne) {
                            return $bet->bets->first()?->outcome_id == $outcomeOne?->id;
                        });
                    ?>

                    <?php if($leftBets->isNotEmpty()): ?>
                        <div class="row row-cols-2 row-cols-md-3 g-2 open-bets-grid">
                        <?php $__currentLoopData = $leftBets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bet): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                $betItem = $bet->bets->first();
                                $canMatch = auth()->check() && auth()->id() != $bet->user_id && !$bet->matched_bet_id;
                                $isMatched = $bet->matched_bet_id != null;
                            ?>
                            <div class="col">
                            <div class="open-bet-card <?php echo e($isMatched ? 'matched' : ''); ?> h-100">
                                <?php if($isMatched): ?>
                                    <div class="matched-badge">
                                        <i class="las la-check-circle"></i> TAPADA
                                    </div>
                                <?php endif; ?>
                                <div class="bet-info">
                                    <div class="bet-side">
                                        <span class="label">Lado:</span>
                                        <span class="value side-left">Izquierda</span>
                                    </div>
                                    <div class="bet-amount">
                                        <span class="label">Monto:</span>
                                        <span class="value"><?php echo e(showAmount($bet->stake_amount)); ?></span>
                                    </div>
                                </div>
                                <?php if($canMatch): ?>
                                    <button
                                        data-game-id="<?php echo e($game->id); ?>"
                                        class="btn btn-match-bet btn-sm w-100 mt-2"
                                        data-bet-id="<?php echo e($bet->id); ?>"
                                        data-amount="<?php echo e($bet->stake_amount); ?>"
                                        data-opposite-outcome-id="<?php echo e($outcomeTwo->id); ?>"
                                        data-opposite-outcome-name="<?php echo e($outcomeTwo->name); ?>"
                                        data-odds="<?php echo e($outcomeTwo->odds); ?>"
                                    >
                                        <i class="las la-hand-rock"></i> Tapar Apuesta
                                    </button>
                                <?php elseif($isMatched): ?>
                                    <div class="text-center small mt-2" style="color: #4caf50; font-weight: 600;">
                                        <i class="las la-check-double"></i> Ya fue tapada
                                    </div>
                                <?php else: ?>
                                    <div class="text-center text-muted small mt-2">
                                        <i class="las la-lock"></i> Tu propia apuesta
                                    </div>
                                <?php endif; ?>
                            </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    <?php else: ?>
                        <div class="empty-bets text-center text-muted">
                            <i class="las la-inbox"></i>
                            <p class="mb-0">No hay apuestas abiertas</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        
        <div class="col-md-6">
            <div class="side-panel right-side">
                <div class="side-panel-header">
                    <span class="side-label"><?php echo e(__($outcomeTwo?->name ?? 'Derecha')); ?></span>
                </div>
                <div class="side-panel-body">
                    <?php
                        $rightBets = $openBets->filter(function($bet) use ($outcomeTwo) {
                            return $bet->bets->first()?->outcome_id == $outcomeTwo?->id;
                        });
                    ?>

                    <?php if($rightBets->isNotEmpty()): ?>
                        <div class="row row-cols-2 row-cols-md-3 g-2 open-bets-grid">
                        <?php $__currentLoopData = $rightBets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bet): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                $betItem = $bet->bets->first();
                                $canMatch = auth()->check() && auth()->id() != $bet->user_id && !$bet->matched_bet_id;
                                $isMatched = $bet->matched_bet_id != null;
                            ?>
                            <div class="col">
                            <div class="open-bet-card <?php echo e($isMatched ? 'matched' : ''); ?> h-100">
                                <?php if($isMatched): ?>
                                    <div class="matched-badge">
                                        <i class="las la-check-circle"></i> TAPADA
                                    </div>
                                <?php endif; ?>
                                <div class="bet-info">
                                    <div class="bet-side">
                                        <span class="label">Lado:</span>
                                        <span class="value side-right">Derecha</span>
                                    </div>
                                    <div class="bet-amount">
                                        <span class="label">Monto:</span>
                                        <span class="value"><?php echo e(showAmount($bet->stake_amount)); ?></span>
                                    </div>
                                </div>
                                <?php if($canMatch): ?>
                                    <button
                                        data-game-id="<?php echo e($game->id); ?>"
                                        class="btn btn-match-bet btn-sm w-100 mt-2"
                                        data-bet-id="<?php echo e($bet->id); ?>"
                                        data-amount="<?php echo e($bet->stake_amount); ?>"
                                        data-opposite-outcome-id="<?php echo e($outcomeOne->id); ?>"
                                        data-opposite-outcome-name="<?php echo e($outcomeOne->name); ?>"
                                        data-odds="<?php echo e($outcomeOne->odds); ?>"
                                    >
                                        <i class="las la-hand-rock"></i> Tapar Apuesta
                                    </button>
                                <?php elseif($isMatched): ?>
                                    <div class="text-center small mt-2" style="color: #4caf50; font-weight: 600;">
                                        <i class="las la-check-double"></i> Ya fue tapada
                                    </div>
                                <?php else: ?>
                                    <div class="text-center text-muted small mt-2">
                                        <i class="las la-lock"></i> Tu propia apuesta
                                    </div>
                                <?php endif; ?>
                            </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    <?php else: ?>
                        <div class="empty-bets text-center text-muted">
                            <i class="las la-inbox"></i>
                            <p class="mb-0">No hay apuestas abiertas</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.open-bets-section {
    background: #1a1a1a;
    border-radius: 12px;
    padding: 16px; /* más compacto */
    margin-top: 30px;
}

.open-bets-header h5 {
    font-size: 1.25rem; /* más pequeño */
    margin-bottom: 4px;
}

.side-panel {
    background: #2a2a2a;
    border-radius: 8px; /* más compacto */
    overflow: hidden;
    height: auto; /* evita ocupar altura innecesaria */
}

.left-side {
    border-left: 4px solid #ff6b35;
}

.right-side {
    border-right: 4px solid #00d4ff;
}

.side-panel-header {
    background: linear-gradient(135deg, #3a3a3a 0%, #2a2a2a 100%);
    padding: 15px;
    text-align: center;
    border-bottom: 2px solid #404040;
}

.side-label {
    font-size: 1.2rem;
    font-weight: bold;
    color: #fff;
    text-transform: uppercase;
}

.left-side .side-label {
    color: #ff6b35;
}

.right-side .side-label {
    color: #00d4ff;
}

.side-panel-body {
    padding: 10px; /* compacto */
    max-height: 360px; /* menor alto visible */
    overflow-y: auto;
}

.open-bet-card {
    background: #353535;
    border-radius: 6px; /* más compacto */
    padding: 10px; /* compacto */
    margin-bottom: 8px; /* menos separación */
    border: 1px solid #404040;
    transition: all 0.3s ease;
    position: relative;
}

/* Ajustes para grilla 3x3 */
.open-bets-grid .open-bet-card {
    height: 100%;
}
.open-bets-grid .col {
    display: flex;
}
.open-bets-grid .col > .open-bet-card {
    width: 100%;
}

.open-bet-card:hover {
    border-color: #ff9f43;
    box-shadow: 0 4px 12px rgba(255, 159, 67, 0.2);
    transform: translateY(-2px);
}

.open-bet-card.matched {
    background: rgba(76, 175, 80, 0.1);
    border-color: #4caf50;
    opacity: 0.85;
}

.open-bet-card.matched:hover {
    border-color: #66bb6a;
    box-shadow: 0 4px 12px rgba(76, 175, 80, 0.3);
}

.matched-badge {
    position: absolute;
    top: 8px;
    right: 8px;
    background: linear-gradient(135deg, #4caf50, #66bb6a);
    color: #fff;
    padding: 4px 10px;
    border-radius: 12px;
    font-size: 0.7rem;
    font-weight: 700;
    letter-spacing: 0.5px;
    box-shadow: 0 2px 6px rgba(76, 175, 80, 0.4);
}

.matched-badge i {
    font-size: 0.9rem;
}

.matched-by {
    padding-top: 8px;
    border-top: 1px solid rgba(76, 175, 80, 0.3);
}

.bet-info {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.bet-user {
    display: flex;
    align-items: center;
    gap: 6px;
    color: #fff;
    font-size: 0.95rem;
    margin-bottom: 8px;
    padding-bottom: 8px;
    border-bottom: 1px solid #404040;
}

.bet-user i {
    font-size: 1.1rem;
    color: #ff9f43;
}

.bet-side,
.bet-odds,
.bet-amount {
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 0.9rem;
}

.bet-side .label,
.bet-odds .label,
.bet-amount .label {
    color: #aaa;
}

.bet-side .value,
.bet-odds .value,
.bet-amount .value {
    color: #fff;
    font-weight: bold;
}

.bet-side .value.side-left {
    color: #ff6b35;
    text-transform: uppercase;
    font-size: 0.95rem;
}

.bet-side .value.side-right {
    color: #00d4ff;
    text-transform: uppercase;
    font-size: 0.95rem;
}

.btn-match-bet {
    background: linear-gradient(135deg, #ff6b35 0%, #f7931e 100%);
    color: #fff;
    border: none;
    padding: 8px; /* compacto */
    font-size: 0.85rem; /* más discreto */
    font-weight: 700;
    border-radius: 6px;
    transition: all 0.3s ease;
}

.btn-match-bet:hover {
    background: linear-gradient(135deg, #f7931e 0%, #ff6b35 100%);
    transform: scale(1.02);
    box-shadow: 0 6px 20px rgba(255, 107, 53, 0.4);
    color: #fff;
}

.btn-match-bet:active {
    transform: scale(0.98);
}

.empty-bets {
    padding: 24px 12px; /* más compacto */
}

.empty-bets i {
    font-size: 2rem; /* más pequeño */
    opacity: 0.3;
    display: block;
    margin-bottom: 8px;
}

.empty-bets p {
    font-size: 0.9rem;
    opacity: 0.6;
}

/* Scrollbar personalizado */
.side-panel-body::-webkit-scrollbar {
    width: 6px;
}

.side-panel-body::-webkit-scrollbar-track {
    background: #2a2a2a;
}

.side-panel-body::-webkit-scrollbar-thumb {
    background: #ff9f43;
    border-radius: 3px;
}

.side-panel-body::-webkit-scrollbar-thumb:hover {
    background: #ff6b35;
}

@media (max-width: 768px) {
    .open-bets-section {
        padding: 12px;
    }

    .side-panel-body {
        max-height: 260px; /* más compacto en móvil */
    }

    .open-bet-card {
        padding: 10px;
    }
}
</style>
<?php else: ?>
    
    <div class="no-open-bets text-center text-muted mt-4 p-4">
        <i class="las la-info-circle" style="font-size: 2rem;"></i>
        <p class="mb-0">No hay apuestas abiertas disponibles en este momento</p>
    </div>
<?php endif; ?>



<?php /**PATH /home3/dannygue/apuestas.ballosbet.com/core/resources/views/components/frontend/open-bets.blade.php ENDPATH**/ ?>