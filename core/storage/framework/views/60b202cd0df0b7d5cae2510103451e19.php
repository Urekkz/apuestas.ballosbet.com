

<?php $__env->startSection('panel'); ?>
    <div class="row">
        <div class="col-lg-12">
            <div class="card b-radius--10">
                <div class="card-body p-0">
                    <div class="table-responsive--md table-responsive">
                        <table class="table--light style--two table">
                            <thead>
                                <tr>
                                    <th><?php echo app('translator')->get('Bet ID'); ?></th>
                                    <th><?php echo app('translator')->get('Bet Placed At'); ?></th>
                                    <th><?php echo app('translator')->get('User'); ?></th>
                                    <th><?php echo app('translator')->get('Type'); ?></th>
                                    <th><?php echo app('translator')->get('Stake Amount'); ?></th>
                                    <th><?php echo app('translator')->get('Return'); ?></th>
                                    <th><?php echo app('translator')->get('Status'); ?></th>
                                    <th><?php echo app('translator')->get('Action'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $bets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bet): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td>
                                            <span><?php echo e(__($bet->bet_number)); ?></span>
                                        </td>

                                        <td>
                                            <?php echo e(showDateTime($bet->created_at)); ?>

                                        </td>

                                        <td>
                                            <a href="<?php echo e(route('admin.users.detail', @$bet->user_id)); ?>"><span>@</span><?php echo e(@$bet->user->username); ?></a>
                                        </td>

                                        <td>
                                            <?php echo $bet->betTypeBadge ?>
                                        </td>

                                        <td> <?php echo e(showAmount($bet->stake_amount)); ?> </td>
                                        <td> <?php echo e(showAmount($bet->return_amount)); ?> </td>
                                        <td>
                                            <?php echo $bet->betStatusBadge ?>
                                            <?php if($bet->status == Status::BET_WIN || $bet->status == Status::BET_REFUNDED): ?>
                                                <br>
                                                <?php if($bet->is_settled): ?>
                                                    <small class="text--success"><?php echo app('translator')->get('Settled'); ?></small>
                                                <?php else: ?>
                                                    <small class="text--warning"><?php echo app('translator')->get('Unsettled'); ?></small>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-outline--primary bet-detail" data-id="<?php echo e($bet->id); ?>" type="button">
                                                <i class="las la-desktop"></i> <?php echo app('translator')->get('Detail'); ?>
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td class="text-muted text-center" colspan="100%"><?php echo e(__($emptyMessage)); ?></td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <?php if($bets->hasPages()): ?>
                    <div class="card-footer py-4">
                        <?php echo e(paginateLinks($bets)); ?>

                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="modal fade" id="betDetailModal" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true" tabindex="-1">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="m-0"><?php echo app('translator')->get('Bet Detail'); ?></h5>
                    <span class="close" data-bs-dismiss="modal" type="button" aria-label="Close">
                        <i class="las la-times"></i>
                    </span>
                </div>
                <div class="modal-body">
                    <div class="table-responsive--lg table-responsive">
                        <table class="table--light style--two table">
                            <thead>
                                <tr>
                                    <th><?php echo app('translator')->get('Game'); ?></th>
                                    <th><?php echo app('translator')->get('Market'); ?></th>
                                    <th><?php echo app('translator')->get('Outcome'); ?></th>
                                    <th><?php echo app('translator')->get('Odds'); ?></th>
                                    <th><?php echo app('translator')->get('Status'); ?></th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('breadcrumb-plugins'); ?>
    <?php if (isset($component)) { $__componentOriginale48b4598ffc2f41a085f001458a956d1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale48b4598ffc2f41a085f001458a956d1 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.search-form','data' => ['placeholder' => 'Bet ID']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('search-form'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['placeholder' => 'Bet ID']); ?>
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

<?php $__env->startPush('script'); ?>
    <script>
        (function($) {
            "use strict";

            $('.bet-detail').on('click', function(e) {
                var modal = $('#betDetailModal');
                modal.find('.modal-body').html('<div style="height: 30px;" class="d-flex justify-content-center align-items-center"><i class="fa fa-spin fa-circle-notch"></i></div>');
                var modal = $('#betDetailModal');
                modal.modal('show');

                const handleBetDetails = (data) => {
                    modal.find('.modal-body').html(data);
                }

                $.get("<?php echo e(route('admin.bet.details', '')); ?>/" + $(this).data('id'), (result) => handleBetDetails(result));
            });

        })(jQuery)
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home3/dannygue/apuestas.ballosbet.com/core/resources/views/admin/bet/index.blade.php ENDPATH**/ ?>