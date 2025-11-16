<div class="sub-category-drawer">
    <ul class="sub-category-drawer__list">
        <?php $__currentLoopData = $leagues; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $league): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li>
                <a class="sub-category-drawer__link <?php if(@$activeLeague->id == $league->id): ?> active <?php endif; ?>" href="<?php echo e(route('league.games', $league->slug)); ?>">
                    <span class="sub-category-drawer__flag">
                        <img class="sub-category-drawer__flag-img" src="<?php echo e($league->logo()); ?>" alt="<?php echo app('translator')->get('image'); ?>">
                    </span>
                    <span class="sub-category-drawer__text" title="<?php echo e(__($league->name)); ?>">
                        <?php echo e(__($league->short_name)); ?>

                    </span>
                </a>
                
            </li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </ul>
</div>


<?php /**PATH /home3/dannygue/apuestas.ballosbet.com/core/resources/views/templates/basic/partials/leagues.blade.php ENDPATH**/ ?>