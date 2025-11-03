<?php $__env->startSection('master'); ?>

    <div class="row gy-4">

        <div class="col-12 d-flex flex-wrap flex-sm-nowrap gap-2 gap-md-3">
            <div class="flex-grow-1">
                <?php if (isset($component)) { $__componentOriginal51a2d661ffc9618691cbedea3fd14983 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal51a2d661ffc9618691cbedea3fd14983 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.user-dashboard-widget','data' => ['title' => 'Total','amount' => ''.e(getAmount($widget['totalBet'])).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('user-dashboard-widget'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Total','amount' => ''.e(getAmount($widget['totalBet'])).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal51a2d661ffc9618691cbedea3fd14983)): ?>
<?php $attributes = $__attributesOriginal51a2d661ffc9618691cbedea3fd14983; ?>
<?php unset($__attributesOriginal51a2d661ffc9618691cbedea3fd14983); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal51a2d661ffc9618691cbedea3fd14983)): ?>
<?php $component = $__componentOriginal51a2d661ffc9618691cbedea3fd14983; ?>
<?php unset($__componentOriginal51a2d661ffc9618691cbedea3fd14983); ?>
<?php endif; ?>
            </div>

            <div class="flex-grow-1">
                <?php if (isset($component)) { $__componentOriginal51a2d661ffc9618691cbedea3fd14983 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal51a2d661ffc9618691cbedea3fd14983 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.user-dashboard-widget','data' => ['title' => 'Pending','amount' => ''.e(getAmount($widget['pendingBet'])).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('user-dashboard-widget'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Pending','amount' => ''.e(getAmount($widget['pendingBet'])).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal51a2d661ffc9618691cbedea3fd14983)): ?>
<?php $attributes = $__attributesOriginal51a2d661ffc9618691cbedea3fd14983; ?>
<?php unset($__attributesOriginal51a2d661ffc9618691cbedea3fd14983); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal51a2d661ffc9618691cbedea3fd14983)): ?>
<?php $component = $__componentOriginal51a2d661ffc9618691cbedea3fd14983; ?>
<?php unset($__componentOriginal51a2d661ffc9618691cbedea3fd14983); ?>
<?php endif; ?>
            </div>

            <div class="flex-grow-1">
                <?php if (isset($component)) { $__componentOriginal51a2d661ffc9618691cbedea3fd14983 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal51a2d661ffc9618691cbedea3fd14983 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.user-dashboard-widget','data' => ['title' => 'Won','amount' => ''.e(getAmount($widget['wonBet'])).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('user-dashboard-widget'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Won','amount' => ''.e(getAmount($widget['wonBet'])).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal51a2d661ffc9618691cbedea3fd14983)): ?>
<?php $attributes = $__attributesOriginal51a2d661ffc9618691cbedea3fd14983; ?>
<?php unset($__attributesOriginal51a2d661ffc9618691cbedea3fd14983); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal51a2d661ffc9618691cbedea3fd14983)): ?>
<?php $component = $__componentOriginal51a2d661ffc9618691cbedea3fd14983; ?>
<?php unset($__componentOriginal51a2d661ffc9618691cbedea3fd14983); ?>
<?php endif; ?>
            </div>

            <div class="flex-grow-1">
                <?php if (isset($component)) { $__componentOriginal51a2d661ffc9618691cbedea3fd14983 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal51a2d661ffc9618691cbedea3fd14983 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.user-dashboard-widget','data' => ['title' => 'Lost','amount' => ''.e(getAmount($widget['loseBet'])).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('user-dashboard-widget'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Lost','amount' => ''.e(getAmount($widget['loseBet'])).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal51a2d661ffc9618691cbedea3fd14983)): ?>
<?php $attributes = $__attributesOriginal51a2d661ffc9618691cbedea3fd14983; ?>
<?php unset($__attributesOriginal51a2d661ffc9618691cbedea3fd14983); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal51a2d661ffc9618691cbedea3fd14983)): ?>
<?php $component = $__componentOriginal51a2d661ffc9618691cbedea3fd14983; ?>
<?php unset($__componentOriginal51a2d661ffc9618691cbedea3fd14983); ?>
<?php endif; ?>
            </div>

            <div class="flex-grow-1">
                <?php if (isset($component)) { $__componentOriginal51a2d661ffc9618691cbedea3fd14983 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal51a2d661ffc9618691cbedea3fd14983 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.user-dashboard-widget','data' => ['title' => 'Refunded','amount' => ''.e(getAmount($widget['refundedBet'])).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('user-dashboard-widget'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Refunded','amount' => ''.e(getAmount($widget['refundedBet'])).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal51a2d661ffc9618691cbedea3fd14983)): ?>
