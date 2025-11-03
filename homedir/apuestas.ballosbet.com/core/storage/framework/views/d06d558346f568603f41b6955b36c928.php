

<?php $__env->startSection('frontend'); ?>
    <?php
        $registerContent = getContent('register.content', true);
    ?>
    <div class="login-page section" style="background-image: url(<?php echo e(frontendImage('register', @$registerContent->data_values->background_image, '1920x1070')); ?>);">
        <div class="container">
            <div class="row g-3 align-items-center justify-content-lg-between justify-content-center">
                <div class="col-lg-6 d-lg-block d-none">
                    <img class="login-page__img img-fluid" src="<?php echo e(frontendImage('register', @$registerContent->data_values->image, '1380x1150')); ?>" alt="<?php echo app('translator')->get('image'); ?>">
                </div>

                <div class="col-lg-6 col-xl-5 col-md-8">
                    <div class="login-form mt-0">
                        <div class="col-12">
                            <h4 class="login-form__title"><?php echo app('translator')->get('Registrarse'); ?></h4>
                        </div>

                        <form class="verify-gcaptcha disableSubmission" action="<?php echo e(route('user.register')); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <div class="row">
                                <?php if(session()->get('reference') != null): ?>
                                    <div class="form-group">
                                        <label class="form-label"><?php echo app('translator')->get('Id Referencia'); ?></label>
                                        <input class="form-control form--control" type="text" value="<?php echo e(session()->get('reference')); ?>" readonly>
                                    </div>
                                <?php endif; ?>

                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label class="form-label"><?php echo app('translator')->get('First Name'); ?></label>
                                        <input class="form-control form--control" name="firstname" type="text" value="<?php echo e(old('firstname')); ?>" required>
                                    </div>
                                </div>

                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label class="form-label"><?php echo app('translator')->get('Last Name'); ?></label>
                                        <input class="form-control form--control" name="lastname" type="text" value="<?php echo e(old('lastname')); ?>" required>
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label class="form-label"><?php echo app('translator')->get('Email Address'); ?></label>
                                        <input class="form-control form--control checkUser" name="email" type="email" value="<?php echo e(old('email')); ?>" required>
                                    </div>
                                </div>

                                
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label class="form-label"><?php echo app('translator')->get('Numero de Celular'); ?></label>
                                        <input class="form-control form--control"
                                               name="mobile"
                                               type="text"
                                               value="<?php echo e(old('mobile')); ?>"
                                               inputmode="numeric"
                                               pattern="[0-9]*"
                                               required
                                               style="margin-bottom: 4px;">
                                        <small style="color: #fff; display: block; margin-top: 2px; font-size: 13px; line-height: 1.2;">
                                            <?php echo app('translator')->get('-'); ?>
                                        </small>
                                    </div>
                                </div>
                                

                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label class="form-label"><?php echo app('translator')->get('Password'); ?></label>
                                        <div class="input-group input--group">
                                            <input class="form-control form--control <?php if(gs('secure_password')): ?> secure-password <?php endif; ?>" name="password" type="password" required>
                                            <span class="input-group-text pass-toggle"><i class="las la-eye"></i></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label class="form-label"><?php echo app('translator')->get('Confirm Password'); ?></label>
                                        <div class="input-group input--group">
                                            <input class="form-control form--control" name="password_confirmation" type="password" required>
                                            <span class="input-group-text pass-toggle"><i class="las la-eye"></i></span>
                                        </div>
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

                                <?php if(gs('agree')): ?>
                                    <?php
                                        $policyElements = getContent('policy_pages.element', orderById: true);
                                    ?>
                                    <div class="col-12">
                                        <div class="form-group form-check d-flex align-items-start gap-2 mt-2">
                                            <input class="form-check-input custom--check" id="agree" name="agree" type="checkbox" <?php if(old('agree')): echo 'checked'; endif; ?> required>
                                            <label class="form-check-label" for="agree">
                                                <span class="text-light"><?php echo app('translator')->get('Estoy de acuerdo con'); ?></span>
                                                <?php $__currentLoopData = $policyElements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $policy): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <a href="<?php echo e(route('policy.pages', $policy->slug)); ?>" target="_blank" class="link-terms">
                                                        <?php echo e(__(@$policy->data_values->title)); ?>

                                                    </a>
                                                    <?php if(!$loop->last): ?>, <?php endif; ?>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </label>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <button class="btn btn--xl btn--base w-100 mt-3" type="submit"><?php echo app('translator')->get('Registrarme'); ?></button>

                            <div class="d-flex justify-content-center align-items-center gap-2 mt-2">
                                <span class="d-inline-block sm-text"><?php echo app('translator')->get('No tienes una cuenta?'); ?></span>
                                <a class="t-link d-inline-block t-link--base base-clr sm-text lh-1 text-center text-end" href="<?php echo e(route('user.login')); ?>">
                                    <?php echo app('translator')->get('Acceder'); ?>
                                </a>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php if(gs('secure_password')): ?>
    <?php $__env->startPush('script-lib'); ?>
        <script src="<?php echo e(asset('assets/global/js/secure_password.js')); ?>"></script>
    <?php $__env->stopPush(); ?>
<?php endif; ?>

<?php $__env->startPush('script'); ?>
    <script>
        "use strict";
        (function($) {
            $('.checkUser').on('focusout', function(e) {
                var url = '<?php echo e(route('user.checkUser')); ?>';
                var value = $(this).val();
                var token = '<?php echo e(csrf_token()); ?>';
                var data = { email: value, _token: token };
                $.post(url, data, function(response) {
                    if (response.data != false) {
                        $('#existModalCenter').modal('show');
                    }
                });
            });
        })(jQuery);
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make($activeTemplate . 'layouts.frontend', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home3/dannygue/apuestas.ballosbet.com/core/resources/views/templates/basic/user/auth/register.blade.php ENDPATH**/ ?>