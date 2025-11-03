
<?php $__env->startSection('content'); ?>
    <?php echo $__env->yieldContent('frontend'); ?>
    <?php echo $__env->make($activeTemplate . 'partials.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make($activeTemplate . 'layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home3/dannygue/apuestas.ballosbet.com/core/resources/views/templates/basic/layouts/frontend_no_header.blade.php ENDPATH**/ ?>