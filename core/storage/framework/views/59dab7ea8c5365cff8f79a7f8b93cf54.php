<?php
    $footerElements = getContent('footer.element', false, null, true);
?>

<div class="footer-bottom-container text-center text-white py-3" style="background-color:#080808;">
    <div class="container d-flex flex-column flex-sm-row justify-content-between align-items-center gap-2" style="padding: 10px 0;">
        
        <div class="copyright text-sm-start text-center" style="font-size:0.9rem; color:#ccc;">
            © <?php echo e(date('Y')); ?> <strong><?php echo e(__(gs('site_name'))); ?></strong> · Todos los derechos reservados.
            <br>
            <span style="font-size:0.8rem; color:#999;">
                Juega responsablemente. Prohibida la venta a menores de edad.
            </span>
        </div>

        <div class="payment-icons text-sm-end text-center mt-2 mt-sm-0">
            <ul class="d-flex justify-content-center justify-content-sm-end align-items-center flex-wrap" style="list-style:none; padding:0; margin:0; gap:10px;">
                <?php $__currentLoopData = $footerElements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $footer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li>
                        <img src="<?php echo e(frontendImage('footer', @$footer->data_values->payment_method_image, '130x50')); ?>" 
                             alt="<?php echo app('translator')->get('image'); ?>" style="max-height:35px; opacity:0.9;">
                    </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>

    </div>
</div>
<?php /**PATH /home3/dannygue/apuestas.ballosbet.com/core/resources/views/templates/basic/partials/footer_bottom.blade.php ENDPATH**/ ?>