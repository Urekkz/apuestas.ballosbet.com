<?php $__env->startSection('panel'); ?>
    <div class="row justify-content-center">
        <?php if(request()->routeIs('admin.withdraw.data.all') || request()->routeIs('admin.withdraw.method')): ?>
            <div class="col-12">
                <?php echo $__env->make('admin.withdraw.widget', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            </div>
        <?php endif; ?>
        <div class="col-lg-12">
            <div class="card ">
                <div class="card-body p-0">

                    <div class="table-responsive--sm table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                                <tr>
                                    <th><?php echo app('translator')->get('Gateway | Transaction'); ?></th>
                                    <th><?php echo app('translator')->get('Initiated'); ?></th>
                                    <th><?php echo app('translator')->get('User'); ?></th>
                                    <th><?php echo app('translator')->get('Amount'); ?></th>
                                    <th><?php echo app('translator')->get('Conversion'); ?></th>
                                    <th><?php echo app('translator')->get('Status'); ?></th>
                                    <th><?php echo app('translator')->get('Action'); ?></th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $withdrawals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $withdraw): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <?php
                                        $details = $withdraw->withdraw_information != null ? json_encode($withdraw->withdraw_information) : null;
                                    ?>
                                    <tr>
                                        <td>
                                            <span class="fw-bold"><a href="<?php echo e(appendQuery('method', @$withdraw->method->id)); ?>"> <?php echo e(__(@$withdraw->method->name)); ?></a></span>
                                            <br>
                                            <small><?php echo e($withdraw->trx); ?></small>
                                        </td>
                                        <td>
                                            <?php echo e(showDateTime($withdraw->created_at)); ?> <br> <?php echo e(diffForHumans($withdraw->created_at)); ?>

                                        </td>

                                        <td>
                                            <span class="fw-bold"><?php echo e($withdraw->user->fullname); ?></span>
                                            <br>
                                            <span class="small"> <a href="<?php echo e(appendQuery('search', @$withdraw->user->username)); ?>"><span>@</span><?php echo e($withdraw->user->username); ?></a> </span>
                                        </td>


                                        <td>
                                            <?php echo e(showAmount($withdraw->amount)); ?> - <span class="text--danger" title="<?php echo app('translator')->get('charge'); ?>"><?php echo e(showAmount($withdraw->charge)); ?> </span>
                                            <br>
                                            <strong title="<?php echo app('translator')->get('Amount after charge'); ?>">
                                                <?php echo e(showAmount($withdraw->amount - $withdraw->charge)); ?>

                                            </strong>

                                        </td>

                                        <td>
                                            <?php echo e(showAmount(1)); ?> = <?php echo e(showAmount($withdraw->rate, currencyFormat: false)); ?> <?php echo e(__($withdraw->currency)); ?>

                                            <br>
                                            <strong><?php echo e(showAmount($withdraw->final_amount, currencyFormat: false)); ?> <?php echo e(__($withdraw->currency)); ?></strong>
                                        </td>

                                        <td>
                                            <?php echo $withdraw->statusBadge ?>
                                        </td>
                                        <td>
                                            <a href="<?php echo e(route('admin.withdraw.data.details', $withdraw->id)); ?>" class="btn btn-sm btn-outline--primary ms-1">
                                                <i class="la la-desktop"></i> <?php echo app('translator')->get('Details'); ?>
                                            </a>
                                        </td>
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
                <?php if($withdrawals->hasPages()): ?>
                    <div class="card-footer py-4">
                        <?php echo e(paginateLinks($withdrawals)); ?>

                    </div>
                <?php endif; ?>
            </div><!-- card end -->
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('breadcrumb-plugins'); ?>
    <?php if (isset($component)) { $__componentOriginale48b4598ffc2f41a085f001458a956d1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale48b4598ffc2f41a085f001458a956d1 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.search-form','data' => ['dateSearch' => 'yes','placeholder' => 'Username / TRX']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('search-form'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['dateSearch' => 'yes','placeholder' => 'Username / TRX']); ?>
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
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home3/dannygue/apuestas.ballosbet.com/core/resources/views/admin/withdraw/withdrawals.blade.php ENDPATH**/ ?>