<form class="verify-gcaptcha" action="<?php echo e(route('user.login')); ?>" method="POST">
    <?php echo csrf_field(); ?>
    <div class="form-group">
        <label class="form-label"><?php echo app('translator')->get('Username or Email'); ?></label>
        <input class="form-control form--control" name="username" type="text" value="<?php echo e(old('username')); ?>" required>
    </div>
    <div class="form-group">
        <label class="form-label"><?php echo app('translator')->get('Password'); ?></label>
        <div class="input-group input--group">
            <input class="form-control form--control" name="password" type="password" required>
            <span class="input-group-text pass-toggle">
                <i class="las la-eye"></i>
            </span>
        </div>
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
    <div class="col-12 d-flex flex-wrap justify-content-between">
        <div class="form-group form-check d-flex flex-wrap align-items-center gap-2">
            <input class="form-check-input custom--check" id="remember-two" name="remember" type="checkbox" <?php if(old('remember')): echo 'checked'; endif; ?>>
            <div>
                <label class="form-check-label sm-text t-heading-font heading-clr fw-md" for="remember-two">
                    <?php echo app('translator')->get('Remember Me'); ?>
                </label>
            </div>
        </div>
        <a class="t-link--base sm-text" href="<?php echo e(route('user.password.request')); ?>"><?php echo app('translator')->get('Forgot Password?'); ?></a>
    </div>

    <button class="btn btn--xl btn--base w-100" type="submit"><?php echo app('translator')->get('Login'); ?></button>

    <?php if(gs('registration')): ?>
        <div class="d-flex justify-content-center align-items-center gap-2 mt-2">
            <span class="d-inline-block sm-text"> <?php echo app('translator')->get('No tienes una cuenta?'); ?> </span>
            <a class="t-link d-inline-block t-link--base base-clr sm-text lh-1 text-center text-end" href="<?php echo e(route('user.register')); ?>"><?php echo app('translator')->get('Create account'); ?></a>
        </div>
    <?php endif; ?>
</form>
<?php $__env->startPush('style'); ?>
    <style>
        .form-check-input {
            margin-top: 0px;
        }
    </style>
<?php $__env->stopPush(); ?>
<?php /**PATH /home3/dannygue/apuestas.ballosbet.com/core/resources/views/templates/basic/partials/login.blade.php ENDPATH**/ ?>