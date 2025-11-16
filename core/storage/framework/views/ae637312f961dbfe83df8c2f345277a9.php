

<?php $__env->startSection('panel'); ?>
<div class="row">
    <div class="col-12">
        <div class="row gy-4">
            <div class="col-xxl-3 col-sm-6">
                <?php if (isset($component)) { $__componentOriginal433d6a5be5b58ac8aa6a74031c6196f9 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal433d6a5be5b58ac8aa6a74031c6196f9 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.widget','data' => ['style' => '7','link' => ''.e(route('admin.report.transaction', $user->id)).'','title' => 'Balance','icon' => 'las la-money-bill-wave-alt','value' => ''.e(showAmount($user->balance)).'','bg' => 'indigo','type' => '2']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('widget'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['style' => '7','link' => ''.e(route('admin.report.transaction', $user->id)).'','title' => 'Balance','icon' => 'las la-money-bill-wave-alt','value' => ''.e(showAmount($user->balance)).'','bg' => 'indigo','type' => '2']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal433d6a5be5b58ac8aa6a74031c6196f9)): ?>
<?php $attributes = $__attributesOriginal433d6a5be5b58ac8aa6a74031c6196f9; ?>
<?php unset($__attributesOriginal433d6a5be5b58ac8aa6a74031c6196f9); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal433d6a5be5b58ac8aa6a74031c6196f9)): ?>
<?php $component = $__componentOriginal433d6a5be5b58ac8aa6a74031c6196f9; ?>
<?php unset($__componentOriginal433d6a5be5b58ac8aa6a74031c6196f9); ?>
<?php endif; ?>
            </div>
            <div class="col-xxl-3 col-sm-6">
                <?php if (isset($component)) { $__componentOriginal433d6a5be5b58ac8aa6a74031c6196f9 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal433d6a5be5b58ac8aa6a74031c6196f9 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.widget','data' => ['style' => '7','link' => ''.e(route('admin.deposit.list', $user->id)).'','title' => 'Deposits','icon' => 'las la-wallet','value' => ''.e(showAmount($totalDeposit)).'','bg' => '8','type' => '2']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('widget'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['style' => '7','link' => ''.e(route('admin.deposit.list', $user->id)).'','title' => 'Deposits','icon' => 'las la-wallet','value' => ''.e(showAmount($totalDeposit)).'','bg' => '8','type' => '2']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal433d6a5be5b58ac8aa6a74031c6196f9)): ?>
<?php $attributes = $__attributesOriginal433d6a5be5b58ac8aa6a74031c6196f9; ?>
<?php unset($__attributesOriginal433d6a5be5b58ac8aa6a74031c6196f9); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal433d6a5be5b58ac8aa6a74031c6196f9)): ?>
<?php $component = $__componentOriginal433d6a5be5b58ac8aa6a74031c6196f9; ?>
<?php unset($__componentOriginal433d6a5be5b58ac8aa6a74031c6196f9); ?>
<?php endif; ?>
            </div>
            <div class="col-xxl-3 col-sm-6">
                <?php if (isset($component)) { $__componentOriginal433d6a5be5b58ac8aa6a74031c6196f9 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal433d6a5be5b58ac8aa6a74031c6196f9 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.widget','data' => ['style' => '7','link' => ''.e(route('admin.withdraw.data.all', $user->id)).'','title' => 'Withdrawals','icon' => 'la la-bank','value' => ''.e(showAmount($totalWithdrawals)).'','bg' => '6','type' => '2']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('widget'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['style' => '7','link' => ''.e(route('admin.withdraw.data.all', $user->id)).'','title' => 'Withdrawals','icon' => 'la la-bank','value' => ''.e(showAmount($totalWithdrawals)).'','bg' => '6','type' => '2']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal433d6a5be5b58ac8aa6a74031c6196f9)): ?>
<?php $attributes = $__attributesOriginal433d6a5be5b58ac8aa6a74031c6196f9; ?>
<?php unset($__attributesOriginal433d6a5be5b58ac8aa6a74031c6196f9); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal433d6a5be5b58ac8aa6a74031c6196f9)): ?>
<?php $component = $__componentOriginal433d6a5be5b58ac8aa6a74031c6196f9; ?>
<?php unset($__componentOriginal433d6a5be5b58ac8aa6a74031c6196f9); ?>
<?php endif; ?>
            </div>
            <div class="col-xxl-3 col-sm-6">
                <?php if (isset($component)) { $__componentOriginal433d6a5be5b58ac8aa6a74031c6196f9 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal433d6a5be5b58ac8aa6a74031c6196f9 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.widget','data' => ['style' => '7','link' => ''.e(route('admin.report.transaction', $user->id)).'','title' => 'Transactions','icon' => 'las la-exchange-alt','value' => ''.e($totalTransaction).'','bg' => '17','type' => '2']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('widget'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['style' => '7','link' => ''.e(route('admin.report.transaction', $user->id)).'','title' => 'Transactions','icon' => 'las la-exchange-alt','value' => ''.e($totalTransaction).'','bg' => '17','type' => '2']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal433d6a5be5b58ac8aa6a74031c6196f9)): ?>
<?php $attributes = $__attributesOriginal433d6a5be5b58ac8aa6a74031c6196f9; ?>
<?php unset($__attributesOriginal433d6a5be5b58ac8aa6a74031c6196f9); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal433d6a5be5b58ac8aa6a74031c6196f9)): ?>
<?php $component = $__componentOriginal433d6a5be5b58ac8aa6a74031c6196f9; ?>
<?php unset($__componentOriginal433d6a5be5b58ac8aa6a74031c6196f9); ?>
<?php endif; ?>
            </div>

            <div class="col-xxl-3 col-sm-6">
                <?php if (isset($component)) { $__componentOriginal433d6a5be5b58ac8aa6a74031c6196f9 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal433d6a5be5b58ac8aa6a74031c6196f9 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.widget','data' => ['style' => '7','link' => ''.e(route('admin.users.bets', $user->id)).'','title' => 'Bet Placed','icon' => 'las la-gamepad','value' => ''.e(getAmount($totalBets)).'','bg' => 'cyan','type' => '2']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('widget'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['style' => '7','link' => ''.e(route('admin.users.bets', $user->id)).'','title' => 'Bet Placed','icon' => 'las la-gamepad','value' => ''.e(getAmount($totalBets)).'','bg' => 'cyan','type' => '2']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal433d6a5be5b58ac8aa6a74031c6196f9)): ?>
<?php $attributes = $__attributesOriginal433d6a5be5b58ac8aa6a74031c6196f9; ?>
<?php unset($__attributesOriginal433d6a5be5b58ac8aa6a74031c6196f9); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal433d6a5be5b58ac8aa6a74031c6196f9)): ?>
<?php $component = $__componentOriginal433d6a5be5b58ac8aa6a74031c6196f9; ?>
<?php unset($__componentOriginal433d6a5be5b58ac8aa6a74031c6196f9); ?>
<?php endif; ?>
            </div>
            <div class="col-xxl-3 col-sm-6">
                <?php if (isset($component)) { $__componentOriginal433d6a5be5b58ac8aa6a74031c6196f9 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal433d6a5be5b58ac8aa6a74031c6196f9 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.widget','data' => ['style' => '7','link' => ''.e(route('admin.users.bets', $user->id)).'?search=win','title' => 'Returned Amount','icon' => 'las la-hand-holding-usd','value' => ''.e(showAmount($betWinAmount)).'','bg' => 'green','type' => '2']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('widget'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['style' => '7','link' => ''.e(route('admin.users.bets', $user->id)).'?search=win','title' => 'Returned Amount','icon' => 'las la-hand-holding-usd','value' => ''.e(showAmount($betWinAmount)).'','bg' => 'green','type' => '2']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal433d6a5be5b58ac8aa6a74031c6196f9)): ?>
<?php $attributes = $__attributesOriginal433d6a5be5b58ac8aa6a74031c6196f9; ?>
<?php unset($__attributesOriginal433d6a5be5b58ac8aa6a74031c6196f9); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal433d6a5be5b58ac8aa6a74031c6196f9)): ?>
<?php $component = $__componentOriginal433d6a5be5b58ac8aa6a74031c6196f9; ?>
<?php unset($__componentOriginal433d6a5be5b58ac8aa6a74031c6196f9); ?>
<?php endif; ?>
            </div>
            <div class="col-xxl-3 col-sm-6">
                <?php if (isset($component)) { $__componentOriginal433d6a5be5b58ac8aa6a74031c6196f9 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal433d6a5be5b58ac8aa6a74031c6196f9 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.widget','data' => ['style' => '7','link' => ''.e(route('admin.users.refereed.users', $user->id)).'','title' => 'Referred','icon' => 'las la-sitemap','value' => ''.e($totalReferred).'','bg' => 'deep-purple','type' => '2']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('widget'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['style' => '7','link' => ''.e(route('admin.users.refereed.users', $user->id)).'','title' => 'Referred','icon' => 'las la-sitemap','value' => ''.e($totalReferred).'','bg' => 'deep-purple','type' => '2']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal433d6a5be5b58ac8aa6a74031c6196f9)): ?>
<?php $attributes = $__attributesOriginal433d6a5be5b58ac8aa6a74031c6196f9; ?>
<?php unset($__attributesOriginal433d6a5be5b58ac8aa6a74031c6196f9); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal433d6a5be5b58ac8aa6a74031c6196f9)): ?>
<?php $component = $__componentOriginal433d6a5be5b58ac8aa6a74031c6196f9; ?>
<?php unset($__componentOriginal433d6a5be5b58ac8aa6a74031c6196f9); ?>
<?php endif; ?>
            </div>
            <div class="col-xxl-3 col-sm-6">
                <?php if (isset($component)) { $__componentOriginal433d6a5be5b58ac8aa6a74031c6196f9 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal433d6a5be5b58ac8aa6a74031c6196f9 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.widget','data' => ['style' => '7','link' => ''.e(route('admin.users.referral.commissions', $user->id)).'','title' => 'Ref. Commission Received','icon' => 'las la-percentage','value' => ''.e(showAmount($totalReferralCom)).'','bg' => 'teal','type' => '2']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('widget'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['style' => '7','link' => ''.e(route('admin.users.referral.commissions', $user->id)).'','title' => 'Ref. Commission Received','icon' => 'las la-percentage','value' => ''.e(showAmount($totalReferralCom)).'','bg' => 'teal','type' => '2']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal433d6a5be5b58ac8aa6a74031c6196f9)): ?>
<?php $attributes = $__attributesOriginal433d6a5be5b58ac8aa6a74031c6196f9; ?>
<?php unset($__attributesOriginal433d6a5be5b58ac8aa6a74031c6196f9); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal433d6a5be5b58ac8aa6a74031c6196f9)): ?>
<?php $component = $__componentOriginal433d6a5be5b58ac8aa6a74031c6196f9; ?>
<?php unset($__componentOriginal433d6a5be5b58ac8aa6a74031c6196f9); ?>
<?php endif; ?>
            </div>
        </div>

        <div class="d-flex flex-wrap gap-3 mt-4">
            <div class="flex-fill">
                <button data-bs-toggle="modal" data-bs-target="#addSubModal" class="btn btn--success btn--shadow w-100 btn-lg bal-btn" data-act="add">
                    <i class="las la-plus-circle"></i> <?php echo app('translator')->get('Add Balance'); ?>
                </button>
            </div>

            <div class="flex-fill">
                <button data-bs-toggle="modal" data-bs-target="#addSubModal" class="btn btn--danger btn--shadow w-100 btn-lg bal-btn" data-act="sub">
                    <i class="las la-minus-circle"></i> <?php echo app('translator')->get('Subtract Balance'); ?>
                </button>
            </div>

            <div class="flex-fill">
                <a href="<?php echo e(route('admin.report.login.history')); ?>?search=<?php echo e($user->username); ?>" class="btn btn--primary btn--shadow w-100 btn-lg">
                    <i class="las la-list-alt"></i> <?php echo app('translator')->get('Logins'); ?>
                </a>
            </div>

            <div class="flex-fill">
                <a href="<?php echo e(route('admin.users.notification.log', $user->id)); ?>" class="btn btn--secondary btn--shadow w-100 btn-lg">
                    <i class="las la-bell"></i> <?php echo app('translator')->get('Notifications'); ?>
                </a>
            </div>

            <?php if($user->kyc_data): ?>
            <div class="flex-fill">
                <a href="<?php echo e(route('admin.users.kyc.details', $user->id)); ?>" target="_blank" class="btn btn--dark btn--shadow w-100 btn-lg">
                    <i class="las la-user-check"></i> <?php echo app('translator')->get('KYC Data'); ?>
                </a>
            </div>
            <?php endif; ?>

            <div class="flex-fill">
                <?php if($user->status == Status::USER_ACTIVE): ?>
                <button type="button" class="btn btn--warning btn--shadow w-100 btn-lg userStatus" data-bs-toggle="modal" data-bs-target="#userStatusModal">
                    <i class="las la-ban"></i> <?php echo app('translator')->get('Ban Bettor'); ?>
                </button>
                <?php else: ?>
                <button type="button" class="btn btn--success btn--shadow w-100 btn-lg userStatus" data-bs-toggle="modal" data-bs-target="#userStatusModal">
                    <i class="las la-undo"></i> <?php echo app('translator')->get('Unban Bettor'); ?>
                </button>
                <?php endif; ?>
            </div>
        </div>

        <div class="card mt-30">
            <div class="card-header">
                <h5 class="card-title mb-0"><?php echo app('translator')->get('Information of'); ?> <?php echo e($user->fullname); ?></h5>
            </div>
            <div class="card-body">
                <form action="<?php echo e(route('admin.users.update', [$user->id])); ?>" method="POST" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><?php echo app('translator')->get('First Name'); ?></label>
                                <input class="form-control" type="text" name="firstname" required value="<?php echo e($user->firstname); ?>">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label><?php echo app('translator')->get('Last Name'); ?></label>
                                <input class="form-control" type="text" name="lastname" required value="<?php echo e($user->lastname); ?>">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label><?php echo app('translator')->get('Email'); ?></label>
                                <input class="form-control" type="email" name="email" required value="<?php echo e($user->email); ?>">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label><?php echo app('translator')->get('Mobile Number'); ?></label>
                                <div class="input-group">
                                    <span class="input-group-text mobile-code">+<?php echo e($user->dial_code); ?></span>
                                    <input type="number" name="mobile" value="<?php echo e($user->mobile); ?>" id="mobile" class="form-control checkUser" required>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label><?php echo app('translator')->get('Address'); ?></label>
                                <input class="form-control" type="text" name="address" value="<?php echo e(@$user->address); ?>">
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6">
                            <div class="form-group">
                                <label><?php echo app('translator')->get('City'); ?></label>
                                <input class="form-control" type="text" name="city" value="<?php echo e(@$user->city); ?>">
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6">
                            <div class="form-group">
                                <label><?php echo app('translator')->get('State'); ?></label>
                                <input class="form-control" type="text" name="state" value="<?php echo e(@$user->state); ?>">
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6">
                            <div class="form-group">
                                <label><?php echo app('translator')->get('Zip/Postal'); ?></label>
                                <input class="form-control" type="text" name="zip" value="<?php echo e(@$user->zip); ?>">
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6">
                            <div class="form-group">
                                <label><?php echo app('translator')->get('Country'); ?> <span class="text--danger">*</span></label>
                                <select name="country" class="form-control select2">
                                    <?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $country): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option data-mobile_code="<?php echo e($country->dial_code); ?>" value="<?php echo e($key); ?>" <?php if($user->country_code == $key): echo 'selected'; endif; ?>><?php echo e(__($country->country)); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6">
                            <div class="form-group">
                                <label><?php echo app('translator')->get('Email Verification'); ?></label>
                                <input type="checkbox" data-bs-toggle="toggle" data-on="<?php echo app('translator')->get('Verified'); ?>" data-off="<?php echo app('translator')->get('Unverified'); ?>" name="ev" <?php if($user->ev): echo 'checked'; endif; ?>>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6">
                            <div class="form-group">
                                <label><?php echo app('translator')->get('Mobile Verification'); ?></label>
                                <input type="checkbox" data-bs-toggle="toggle" data-on="<?php echo app('translator')->get('Verified'); ?>" data-off="<?php echo app('translator')->get('Unverified'); ?>" name="sv" <?php if($user->sv): echo 'checked'; endif; ?>>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6">
                            <div class="form-group">
                                <label><?php echo app('translator')->get('2FA Verification'); ?></label>
                                <input type="checkbox" data-bs-toggle="toggle" data-on="<?php echo app('translator')->get('Enabled'); ?>" data-off="<?php echo app('translator')->get('Disabled'); ?>" name="ts" <?php if($user->ts): echo 'checked'; endif; ?>>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6">
                            <div class="form-group">
                                <label><?php echo app('translator')->get('KYC'); ?></label>
                                <input type="checkbox" data-bs-toggle="toggle" data-on="<?php echo app('translator')->get('Verified'); ?>" data-off="<?php echo app('translator')->get('Unverified'); ?>" name="kv" <?php if($user->kv == Status::KYC_VERIFIED): echo 'checked'; endif; ?>>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <button type="submit" class="btn btn--primary w-100 h-45"><?php echo app('translator')->get('Submit'); ?></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<div id="addSubModal" class="modal fade" tabindex="-1">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><span class="type"></span> <?php echo app('translator')->get('Balance'); ?></h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><i class="las la-times"></i></button>
            </div>
            <form action="<?php echo e(route('admin.users.add.sub.balance', $user->id)); ?>" method="POST" class="balanceAddSub disableSubmission">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="act">
                <div class="modal-body">
                    <div class="form-group">
                        <label><?php echo app('translator')->get('Amount'); ?></label>
                        <div class="input-group">
                            <input type="number" step="any" name="amount" class="form-control" placeholder="<?php echo app('translator')->get('Please provide a positive amount'); ?>" required>
                            <div class="input-group-text"><?php echo e(__(gs('cur_text'))); ?></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label><?php echo app('translator')->get('Remark'); ?></label>
                        <textarea class="form-control" name="remark" rows="4" placeholder="<?php echo app('translator')->get('Remark'); ?>" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn--primary w-100 h-45"><?php echo app('translator')->get('Submit'); ?></button>
                </div>
            </form>
        </div>
    </div>
