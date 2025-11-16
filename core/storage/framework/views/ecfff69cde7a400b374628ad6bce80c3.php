<div class="container-fluid mt-auto px-0">
    <!-- FOOTER TOP (fondo negro con imagen/logo) -->
    <div class="footer footer--dark" style="background-color:#080808;">
        <div class="container py-5">
            <?php echo $__env->make($activeTemplate . 'partials.footer_top', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        </div>
    </div>

    <!-- FOOTER BOTTOM (texto inferior) -->
    <div class="footer-bottom footer-bottom--dark" style="background-color:#000;">
        <div class="container py-3">
            <?php echo $__env->make($activeTemplate . 'partials.footer_bottom', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        </div>
    </div>
</div>
<?php /**PATH /home3/dannygue/apuestas.ballosbet.com/core/resources/views/templates/basic/partials/footer.blade.php ENDPATH**/ ?>