<div class="header-fluid-custom-parent">

    <div class="logo">
        <a href="https://ballosbet.com/">
            <img class="img-fluid" src="<?php echo e(siteLogo()); ?>" alt="<?php echo app('translator')->get('logo'); ?>">
        </a>
    </div>

    <nav class="primary-menu-container">

        
        <ul class="align-items-center justify-content-start gap-3 gap-lg-4 mb-0 p-0 list-unstyled d-none d-lg-flex main-nav-menu">
            <li>
                <a href="https://apuestas.ballosbet.com/" class="nav-link-item <?php echo e(request()->is('/') ? 'active' : ''); ?>">
                    <?php echo app('translator')->get('INICIO'); ?>
                </a>
            </li>
            <li>
                <a href="https://ballosbet.com/eventos" class="nav-link-item <?php echo e(request()->is('eventos*') ? 'active' : ''); ?>">
                    <?php echo app('translator')->get('EVENTOS'); ?>
                </a>
            </li>
            <li>
                <a href="https://ballosbet.com/resultados-2" class="nav-link-item <?php echo e(request()->is('resultados*') ? 'active' : ''); ?>">
                    <?php echo app('translator')->get('RESULTADOS'); ?>
                </a>
            </li>
            <li>
                <a href="https://ballosbet.com/videoteca" class="nav-link-item <?php echo e(request()->is('videoteca*') ? 'active' : ''); ?>">
                    <?php echo app('translator')->get('VIDEOTECA'); ?>
                </a>
            </li>
            <li>
                <a href="https://ballosbet.com/membresias" class="nav-link-item <?php echo e(request()->is('membresias*') ? 'active' : ''); ?>">
                    <?php echo app('translator')->get('MEMBRESÍAS'); ?>
                </a>
            </li>
        </ul>

        <ul class="list list--row primary-menu justify-content-end align-items-center right-side-nav gap-3 gap-sm-4">


            <li class="d-flex align-items-center gap-2">
                <div class="d-flex align-items-center gap-1">
                    <img class="flag"
                         src="https://apuestas.ballosbet.com/assets/images/language/68fb99650de3d1761319269.jpg"
                         alt="Perú"
                         style="width: 20px; height: 14px; border-radius: 2px;">
                    <span class="text-white" style="font-size: 14px;">ES</span>
                </div>
            </li>

            
            <li class="d-flex align-items-center">
                <?php if(auth()->guard()->check()): ?>
                    <div class="app-nav__menu-text text-white ps-2"><?php echo app('translator')->get('Saldo'); ?>: <strong id="mobileBalance"><?php echo e(showAmount(auth()->user()->balance)); ?></strong></div>
                <?php endif; ?>
            </li>

            
            <li class="d-none d-lg-block">
                <?php if(auth()->check() && !request()->routeIs('user.*')): ?>
                    <div class="dropdown-center user-profile-dropdown">
                        <button class="dropdown-toggle user-profile-btn" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="la la-user-circle"></i> <?php echo e(auth()->user()->username); ?>

                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="<?php echo e(route('user.profile.setting')); ?>"><?php echo app('translator')->get('My Profile'); ?></a></li>
                            <li><a class="dropdown-item" href="<?php echo e(route('user.deposit.index')); ?>"><?php echo app('translator')->get('Deposit Money'); ?></a></li>
                            <li><a class="dropdown-item" href="<?php echo e(route('user.logout')); ?>"><?php echo app('translator')->get('Logout'); ?></a></li>
                        </ul>
                    </div>
                <?php else: ?>
                    <?php if(Route::is('user.login')): ?>
                        <a class="btn btn--signup" href="<?php echo e(route('user.register')); ?>"> <?php echo app('translator')->get('Ingresar'); ?> </a>
                    <?php else: ?>
                        <?php if(in_array(request()->route()->getName(), ['home', 'category.games', 'game.markets'])): ?>
                            <button class="btn btn--signup" data-bs-toggle="modal" data-bs-target="#loginModal" type="button">
                                <i class="la la-sign-in"></i> <?php echo app('translator')->get('Login'); ?>
                            </button>
                        <?php else: ?>
                            <a class="btn btn--signup" href="<?php echo e(route('user.login')); ?>">
                                <i class="la la-sign-in"></i> <?php echo app('translator')->get('Salir'); ?>
                            </a>
                        <?php endif; ?>
                    <?php endif; ?>
                <?php endif; ?>
            </li>
        </ul>
    </nav>
</div>

<?php
    $loginContent = getContent('login.content', true);
?>

<?php if(in_array(request()->route()->getName(), ['home', 'category.games', 'game.markets'])): ?>
    <div class="modal fade login-modal" id="loginModal" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body p-3 p-sm-5">
                    <span class="close" data-bs-dismiss="modal" type="button" aria-label="Close">
                        <i class="las la-times"></i>
                    </span>
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h4 class="mt-0"><?php echo e(__(@$loginContent->data_values->heading)); ?></h4>
                    </div>
                    <?php echo $__env->make($activeTemplate . 'partials.login', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

<?php /**PATH /home3/dannygue/apuestas.ballosbet.com/core/resources/views/templates/basic/partials/header.blade.php ENDPATH**/ ?>