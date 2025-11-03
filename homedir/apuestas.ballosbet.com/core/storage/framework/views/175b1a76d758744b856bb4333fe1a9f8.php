
<?php $__env->startSection('content'); ?>
    <header class="header-primary">
        <div class="container-fluid">
            <?php echo $__env->make($activeTemplate . 'partials.header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        </div>
    </header>
    <main class="home-page">
        <?php echo $__env->make($activeTemplate . 'partials.category', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        
        <div class="sports-body">
            <div class="row g-3">
                <?php echo $__env->yieldContent('bet'); ?>
            </div>
        </div>

        <div class="betslip">
            <div class="betslip-header">
                <div class="list-group bet-type justify-content-center">
                    <label for="mybets-btn" class="bet-type__btn">
                        <input id="mybets-btn" type="radio" name="bet-type" checked>
                        <span><?php echo app('translator')->get('Mis apuestas'); ?></span>
                    </label>
                </div>
            </div>

            <div class="mybet-container betslip-inner">
                <?php echo $__env->make($activeTemplate . 'partials.my_bets', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            </div>
        </div>

        <?php echo $__env->make($activeTemplate . 'partials.mobile_menu', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    </main>

    
    <div class="col-12">
        <div class="footer footer--light">
            <?php echo $__env->make($activeTemplate . 'partials.footer_top', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        </div>
    </div>
    <div class="col-12">
        <div class="footer-bottom">
            <div class="container-fluid">
                <?php echo $__env->make($activeTemplate . 'partials.footer_bottom', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>



<?php echo $__env->make($activeTemplate . 'layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home3/dannygue/apuestas.ballosbet.com/core/resources/views/templates/basic/layouts/bet.blade.php ENDPATH**/ ?>