<div class="app-nav">
    <div class="container-fluid">
        <div class="row g-0">
            <div class="col-12">
                <ul class="app-nav__menu list list--row justify-content-between align-items-center">
                    <li>
                        <a class="app-nav__menu-link active" href="<?php echo e(route('home')); ?>">
                            <span class="app-nav__menu-icon">
                                <img src="<?php echo e(asset($activeTemplateTrue . 'images/bet-now.png')); ?>" alt="<?php echo app('translator')->get('image'); ?>">
                            </span>
                            <span class="app-nav__menu-text"> <?php echo app('translator')->get('Apuesta Ahora'); ?> </span>
                        </a>
                    </li>
                    <li>
                        <a class="app-nav__menu-link" href="<?php echo e(route('user.deposit.index')); ?>">
                            <span class="app-nav__menu-icon">
                                <img src="<?php echo e(asset($activeTemplateTrue . 'images/deposit.png')); ?>" alt="<?php echo app('translator')->get('image'); ?>">
                            </span>
                            <span class="app-nav__menu-text"> <?php echo app('translator')->get('Depositar'); ?> </span>
                        </a>
                    </li>

                    <li class="app-nav__menu-link-important-container">
                        <a class="app-nav__menu-link-important sidenav-toggler" href="javascript:void(0)">
                            <i class="fas fa-bars"></i>
                        </a>
                    </li>

                    <li>
                        <a class="app-nav__menu-link" href="<?php echo e(route('user.withdraw')); ?>">
                            <span class="app-nav__menu-icon">
                                <img src="<?php echo e(asset($activeTemplateTrue . 'images/withdraw.png')); ?>" alt="<?php echo app('translator')->get('image'); ?>">
                            </span>
                            <span class="app-nav__menu-text"> <?php echo app('translator')->get('Retirar'); ?> </span>
                        </a>
                    </li>

                    <li>
                        <a class="app-nav__menu-link" href="<?php echo e(route('user.bets.all')); ?>">
                            <span class="app-nav__menu-icon">
                                <img src="<?php echo e(asset($activeTemplateTrue . 'images/my_bets.png')); ?>" alt="<?php echo app('translator')->get('image'); ?>">
                            </span>
                            <span class="app-nav__menu-text"><?php echo app('translator')->get('Mis apuestas'); ?></span>
                        </a>
                    </li>

                </ul>
            </div>
        </div>
    </div>
</div>
<?php /**PATH /home3/dannygue/apuestas.ballosbet.com/core/resources/views/templates/basic/partials/dashboard_mobile_menu.blade.php ENDPATH**/ ?>