<?php $__env->startSection('master'); ?>
    <div class="row gy-4">

        <div class="col-12">

            <a class="text-muted text-decoration-underline" href="<?php echo e(route('user.referral.users')); ?>">
                <i class="la la-users"></i> <?php echo app('translator')->get('My Referred Users'); ?>
            </a>

            <div class="table-responsive mt-2">
                <table class="table-responsive--md custom--table table">
                    <thead>
                        <tr>
                            <th><?php echo app('translator')->get('TRX No.'); ?></th>
                            <th><?php echo app('translator')->get('From'); ?></th>
                            <th><?php echo app('translator')->get('Level'); ?></th>
                            <th><?php echo app('translator')->get('Percent'); ?></th>
                            <th><?php echo app('translator')->get('Amount'); ?></th>
                            <th><?php echo app('translator')->get('Type'); ?></th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $logs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td>
                                    #<?php echo e(@$log->trx); ?>

                                    <br>
                                    <small class="text-muted"><em> <i class="la la-clock"></i> <?php echo e(showDateTime($log->created_at)); ?></em></small>
                                </td>
                                <td> <?php echo e(@$log->byWho->username); ?> </td>
                                <td> <?php echo e(ordinal($log->level)); ?> <?php echo app('translator')->get('Level'); ?> </td>
                                <td> <?php echo e(getAmount($log->percent)); ?>% </td>
                                <td> <?php echo e(showAmount($log->commission_amount)); ?></td>
                                <td> <?php echo e(__($log->commissionType())); ?></td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td class="text-center" colspan="100%"><?php echo app('translator')->get('No commission log found'); ?></td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="mt-4 align-items-center pagination-wrapper">
            <?php echo e($logs->links()); ?>

        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('breadcrumb-items'); ?>
    <div class="d-flex gap-2">

        <form class="ms-auto min-width-220" method="GET">
            <select class="form-control form--control select2" id="referralType" data-minimum-results-for-search="-1" name="type">
                <option value=""><?php echo app('translator')->get('Any Type'); ?></option>
                <option value="deposit" <?php if($type == 'deposit'): echo 'selected'; endif; ?>><?php echo app('translator')->get('Deposit Commissions'); ?></option>
                <option value="bet" <?php if($type == 'bet'): echo 'selected'; endif; ?>><?php echo app('translator')->get('Bet Place Commissions'); ?></option>
                <option value="win" <?php if($type == 'win'): echo 'selected'; endif; ?>><?php echo app('translator')->get('Bet Win Commissions'); ?></option>
            </select>
        </form>
        <?php if (isset($component)) { $__componentOriginale48b4598ffc2f41a085f001458a956d1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale48b4598ffc2f41a085f001458a956d1 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.search-form','data' => ['btn' => 'btn-light','placeholder' => 'TRX No.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('search-form'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['btn' => 'btn-light','placeholder' => 'TRX No.']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale48b4598ffc2f41a085f001458a956d1)): ?>
<?php $attributes = $__attributesOriginale48b4598ffc2f41a085f001458a956d1; ?>
<?php unset($__attributesOriginale48b4598ffc2f41a085f001458a956d1); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale48b4598ffc2f41a085f001458a956d1)): ?>
<?php $component = $__componentOriginale48b4598ffc2f41a085f001458a956d1; ?>
<?php unset($__componentOriginale48b4598ffc2f41a085f001458a956d1); ?>
<?php endif; ?>
    </div>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('style'); ?>
    <style>
        .min-width-220 {
            min-width: 220px;
        }
    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('script'); ?>
    <script>
        (function($) {
            "use strict";
            $('#referralType').on('change', function() {
                $(this).closest('form').submit();
            });
        })(jQuery);
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make($activeTemplate . 'layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home3/dannygue/apuestas.ballosbet.com/core/resources/views/templates/basic/user/referral/commission.blade.php ENDPATH**/ ?>