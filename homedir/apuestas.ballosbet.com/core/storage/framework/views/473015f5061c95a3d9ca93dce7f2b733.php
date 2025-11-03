<?php if(@$game->teamOne && @$game->teamTwo): ?>
    <div class="d-flex justify-content-between justify-content-lg-center align-items-center gap-2">
        <div class="team-logo d-flex gap-2 align-items-center">
            <img src="<?php echo e($game?->teamOne->teamImage()); ?>" alt="image">
            <small><?php echo e(__(@$game->teamOne->short_name)); ?></small>
        </div>
        <span class="px-3"><?php echo app('translator')->get('VS'); ?></span>
        <div class="team-logo team-logo d-flex gap-2 align-items-center">
            <img src="<?php echo e($game?->teamTwo->teamImage()); ?>" alt="image">
            <smal><?php echo e(__(@$game->teamTwo->short_name)); ?></smal>
        </div>
    </div>
<?php else: ?>
    <small class="text-muted"> <?php echo app('translator')->get('Market'); ?></small>
    <h6><?php echo e(__($game->title)); ?></h6>
<?php endif; ?>

<?php if (! $__env->hasRenderedOnce('75c77a1d-494f-4495-bcda-080eb67a9a73')): $__env->markAsRenderedOnce('75c77a1d-494f-4495-bcda-080eb67a9a73');
$__env->startPush('style'); ?>
    <style>
        .team-logo img {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            padding: 3px;
            box-shadow: 0 0 10px 0px #ddd;
        }
    </style>
<?php $__env->stopPush(); endif; ?>
<?php /**PATH /home3/dannygue/apuestas.ballosbet.com/core/resources/views/admin/game/partials/game_title.blade.php ENDPATH**/ ?>