<div id="cronModal" class="modal fade cron-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h5 class="modal-title" id="exampleModalLongTitle"><i class="las la-clock text--primary"></i>
                        <?php echo app('translator')->get('Cron Job Commands'); ?>
                    </h5>
                    <a href="<?php echo e(route('admin.cron.index')); ?>" class="text--primary text-decoration-underline"><?php echo app('translator')->get('View Detailed Instruction'); ?></a>
                </div>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="las la-times"></i>
                </button>
            </div>
            <div class="modal-body px-0">

                <div class="alert alert-info p-3 m-3 mt-0" role="alert">
                    <p>
                        <?php echo app('translator')->get('To automate the process of fetching Leagues, Games and Odds you need to set up the API key & configuration'); ?> <?php echo app('translator')->get('from the'); ?> <a href="<?php echo e(route('admin.setting.api')); ?>" class="text-decoration-underline"> <?php echo app('translator')->get('Odds API Setting'); ?></a>.
                    </p>
                </div>

                <div class="list-group list-group-flush">
                    <?php $__currentLoopData = App\Models\CronJob::get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cron): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="list-group-item">
                            <label class="fw-semibold"><?php echo e($cron->name); ?></label>
                            <div class="input-group mb-1">
                                <input type="text" class="form-control form-control-lg" value="<?php echo e(route('home') . '/' . $cron->url); ?>" readonly>
                                <button type="button" class="input-group-text copy-text-btn copyCronPath text--primary">
                                    <i class="la la-copy"></i> <span class="copyText text--primary"><?php echo app('translator')->get('Copy'); ?></span>
                                </button>
                            </div>

                            <small><span><?php echo app('translator')->get('Interval Recommendation'); ?></span>: <span class="fw-semibold text--info"><?php echo e($cron->interval_info); ?></span></small>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $__env->startPush('style'); ?>
    <style>
        .form-control[readonly],
        .form-control[disabled] {
            background-color: rgba(246, 246, 246, 1);
            pointer-events: none;
            border: none;
            border-radius: 5px !important;
        }

        .copy-text-btn {
            position: absolute;
            top: 50%;
            right: 0px;
            background: transparent;
            border: none;
            font-weight: 600;
            transform: translateY(-50%);
            font-size: 14px;
            z-index: 99;
            height: 100%;
            background: #f6f6f6;
        }

        .copy-text-btn i {
            margin-right: 5px;
        }

        .form-control:focus {
            box-shadow: none;
        }


    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('script'); ?>
    <script>
        (function($) {
            "use strict";

            $(document).on('click', '.copyCronPath', function() {
                var copyCronCommand = $(this).siblings('input')[0];

                copyCronCommand.select();
                copyCronCommand.setSelectionRange(0, 99999);

                document.execCommand('copy');
                $(this).find('.copyText').text('Copied');
                setTimeout(() => {
                    $(this).find('.copyText').text('Copy');
                }, 2000);
            });
        })(jQuery)
    </script>
<?php $__env->stopPush(); ?>
<?php /**PATH /home3/dannygue/apuestas.ballosbet.com/core/resources/views/admin/partials/cron_modal.blade.php ENDPATH**/ ?>