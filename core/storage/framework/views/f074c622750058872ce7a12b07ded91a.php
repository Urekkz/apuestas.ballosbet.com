<?php $__env->startSection('master'); ?>
    <div class="show-filter mb-3 text-end">
        <button class="btn btn--base showFilterBtn btn-sm" type="button"><i class="las la-filter"></i> <?php echo app('translator')->get('Filter'); ?></button>
    </div>
    <div class="responsive-filter-card mb-3">
        <form>
            <div class="d-flex flex-wrap gap-4">
                <div class="flex-grow-1">
                    <label class="form-label"><?php echo app('translator')->get('Transaction No.'); ?></label>
                    <input class="form-control form--control" name="search" type="text" value="<?php echo e(request()->search); ?>">
                </div>
                <div class="flex-grow-1">
                    <label class="form-label"><?php echo app('translator')->get('Tipo'); ?></label>
                    <select class="form-control select2" name="trx_type" data-minimum-results-for-search="-1">
                        <option value=""><?php echo app('translator')->get('Todos'); ?></option>
                        <option value="+" <?php if(request()->trx_type == '+'): echo 'selected'; endif; ?>><?php echo app('translator')->get('Plus'); ?></option>
                        <option value="-" <?php if(request()->trx_type == '-'): echo 'selected'; endif; ?>><?php echo app('translator')->get('Minus'); ?></option>
                    </select>
                </div>
                <div class="flex-grow-1">
                    <label class="form-label"><?php echo app('translator')->get('Observacion'); ?></label>
                    <select class="form-control select2" name="remark" data-minimum-results-for-search="-1">
                        <option value=""><?php echo app('translator')->get('Cualquiera'); ?></option>
                        <?php $__currentLoopData = $remarks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $remark): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($remark->remark); ?>" <?php if(request()->remark == $remark->remark): echo 'selected'; endif; ?>><?php echo e(__(keyToTitle($remark->remark))); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="flex-grow-1 align-self-end">
                    <button class="btn btn--base btn--xl w-100"><i class="las la-filter"></i> <?php echo app('translator')->get('Filter'); ?></button>
                </div>
            </div>
        </form>
    </div>
    <div class="table-responsive">
        <table class="table-responsive--md custom--table table">
            <thead>
                <tr>
                    <th><?php echo app('translator')->get('Transaction No.'); ?></th>
                    <th><?php echo app('translator')->get('Realizado'); ?></th>
                    <th><?php echo app('translator')->get('Monto'); ?></th>
                    <th><?php echo app('translator')->get('Nuevo Saldo'); ?></th>
                    <th><?php echo app('translator')->get('Detalles'); ?></th>
                </tr>
            </thead>

            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $transactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $trx): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td>#<?php echo e($trx->trx); ?></td>
                        <td>
                            <?php echo e(showDateTime($trx->created_at)); ?>

                        </td>
                        <td>
                            <span class="<?php if($trx->trx_type == '+'): ?> text--success <?php else: ?> text--danger <?php endif; ?>">
                                <?php echo e($trx->trx_type); ?> <?php echo e(showAmount($trx->amount)); ?>

                            </span>
                        </td>
                        <td>
                            <?php echo e(showAmount($trx->post_balance)); ?>

                        </td>
                        <td><p><?php echo e($trx->details); ?></p></td>
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
        <?php echo e($transactions->links()); ?>

    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('style'); ?>
    <style>
        .select2-container {
            width: 100% !important;
        }
    </style>
<?php $__env->stopPush(); ?>

<?php echo $__env->make($activeTemplate . 'layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home3/dannygue/apuestas.ballosbet.com/core/resources/views/templates/basic/user/transactions.blade.php ENDPATH**/ ?>