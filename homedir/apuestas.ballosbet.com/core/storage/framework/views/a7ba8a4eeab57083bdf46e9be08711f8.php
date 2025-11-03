<?php
    $categories = App\Models\Category::active()->orderBy('name')->get();
    $gameType = session('game_type', 'live');
?>

<nav class="sports-category">

    <a class="sports-category__link live-btn <?php if(session('game_type') == 'live'): ?> active <?php endif; ?>" href="<?php echo e(route('switch.type')); ?>">
        <span class="sports-category__icon">
            <i class="la la-desktop"></i>
        </span>
        
        <span class="sports-category__text">
            <?php echo app('translator')->get('LIVE ONLY'); ?>
        </span>
    </a>

    <div class="sports-category__list">
        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <a class="sports-category__link <?php if(@$activeCategory->id == $category->id): ?> active <?php endif; ?>" href="<?php echo e(route('category.games', $category->slug)); ?>">
                <span class="sports-category__icon">
                    <?php echo $category->icon ?>
                </span>
                <span class="sports-category__text">
                    <?php echo e(strLimit(__($category->name), 20)); ?>

                </span>
            </a>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
    
</nav>
<?php /**PATH /home3/dannygue/apuestas.ballosbet.com/core/resources/views/templates/basic/partials/category.blade.php ENDPATH**/ ?>