
<?php $__env->startSection('master'); ?>
    <div class="row gy-4">
        <div class="col-12">
            <div class="table-responsive">
                <table class="table-responsive--md custom--table table">
                    <thead>
                        <tr>
                            <th><?php echo app('translator')->get('TRX No.'); ?></th>
                            <th><?php echo app('translator')->get('Monto'); ?></th>
                            <th><?php echo app('translator')->get('Cargo'); ?></th>
                            <th><?php echo app('translator')->get('Estado'); ?></th>
                            <th><?php echo app('translator')->get('Detalles'); ?></th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $withdrawals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $withdraw): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td>
                                    #<?php echo e($withdraw->trx); ?>

                                    <br>
                                    <small class="text-muted"><em> <i class="la la-clock"></i> <?php echo e(showDateTime($withdraw->created_at)); ?></small>
                                </td>

                                <td><?php echo e(showAmount($withdraw->amount)); ?></td>

                                <td><?php echo e(showAmount($withdraw->charge)); ?></td>

                                <td><?php echo $withdraw->statusBadge ?></td>

                                <?php
                                    $details = [
                                        ['name' => 'TRX No.', 'type' => 'text', 'value' => '#' . $withdraw->trx],
                                        ['name' => 'Requested At', 'type' => 'text', 'value' => showDateTime($withdraw->created_at, 'd M Y, h:i A')],
                                        ['name' => 'Amount', 'type' => 'text', 'value' => '<h4 class="m-0">' . showAmount($withdraw->amount) . '</h4>'],
                                        ['name' => 'Processing Charge', 'type' => 'text', 'value' => showAmount($withdraw->charge)],
                                        ['name' => 'After Charge', 'type' => 'text', 'value' => '<h6 class="m-0">' . showAmount($withdraw->amount - $withdraw->charge) . '</h6>'],
                                        ['name' => 'Rate', 'type' => 'text', 'value' => showAmount($withdraw->rate, currencyFormat: false) . ' ' . __($withdraw->currency)],
                                        ['name' => 'Receivable Amount', 'type' => 'text', 'value' => '<h4 class="m-0 text--success">' . showAmount($withdraw->final_amount, currencyFormat: false) . ' ' . __($withdraw->currency) . '</h4>'],
                                        ['name' => 'Status', 'type' => 'text', 'value' => $withdraw->statusBadge],
                                        ['name' => 'Payment Gateway', 'type' => 'text', 'value' => __(@$withdraw->method->name)],
                                    ];

                                    // Convertir withdraw_information en array, por si viene como objeto
                                    $withdrawInfo = $withdraw->withdraw_information;
                                    if (is_object($withdrawInfo)) {
                                        $withdrawInfo = (array) $withdrawInfo;
                                    }

                                    if (is_array($withdrawInfo)) {
                                        foreach ($withdrawInfo as $key => $info) {
                                            // Si viene como objeto dentro del array
                                            if (is_object($info)) {
                                                $info = (array) $info;
                                            }

                                            $details[] = $info;

                                            // Si el campo es tipo "file", generar el enlace correcto
                                            if (isset($info['type']) && $info['type'] == 'file') {
                                                $details[array_key_last($details)]['value'] = route('user.download.attachment', encrypt(getFilePath('verify') . '/' . $info['value']));
                                            }
                                        }
                                    }
                                ?>

                                <td>
                                    <button class="btn btn--sm btn-outline--base detailBtn"
                                        data-user_data="<?php echo e(json_encode($details)); ?>"
                                        <?php if($withdraw->status == Status::PAYMENT_REJECT): ?>
                                            data-admin_feedback="<?php echo e($withdraw->admin_feedback); ?>"
                                        <?php endif; ?>>
                                        <i class="las la-desktop"></i> <?php echo app('translator')->get('Ver'); ?>
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td class="text-muted text-center" colspan="100%"><?php echo app('translator')->get('No se encontraron retiros'); ?></td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <div class="mt-4 align-items-center pagination-wrapper">
                <?php echo e($withdrawals->links()); ?>

            </div>
        </div>
    </div>

    <div id="detailModal" class="modal custom--modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <h5 class="modal-title mb-2"><?php echo app('translator')->get('Detalles de retiro'); ?></h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>

                    <ul class="list-group list-group-flush userData mb-2"></ul>
                    <div class="feedback p-3 rounded d-none"></div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('breadcrumb-items'); ?>
    <?php if (isset($component)) { $__componentOriginale48b4598ffc2f41a085f001458a956d1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale48b4598ffc2f41a085f001458a956d1 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.search-form','data' => ['btn' => 'btn-light','placeholder' => 'TRX No.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('search-form'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['btn' => 'btn-light','placeholder' => 'TRX No.']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale48b4598ffc2f41a085f001458a956d1)): ?>
<?php $attributes = $__attributesOriginale48b4598ffc2f41a085f001458a956d1; ?>
<?php unset($__attributesOriginale48b4598ffc2f41a085f001458a956d1); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale48b4598ffc2f41a085f001458a956d1)): ?>
<?php $component = $__componentOriginale48b4598ffc2f41a085f001458a956d1; ?>
<?php unset($__componentOriginale48b4598ffc2f41a085f001458a956d1); ?>
<?php endif; ?>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('style'); ?>
    <style>
        .input-group-text {
            border-radius: 0 5px 5px 0 !important;
        }

        .feedback {
            background: hsl(var(--danger) / 0.2);
        }
    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('script'); ?>
    <script>
        (function($) {
            "use strict";

            $('.detailBtn').on('click', function() {
                var modal = $('#detailModal');
                var userData = $(this).data('user_data');
                var html = '';

                if (userData) {
                    userData.forEach(element => {
                        if (element.type != 'file') {
                            html += `<li class="list-group-item px-0 py-2 d-flex flex-wrap align-items-center justify-content-between">
                                        <small class="deposit-card__title">${element.name}</small>
                                        <small class="text-end">${element.value}</small>
                                    </li>`;
                        }
                    });
                }

                modal.find('.userData').html(html);

                if ($(this).data('admin_feedback') != undefined) {
                    modal.find('.feedback').removeClass('d-none').html(`<p>${$(this).data('admin_feedback')}</p>`);
                } else {
                    modal.find('.feedback').empty().addClass('d-none');
                }

                modal.modal('show');
            });
        })(jQuery);
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make($activeTemplate . 'layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home3/dannygue/apuestas.ballosbet.com/core/resources/views/templates/basic/user/withdraw/log.blade.php ENDPATH**/ ?>