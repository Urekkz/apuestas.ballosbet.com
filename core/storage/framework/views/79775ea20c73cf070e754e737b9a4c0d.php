<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['outcome' => null, 'marketIsLocked' => null, 'label' => null]));

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

foreach (array_filter((['outcome' => null, 'marketIsLocked' => null, 'label' => null]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<?php foreach ((['betPlacedIds' => []]) as $__key => $__value) {
    $__consumeVariable = is_string($__key) ? $__key : $__value;
    $$__consumeVariable = is_string($__key) ? $__env->getConsumableComponentData($__key, $__value) : $__env->getConsumableComponentData($__value);
} ?>

<div class="option-odd-list__item">
    <?php if($outcome): ?>
        <button class="<?php echo \Illuminate\Support\Arr::toCssClasses([
            'oddBtn',
            'active' => in_array($outcome->id ?? 0, $betPlacedIds),
            'locked' => ($outcome->locked ?? false || $marketIsLocked),
        ]); ?>" 
        data-outcome_id="<?php echo e($outcome->id); ?>" 
        data-odds="<?php echo e($outcome->odds); ?>"
        data-outcome_name="<?php echo e($label ?? $outcome->name); ?>"
        <?php if(($outcome->locked ?? false) || $marketIsLocked): ?> disabled <?php endif; ?>
        >
            <div class="oddBtn-content">
                <span class="outcome-name"><?php echo e($label ?? $outcome->name); ?></span>
                <span class="outcome-odds"><?php echo e(number_format($outcome->odds, 2)); ?></span>
            </div>
        </button>
    <?php else: ?>
        <button class="oddBtn oddBtn-disabled" disabled>
            <span>Sin datos</span>
        </button>
    <?php endif; ?>
</div>

<style>
.option-odd-list__item {
    display: inline-block;
    margin: 5px;
}

.oddBtn {
    min-width: 160px;
    min-height: 80px;
    padding: 0;
    background: linear-gradient(135deg, #2d3748 0%, #1a202c 100%);
    border: 2px solid #374151;
    border-radius: 12px;
    cursor: pointer;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.3);
}

.oddBtn::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 138, 0, 0.2), transparent);
    transition: left 0.5s ease;
}

.oddBtn:hover::before {
    left: 100%;
}

.oddBtn-content {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 12px 16px;
    height: 100%;
    gap: 6px;
}

.oddBtn .outcome-name {
    font-size: 0.75rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.8px;
    color: #ff8a00;
    text-shadow: 0 1px 2px rgba(0, 0, 0, 0.5);
    line-height: 1.2;
}

.oddBtn .outcome-odds {
    font-size: 1.4rem;
    font-weight: 800;
    color: #fff;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.5);
    display: none !important;
}

/* Hover effect */
.oddBtn:hover:not(.locked):not(:disabled) {
    transform: translateY(-3px);
    box-shadow: 0 8px 16px rgba(255, 138, 0, 0.4);
    border-color: #ff8a00;
    background: linear-gradient(135deg, #374151 0%, #2d3748 100%);
}

/* Selected state */
.oddBtn.selected-outcome {
    background: linear-gradient(135deg, #ff8a00 0%, #ff6b35 100%) !important;
    border-color: #ff8a00 !important;
    box-shadow: 0 8px 20px rgba(255, 138, 0, 0.6) !important;
    transform: scale(1.05);
}

.oddBtn.selected-outcome .outcome-name {
    color: #fff !important;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.7);
}

.oddBtn.selected-outcome .outcome-odds {
    color: #fff !important;
}

/* Locked/Disabled state */
.oddBtn.locked,
.oddBtn:disabled,
.oddBtn-disabled {
    opacity: 0.4;
    cursor: not-allowed;
    background: #1a202c;
    border-color: #2d3748;
}

.oddBtn.locked:hover,
.oddBtn:disabled:hover {
    transform: none;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.3);
    border-color: #374151;
}

/* Responsive */
@media (max-width: 768px) {
    .oddBtn {
        min-width: 140px;
        min-height: 70px;
    }
    
    .oddBtn .outcome-name {
        font-size: 0.7rem;
    }
    
    .oddBtn .outcome-odds {
        font-size: 1.2rem;
    }
}
</style> 
<?php /**PATH /home3/dannygue/apuestas.ballosbet.com/core/resources/views/components/frontend/odds-button.blade.php ENDPATH**/ ?>