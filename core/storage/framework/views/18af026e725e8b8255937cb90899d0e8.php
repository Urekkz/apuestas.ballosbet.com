<?php if(auth()->guard()->check()): ?>
    <?php
        $betHistory = App\Models\BetItem::whereHas('bet', function ($query) {
            $query->where('user_id', auth()->id())->notSettled();
        })
            ->with(['bet', 'market.game.teamOne', 'market.game.teamTwo', 'outcome'])
            ->orderBy('created_at', 'desc')
            ->limit(50)
            ->get()
            ->groupBy('bet_id')
            ->map(function ($group) {
                $bet = $group->first()->bet;
                return (object) [
                    'bet' => $bet,
                    'details' => $group,
                ];
            });
    ?>

    <?php if($betHistory->isNotEmpty()): ?>
        <div class="single-bet">
            <ul class="list bets__list">
                <?php $__currentLoopData = $betHistory; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $betData): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li class="bet-list-item mb-0">
                        <div class="bet-list-item__body">
                            <?php $__currentLoopData = @$betData->details ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $betDetail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $market = @$betDetail->market;
                                    $outcome = @$betDetail->outcome;
                                ?>

                                <div class="bet-single">

                                    <div class="d-flex justify-content-between align-items-center mb-2 gap-2">
                                        <?php
                                            $marketTitle = @$market->market_title;
                                            // Oculta
                                            if (!in_array(strtolower($marketTitle), ['mano a mano', '1vs1'])) {
                                                echo '<span class="bet-market_type">' . $marketTitle . '</span>';
                                            }
                                        ?>
                                        <?php
                                            echo @$betDetail->statusBadge;
                                        ?>
                                    </div>

                                    <div class="betslip-item-league">
                                        <?php
                                            echo @$market->game->league->category->icon;
                                        ?>
                                        <span class="betslip-item-league__name"><?php echo e(__(@$market->game->league->name)); ?></span>
                                    </div>

                                    <?php if($market->market_type != 'outrights'): ?>
                                        <div class="bet-single__teams">
                                            <span class="bet-single__team"><?php echo e(__(@$market->game->teamOne->name)); ?></span>
                                            <span class="bet-single__vs"><?php echo app('translator')->get('vs'); ?></span>
                                            <span class="bet-single__team"><?php echo e(__(@$market->game->teamTwo->name)); ?></span>
                                        </div>
                                    <?php endif; ?>

                                    <div class="bet-single__selected-team mb-2">
                                        <span class="name"><?php echo e(str_replace(['mano a mano', 'Mano a mano', 'MANO A MANO'], 'Uno contra Uno', __(@$outcome->name))); ?></span>
                                    </div>


                                </div>
                                
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                        <div class="bet-list-item__footer">
                            <div class="bet-single-info">
                                <div class="bet-single-info__item">
                                    <span class="label"><?php echo app('translator')->get('Stake Amount'); ?></span>
                                    <span class="value"><?php echo e(showAmount(@$betData->bet->stake_amount, exceptZeros: true)); ?></span>
                                </div>
                                <div class="bet-single-info__item">
                                    <span class="label"><?php echo app('translator')->get('Win Amount'); ?></span>
                                    <span class="value"><?php echo e(showAmount(@$betData->bet->return_amount, exceptZeros: true)); ?></span>
                                </div>
                                <?php
                                    $profit = @$betData->bet->return_amount - @$betData->bet->stake_amount;
                                    $commissionPercent = 5.00;
                                    $commissionAmount = $profit > 0 ? round($profit * ($commissionPercent / 100), 8) : 0;
                                    $finalPayout = @$betData->bet->return_amount - $commissionAmount;
                                ?>
                                <div class="bet-single-info__item" style="border-top: 1px dashed rgba(255,255,255,0.1); padding-top: 8px; margin-top: 8px;">
                                    <span class="label" style="color: #ffc107;"><?php echo app('translator')->get('Comisión si ganas'); ?></span>
                                    <span class="value" style="color: #ffc107;">-<?php echo e(showAmount($commissionAmount, exceptZeros: true)); ?> (<?php echo e($commissionPercent); ?>%)</span>
                                </div>
                                <div class="bet-single-info__item">
                                    <span class="label" style="font-weight: bold; color: #28a745;"><?php echo app('translator')->get('Recibirás si ganas'); ?></span>
                                    <span class="value" style="font-weight: bold; color: #28a745;"><?php echo e(showAmount($finalPayout, exceptZeros: true)); ?></span>
                                </div>
                            </div>
                        </div>
                    </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php else: ?>
        <div class="betslip__body h-100">
            <div class="empty-slip-message ">
                <span class="d-flex justify-content-center align-items-center">
                    <img src="<?php echo e(asset($activeTemplateTrue . 'images/empty_list.png')); ?>" alt="<?php echo app('translator')->get('image'); ?>">
                </span>
                <?php echo app('translator')->get('No bet placed yet'); ?>
            </div>
        </div>
    <?php endif; ?>
<?php else: ?>
    <div class="login-message">
        <p class="login-message-text">
            <?php echo app('translator')->get('Login to see your open bets displayed here'); ?>
        </p>
    </div>
<?php endif; ?>
<?php /**PATH /home3/dannygue/apuestas.ballosbet.com/core/resources/views/templates/basic/partials/my_bets.blade.php ENDPATH**/ ?>