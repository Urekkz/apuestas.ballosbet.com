<?php $__env->startSection('panel'); ?>
    <div class="row mb-none-30 justify-content-center">
        <div class="col-xl-4 col-md-6 mb-30">
            <div class="card overflow-hidden box--shadow1">
                <div class="card-body">
                    <h5 class="mb-20 text-muted"><?php echo app('translator')->get('Deposit Via'); ?> <?php if($deposit->method_code < 5000): ?>
                            <?php echo e(__(@$deposit->gateway->name)); ?>

                        <?php else: ?>
                            <?php echo app('translator')->get('Google Pay'); ?>
                        <?php endif; ?>
                    </h5>
                    <ul class="list-group">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <?php echo app('translator')->get('Date'); ?>
                            <span class="fw-bold"><?php echo e(showDateTime($deposit->created_at)); ?></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <?php echo app('translator')->get('Transaction Number'); ?>
                            <span class="fw-bold"><?php echo e($deposit->trx); ?></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <?php echo app('translator')->get('Username'); ?>
                            <span class="fw-bold">
                                <a href="<?php echo e(route('admin.users.detail', $deposit->user_id)); ?>"><span>@</span><?php echo e(@$deposit->user->username); ?></a>
                            </span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <?php echo app('translator')->get('Method'); ?>
                            <span class="fw-bold">
                                <?php if($deposit->method_code < 5000): ?>
                                    <?php echo e(__(@$deposit->gateway->name)); ?>

                                <?php else: ?>
                                    <?php echo app('translator')->get('Google Pay'); ?>
                                <?php endif; ?>
                            </span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <?php echo app('translator')->get('Amount'); ?>
                            <span class="fw-bold"><?php echo e(showAmount($deposit->amount)); ?></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <?php echo app('translator')->get('Charge'); ?>
                            <span class="fw-bold"><?php echo e(showAmount($deposit->charge)); ?></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <?php echo app('translator')->get('After Charge'); ?>
                            <span class="fw-bold"><?php echo e(showAmount($deposit->amount + $deposit->charge)); ?></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <?php echo app('translator')->get('Rate'); ?>
                            <span class="fw-bold">1 <?php echo e(__(gs('cur_text'))); ?>

                                = <?php echo e(showAmount($deposit->rate, currencyFormat: false)); ?> <?php echo e(__($deposit->baseCurrency())); ?></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <?php echo app('translator')->get('After Rate Conversion'); ?>
                            <span class="fw-bold"><?php echo e(showAmount($deposit->final_amount, currencyFormat: false)); ?> <?php echo e(__($deposit->method_currency)); ?></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <?php echo app('translator')->get('Status'); ?>
                            <?php echo $deposit->statusBadge ?>
                        </li>
                        <?php if($deposit->admin_feedback): ?>
                            <li class="list-group-item">
                                <strong><?php echo app('translator')->get('Admin Response'); ?></strong>
                                <br>
                                <p><?php echo e(__($deposit->admin_feedback)); ?></p>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </div>
        <?php if($details || $deposit->status == Status::PAYMENT_PENDING): ?>
            <div class="col-xl-8 col-md-6 mb-30">
                <div class="card overflow-hidden box--shadow1">
                    <div class="card-body">
                        <h5 class="card-title border-bottom pb-2"><?php echo app('translator')->get('User Deposit Information'); ?></h5>
                        <?php if($details != null): ?>
                            <?php $__currentLoopData = json_decode($details); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($deposit->method_code >= 1000): ?>
                                    <div class="row mt-4">
                                        <div class="col-md-12">
                                            <h6><?php echo e(__($val->name)); ?></h6>
                                            <?php if($val->type == 'checkbox'): ?>
                                                <?php echo e(implode(',', $val->value)); ?>

                                            <?php elseif($val->type == 'file'): ?>
                                                <?php if($val->value): ?>
                                                    <a href="<?php echo e(route('admin.download.attachment', encrypt(getFilePath('verify') . '/' . $val->value))); ?>"><i class="fa-regular fa-file"></i> <?php echo app('translator')->get('Attachment'); ?> </a>
                                                <?php else: ?>
                                                    <?php echo app('translator')->get('No File'); ?>
                                                <?php endif; ?>
                                            <?php else: ?>
                                                <p><?php echo e(__($val->value)); ?></p>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php if($deposit->method_code < 1000): ?>
                                <?php echo $__env->make('admin.deposit.gateway_data', ['details' => json_decode($details)], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                            <?php endif; ?>
                        <?php endif; ?>
                        <?php if($deposit->status == Status::PAYMENT_PENDING): ?>
                            <div class="row mt-4">
                                <div class="col-md-12">
                                    <button class="btn btn-outline--success btn-sm ms-1 confirmationBtn"
                                            data-action="<?php echo e(route('admin.deposit.approve', $deposit->id)); ?>"
                                            data-question="<?php echo app('translator')->get('Are you sure to approve this transaction?'); ?>"><i class="las la-check"></i>
                                        <?php echo app('translator')->get('Approve'); ?>
                                    </button>

                                    <button class="btn btn-outline--danger btn-sm ms-1" data-bs-toggle="modal" data-bs-target="#rejectModal"><i class="las la-ban"></i> <?php echo app('translator')->get('Reject'); ?>
                                    </button>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>

    
    <div id="rejectModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><?php echo app('translator')->get('Reject Deposit Confirmation'); ?></h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <form action="<?php echo e(route('admin.deposit.reject')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="id" value="<?php echo e($deposit->id); ?>">
                    <div class="modal-body">
                        <p><?php echo app('translator')->get('Are you sure to'); ?> <span class="fw-bold"><?php echo app('translator')->get('reject'); ?></span> <span class="fw-bold text--success"><?php echo e(showAmount($deposit->amount)); ?></span> <?php echo app('translator')->get('deposit of'); ?> <span class="fw-bold"><?php echo e(@$deposit->user->username); ?></span>?</p>

                        <div class="form-group">
                            <label class="mt-2"><?php echo app('translator')->get('Reason for Rejection'); ?></label>
                            <textarea name="message" maxlength="255" class="form-control" rows="5" required><?php echo e(old('message')); ?></textarea>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn--primary w-100 h-45"><?php echo app('translator')->get('Submit'); ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php if (isset($component)) { $__componentOriginalbd5922df145d522b37bf664b524be380 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalbd5922df145d522b37bf664b524be380 = $attributes; } ?>
<?php $component = App\View\Components\ConfirmationModal::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('confirmation-modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\ConfirmationModal::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalbd5922df145d522b37bf664b524be380)): ?>
<?php $attributes = $__attributesOriginalbd5922df145d522b37bf664b524be380; ?>
<?php unset($__attributesOriginalbd5922df145d522b37bf664b524be380); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalbd5922df145d522b37bf664b524be380)): ?>
<?php $component = $__componentOriginalbd5922df145d522b37bf664b524be380; ?>
<?php unset($__componentOriginalbd5922df145d522b37bf664b524be380); ?>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home3/dannygue/apuestas.ballosbet.com/core/resources/views/admin/deposit/detail.blade.php ENDPATH**/ ?>