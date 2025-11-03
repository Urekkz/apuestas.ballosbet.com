<?php $__env->startSection('master'); ?>
    <div class="card custom--card">
        <div class="card-body">
            <form action="<?php echo e(route('user.withdraw.money')); ?>" method="post" class="withdraw-form disableSubmission">
                <?php echo csrf_field(); ?>
                <div class="gateway-card">
                    <div class="row justify-content-center gy-sm-4 gy-3">
                        <div class="col-lg-6">
                            <h5 class="card-title mb-3"><?php echo app('translator')->get('Choose Withdrawal Method'); ?></h5>
                            <div class="payment-system-list is-scrollable gateway-outcome-list">
                                <?php $__currentLoopData = $withdrawMethod; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <label for="<?php echo e(titleToKey($data->name)); ?>" class="payment-item gateway-outcome">
                                        <div class="payment-item__info">
                                            <span class="payment-item__check"></span>
                                            <span class="payment-item__name"><?php echo e(__($data->name)); ?></span>
                                        </div>
                                        <div class="payment-item__thumb">
                                            <img class="payment-item__thumb-img" src="<?php echo e(getImage(getFilePath('withdrawMethod') . '/' . $data->image)); ?>" alt="<?php echo app('translator')->get('payment-thumb'); ?>">
                                        </div>
                                        <input class="payment-item__radio gateway-input" id="<?php echo e(titleToKey($data->name)); ?>" hidden data-gateway='<?php echo json_encode($data, 15, 512) ?>' type="radio" name="method_code" value="<?php echo e($data->id); ?>" <?php if(old('method_code', $loop->first) == $data->id): echo 'checked'; endif; ?> data-min-amount="<?php echo e(showAmount($data->min_limit)); ?>" data-max-amount="<?php echo e(showAmount($data->max_limit)); ?>">
                                    </label>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="payment-system-list p-3">
                                <div class="deposit-info">
                                    <div class="deposit-info__title">
                                        <p class="text mb-0"><?php echo app('translator')->get('Monto'); ?></p>
                                    </div>
                                    <div class="deposit-info__input">
                                        <div class="deposit-info__input-group input-group">
                                            <span class="deposit-info__input-group-text"><?php echo e(gs('cur_sym')); ?></span>
                                            <input type="text" class="form-control form--control amount" name="amount" placeholder="<?php echo app('translator')->get('00.00'); ?>" value="<?php echo e(old('amount')); ?>" autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="deposit-info">
                                    <div class="deposit-info__title">
                                        <p class="text has-icon"> <?php echo app('translator')->get('Limite'); ?></p>
                                    </div>
                                    <div class="deposit-info__input">
                                        <p class="text"><span class="gateway-limit"><?php echo app('translator')->get('0.00'); ?></span> </p>
                                    </div>
                                </div>
                                <div class="deposit-info">
                                    <div class="deposit-info__title">
                                        <p class="text has-icon"><?php echo app('translator')->get('Cargo'); ?>
                                            <span data-bs-toggle="tooltip" title="<?php echo app('translator')->get('Processing charge for withdraw method'); ?>" class="proccessing-fee-info"><i class="las la-info-circle"></i> </span>
                                        </p>
                                    </div>
                                    <div class="deposit-info__input">
                                        <p class="text"><?php echo e(gs('cur_sym')); ?><span class="processing-fee"><?php echo app('translator')->get('0.00'); ?></span>
                                            <?php echo e(__(gs('cur_text'))); ?>

                                        </p>
                                    </div>
                                </div>

                                <div class="deposit-info total-amount pt-3">
                                    <div class="deposit-info__title">
                                        <p class="text"><?php echo app('translator')->get('Saldo a retirar'); ?></p>
                                    </div>
                                    <div class="deposit-info__input">
                                        <p class="text"><?php echo e(gs('cur_sym')); ?><span class="final-amount"><?php echo app('translator')->get('0.00'); ?></span>
                                            <?php echo e(__(gs('cur_text'))); ?></p>
                                    </div>
                                </div>

                                <div class="deposit-info gateway-conversion d-none total-amount pt-2">
                                    <div class="deposit-info__title">
                                        <p class="text"><?php echo app('translator')->get('Conversión'); ?>
                                        </p>
                                    </div>
                                    <div class="deposit-info__input">
                                        <p class="text"></p>
                                    </div>
                                </div>
                                <div class="deposit-info conversion-currency d-none total-amount pt-2">
                                    <div class="deposit-info__title">
                                        <p class="text">
                                            <?php echo app('translator')->get('In'); ?> <span class="gateway-currency"></span>
                                        </p>
                                    </div>
                                    <div class="deposit-info__input">
                                        <p class="text">
                                            <span class="in-currency"></span>
                                        </p>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn--base w-100" disabled>
                                    <?php echo app('translator')->get('Confirm Withdraw'); ?>
                                </button>
                                <div class="info-text pt-3">
                                    <p class="text"><?php echo app('translator')->get('Retira tus fondos de forma segura utilizando nuestro proceso altamente seguro y nuestros diversos métodos de retiro.'); ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('style'); ?>
    <style>
        .deposit-info__input-group .form--control {
            padding: 5px !important;
        }
    </style>
