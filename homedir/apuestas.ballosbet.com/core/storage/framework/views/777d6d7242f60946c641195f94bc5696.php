<div class="ajax-preloader d-none">
    <i class="la la-spin la-circle-notch"></i>
</div>

<?php $__env->startPush('style'); ?>
    <style>
        .ajax-preloader {
            position: absolute;
            width: 100%;
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 2rem;
            z-index: 9;
            color: #2c2c2c;
        }
        .ajax-preloader::after {
            content: '';
            position: absolute;
            width: 100%;
            height: 100%;
            background-color: #0000000c;
        }
    </style>
<?php $__env->stopPush(); ?>
<?php /**PATH /home3/dannygue/apuestas.ballosbet.com/core/resources/views/components/ajax-preloader.blade.php ENDPATH**/ ?>