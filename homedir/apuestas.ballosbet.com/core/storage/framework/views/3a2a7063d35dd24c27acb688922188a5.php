<?php $__env->startSection('master'); ?>
    <div class="card custom--card">
        <div class="card-body">
            <div class="alert alert-primary">
                <p class="mb-0"><i class="las la-info-circle"></i> <?php echo app('translator')->get('Usted solicita un retiro de'); ?> <b><?php echo e(showAmount($withdraw->amount)); ?></b>. <?php echo app('translator')->get('El administrador enviará'); ?>
                    <b class="text--success"><?php echo e(showAmount($withdraw->final_amount, currencyFormat: false) . ' ' . $withdraw->currency); ?> </b> <?php echo app('translator')->get('a tu cuenta.'); ?>
                </p>
            </div>
            <form action="<?php echo e(route('user.withdraw.submit')); ?>" class="disableSubmission" method="post" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <div class="mb-2">
                    <?php
                        echo $withdraw->method->description;
                    ?>
                </div>
                <?php if (isset($component)) { $__componentOriginal3bd95de28203859144f617d3fb6afebc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3bd95de28203859144f617d3fb6afebc = $attributes; } ?>
<?php $component = App\View\Components\ViserForm::resolve(['identifier' => 'id','identifierValue' => ''.e($withdraw->method->form_id).''] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
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
                <?php if(auth()->user()->ts): ?>
                    <div class="form-group">
                        <label><?php echo app('translator')->get('Google Authenticator Code'); ?></label>
                        <input type="text" name="authenticator_code" class="form-control form--control" required>
                    </div>
                <?php endif; ?>
                <button type="submit" class="btn btn--base w-100"><?php echo app('translator')->get('Enviar'); ?></button>
            </form>
        </div>
    </div>
<?php $__env->stopSection(); ?>



<?php echo $__env->make($activeTemplate . 'layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home3/dannygue/apuestas.ballosbet.com/core/resources/views/templates/basic/user/withdraw/preview.blade.php ENDPATH**/ ?>