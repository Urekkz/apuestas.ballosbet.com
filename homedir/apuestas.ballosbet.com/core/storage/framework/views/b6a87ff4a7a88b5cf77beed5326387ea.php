<div class="app-nav">
    <div class="container-fluid">
        <div class="row g-0">
            <div class="col-12">
                <ul class="app-nav__menu list list--row justify-content-between align-items-center">
                    <li>
                        <a class="app-nav__menu-link active" href="<?php echo e(route('home')); ?>">
                            <span class="app-nav__menu-icon">
                                <img src="<?php echo e(asset($activeTemplateTrue . 'images/bet-now.png')); ?>" alt="<?php echo app('translator')->get('image'); ?>">
                            </span>
                            <span class="app-nav__menu-text"> <?php echo app('translator')->get('Bet Now'); ?> </span>
                        </a>
                    </li>

                    <li>
                        <a class="app-nav__menu-link" href="<?php echo e(route('contact')); ?>">
                            <span class="app-nav__menu-icon">
                                <i class="la la-headset"></i>
                            </span>
                            <span class="app-nav__menu-text"> <?php echo app('translator')->get('Contact'); ?> </span>
                        </a>
                    </li>

                    <li class="app-nav__menu-link-important-container">
                        <a class="app-nav__menu-link-important mobile-category" href="javascript:void(0)">
                            <i class="fas fa-bars"></i>
                        </a>
                    </li>

                    <li>
                        <a class="app-nav__menu-link open-betslip position-relative" href="javascript:void(0)">
                            <span class="bet-count"><?php echo e(collect(session('bets'))->count()); ?></span>
                            <span class="app-nav__menu-icon">
                                <i class="fa-thin fa-clipboard-list-check"></i>
                            </span>
                            <span class="app-nav__menu-text"><?php echo app('translator')->get('Bet Slip'); ?></span>
                        </a>
                    </li>

                    <li>
                        <?php if(auth()->guard()->check()): ?>
                            <a class="app-nav__menu-link" href="<?php echo e(route('user.home')); ?>">
                                <span class="app-nav__menu-icon">
                                    <img src="<?php echo e(asset($activeTemplateTrue . 'images/user.png')); ?>" alt="<?php echo app('translator')->get('image'); ?>">
                                </span>
                                <span class="app-nav__menu-text"> <?php echo app('translator')->get('Dashboard'); ?> </span>
                            </a>
                        <?php else: ?>
                            <a class="app-nav__menu-link"
                               <?php if(request()->routeIs('user.login')): ?>
                                   href="<?php echo e(route('user.login')); ?>"
                               <?php else: ?>
                                   href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#loginModal"
                               <?php endif; ?>>
                                <span class="app-nav__menu-icon">
                                    <img src="<?php echo e(asset($activeTemplateTrue . 'images/user.png')); ?>" alt="<?php echo app('translator')->get('image'); ?>">
                                </span>
                                <span class="app-nav__menu-text"> <?php echo app('translator')->get('Login'); ?> </span>
                            </a>
                        <?php endif; ?>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="app-nav__drawer">
        <ul class="list app-nav__drawer-list">
            <li>
                <a class="app-nav__drawer-link" href="<?php echo e(route('home')); ?>">
                    <span class="app-nav__drawer-icon">
                        <i class="las la-home"></i>
                    </span>
                    <span class="app-nav__drawer-text"> <?php echo app('translator')->get('Home'); ?> </span>
                </a>
            </li>
            <li>
                <a class="app-nav__drawer-link" href="<?php echo e(route('blog')); ?>">
                    <span class="app-nav__drawer-icon">
                        <i class="las la-newspaper"></i>
                    </span>
                    <span class="app-nav__drawer-text"> <?php echo app('translator')->get('News & Updates'); ?> </span>
                </a>
            </li>
            <li>
                <a class="app-nav__drawer-link" href="<?php echo e(route('contact')); ?>">
                    <span class="app-nav__drawer-icon">
                        <i class="las la-headset"></i>
                    </span>
                    <span class="app-nav__drawer-text"> <?php echo app('translator')->get('Contact'); ?> </span>
                </a>
            </li>
            <li>
                <div class="select-lang--container">
                    <div class="select-lang">
                        <span class="select-lang__icon">
                            <i class="las la-percent"></i>
                        </span>
                        <select class="form-select oddsType">
                            <option value="" disabled><?php echo app('translator')->get('Select Odds Type'); ?></option>
                            <option value="decimal" <?php if(session('odds_type') == 'decimal'): echo 'selected'; endif; ?>><?php echo app('translator')->get('Decimal'); ?></option>
                            <option value="fraction" <?php if(session('odds_type') == 'fraction'): echo 'selected'; endif; ?>><?php echo app('translator')->get('Fraction'); ?></option>
                            <option value="american" <?php if(session('odds_type') == 'american'): echo 'selected'; endif; ?>><?php echo app('translator')->get('American Odds'); ?></option>
                        </select>
                    </div>
                </div>
            </li>

            <?php if(gs('multi_language')): ?>
                <?php
                    $languages = App\Models\Language::all();
                    $language = $languages->where('code', '!=', session('lang'));
                    $activeLanguage = $languages->where('code', session('lang'))->first();
                ?>
                <li>
                    <div class="dropdown-lang dropdown mt-0">
                        <a href="#" class="language-btn dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                            <img class="flag" src="<?php echo e(getImage(getFilePath('language') . '/' . @$activeLanguage->image, getFileSize('language'))); ?>" alt="us">
                            <span class="language-text text-white"><?php echo e(__(@$activeLanguage->name)); ?></span>
                        </a>
                        <ul class="dropdown-menu">
                            <?php $__currentLoopData = $language; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li>
                                    <a href="javascript:void(0)" class="langSel" data-code="<?php echo e($item->code); ?>">
                                        <img class="flag" src="<?php echo e(getImage(getFilePath('language') . '/' . @$item->image, getFileSize('language'))); ?>" alt="image">
                                        <?php echo e(__(@$item->name)); ?>

                                    </a>
                                </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                </li>
            <?php endif; ?>
        </ul>
    </div>
</div>
<?php /**PATH /home3/dannygue/apuestas.ballosbet.com/core/resources/views/templates/basic/partials/mobile_menu.blade.php ENDPATH**/ ?>