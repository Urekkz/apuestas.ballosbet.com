<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'link' => '',
    'icon' => '',
    'amount' => '',
    'title' => '',
]));

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

foreach (array_filter(([
    'link' => '',
    'icon' => '',
    'amount' => '',
    'title' => '',
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<a class="widget-card widget-card--secondary h-100" href="<?php echo e($link != '' ? $link : 'javascript:void(0)'); ?>">
    <?php if($icon): ?>
        <div class="widget-card__icon-container">
            <div class="widget-card__icon">
                <i class="<?php echo e($icon); ?>"></i>
            </div>
        </div>
    <?php endif; ?>
    <div class="widget-card__body">
        <h5 class="widget-card__balance"><?php echo e($amount); ?></h5>
        <span class="widget-card__balance-text fw-bold"><?php echo e(__($title)); ?></span>
    </div>
</a>
<?php /**PATH /home3/dannygue/apuestas.ballosbet.com/core/resources/views/components/user-dashboard-widget.blade.php ENDPATH**/ ?>