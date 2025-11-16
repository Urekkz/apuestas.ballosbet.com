<?php $__env->startSection('panel'); ?>
    <div class="row">
        <div class="col-lg-12">
            <div class="card b-radius--10">
                <div class="card-body p-0">
                    <div class="table-responsive--md table-responsive">
                        <table class="table--light style--two table">

                            <thead>
                                <tr>
                                    <th><?php echo app('translator')->get('League'); ?> | <?php echo app('translator')->get('Title'); ?></th>
                                    <th><?php echo app('translator')->get('Category'); ?></th>
                                    <th><?php echo app('translator')->get('Game Starts From'); ?></th>
                                    <th><?php echo app('translator')->get('Bet Starts From'); ?></th>
                                    <th><?php echo app('translator')->get('Status'); ?></th>
                                    <th><?php echo app('translator')->get('Action'); ?></th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $games; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $game): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>

                                        <td>
                                            <small class="fw-semibold"><?php echo e(__(@$game->league->short_name)); ?></small>
                                            <br>
                                            <?php if(@$game->teamOne && @$game->teamTwo): ?>
                                                <?php echo e(__($game->teamOne->name)); ?> <em><?php echo app('translator')->get('vs'); ?></em> <?php echo e(__(@$game->teamTwo->name)); ?>

                                            <?php else: ?>
                                                <?php echo e(__(@$game->title)); ?>

                                            <?php endif; ?>
                                        </td>

                                        <td>
                                            <?php echo e(__(@$game->league->category->name)); ?>

                                        </td>

                                        <td>
                                            <?php echo e(showDateTime($game->start_time, 'd M, Y h:i A')); ?>

                                        </td>

                                        <td>
                                            <?php echo e(showDateTime($game->bet_start_time, 'd M, Y h:i A')); ?>

                                        </td>

                                        <td>
                                            <?php echo $game->statusBadge ?>
                                            <?php if(!in_array($game->status, [Status::GAME_CANCELLED, Status::GAME_ENDED])): ?>
                                                <button class="btn btn-sm btn-no--bg p-0 ms-1 changeStatusBtn" data-status="<?php echo e($game->status); ?>" data-id="<?php echo e($game->id); ?>" title="<?php echo app('translator')->get('Change Status'); ?>"><i class="la la-pencil"></i>
                                            <?php endif; ?>
                                        </td>

                                        <td>
                                            <div class="d-flex justify-content-end gap-1 align-items-center">
                                                <a class="btn btn-sm btn-outline--primary" href="<?php echo e(route('admin.game.edit', $game->id)); ?>"> <i class="la la-pencil"></i><?php echo app('translator')->get('Edit'); ?></a>

                                                <div class="dropdown">
                                                    <button class="btn btn-sm btn-outline--dark dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="las la-ellipsis-v"></i><?php echo app('translator')->get('More'); ?>
                                                    </button>
                                                    <ul class="dropdown-menu">

                                                        <li><a class="dropdown-item" href="<?php echo e(route('admin.market.index', $game->id)); ?>"><?php echo app('translator')->get('Markets'); ?> (<?php echo e($game->markets_count); ?>)</a></li>
                                                        <li><a class="dropdown-item" href="<?php echo e(route('admin.bet.index')); ?>?game_id=<?php echo e($game->id); ?>"><?php echo app('translator')->get('Bets'); ?> (<?php echo e(@$game->total_bets_count); ?>)</a></li>

                                                        <li><a class="dropdown-item" href="<?php echo e(route('admin.outcomes.declare.pending')); ?>?game_id=<?php echo e($game->id); ?>"><?php echo app('translator')->get('Declare Outcomes'); ?></a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td class="text-muted text-center" colspan="100%"><?php echo e(__($emptyMessage)); ?></td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table><!-- table end -->
                    </div>
                </div>

                <?php if($games->hasPages()): ?>
                    <div class="card-footer py-4">
                        <?php echo e(paginateLinks($games)); ?>

                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="offcanvas offcanvas-end" id="offcanvasRight" aria-labelledby="offcanvasRightLabel" tabindex="-1">
        <div class="offcanvas-header">
            <h5 id="offcanvasRightLabel"><?php echo app('translator')->get('Filter by'); ?></h5>
            <button class="close bg--transparent" data-bs-dismiss="offcanvas" type="button" aria-label="Close">
                <i class="las la-times"></i>
            </button>
        </div>
        <div class="offcanvas-body">
            <form action="">
                <div class="form-group">
                    <label><?php echo app('translator')->get('Category'); ?></label>
                    <select class="form-control select2" name="category_id">
                        <option value=""><?php echo app('translator')->get('All'); ?></option>
                        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($category->id); ?>" <?php if(request()->category_id == $category->id): echo 'selected'; endif; ?>><?php echo e(@$category->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                <div class="form-group">
                    <label><?php echo app('translator')->get('Leauge'); ?></label>
                    <select class="form-control select2" name="league_id">
                        <option value=""><?php echo app('translator')->get('All'); ?></option>
                        <?php $__currentLoopData = $leagues; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $league): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($league->id); ?>" <?php if(request()->league_id == $league->id): echo 'selected'; endif; ?>><?php echo e(__($league->name)); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                <div class="form-group">
                    <label><?php echo app('translator')->get('Team One'); ?></label>
                    <select class="form-control select2" name="team_one_id">
                        <option value=""><?php echo app('translator')->get('All'); ?></option>
                        <?php $__currentLoopData = $teams; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $team): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($team->id); ?>" <?php if(request()->team_one_id == $team->id): echo 'selected'; endif; ?>><?php echo e($team->short_name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                <div class="form-group">
                    <label><?php echo app('translator')->get('Team Two'); ?></label>
                    <select class="form-control select2" name="team_two_id">
                        <option value=""><?php echo app('translator')->get('All'); ?></option>
                        <?php $__currentLoopData = $teams; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $team): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($team->id); ?>" <?php if(request()->team_two_id == $team->id): echo 'selected'; endif; ?>><?php echo e(@$team->short_name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                <div class="form-group">
                    <label><?php echo app('translator')->get('Game Started From'); ?></label>
                    <input name="start_time" type="search" class="datepicker-here form-control bg--white pe-2 date-range" placeholder="<?php echo app('translator')->get('Start Date - End Date'); ?>" autocomplete="off" value="<?php echo e(request()->start_time); ?>">
                </div>
                <div class="form-group">
                    <label><?php echo app('translator')->get('Bet Started From'); ?></label>
                    <input name="bet_start_time" type="search" class="datepicker-here form-control bg--white pe-2 date-range" placeholder="<?php echo app('translator')->get('Start Date - End Date'); ?>" autocomplete="off" value="<?php echo e(request()->bet_start_time); ?>">
                </div>

                <div class="form-group">
                    <button class="btn btn--primary w-100 h-45"> <?php echo app('translator')->get('Filter'); ?></button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="statusModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><?php echo app('translator')->get('Change Game Status'); ?></h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="la la-times"></i>
                    </button>
                </div>

                <form action="" method="post">
                    <?php echo csrf_field(); ?>
                    <div class="modal-body">

                        <div class="form-check mb-3 open-for-betting">
                            <label class="form-check-label mb-0 flex-shrink-0" for="open_for_betting">
                                <input type="radio" id="open_for_betting" class="form-check-input" name="status" value="<?php echo e(Status::GAME_OPEN_FOR_BETTING); ?>"><?php echo app('translator')->get('Open for Betting'); ?>
                            </label>
                            <small class="text-muted d-block"><i class="la la-info-circle"></i> <?php echo app('translator')->get('Select this status when the game is currently open for betting. Bettors can place bets during this period. Ensure that the \'Bet Start From\' has passed, as this status indicates that betting is actively available for the game.'); ?></small>
                        </div>


                        <div class="form-check mb-3 close-for-betting">
                            <label class="form-check-label mb-0 flex-shrink-0" for="closed_for_betting">
                                <input type="radio" id="closed_for_betting" class="form-check-input" name="status" value="<?php echo e(Status::GAME_CLOSED_FOR_BETTING); ?>"><?php echo app('translator')->get('Close for Betting'); ?>
                            </label>

                            <small class="text-muted d-block"><i class="la la-info-circle"></i> <?php echo app('translator')->get('Select this status when the game is no longer accepting bets. No new bets can be placed, but existing bets will remain valid and can be settled once the game concludes. Use this status to indicate that betting is officially closed for the game.'); ?></small>
                        </div>

                        <div class="form-check mb-3 game-cancelled">
                            <label class="form-check-label mb-0 flex-shrink-0" for="game_cancelled">
                                <input type="radio" id="game_cancelled" class="form-check-input" name="status" value="<?php echo e(Status::GAME_CANCELLED); ?>" <?php if(@$game->status == Status::GAME_CANCELLED): echo 'checked'; endif; ?>><?php echo app('translator')->get('Game Cancelled'); ?>
                            </label>

                            <small class="text-muted d-block"><i class="la la-info-circle"></i> <?php echo app('translator')->get('Select this if the game has been cancelled. No bets can be placed or settled, and any existing bets will be voided.'); ?> <span class="text--warning"><?php echo app('translator')->get('The stake amounts for all existing bets need to be refunded manually.'); ?></span></small>
                        </div>

                        <div class="form-check game-completed">
                            <label class="form-check-label mb-0 flex-shrink-0" for="GAME_ENDED">
                                <input type="radio" id="GAME_ENDED" class="form-check-input" name="status" value="<?php echo e(Status::GAME_ENDED); ?>"><?php echo app('translator')->get('Game Ended'); ?>
                            </label>

                            <small class="text-muted d-block"><i class="la la-info-circle"></i> <?php echo app('translator')->get('Select this status when the game has concluded. All bets can now be settled based on the final outcome. Ensure to update this status promptly after the game ends to allow for accurate bet settlement and result processing.'); ?> </small>
                        </div>

                        <p class="p-3 bg-light text-muted mt-3 rounded">
                            <i class="la la-info-circle"></i> <span class="text--danger"><?php echo app('translator')->get('Once you have changed the game status to \'Game Ended\' or \'Game Cancelled\',  this action cannot be undone.'); ?></span>
                            <br>
                            <i class="la la-info-circle"></i> <?php echo app('translator')->get('Games will only be displayed on the website when their status is set to "Open for Betting."'); ?>
                        </p>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn--primary h-45 w-100"><?php echo app('translator')->get('Save Changes'); ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('style'); ?>
    <style>
        .thumb img {
            width: 30px;
            height: 30px;
        }

        .btn-no--bg {
            background-color: transparent;
            color: #464646;
        }

        .btn-no--bg:hover i {
            color: #252525 !important;
        }
    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('breadcrumb-plugins'); ?>
    <button class="btn btn-sm btn-outline--info " data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" type="button" aria-controls="offcanvasRight"><i class="las la-filter"></i> <?php echo app('translator')->get('Filter'); ?></button>
    <a class="btn btn-sm btn-outline--primary " href="<?php echo e(route('admin.game.create')); ?>"><i class="las la-plus"></i><?php echo app('translator')->get('Add New Game'); ?></a>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('script-lib'); ?>
    <script src="<?php echo e(asset('assets/admin/js/moment.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/global/js/daterangepicker.min.js')); ?>"></script>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('style-lib'); ?>
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('assets/global/css/daterangepicker.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startPush('style'); ?>
    <style>
        .form-check .form-check-input {
            margin-left: -16px;
            margin-top: 0px;
            margin-right: 6px;
        }
    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('script'); ?>
    <script>
        (function($) {
            "use strict"

            const datePicker = $('.date-range').daterangepicker({
                autoUpdateInput: false,
                locale: {
                    cancelLabel: 'Clear'
                },
                showDropdowns: true,
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 15 Days': [moment().subtract(14, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(30, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
                    'Last 6 Months': [moment().subtract(6, 'months').startOf('month'), moment().endOf('month')],
                    'This Year': [moment().startOf('year'), moment().endOf('year')],
                },
                maxDate: moment()
            });
            const changeDatePickerText = (event, startDate, endDate) => {
                $(event.target).val(startDate.format('MMMM DD, YYYY') + ' - ' + endDate.format('MMMM DD, YYYY'));
            }


            $('.date-range').on('apply.daterangepicker', (event, picker) => changeDatePickerText(event, picker.startDate, picker.endDate));


            if ($('.date-range').val()) {
                let dateRange = $('.date-range').val().split(' - ');
                $('.date-range').data('daterangepicker').setStartDate(new Date(dateRange[0]));
                $('.date-range').data('daterangepicker').setEndDate(new Date(dateRange[1]));
            }

            $('.changeStatusBtn').on('click', function() {
                const modal = $('#statusModal');
                const status = $(this).data('status');

                modal.find('.form-check').removeClass('d-none');

                let url = `<?php echo e(route('admin.game.status', ':id')); ?>`;

                url = url.replace(':id', $(this).data('id'));
                modal.find('form').attr('action', url);

                if (status == '<?php echo e(Status::GAME_OPEN_FOR_BETTING); ?>') {
                    modal.find('.open-for-betting').addClass('d-none');
                }

                if (status == '<?php echo e(Status::GAME_CLOSED_FOR_BETTING); ?>') {
                    modal.find('.open-for-betting').removeClass('d-none');
                    modal.find('.close-for-betting').addClass('d-none');
                }

                modal.modal('show');
            });

        })(jQuery)
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home3/dannygue/apuestas.ballosbet.com/core/resources/views/admin/game/index.blade.php ENDPATH**/ ?>