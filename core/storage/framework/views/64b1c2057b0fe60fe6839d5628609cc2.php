<?php $__env->startSection('panel'); ?>
    <div class="row">
        <div class="col-lg-12">
            <div class="show-filter mb-3 text-end">
                <button type="button" class="btn btn-outline--primary showFilterBtn btn-sm"><i class="las la-filter"></i> <?php echo app('translator')->get('Filter'); ?></button>
            </div>
            <div class="card responsive-filter-card mb-4">
                <div class="card-body">
                    <form action="">
                        <div class="d-flex flex-wrap gap-4">
                            <div class="flex-grow-1">
                                <label><?php echo app('translator')->get('TRX/Username'); ?></label>
                                <input type="text" name="search" value="<?php echo e(request()->search); ?>" class="form-control">
                            </div>
                            <div class="flex-grow-1">
                                <label><?php echo app('translator')->get('Commission Type'); ?></label>
                                <select name="type" class="form-control select2"  data-minimum-results-for-search="-1">
                                    <option value=""><?php echo app('translator')->get('All'); ?></option>
                                    <option value="deposit"><?php echo app('translator')->get('Deposit'); ?></option>
                                    <option value="bet"><?php echo app('translator')->get('Bet Place'); ?></option>
                                    <option value="win"><?php echo app('translator')->get('Bet Win'); ?></option>
                                </select>
                            </div>
                            <div class="flex-grow-1">
                                <label><?php echo app('translator')->get('Date'); ?></label>
                                <input name="date" type="text" data-range="true" data-multiple-dates-separator=" - " data-language="en" class="datepicker-here form-control" data-position='bottom right' placeholder="<?php echo app('translator')->get('Start date - End date'); ?>" autocomplete="off" value="<?php echo e(request()->date); ?>">
                            </div>
                            <div class="flex-grow-1 align-self-end">
                                <button class="btn btn--primary w-100 h-45"><i class="fas fa-filter"></i> <?php echo app('translator')->get('Filter'); ?></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card ">
                <div class="card-body p-0">
                    <div class="table-responsive--sm table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                                <tr>
                                    <th><?php echo app('translator')->get('TRX'); ?></th>
                                    <th><?php echo app('translator')->get('From'); ?></th>
                                    <th><?php echo app('translator')->get('To'); ?></th>
                                    <th><?php echo app('translator')->get('Level'); ?></th>
                                    <th><?php echo app('translator')->get('Percent'); ?></th>
                                    <th><?php echo app('translator')->get('Amount'); ?></th>
                                    <th><?php echo app('translator')->get('Date'); ?></th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $logs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td> <?php echo e($log->trx); ?></td>
                                        <td>
                                            <span class="fw-bold"><?php echo e(__(@$log->byWho->fullname)); ?></span>
                                            <br>
                                            <span class="small">
                                                <a href="<?php echo e(route('admin.users.detail', @$log->byWho->id)); ?>"><span>@</span><?php echo e(@$log->byWho->username); ?></a>
                                            </span>
                                        </td>
                                        <td>
                                            <span class="fw-bold"><?php echo e(__(@$log->toUser->fullname)); ?></span>
                                            <br>
                                            <span class="small">
                                                <a href="<?php echo e(route('admin.users.detail', @$log->toUser->id)); ?>"><span>@</span><?php echo e(@$log->toUser->username); ?></a>
                                            </span>
                                        </td>
                                        <td> <?php echo e(__(ordinal($log->level))); ?> <?php echo app('translator')->get('Level'); ?> </td>
                                        <td> <?php echo e(getAmount($log->percent)); ?> % </td>
                                        <td> <?php echo e(showAmount($log->commission_amount)); ?> </td>
                                        <td> <?php echo e(showDateTime($log->created_at, 'd M, Y')); ?> </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td class="text-muted text-center" colspan="100%"><?php echo e(__($emptyMessage)); ?></td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table><!-- table end -->
                    </div>
                </div>

                <?php if($logs->hasPages()): ?>
                    <div class="card-footer py-4">
                        <?php echo e(paginateLinks($logs)); ?>

                    </div>
                <?php endif; ?>
            </div><!-- card end -->
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('style-lib'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('assets/admin/css/vendor/datepicker.min.css')); ?>">
<?php $__env->stopPush(); ?>


<?php $__env->startPush('script-lib'); ?>
    <script src="<?php echo e(asset('assets/admin/js/vendor/datepicker.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/admin/js/vendor/datepicker.en.js')); ?>"></script>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('script'); ?>
    <script>
        (function($) {
            "use strict";

            <?php if(request()->type): ?>
                $('[name=type]').val(`<?php echo e(request()->type); ?>`);
            <?php endif; ?>

            if (!$('.datepicker-here').val()) {
                $('.datepicker-here').datepicker();
            }
        })(jQuery)
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home3/dannygue/apuestas.ballosbet.com/core/resources/views/admin/reports/referral_commissions.blade.php ENDPATH**/ ?>