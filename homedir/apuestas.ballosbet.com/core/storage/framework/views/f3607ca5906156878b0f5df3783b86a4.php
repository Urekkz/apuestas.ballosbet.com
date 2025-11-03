<?php
    $banners = getContent('banner.element', false, null, true);
?>

<div class="banner-slider hero-slider mb-3">
    <?php $__currentLoopData = $banners; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $banner): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="banner_slide">
            <img class="banner_image" src="<?php echo e(frontendImage('banner', @$banner->data_values->image, '1610x250')); ?>">
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>

<?php if (! $__env->hasRenderedOnce('08c9826f-4a8b-4210-afd4-15ac4cd67faa')): $__env->markAsRenderedOnce('08c9826f-4a8b-4210-afd4-15ac4cd67faa');
$__env->startPush('script'); ?>
    <script>
        (function($) {
            "use strict";
            $(".banner-slider").stepCycle({
                autoAdvance: true,
                transitionTime: 1,
                displayTime: 5,
                transition: "zoomIn",
                easing: "linear",
                childSelector: false,
                ie8CheckSelector: ".ltie9",
                showNav: false,
                transitionBegin: function() {},
                transitionComplete: function() {},
            });

            function controlSliderHeight() {
                let width = $(".banner-slider")[0].clientWidth;
                let height = (width / 37) * 7;
                $(".banner-slider").css({
                    height: height,
                });

                $(".banner_image").css({
                    height: height,
                });
            }

            controlSliderHeight();

        })(jQuery);
    </script>
<?php $__env->stopPush(); endif; ?>

<?php /**PATH /home3/dannygue/apuestas.ballosbet.com/core/resources/views/templates/basic/partials/slider.blade.php ENDPATH**/ ?>