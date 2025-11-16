<?php $__env->startSection('master'); ?>
    <div class="card mb-4">
        <div class="card-body">
            <h4 class="mt-0 mb-2"><?php echo e($user->fullname); ?></h4>

            <ul class="list-group d-flex flex-column flex-md-row flex-wrap gap-3 justify-content-between">
                <li class="list-group-item d-flex flex-column border-0 p-0">
                    <small class="text-muted"><?php echo app('translator')->get('Nombre de usuario'); ?></small>
                    <span class="fw-semibold lh-1"> <?php echo e($user->username); ?></span>
                </li>
                <li class="list-group-item d-flex flex-column border-0 p-0">
                    <small class="text-muted"><?php echo app('translator')->get('Correo'); ?></small>
                    <span class="fw-semibold lh-1"> <?php echo e($user->email); ?></span>
                </li>
                <li class="list-group-item d-flex flex-column border-0 p-0">
                    <small class="text-muted"><?php echo app('translator')->get('Celular'); ?></small>
                    <span class="fw-semibold lh-1"> <?php echo e($user->mobile); ?></span>
                </li>

                <li class="list-group-item d-flex flex-column border-0 p-0">
                    <small class="text-muted"><?php echo app('translator')->get('País'); ?></small>
                    <span class="fw-semibold lh-1"> <?php echo e($user->country_name); ?></span>
                </li>

                <li class="list-group-item d-flex flex-column border-0 p-0">
                    <small class="text-muted"><?php echo app('translator')->get('KYC'); ?></small>
                    <?php if($user->kv): ?>
                        <span class="fw-semibold lh-1 text--success"> <i class="la la-check-circle"></i> <?php echo app('translator')->get('Verificado'); ?></span>
                    <?php else: ?>
                        <span class="fw-semibold lh-1 text--danger"> <i class="la la-times-circle"></i> <?php echo app('translator')->get('Sin Verificar'); ?></span>
                    <?php endif; ?>
                </li>
            </ul>

        </div>
    </div>


    <div class="mb-3">
        <h5 class="m-0"><?php echo app('translator')->get('Actualiza tu perfil'); ?></h5>
        <small class="text-muted">
            <?php echo app('translator')->get('Mantén tu información actualizada para garantizar una comunicación fluida y una gestión eficaz de tu cuenta. Revisa y actualiza tus datos a continuación.'); ?>
        </small>
    </div>

    <form class="register" method="post" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>
        <div class="card custom--card">
            <div class="card-body">
               <h6 class="m-0 mb-2"><?php echo app('translator')->get('Información Persolnal'); ?></h6>
                <div class="row">
                    <div class="form-group col-sm-6">
                        <label class="form-label"><?php echo app('translator')->get('First Name'); ?></label>
                        <input type="text" class="form-control form--control" name="firstname" value="<?php echo e($user->firstname); ?>" required>
                    </div>
                    <div class="form-group col-sm-6">
                        <label class="form-label"><?php echo app('translator')->get('Last Name'); ?></label>
                        <input type="text" class="form-control form--control" name="lastname" value="<?php echo e($user->lastname); ?>" required>
                    </div>
                </div>

               <h6 class="mt-3 mb-2"><?php echo app('translator')->get('Información de contacto'); ?></h6>
                <div class="row">
                    <div class="form-group col-sm-6">
                        <label class="form-label"><?php echo app('translator')->get('State'); ?> <span class="text-muted">(<?php echo app('translator')->get('Optional'); ?>)</span></label>
                        <input type="text" class="form-control form--control" name="state" value="<?php echo e(@$user->state); ?>">
                    </div>

                    <div class="form-group col-sm-6">
                        <label class="form-label"><?php echo app('translator')->get('Zip Code'); ?> <span class="text-muted">(<?php echo app('translator')->get('Optional'); ?>)</span></label>
                        <input type="text" class="form-control form--control" name="zip" value="<?php echo e(@$user->zip); ?>">
                    </div>

                    <div class="form-group col-sm-6">
                        <label class="form-label"><?php echo app('translator')->get('City'); ?> <span class="text-muted">(<?php echo app('translator')->get('Optional'); ?>)</span></label>
                        <input type="text" class="form-control form--control" name="city" value="<?php echo e(@$user->city); ?>">
                    </div>


                    <div class="form-group col-sm-6">
                        <label class="form-label"><?php echo app('translator')->get('Address'); ?> <span class="text-muted">(<?php echo app('translator')->get('Optional'); ?>)</span></label>
                        <input type="text" class="form-control form--control" name="address" value="<?php echo e(@$user->address); ?>">
                    </div>


                </div>


            </div>
        </div>

        <button class="btn btn--base w-100 mt-3" type="submit"><?php echo app('translator')->get('Update Profile'); ?></button>
    </form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make($activeTemplate . 'layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home3/dannygue/apuestas.ballosbet.com/core/resources/views/templates/basic/user/profile_setting.blade.php ENDPATH**/ ?>