<?php $attributes = $__attributesOriginal51a2d661ffc9618691cbedea3fd14983; ?>
<?php unset($__attributesOriginal51a2d661ffc9618691cbedea3fd14983); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal51a2d661ffc9618691cbedea3fd14983)): ?>
<?php $component = $__componentOriginal51a2d661ffc9618691cbedea3fd14983; ?>
<?php unset($__componentOriginal51a2d661ffc9618691cbedea3fd14983); ?>
<?php endif; ?>
            </div>
        </div>


        <div class="col-12">
            <div class="d-flex justify-content-between flex-wrap flex-sm-nowrap align-items-center mt-0 gap-3">
                <div class="action-area d-flex gap-2 flex-shrink-0">
                    <a class="btn btn-outline--base btn-sm <?php echo e(menuActive('user.bets.all')); ?>" href="<?php echo e(route('user.bets.all')); ?>"><?php echo app('translator')->get('All'); ?></a>
                    <a class="btn btn-outline--base btn-sm <?php echo e(menuActive('user.bets.pending')); ?>" href="<?php echo e(route('user.bets.pending')); ?>"><?php echo app('translator')->get('Pending'); ?></a>

                    <a class="btn btn-outline--base btn-sm <?php echo e(menuActive('user.bets.wins')); ?>" href="<?php echo e(route('user.bets.wins')); ?>"><?php echo app('translator')->get('Won'); ?></a>
                    <a class="btn btn-outline--base btn-sm <?php echo e(menuActive('user.bets.losses')); ?>" href="<?php echo e(route('user.bets.losses')); ?>"><?php echo app('translator')->get('Lost'); ?></a>
                    <a class="btn btn-outline--base btn-sm <?php echo e(menuActive('user.bets.refunded')); ?>" href="<?php echo e(route('user.bets.refunded')); ?>"><?php echo app('translator')->get('Refunded'); ?></a>
                </div>
                <div class="ms-auto search--form">
                    <?php if (isset($component)) { $__componentOriginale48b4598ffc2f41a085f001458a956d1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale48b4598ffc2f41a085f001458a956d1 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.search-form','data' => ['btn' => 'btn-light','placeholder' => 'Bet No.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('search-form'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['btn' => 'btn-light','placeholder' => 'Bet No.']); ?>
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
                </div>
            </div>
        </div>

        <div class="col-12">

            <div class="table-responsive">
                <table class="table-responsive--sm custom--table table">
                    <thead>
                        <tr>
                            <th><?php echo app('translator')->get('No. Apuesta'); ?></th>
                            <th><?php echo app('translator')->get('Tipo'); ?></th>
                            <th><?php echo app('translator')->get('Apostado'); ?></th>
                            <th><?php echo app('translator')->get('Devolver'); ?></th>
                            <th><?php echo app('translator')->get('Estado'); ?></th>
                            <?php if(!Route::is('user.bets.pending')): ?>
                                <th><?php echo app('translator')->get('Resuelto'); ?></th>
                            <?php endif; ?>
                            <th><?php echo app('translator')->get('Accion'); ?></th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $bets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bet): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td>
                                    #<?php echo e($bet->bet_number); ?>

                                    <br>
                                    <small class="text-muted"><em> <i class="la la-clock"></i> <?php echo e(showDateTime($bet->created_at)); ?></em></small>
                                </td>


                                <td>
                                    <?php echo $bet->betTypeBadge ?>
                                </td>

                                <td> <?php echo e(showAmount($bet->stake_amount)); ?> </td>
                                <td> <?php echo e(showAmount($bet->return_amount)); ?> </td>

                                <td>
                                    <?php echo $bet->betStatusBadge ?>
                                </td>

                                <?php if(!Route::is('user.bets.pending')): ?>
                                    <td>
                                        <?php if($bet->status == Status::BET_WIN || $bet->status == Status::BET_REFUNDED): ?>
                                            <br>
                                            <?php if($bet->is_settled): ?>
                                                <small><?php echo app('translator')->get('Si'); ?></small>
                                            <?php else: ?>
                                                <small class="text--warning"><?php echo app('translator')->get('No'); ?></small>
                                            <?php endif; ?>
                                        <?php elseif($bet->status == Status::BET_LOSS): ?>
                                            <small><?php echo app('translator')->get('Si'); ?></small>
                                        <?php else: ?>
                                            <small><?php echo app('translator')->get('...'); ?></small>
                                        <?php endif; ?>
                                    </td>
                                <?php endif; ?>

                                <td>
                                    <button class="btn btn--sm btn-outline--base view-btn" data-id="<?php echo e($bet->id); ?>" data-is_settled="<?php echo e($bet->is_settled); ?>" data-bet_details='<?php echo e($bet->bets); ?>' type="button">
                                        <i class="las la-desktop"></i> <?php echo app('translator')->get('Ver'); ?>
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td class="text-center" colspan="100%"><?php echo e(__($emptyMessage)); ?></td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <div class="mt-4 align-items-center pagination-wrapper">
                <?php echo e($bets->links()); ?>

            </div>
        </div>
    </div>

    <div class="modal fade" id="betDetailModal" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true" tabindex="-1">
        <div class="modal-dialog modal-lg scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header border-bottom-0">
                    <h5 class="m-0"><?php echo app('translator')->get('Selections'); ?></h5>
                    <span class="close" data-bs-dismiss="modal" type="button" aria-label="Close">
                        <i class="las la-times"></i>
                    </span>
                </div>
                <div class="modal-body"></div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script'); ?>
    <script>
        (function($) {
            "use strict";
            $('.view-btn').on('click', function(e) {
                var modal = $('#betDetailModal');
                modal.find('.modal-body').html('<div style="height: 30px;" class="d-flex justify-content-center align-items-center"><i class="fa fa-spin fa-circle-notch"></i></div>');
                var modal = $('#betDetailModal');
                modal.modal('show');

                const handleBetDetails = (data) => {
                    modal.find('.modal-body').html(data);
                }

                $.get("<?php echo e(route('user.bets.details', '')); ?>/" + $(this).data('id'), (result) => handleBetDetails(result));
            });
        })(jQuery)
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make($activeTemplate . 'layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home3/dannygue/apuestas.ballosbet.com/core/resources/views/templates/basic/user/bet/index.blade.php ENDPATH**/ ?>