<?php $__env->stopPush(); ?>
<?php $__env->startPush('script'); ?>
    <script>
        "use strict";
        (function($) {

            var amount = parseFloat($('.amount').val() || 0);
            var gateway, minAmount, maxAmount;


            $('.amount').on('input', function(e) {
                amount = parseFloat($(this).val());
                if (!amount) {
                    amount = 0;
                }
                calculation();
            });

            $('.gateway-input').on('change', function(e) {
                gatewayChange();
            });

            function gatewayChange() {
                let gatewayElement = $('.gateway-input:checked');
                let methodCode = gatewayElement.val();

                gateway = gatewayElement.data('gateway');
                minAmount = gatewayElement.data('min-amount');
                maxAmount = gatewayElement.data('max-amount');

                let processingFeeInfo =
                    `${parseFloat(gateway.percent_charge).toFixed(2)}% with ${parseFloat(gateway.fixed_charge).toFixed(2)} <?php echo e(__(gs('cur_text'))); ?> charge for processing fees`
                $(".proccessing-fee-info").attr("data-bs-original-title", processingFeeInfo);

                calculation();
            }

            gatewayChange();


            function calculation() {
                if (!gateway) return;
                $(".gateway-limit").text(minAmount + " - " + maxAmount);

                let percentCharge = 0;
                let fixedCharge = 0;
                let totalPercentCharge = 0;

                if (amount) {
                    percentCharge = parseFloat(gateway.percent_charge);
                    fixedCharge = parseFloat(gateway.fixed_charge);
                    totalPercentCharge = parseFloat(amount / 100 * percentCharge);
                }

                let totalCharge = parseFloat(totalPercentCharge + fixedCharge);
                let totalAmount = parseFloat((amount || 0) - totalPercentCharge - fixedCharge);

                $(".final-amount").text(totalAmount.toFixed(2));
                $(".processing-fee").text(totalCharge.toFixed(2));
                $("input[name=currency]").val(gateway.currency);
                $(".gateway-currency").text(gateway.currency);

                if (amount < Number(gateway.min_limit) || amount > Number(gateway.max_limit)) {
                    $(".withdraw-form button[type=submit]").attr('disabled', true);
                } else {
                    $(".withdraw-form button[type=submit]").removeAttr('disabled');
                }

                if (gateway.currency != "<?php echo e(gs('cur_text')); ?>") {
                    $('.withdraw-form').addClass('adjust-height')
                    $(".gateway-conversion, .conversion-currency").removeClass('d-none');
                    $(".gateway-conversion").find('.deposit-info__input .text').html(
                        `1 <?php echo e(__(gs('cur_text'))); ?> = <span class="rate">${parseFloat(gateway.rate).toFixed(2)}</span>  <span class="method_currency">${gateway.currency}</span>`
                    );
                    $('.in-currency').text(parseFloat(totalAmount * gateway.rate).toFixed(2))
                } else {
                    $(".gateway-conversion, .conversion-currency").addClass('d-none');
                    $('.withdraw-form').removeClass('adjust-height')
                }
            }

            $('.gateway-input').change();
        })(jQuery);
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make($activeTemplate . 'layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home3/dannygue/apuestas.ballosbet.com/core/resources/views/templates/basic/user/withdraw/methods.blade.php ENDPATH**/ ?>