</div>


<div id="userStatusModal" class="modal fade" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <?php if($user->status == Status::USER_ACTIVE): ?>
                        <?php echo app('translator')->get('Ban Bettor'); ?>
                    <?php else: ?>
                        <?php echo app('translator')->get('Unban Bettor'); ?>
                    <?php endif; ?>
                </h5>
                <button type="button" class="close" data-bs-dismiss="modal"><i class="las la-times"></i></button>
            </div>
            <form action="<?php echo e(route('admin.users.status', $user->id)); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="modal-body">
                    <?php if($user->status == Status::USER_ACTIVE): ?>
                        <h6><?php echo app('translator')->get('If you ban this bettor, they will lose access to their dashboard.'); ?></h6>
                        <div class="form-group">
                            <label><?php echo app('translator')->get('Reason'); ?></label>
                            <textarea class="form-control" name="reason" rows="4" required></textarea>
                        </div>
                    <?php else: ?>
                        <p><strong><?php echo app('translator')->get('Ban reason was:'); ?></strong></p>
                        <p><?php echo e($user->ban_reason); ?></p>
                        <h5 class="text-center mt-3"><?php echo app('translator')->get('Are you sure you want to unban this bettor?'); ?></h5>
                    <?php endif; ?>
                </div>
                <div class="modal-footer">
                    <?php if($user->status == Status::USER_ACTIVE): ?>
                        <button type="submit" class="btn btn--primary w-100"><?php echo app('translator')->get('Submit'); ?></button>
                    <?php else: ?>
                        <button type="button" class="btn btn--dark" data-bs-dismiss="modal"><?php echo app('translator')->get('No'); ?></button>
                        <button type="submit" class="btn btn--primary"><?php echo app('translator')->get('Yes'); ?></button>
                    <?php endif; ?>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('breadcrumb-plugins'); ?>
<a href="<?php echo e(route('admin.users.login', $user->id)); ?>" target="_blank" class="btn btn-sm btn-outline--primary">
    <i class="las la-sign-in-alt"></i> <?php echo app('translator')->get('Login as Bettor'); ?>
</a>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('script'); ?>
<script>
    (function($) {
        "use strict";

        $('.bal-btn').on('click', function() {
            $('.balanceAddSub')[0].reset();
            var act = $(this).data('act');
            $('#addSubModal').find('input[name=act]').val(act);
            $('.type').text(act == 'add' ? 'Add' : 'Subtract');
        });

        let mobileElement = $('.mobile-code');
        $('select[name=country]').on('change', function() {
            mobileElement.text('+' + $('select[name=country] :selected').data('mobile_code'));
        });

    })(jQuery);
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home3/dannygue/apuestas.ballosbet.com/core/resources/views/admin/users/detail.blade.php ENDPATH**/ ?>