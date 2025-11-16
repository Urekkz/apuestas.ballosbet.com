<?php $__env->startSection('master'); ?>
    <div class="table-responsive">
        <table class="table-responsive--md custom--table table">
            <thead>
                <tr>
                    <th><?php echo app('translator')->get('Asunto'); ?></th>
                    <th><?php echo app('translator')->get('Estado'); ?></th>
                    <th><?php echo app('translator')->get('Prioridad'); ?></th>
                    <th><?php echo app('translator')->get('Última respuesta'); ?></th>
                    <th><?php echo app('translator')->get('Acción'); ?></th>
            </thead>

            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $supports; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $support): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td>
                            <a class="t-link--base" href="<?php echo e(route('ticket.view', $support->ticket)); ?>">[<?php echo app('translator')->get('Ticket'); ?>#<?php echo e($support->ticket); ?>] <?php echo e(__($support->subject)); ?></a>
                        </td>
                        <td>
                            <?php echo $support->statusBadge; ?>
                        </td>
                        <td>
                            <?php if($support->priority == Status::PRIORITY_LOW): ?>
                                <span class="badge badge--dark"><?php echo app('translator')->get('Baja'); ?></span>
                            <?php elseif($support->priority == Status::PRIORITY_MEDIUM): ?>
                                <span class="badge badge--warning"><?php echo app('translator')->get('Media'); ?></span>
                            <?php elseif($support->priority == Status::PRIORITY_HIGH): ?>
                                <span class="badge badge--danger"><?php echo app('translator')->get('Alta'); ?></span>
                            <?php endif; ?>
                        </td>
                        <td><?php echo e(diffForHumans($support->last_reply)); ?> </td>
                        <td>
                            <a class="btn btn--sm btn-outline--base" href="<?php echo e(route('ticket.view', $support->ticket)); ?>">
                                <i class="las la-desktop"></i> <?php echo app('translator')->get('Ver'); ?>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td class="text-center" colspan="100%"><?php echo e(__($emptyMessage)); ?></td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div class="mt-4 align-items-center pagination-wrapper">
        <?php echo e($supports->links()); ?>

    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('breadcrumb-items'); ?>
    <a class="btn btn--base" href="<?php echo e(route('ticket.open')); ?>">
        <span class="dashboard-menu__text"><i class="la la-plus"></i> <?php echo app('translator')->get('Abrir nuevo Ticket'); ?></span>
    </a>
<?php $__env->stopPush(); ?>

<?php echo $__env->make($activeTemplate . 'layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home3/dannygue/apuestas.ballosbet.com/core/resources/views/templates/basic/user/support/index.blade.php ENDPATH**/ ?>