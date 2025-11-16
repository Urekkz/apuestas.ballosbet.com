<?php $__env->startSection('panel'); ?>
    <div class="row">
        <div class="col-lg-12">
            <div class="card b-radius--10">
                <div class="card-body p-0">
                    <div class="table-responsive--md table-responsive">
                        <table class="table--light style--two table">
                            <thead>
                                <tr>
                                    <th><?php echo app('translator')->get('Game'); ?></th>
                                    <th><?php echo app('translator')->get('Market'); ?></th>
                                    <th><?php echo app('translator')->get('Total Bets'); ?></th>
                                    <?php if(request()->routeIs('admin.outcomes.declare.declared')): ?>
                                        <th><?php echo app('translator')->get('Win Outcome'); ?></th>
                                    <?php endif; ?>
                                    <?php if(request()->routeIs('admin.outcomes.declare.pending')): ?>
                                        <th><?php echo app('translator')->get('Action'); ?></th>
                                    <?php endif; ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $markets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $market): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td>
                                            <?php if(@$market->game?->teamOne && @$market->game?->teamTwo): ?>
                                                <?php echo e(__(@$market->game->teamOne->name)); ?>

                                                <?php echo app('translator')->get('VS'); ?>
                                                <?php echo e(__(@$market->game->teamTwo->name)); ?>

                                                <br>
                                                <?php echo e(showDateTime(@$market->game->start_time)); ?>

                                            <?php else: ?>
                                                <?php echo e($market->game?->league?->name); ?>

                                            <?php endif; ?>
                                        </td>

                                        <td><?php echo e(__(@$market->market_title)); ?></td>

                                        <td>
                                            <?php echo e(getAmount(@$market->bet_items_count)); ?>

                                        </td>


                                        <?php if(request()->routeIs('admin.outcomes.declare.declared')): ?>
                                            <td>
                                                <?php if(@$market->winOutcome): ?>
                                                    <span><?php echo e(__(@$market->winOutcome->name)); ?></span>
                                                <?php else: ?>
                                                    <span class="text--warning"><?php echo app('translator')->get('Refunded'); ?></span>
                                                <?php endif; ?>
                                            </td>
                                        <?php endif; ?>

                                        <?php if(request()->routeIs('admin.outcomes.declare.pending')): ?>
                                            <td>
                                                <div class="button--group">
                                                    <button class="btn btn-sm btn-outline--primary outcome-btn" data-market="<?php echo e(__($market->title ?? $market->market_title)); ?>" data-outcomes='<?php echo e($market->outcomes); ?>' type="button">
                                                        <i class="la la-info-circle"></i><?php echo app('translator')->get('Select Outcome'); ?>
                                                    </button>

                                                    <button class="btn btn-sm btn-outline--info confirmationBtn" data-action="<?php echo e(route('admin.outcomes.declare.refund', $market->id)); ?>" data-question="<?php echo app('translator')->get('Do you want to return the bet amount for this market?'); ?>" type="button">
                                                        <i class="las la-undo-alt"></i> <?php echo app('translator')->get('Refund Bet'); ?>
                                                    </button>

                                                    <a class="btn btn-sm btn-outline--dark" href="<?php echo e(route('admin.bet.market', $market->id)); ?>">
                                                        <i class="las la-clipboard-list"></i> <?php echo app('translator')->get('Bets'); ?>
                                                    </a>
                                                </div>
                                            </td>
                                        <?php endif; ?>
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

                <?php if($markets->hasPages()): ?>
                    <div class="card-footer py-4">
                        <?php echo e(paginateLinks($markets)); ?>

                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="modal" id="outcomeModal" role="dialog" tabindex="-1">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <button class="close" data-bs-dismiss="modal" type="button" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
                        <div class="result-area"></div>
                        <div class="action-area"></div>
                    </div>
                    <div class="table-responsive--sm table-responsive">
                        <table class="table--light style--two table">
                            <thead>
                                <tr>
                                    <th><?php echo app('translator')->get('Name'); ?></th>
                                    <th><?php echo app('translator')->get('Rate'); ?></th>
                                    <th><?php echo app('translator')->get('Bet Count'); ?></th>
                                    <th><?php echo app('translator')->get('Action'); ?></th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php if (isset($component)) { $__componentOriginalbd5922df145d522b37bf664b524be380 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalbd5922df145d522b37bf664b524be380 = $attributes; } ?>
<?php $component = App\View\Components\ConfirmationModal::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('confirmation-modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\ConfirmationModal::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalbd5922df145d522b37bf664b524be380)): ?>
<?php $attributes = $__attributesOriginalbd5922df145d522b37bf664b524be380; ?>
<?php unset($__attributesOriginalbd5922df145d522b37bf664b524be380); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalbd5922df145d522b37bf664b524be380)): ?>
<?php $component = $__componentOriginalbd5922df145d522b37bf664b524be380; ?>
<?php unset($__componentOriginalbd5922df145d522b37bf664b524be380); ?>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('breadcrumb-plugins'); ?>
    <?php if (isset($component)) { $__componentOriginale48b4598ffc2f41a085f001458a956d1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale48b4598ffc2f41a085f001458a956d1 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.search-form','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('search-form'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
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
        .thumb img {
            width: 30px;
            height: 30px;
        }
    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('script'); ?>
    <script>
        (function($) {
            "use strict";
            let modal = $("#outcomeModal");
            $('.outcome-btn').on('click', function(e) {
                modal.find('tbody').html('')
                var market = $(this).data('market');
                var outcomes = $(this).data('outcomes');

                var modalTitle = `Outcomes for - ${market}`;
                modal.find('.modal-title').text(modalTitle);
                var tableRow = ``;
                $.each(outcomes, function(index, outcome) {
                    tableRow += `<tr>
                                    <td data-label="<?php echo app('translator')->get('Name'); ?>">${outcome.name}</td>
                                    <td data-label="<?php echo app('translator')->get('Odds'); ?>">${Math.abs(outcome.odds)}</td>
                                    <td data-label="<?php echo app('translator')->get('Bet Count'); ?>">${outcome.bets_count}</td>
                                    <td data-label="<?php echo app('translator')->get('Action'); ?>">
                                        <button class="btn btn-sm btn-outline--primary confirmationBtn" data-action="<?php echo e(route('admin.outcomes.declare.winner', '')); ?>/${outcome.id}" data-question="<?php echo app('translator')->get('Are you sure to select'); ?> ${outcome.name}?">
                                            <i class="las la-trophy"></i><?php echo app('translator')->get('Select'); ?>
                                        </button>
                                    </td>
                                </tr>`;
                });
                modal.find('tbody').append(tableRow)
                modal.modal('show')
            });

            let confirmationModal = $("#confirmationModal");

            $(document).on('click', '.confirmationBtn', function(e) {
                modal.modal('hide');
                confirmationModal.modal('show');
            });

            $(document).on('click', '#confirmationModal [data-bs-dismiss=modal]', function(e) {
                let formUrl = $(document).find("#confirmationModal form").attr('action');
                confirmationModal.modal('hide')
                if (!formUrl.includes("match/market/refund")) {
                    modal.modal('show');
                }
            });

        })(jQuery);
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home3/dannygue/apuestas.ballosbet.com/core/resources/views/admin/declare_outcomes/index.blade.php ENDPATH**/ ?>