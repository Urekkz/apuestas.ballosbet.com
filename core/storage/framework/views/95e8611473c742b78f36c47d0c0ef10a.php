<?php $__env->startSection('master'); ?>
    <div class="card custom--card">
        <div class="card-body">
            <div class="mb-3">
                <h5 class="card-title"><?php echo app('translator')->get('Actualiza tu contraseña'); ?></h5>
                <small class="text-muted"><?php echo app('translator')->get('Actualiza tu contraseña para mantener tu cuenta segura. Introduce tu contraseña actual y elige una nueva a continuación.'); ?></small>
            </div>
            <form method="post">
                <?php echo csrf_field(); ?>
                <div class="form-group">
                    <label class="form-label"><?php echo app('translator')->get('Contraseña actual'); ?></label>
                    <input type="password" class="form-control form--control" name="current_password" required autocomplete="current-password">
                </div>
                <div class="form-group">
                    <label class="form-label"><?php echo app('translator')->get('Nueva Contraseña'); ?></label>
                    <input type="password" class="form-control form--control <?php if(gs('secure_password')): ?> secure-password <?php endif; ?>" name="password" required autocomplete="current-password">
                </div>
                <div class="form-group">
                    <label class="form-label"><?php echo app('translator')->get('Confirmar Contraseña'); ?></label>
                    <input type="password" class="form-control form--control" name="password_confirmation" required autocomplete="current-password">
                </div>
                <div class="text-end">
                    <button type="submit" class="btn btn--base w-100"><?php echo app('translator')->get('Enviar'); ?></button>
                </div>
            </form>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php if(gs('secure_password')): ?>
    <?php $__env->startPush('script-lib'); ?>
        <script src="<?php echo e(asset('assets/global/js/secure_password.js')); ?>"></script>
    <?php $__env->stopPush(); ?>
<?php endif; ?>

<?php echo $__env->make($activeTemplate . 'layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home3/dannygue/apuestas.ballosbet.com/core/resources/views/templates/basic/user/password.blade.php ENDPATH**/ ?>