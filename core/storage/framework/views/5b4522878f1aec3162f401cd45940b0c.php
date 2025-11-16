<header class="header-primary user-header-primary">
    <div class="container">
        <div class="row g-0 align-items-center">
            <div class="header-fluid-custom-parent">
                <a class="logo" href="<?php echo e(route('home')); ?>">
                    <img class="img-fluid logo__is" src="<?php echo e(siteLogo()); ?>" alt="<?php echo app('translator')->get('logo'); ?>">
                </a>

                <nav class="primary-menu-container justify-content-end">
                    <ul class="list list--row primary-menu justify-content-end align-items-center right-side-nav gap-3 gap-sm-4">
                        <li class="d-none d-lg-block">
                            <a class="btn btn--signup" href="<?php echo e(route('home')); ?>">
                                <?php echo app('translator')->get('Bet Now'); ?>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</header>

<?php /**PATH /home3/dannygue/apuestas.ballosbet.com/core/resources/views/templates/basic/partials/user_header.blade.php ENDPATH**/ ?>