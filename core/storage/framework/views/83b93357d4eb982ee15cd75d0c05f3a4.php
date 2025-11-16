
<?php $__env->startSection('content'); ?>
    <?php echo $__env->make($activeTemplate . 'partials.user_header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <div class="user-dashboard">
        <div class="container">
            <div class="dashboard-wrapper">
                <?php echo $__env->make($activeTemplate . 'partials.dashboard_sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                <div class="dashboard-right">
                    <?php if(!Route::is('user.home')): ?>
                        
                        <div class="d-flex justify-content-between gap-3 mb-4">
                            <h5 class="m-0"><?php echo e(__($pageTitle)); ?></h5>
                            <div class="ms-auto">
                                <?php echo $__env->yieldPushContent('breadcrumb-items'); ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php echo $__env->yieldContent('master'); ?>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid mt-auto px-0">
        <div class="footer-bottom footer-bottom--dark">
            <div class="container">
                <?php echo $__env->make($activeTemplate . 'partials.footer_bottom', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            </div>
        </div>
    </div>

    <?php echo $__env->make($activeTemplate . 'partials.dashboard_mobile_menu', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('style-lib'); ?>
    <link href="<?php echo e(asset($activeTemplateTrue . 'css/dashboard.css')); ?>" rel="stylesheet">
<?php $__env->stopPush(); ?>

<?php $__env->startPush('script'); ?>
    <script>
        (function($) {
            "use strict";

            // Mostrar u ocultar filtros
            $('.showFilterBtn').on('click', function() {
                $('.responsive-filter-card').slideToggle();
            });

            // Configuración de Select2
            function formatState(state) {
                if (!state.id) return console.log(state.text);
                let gatewayData = $(state.element).data();
                return $(`<div class="d-flex gap-2">
                    ${gatewayData.imageSrc ? `<div class="select2-image-wrapper">
                        <img class="select2-image" src="${gatewayData.imageSrc}">
                    </div>` : '' }
                    <div class="select2-content">
                        <p class="select2-title">${gatewayData.title}</p>
                        <p class="select2-subtitle">${gatewayData.subtitle}</p>
                    </div>
                </div>`);
            }

            $('.select2').each(function(index, element) {
                $(element).select2();
            });

            $('.select2-basic').each(function(index, element) {
                $(element).select2({
                    dropdownParent: $(element).closest('.select2-parent')
                });
            });

        })(jQuery)
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make($activeTemplate . 'layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home3/dannygue/apuestas.ballosbet.com/core/resources/views/templates/basic/layouts/master.blade.php ENDPATH**/ ?>