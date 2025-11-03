
<?php $__env->startSection('master'); ?>
    <div class="row gy-4">
        <div class="col-md-12">
            <div class="row gy-4">
                <div class="col-xl-8">
                    <div class="d-flex gap-2 justify-content-between align-items-center mb-3">
                        <h5 class="m-0"><?php echo app('translator')->get('Tabla de apuestas'); ?></h5>
                        <input class="form-control w-auto bg-white" name="date" type="text" value="<?php echo e(request()->date); ?>" autocomplete="off" placeholder="<?php echo app('translator')->get('Start Date - End Date'); ?>">
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <div id="betChart"></div>
                        </div>
                    </div>

                    <?php if(gs('referral_program')): ?>
                        <div class="mt-4">
                            <h5 class="m-0">
                                <?php echo app('translator')->get('Refiere a tu amigo'); ?>
                            </h5>

                            <div class="qr-code text--base mb-1 mt-3">
                                <div class="qr-code-copy-form" data-copy=true>
                                    <input id="qr-code-text" type="text" value="<?php echo e(route('home')); ?>?reference=<?php echo e($user->referral_code); ?>" readonly>
                                    <button class="text-copy-btn copy-btn lh-1 text-white" data-bs-toggle="tooltip" data-bs-original-title="<?php echo app('translator')->get('Copy to clipboard'); ?>" type="button"><?php echo app('translator')->get('Copiar'); ?></button>
                                </div>
                            </div>

                            <small class="lh-1 text-muted">
                                <i class="la la-info-circle"></i>
                                <?php echo app('translator')->get('¡Gana una bonificación por recomendar a tus amigos! Solo tienes que compartir tu enlace de referido con ellos para empezar.'); ?>
                            </small>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="col-xl-4">
                    <h5 class="mt-0"><?php echo app('translator')->get('Últimas Transacciones'); ?></h5>
                    <div class="card">
                        <div class="card-body">
                            <ul class="list-group list-group-flush">
                                <?php $__empty_1 = true; $__currentLoopData = $transactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $trx): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <li class="list-group-item px-0 py-2">
                                        <div class="d-flex justify-content-between flex-wrap ">
                                            <div class="d-flex flex-column">
                                                <small class="fw-semibold">#<?php echo e($trx->trx); ?></small>
                                                <small class="text-muted lh-1"><em><?php echo e(showDateTime($trx->created_at)); ?></em></small>
                                            </div>
                                            <span class="<?php if($trx->trx_type == '+'): ?> text--success <?php else: ?> text--danger <?php endif; ?>">
                                                <?php echo e($trx->trx_type); ?> <?php echo e(showAmount($trx->amount)); ?>

                                            </span>
                                        </div>
                                        <p class="sm-text text--base mb-0 mt-1"> <?php echo e($trx->details); ?></p>
                                    </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <li class="list-group-item text-center px-0">
                                        <small class="text-muted"><?php echo app('translator')->get('Aún no hay transacciones'); ?></small>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('style-lib'); ?>
    <link href="<?php echo e(asset('assets/global/css/daterangepicker.css')); ?>" rel="stylesheet">
<?php $__env->stopPush(); ?>

<?php $__env->startPush('script-lib'); ?>
    <script src="<?php echo e(asset('assets/global/js/apexcharts.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/global/js/moment.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/global/js/daterangepicker.min.js')); ?>"></script>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('script'); ?>
    <script>
        (function($) {
            "use strict";

            $('.copyBtn').on('click', function() {
                var copyText = document.getElementById("textToCopy");
                copyText.select();
                copyText.setSelectionRange(0, 99999);
                document.execCommand("copy");
                iziToast.success({
                    message: "Copied: " + copyText.value,
                    position: "topRight"
                });
            });

            var startsOne;
            var endOne;
            let startDate;
            let endDate;

            <?php if(@$request->starts_from_start): ?>
                startsOne = moment(`<?php echo e(@$request->startDate); ?>`);
            <?php endif; ?>

            <?php if(@$request->starts_from_end): ?>
                endOne = moment(`<?php echo e(@$request->endDate); ?>`);
            <?php endif; ?>

            function intDateRangePicker(element, start, end) {
                $(element).daterangepicker({
                    startDate: start,
                    endDate: end,
                    ranges: {
                        'Clear': ['', ''],
                        'Today': [moment(), moment()],
                        'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                        'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                        'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                        'This Month': [moment().startOf('month'), moment().endOf('month')],
                        'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
                    },
                    applyButtonClasses: 'btn btn--base',
                });

                $(element).on('apply.daterangepicker', function(ev, picker) {
                    if (!(picker.startDate.isValid() && picker.endDate.isValid())) {
                        $(element).val('');
                    }
                    window.location = appendQueryParameter('date', this.value);
                });
            }

            intDateRangePicker('[name=date]', startsOne, endOne);

            var betOutcomes = {
                series: [{
                    name: 'Total Stake',
                    data: [
                        <?php $__currentLoopData = $report['bet_stake_amount']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stakeAmount): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            "<?php echo e($stakeAmount); ?>",
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    ]
                }, {
                    name: 'Total Return',
                    data: [
                        <?php $__currentLoopData = $report['bet_return_amount']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $returnAmount): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            "<?php echo e($returnAmount); ?>",
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    ]
                }],
                chart: {
                    type: 'bar',
                    height: 415,
                    toolbar: {
                        show: true,
                        tools: {
                            download: false
                        }
                    }
                },
                grid: {
                    xaxis: {
                        lines: {
                            show: false
                        }
                    },
                    yaxis: {
                        lines: {
                            show: false
                        }
                    },
                },
                plotOutcomes: {
                    bar: {
                        horizontal: false,
                        columnWidth: '55%',
                        endingShape: 'rounded'
                    },
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    show: true,
                    width: 2,
                    colors: ['transparent']
                },
                xaxis: {
                    categories: [
                        <?php $__currentLoopData = $report['bet_dates']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $date): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            "<?php echo e($date); ?>",
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    ],
                },
                fill: {
                    opacity: 1
                },
                tooltip: {
                    y: {
                        formatter: function(val) {
                            return `${val} <?php echo e(gs('cur_text')); ?>`
                        }
                    }
                },
            };
            var chart = new ApexCharts(document.querySelector("#betChart"), betOutcomes);
            chart.render();
        })(jQuery);
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make($activeTemplate . 'layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home3/dannygue/apuestas.ballosbet.com/core/resources/views/templates/basic/user/dashboard.blade.php ENDPATH**/ ?>