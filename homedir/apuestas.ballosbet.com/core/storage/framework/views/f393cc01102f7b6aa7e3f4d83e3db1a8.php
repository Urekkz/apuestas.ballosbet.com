<div class="d-flex flex-column gap-3 flex-wrap">
    <?php $__currentLoopData = $gameMarkets ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $market): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php
            $isExists = $markets->where('market_type', $market->key)->first() ? true : false;
            if ($market->key == 'outrights') {
                $isExists = true;
            }
        ?>
        <div class="form-check mb-0 flex-shrink-0">
            <label class="form-check-label user-select-none mb-0">
                <input type="checkbox" class="form-check-input marketCheckBox" data-market='<?php echo json_encode($market, 15, 512) ?>' id="<?php echo e($market->key); ?>" <?php if($isExists): echo 'disabled'; endif; ?> <?php if($isExists): echo 'checked'; endif; ?>>
                <?php echo e($market->name); ?>

            </label>

            <?php if(@$market->max_limit != 1 && $market->key != 'outrights'): ?>
                <button class="btn btn-sm btn--dark p-0 px-1 addAnotherBtn <?php if(!$isExists): ?> d-none <?php endif; ?>" data-key="<?php echo e($market->key); ?>" data-limit="<?php echo e(@$market->max_limit); ?>"><i class="la la-plus m-0"></i></button>
            <?php endif; ?>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>
<?php /**PATH /home3/dannygue/apuestas.ballosbet.com/core/resources/views/admin/game/partials/markets_list.blade.php ENDPATH**/ ?>