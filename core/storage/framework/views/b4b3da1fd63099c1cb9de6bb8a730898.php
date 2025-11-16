<?php $__env->startSection('frontend'); ?>
    <?php
        $contactContent = getContent('contact.content', true);
        $contactElements = getContent('contact.element', false, null, true);
    ?>

    <div class="section contact-section" style="background-image: url(<?php echo e(frontendImage('contact', @$contactContent->data_values->background_image, '1600x1100')); ?>);">
        <div class="container">
            <div class="row g-3 align-items-lg-center justify-content-lg-between">
                <div class="col-lg-5">
                    <ul class="list">
                        <?php $__currentLoopData = $contactElements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $contact): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li>
                                <div class="contact-card">
                                    <span class="contact-card__icon">
                                        <?php echo @$contact->data_values->icon ?>
                                    </span>
                                    <div class="contact-card__content">
                                        <h5 class="contact-card__title"><?php echo e(__(@$contact->data_values->heading)); ?></h5>
                                        <p class="contact-card__text">
                                            <?php echo e(__(@$contact->data_values->details)); ?>

                                        </p>
                                    </div>
                                </div>
                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>

                <div class="col-lg-6">
                    <div class="login-form">
                        <form class="verify-gcaptcha" method="POST">
                            <?php echo csrf_field(); ?>
                            <h4 class="login-form__title"><?php echo e(__(@$contactContent->data_values->heading)); ?> </h4>
                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label class="form-label"><?php echo app('translator')->get('Name'); ?></label>
                                        <input class="form-control form--control mb-3" name="name" type="text" value="<?php echo e(old('name', @$user->fullname)); ?>" <?php if($user): ?> readonly <?php endif; ?> required>
                                    </div>
                                </div>

                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label class="form-label"><?php echo app('translator')->get('Email'); ?></label>
                                        <input class="form-control form--control mb-3" name="email" type="email" value="<?php echo e(old('email', @$user->email)); ?>" <?php if($user): ?> readonly <?php endif; ?> required>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label"><?php echo app('translator')->get('Subject'); ?></label>
                                <input class="form-control form--control mb-3" name="subject" type="text" value="<?php echo e(old('subject')); ?>" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label"><?php echo app('translator')->get('Message'); ?></label>
                                <textarea class="form-control form--control" name="message" cols="30" rows="5" required><?php echo e(old('message')); ?></textarea>
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
                            <button class="btn btn--xl btn--base w-100" type="submit"><?php echo app('translator')->get('Send Message'); ?></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make($activeTemplate . 'layouts.frontend', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home3/dannygue/apuestas.ballosbet.com/core/resources/views/templates/basic/contact.blade.php ENDPATH**/ ?>