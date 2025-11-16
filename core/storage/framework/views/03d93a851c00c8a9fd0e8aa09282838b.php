<?php $__env->startSection('frontend'); ?>
    <?php
        $forgetPasswordContent = getContent('forget_password.content', true);
    ?>
    <div class="login-page section" style="background-image: url(<?php echo e(frontendImage('forget_password', @$forgetPasswordContent->data_values->background_image, '1920x1070')); ?>);">
        <div class="container">
            <div class="row g-3 align-items-center justify-content-lg-between justify-content-center">
                <div class="col-lg-6 d-lg-block d-none">
                    <img class="login-page__img img-fluid" src="<?php echo e(frontendImage('forget_password', @$forgetPasswordContent->data_values->image, '1380x1150')); ?>" alt="<?php echo app('translator')->get('image'); ?>">
                </div>
                <div class="col-lg-6 col-xl-5 col-md-8">
                    <div class="login-form mt-0">
                        <form class="verify-gcaptcha" action="<?php echo e(route('user.password.email')); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <h4 class="login-form__title"><?php echo e(__($pageTitle)); ?></h4>
                            <p class="text-muted"><?php echo app('translator')->get('Por favor, proporciona tu correo para encontrar tu cuenta..'); ?></p>
                            <div class="form-group">
                                <label class="form-label"><?php echo app('translator')->get('Correo Electronico'); ?></label>
                                <input class="form-control form--control mb-3" name="value" type="text" value="<?php echo e(old('value')); ?>" required>
                            </div>
                            <?php if (isset($component)) { $__componentOriginalff0a9fdc5428085522b49c68070c11d6 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalff0a9fdc5428085522b49c68070c11d6 = $attributes; } ?>
<?php $component = App\View\Components\Captcha::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('captcha'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Captcha::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalff0a9fdc5428085522b49c68070c11d6)): ?>
<?php $attributes = $__attributesOriginalff0a9fdc5428085522b49c68070c11d6; ?>
<?php unset($__attributesOriginalff0a9fdc5428085522b49c68070c11d6); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalff0a9fdc5428085522b49c68070c11d6)): ?>
<?php $component = $__componentOriginalff0a9fdc5428085522b49c68070c11d6; ?>
<?php unset($__componentOriginalff0a9fdc5428085522b49c68070c11d6); ?>
<?php endif; ?>
                            <button class="btn btn--xl btn--base w-100" type="submit">
                                <?php echo app('translator')->get('Salir'); ?>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make($activeTemplate . 'layouts.frontend', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home3/dannygue/apuestas.ballosbet.com/core/resources/views/templates/basic/user/auth/passwords/email.blade.php ENDPATH**/ ?>