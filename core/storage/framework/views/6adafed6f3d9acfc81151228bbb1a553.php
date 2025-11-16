<div class="d-flex flex-column gap-3">
    <?php $__currentLoopData = $bets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $betData): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="list-group list--group">
            <div class="list-group-item head d-flex justify-content-center">
                <?php if(@$betData->outcome->market->market_type == 'outrights'): ?>
                    <?php echo e(__(@$betData->outcome->market->title)); ?>

                <?php else: ?>
                
                    <?php echo e(__(@$betData->outcome->market->game?->teamOne?->short_name)); ?>

                    <span class="text--base mx-2"><?php echo app('translator')->get('vs'); ?></span>
                    <?php echo e(__($betData->outcome->market->game?->teamTwo?->short_name)); ?>

                <?php endif; ?>
            </div>
            <div class="list-group-item d-flex justify-content-between flex-wrap">
                <small><?php echo app('translator')->get('Mercado'); ?></small>
                <small> <?php echo e(__($betData->outcome->market->market_title)); ?> </small>
            </div>

            <div class="list-group-item d-flex justify-content-between flex-wrap">
                <small><?php echo app('translator')->get('Resultado'); ?></small>
                <small> <?php echo e(__($betData->outcome->name)); ?> </small>
            </div>

            <div class="list-group-item d-flex justify-content-between flex-wrap">
                <small><?php echo app('translator')->get('Estado'); ?></small>
                <span> <?php echo $betData->statusBadge ?> </span>
            </div>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>
<?php /**PATH /home3/dannygue/apuestas.ballosbet.com/core/resources/views/templates/basic/user/bet/details.blade.php ENDPATH**/ ?>