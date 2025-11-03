
<?php
    $text = Route::is('user.register') ? 'Register' : 'Login';
?>


<?php if(@gs('socialite_credentials')->linkedin->status || @gs('socialite_credentials')->facebook->status == Status::ENABLE || @gs('socialite_credentials')->google->status == Status::ENABLE): ?>
<div class="text-center py-3">
    <span><?php echo app('translator')->get('OR'); ?></span>
</div>
<?php endif; ?>

<?php if(@gs('socialite_credentials')->google->status == Status::ENABLE): ?>
<div class="mb-3 continue-google">
    <a href="<?php echo e(route('user.social.login', 'google')); ?>" class="btn w-100 social-login-btn">
        <span class="google-icon">
        <img src="<?php echo e(asset($activeTemplateTrue."images/google.svg")); ?>" alt="Google">
        </span> <?php echo app('translator')->get("$text with Google"); ?>
    </a>
</div>
<?php endif; ?>
<?php if(@gs('socialite_credentials')->facebook->status == Status::ENABLE): ?>
<div class="mb-3 continue-facebook">
    <a href="<?php echo e(route('user.social.login', 'facebook')); ?>" class="btn w-100 social-login-btn">
        <span class="facebook-icon">
        <img src="<?php echo e(asset($activeTemplateTrue."images/facebook.svg")); ?>" alt="Facebook">
        </span> <?php echo app('translator')->get("$text with Facebook"); ?>
    </a>
</div>
<?php endif; ?>
<?php if(@gs('socialite_credentials')->linkedin->status == Status::ENABLE): ?>


<div class="continue-facebook mb-3">
    <a href="<?php echo e(route('user.social.login', 'linkedin')); ?>" class="btn w-100 social-login-btn">
        <span class="facebook-icon">
        <img src="<?php echo e(asset($activeTemplateTrue."images/linkdin.svg")); ?>" alt="Linkedin">
        </span> <?php echo app('translator')->get("$text with Linkedin"); ?>
    </a>
</div>
<?php endif; ?>


<?php $__env->startPush('style'); ?>
<style>
    .social-login-btn{
        border: 1px solid #cbc4c4;
    }
    .social-login-btn:hover{
        border: 1px solid hsl(var(--base));
    }
</style>
<?php $__env->stopPush(); ?>
<?php /**PATH /home3/dannygue/apuestas.ballosbet.com/core/resources/views/templates/basic/partials/social_login.blade.php ENDPATH**/ ?>