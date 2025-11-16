<div class="dashboard-sidebar">
    <div class="widget-card widget-card--primary">
        <div class="widget-card__head">
            <span class="widget-card__id"> <i class="la la-user"></i> <?php echo e(auth()->user()->username); ?></span>
            <button class="btn widget-card__reload" id="reload" type="button">
                <i class="las la-sync"></i>
            </button>
        </div>
        <div class="widget-card__body">
            <h5 class="widget-card__balance"><?php echo e(showAmount(auth()->user()->balance)); ?></h5>
            <span class="widget-card__balance-text"><?php echo app('translator')->get('Saldo Actual'); ?></span>
            <div class="d-flex gap-2">
                <a class="btn widget-card__withdraw flex-shrink-0 flex-grow-1" href="<?php echo e(route('user.withdraw')); ?>"> <i class="fa fa-minus"></i> <?php echo app('translator')->get('Retirar'); ?></a>
                <a class="btn widget-card__deposit flex-shrink-0 flex-grow-1" href="<?php echo e(route('user.deposit.index')); ?>"> <i class="fa fa-plus"></i> <?php echo app('translator')->get('Depositar'); ?></a>
            </div>
        </div>
    </div>


    <div class="dashboard-menu overflow-hidden" style="color: white;">
        <div class="dashboard-menu__body">
            <ul class="list dashboard-menu__list">
                <li>
                    <a class="dashboard-menu__link <?php echo e(menuActive('user.home')); ?>" href="<?php echo e(route('user.home')); ?>">
                        <span class="dashboard-menu__icon">
                            <i class="las la-home"></i>
                        </span>
                        <span class="dashboard-menu__text"> <?php echo app('translator')->get('Tablero'); ?> </span>
                    </a>
                </li>

                <li>
                    <a class="dashboard-menu__link <?php echo e(menuActive('user.bets.*')); ?>" href="<?php echo e(route('user.bets.all')); ?>">
                        <span class="dashboard-menu__icon">
                            <i class="las la-list"></i>
                        </span>
                        <span class="dashboard-menu__text"> <?php echo app('translator')->get('Mis Apuestas'); ?> </span>
                    </a>
                </li>

                <li>
                    <a class="dashboard-menu__link <?php echo e(menuActive('user.deposit.history')); ?>" href="<?php echo e(route('user.deposit.history')); ?>">
                        <span class="dashboard-menu__icon">
                            <i class="las la-wallet"></i>
                        </span>
                        <span class="dashboard-menu__text"> <?php echo app('translator')->get('Historial de Deposito'); ?> </span>
                    </a>
                </li>

                <li>
                    <a class="dashboard-menu__link <?php echo e(menuActive('user.withdraw.history')); ?>" href="<?php echo e(route('user.withdraw.history')); ?>">
                        <span class="dashboard-menu__icon">
                            <i class="las la-list"></i>
                        </span>
                        <span class="dashboard-menu__text"> <?php echo app('translator')->get('Historial de Retiro'); ?> </span>
                    </a>
                </li>

                <?php if(gs('referral_program')): ?>
                    <li>
                        <a class="dashboard-menu__link <?php echo e(menuActive('user.referral.commissions')); ?>" href="<?php echo e(route('user.referral.commissions')); ?>">
                            <span class="dashboard-menu__icon">
                                <i class="las la-sitemap"></i>
                            </span>
                            <span class="dashboard-menu__text"> <?php echo app('translator')->get('Comisiones por Referidos'); ?> </span>
                        </a>
                    </li>
                <?php endif; ?>

                <li>
                    <a class="dashboard-menu__link <?php echo e(menuActive('user.transactions')); ?>" href="<?php echo e(route('user.transactions')); ?>">
                        <span class="dashboard-menu__icon">
                            <i class="las la-exchange-alt"></i>
                        </span>
                        <span class="dashboard-menu__text"> <?php echo app('translator')->get('Transacciones'); ?> </span>
                    </a>
                </li>

                <li>
                    <a class="dashboard-menu__link <?php echo e(menuActive('ticket.*')); ?>" href="<?php echo e(route('ticket.index')); ?>">
                        <span class="dashboard-menu__icon">
                            <i class="las la-ticket-alt"></i>
                        </span>
                        <span class="dashboard-menu__text"><?php echo app('translator')->get('Boletos de Soporte'); ?></span>
                    </a>
                </li>

                <li>
                    <a class="dashboard-menu__link <?php echo e(menuActive('user.profile.setting')); ?>" href="<?php echo e(route('user.profile.setting')); ?>">
                        <span class="dashboard-menu__icon">
                            <i class="las la-user-edit"></i>
                        </span>
                        <?php echo app('translator')->get('Perfil'); ?>
                    </a>
                </li>

                <li>
                    <a class="dashboard-menu__link <?php echo e(menuActive('user.change.password')); ?>" href="<?php echo e(route('user.change.password')); ?>">
                        <span class="dashboard-menu__icon">
                            <i class="las la-lock"></i>
                        </span>
                        <?php echo app('translator')->get('Cambiar Contrasena'); ?>
                    </a>
                </li>

                <li>
                    <a class="dashboard-menu__link <?php echo e(menuActive('user.twofactor')); ?>" href="<?php echo e(route('user.twofactor')); ?>">
                        <span class="dashboard-menu__icon">
                            <i class="las la-user-shield"></i>
                        </span>
                        <?php echo app('translator')->get('2FA Verificacion'); ?>
                    </a>
                </li>


                <li>
                    <a class="dashboard-menu__link" href="<?php echo e(route('user.logout')); ?>">
                        <span class="dashboard-menu__icon">
                            <i class="las la-sign-out-alt"></i>
                        </span>
                        <span class="dashboard-menu__text"> <?php echo app('translator')->get('Cerrar Sesion'); ?> </span>
                    </a>
                </li>
            </ul>
        </div>

    </div>
</div>

<?php $__env->startPush('script'); ?>
    <script>
        (function($) {
            "use strict";

            $('#reload').on('click', function() {
                location.reload();
            });

            $('.dashboard-sidebar__nav-toggle-btn').on('click', function() {
                $('.body-overlay').toggleClass('active')
            });

            $('.dashboard-menu__head-close').on('click', function() {
                $('body').removeClass('.dashboard-menu-open')
                $('.body-overlay').removeClass('active')
            });

            $('.body-overlay').on('click', function() {
                $('.dashboard-menu__head-close').trigger('click')
                $('.body-overlay').removeClass('active')
            });
        })(jQuery);
    </script>
<?php $__env->stopPush(); ?>
<?php /**PATH /home3/dannygue/apuestas.ballosbet.com/core/resources/views/templates/basic/partials/dashboard_sidebar.blade.php ENDPATH**/ ?>