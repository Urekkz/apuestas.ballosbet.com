<?php $__env->startSection('master'); ?>
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card custom--card">
                    <div class="card-body  ">
                        <form action="<?php echo e(route('user.deposit.manual.update')); ?>" method="POST" class="disableSubmission" enctype="multipart/form-data">
                            <?php echo csrf_field(); ?>
                            <div class="alert alert-primary">
                                <p class="mb-0"><i class="las la-info-circle"></i> <?php echo app('translator')->get('estas solicitando'); ?> <b><?php echo e(showAmount($data['amount'])); ?></b> <?php echo app('translator')->get('para depositar.'); ?> <?php echo app('translator')->get('Pagar por favor'); ?>
                                    <b><?php echo e(showAmount($data['final_amount'], currencyFormat: false) . ' ' . $data['method_currency']); ?> </b> <?php echo app('translator')->get('for successful payment.'); ?>
                                </p>
                            </div>
                            <?php if(strip_tags($data->gateway->description)): ?>
                                <div class="mb-3"><?php echo $data->gateway->description ?></div>
                            <?php endif; ?>
                            <?php if (isset($component)) { $__componentOriginal3bd95de28203859144f617d3fb6afebc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3bd95de28203859144f617d3fb6afebc = $attributes; } ?>
<?php $component = App\View\Components\ViserForm::resolve(['identifier' => 'id','identifierValue' => ''.e($gateway->form_id).''] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('viser-form'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\ViserForm::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal3bd95de28203859144f617d3fb6afebc)): ?>
<?php $attributes = $__attributesOriginal3bd95de28203859144f617d3fb6afebc; ?>
<?php unset($__attributesOriginal3bd95de28203859144f617d3fb6afebc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal3bd95de28203859144f617d3fb6afebc)): ?>
<?php $component = $__componentOriginal3bd95de28203859144f617d3fb6afebc; ?>
<?php unset($__componentOriginal3bd95de28203859144f617d3fb6afebc); ?>
<?php endif; ?>

                            <button type="submit" class="btn btn--base w-100"><?php echo app('translator')->get('Enviar'); ?></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make($activeTemplate . 'layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home3/dannygue/apuestas.ballosbet.com/core/resources/views/templates/basic/user/payment/manual.blade.php ENDPATH**/ ?>