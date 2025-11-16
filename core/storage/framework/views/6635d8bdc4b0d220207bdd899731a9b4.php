<?php $__env->startSection('panel'); ?>
    <form method="POST" action="<?php echo e(route('admin.setting.api.save')); ?>" id="apiForm">
        <?php echo csrf_field(); ?>
        <div class="row gy-4">
            <div class="col-md-6">

                <div class="row gy-4">
                    <div class="col-md-12">

                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0"><?php echo app('translator')->get('API Key'); ?></h5>
                            </div>
                            <div class="card-body">
                                <div class="form-group mb-0">
                                    <input class="form-control" type="text" name="ods_api_key" required value="<?php echo e(gs('ods_api_key')); ?>">
                                    <small class="text-muted"><i class="la la-info-circle"></i> <?php echo app('translator')->get('Get an API key via email by subscribing a plan.'); ?> <a href="https://the-odds-api.com/#get-access" target="blank"><?php echo app('translator')->get('See Plans'); ?></a></small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0"><?php echo app('translator')->get('Bookmaker Regions'); ?></h5>
                            </div>
                            <div class="card-body">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="form-check mb-0">
                                        <input class="form-check-input" type="checkbox" name="ods_api_regions[]" value="us" id="us-region" <?php if(in_array('us', gs('ods_api_regions')??[])): echo 'checked'; endif; ?>>
                                        <label class="form-check-label" for="us-region">
                                            <?php echo app('translator')->get('US'); ?>
                                        </label>
                                    </div>

                                    <div class="form-check mb-0">
                                        <input class="form-check-input" type="checkbox" name="ods_api_regions[]" value="uk" id="uk-region" <?php if(in_array('uk', gs('ods_api_regions')??[])): echo 'checked'; endif; ?>>
                                        <label class="form-check-label" for="uk-region">
                                            <?php echo app('translator')->get('UK'); ?>
                                        </label>
                                    </div>

                                    <div class="form-check mb-0">
                                        <input class="form-check-input" type="checkbox" name="ods_api_regions[]" value="eu" id="eu-region" <?php if(in_array('eu', gs('ods_api_regions')??[])): echo 'checked'; endif; ?>>
                                        <label class="form-check-label" for="eu-region">
                                            <?php echo app('translator')->get('EU'); ?>
                                        </label>
                                    </div>

                                    <div class="form-check mb-0">
                                        <input class="form-check-input" type="checkbox" name="ods_api_regions[]" value="au" id="au-region" <?php if(in_array('au', gs('ods_api_regions')??[])): echo 'checked'; endif; ?>>
                                        <label class="form-check-label" for="au-region">
                                            <?php echo app('translator')->get('AU'); ?>
                                        </label>
                                    </div>
                                </div>

                                <div class="mt-3">
                                    <small class="text-muted"><i class="la la-info-circle"></i> <?php echo app('translator')->get('The bookmakers provide the odds, and the integrated API offers several bookmakers from various regions. Valid regions are listed above—select the ones you want to use. Before selecting a region, ensure you understand both the region and the bookmaker, as this will impact the Usage Quota Cost of your API subscription.'); ?>
                                        <a href="https://the-odds-api.com/sports-odds-data/bookmaker-apis.html#us-bookmakers" target="blank"><?php echo app('translator')->get('See the list of bookmakers by region.'); ?></a>
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="col-md-6">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="form-group mb-0">
                            <label><?php echo app('translator')->get('Markets'); ?></label>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="ods_api_markets[]" value="h2h" id="head-to-head" <?php if(in_array('h2h', gs('ods_api_markets')??[])): echo 'checked'; endif; ?>>
                                <label class="form-check-label" for="head-to-head">
                                    <?php echo app('translator')->get('Head to head'); ?> / <?php echo app('translator')->get('Moneyline'); ?>
                                </label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="ods_api_markets[]" value="spreads" id="spread-points" <?php if(in_array('spreads', gs('ods_api_markets')??[])): echo 'checked'; endif; ?>>
                                <label class="form-check-label" for="spread-points">
                                    <?php echo app('translator')->get('Points spread'); ?> / <?php echo app('translator')->get('Handicap'); ?>
                                </label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="ods_api_markets[]" value="totals" id="totals" <?php if(in_array('totals', gs('ods_api_markets')??[])): echo 'checked'; endif; ?>>
                                <label class="form-check-label" for="totals">
                                    <?php echo app('translator')->get('Total'); ?> / <?php echo app('translator')->get('Over/Under'); ?>
                                </label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="ods_api_markets[]" value="outrights" id="outrights" <?php if(in_array('outrights', gs('ods_api_markets')??[])): echo 'checked'; endif; ?>>

                                <label class="form-check-label" for="outrights">
                                    <?php echo app('translator')->get('Outrights'); ?> / <?php echo app('translator')->get('Futures'); ?>
                                </label>
                            </div>

                            <div class="mt-3">
                                <small class="text-muted">
                                    <i class="la la-info-circle"></i>
                                    <?php echo app('translator')->get('For more information on the betting market list,'); ?>
                                    <a href="https://the-odds-api.com/sports-odds-data/betting-markets.html" target="blank"><?php echo app('translator')->get('Click here.'); ?></a>
                                    <?php echo app('translator')->get('We are fetching the odds of the market list above from the api. We fetch odds for the featured market types listed above from the API. Only the odds of these featured market types are retrieved from the provider. You also have the option to add more predefined markets for each game from Game Management > Markets of a game, as well as the option to add custom markets.'); ?>
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php if(!blank($categories)): ?>
            <div class="col-md-12 mt-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title"><?php echo app('translator')->get('Category Specific Bookmaker Regions'); ?> <small class="text-muted">(<?php echo app('translator')->get('Optional'); ?>)</small></h5>

                        <p class="fst-italic text--muted">
                            <i class="la la-info-circle"></i> <?php echo app('translator')->get('Regions will be managed based on the selections made above for each category. If you want to set up regions for a specific category, you can do so here.'); ?>
                        </p>
                    </div>
                    <div class="card-body">
                        <?php
                            $categories = $categories->chunk(ceil($categories->count() / 2));
                        ?>

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="list-group striped">
                                    <?php $__currentLoopData = $categories[0]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="list-group-item d-flex justify-content-between align-items-center">
                                            <?php echo e(__($category->name)); ?>

                                            <input type="hidden" name="category_id[]" value="<?php echo e($category->id); ?>">
                                            <div class="d-flex gap-3">
                                                <div class="form-check mb-0">
                                                    <input class="form-check-input" type="checkbox" name="category_api_regions[<?php echo e($category->id); ?>][]" value="us" id="us-region<?php echo e($category->id); ?>" <?php if($category->regions ? in_array('us', $category->regions) : false): echo 'checked'; endif; ?>>
                                                    <label class="form-check-label" for="us-region<?php echo e($category->id); ?>">
                                                        <?php echo app('translator')->get('US'); ?>
                                                    </label>
                                                </div>

                                                <div class="form-check mb-0">
                                                    <input class="form-check-input" type="checkbox" name="category_api_regions[<?php echo e($category->id); ?>][]" value="uk" id="uk-region<?php echo e($category->id); ?>" <?php if($category->regions ? in_array('uk', $category->regions) : false): echo 'checked'; endif; ?>>
                                                    <label class="form-check-label" for="uk-region<?php echo e($category->id); ?>">
                                                        <?php echo app('translator')->get('UK'); ?>
                                                    </label>
                                                </div>

                                                <div class="form-check mb-0">
                                                    <input class="form-check-input" type="checkbox" name="category_api_regions[<?php echo e($category->id); ?>][]" value="eu" id="eu-region<?php echo e($category->id); ?>" <?php if($category->regions ? in_array('eu', $category->regions) : false): echo 'checked'; endif; ?>>
                                                    <label class="form-check-label" for="eu-region<?php echo e($category->id); ?>">
                                                        <?php echo app('translator')->get('EU'); ?>
                                                    </label>
                                                </div>

                                                <div class="form-check mb-0">
                                                    <input class="form-check-input" type="checkbox" name="category_api_regions[<?php echo e($category->id); ?>][]" value="au" id="au-region<?php echo e($category->id); ?>" <?php if($category->regions ? in_array('au', $category->regions) : false): echo 'checked'; endif; ?>>
                                                    <label class="form-check-label" for="au-region<?php echo e($category->id); ?>">
                                                        <?php echo app('translator')->get('AU'); ?>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="list-group striped">
                                    <?php $__currentLoopData = $categories[1]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="list-group-item d-flex justify-content-between align-items-center">
                                            <?php echo e(__($category->name)); ?>

                                            <input type="hidden" name="category_id[]" value="<?php echo e($category->id); ?>">
                                            <div class="d-flex gap-3">
                                                <div class="form-check mb-0">
                                                    <input class="form-check-input" type="checkbox" name="category_api_regions[<?php echo e($category->id); ?>][]" value="us" id="us-region<?php echo e($category->id); ?>" <?php if($category->regions ? in_array('us', $category->regions) : false): echo 'checked'; endif; ?>>
                                                    <label class="form-check-label" for="us-region<?php echo e($category->id); ?>">
                                                        <?php echo app('translator')->get('US'); ?>
                                                    </label>
                                                </div>

                                                <div class="form-check mb-0">
                                                    <input class="form-check-input" type="checkbox" name="category_api_regions[<?php echo e($category->id); ?>][]" value="uk" id="uk-region<?php echo e($category->id); ?>" <?php if($category->regions ? in_array('uk', $category->regions) : false): echo 'checked'; endif; ?>>
                                                    <label class="form-check-label" for="uk-region<?php echo e($category->id); ?>">
                                                        <?php echo app('translator')->get('UK'); ?>
                                                    </label>
                                                </div>

                                                <div class="form-check mb-0">
                                                    <input class="form-check-input" type="checkbox" name="category_api_regions[<?php echo e($category->id); ?>][]" value="eu" id="eu-region<?php echo e($category->id); ?>" <?php if($category->regions ? in_array('eu', $category->regions) : false): echo 'checked'; endif; ?>>
                                                    <label class="form-check-label" for="eu-region<?php echo e($category->id); ?>">
                                                        <?php echo app('translator')->get('EU'); ?>
                                                    </label>
                                                </div>

                                                <div class="form-check mb-0">
                                                    <input class="form-check-input" type="checkbox" name="category_api_regions[<?php echo e($category->id); ?>][]" value="au" id="au-region<?php echo e($category->id); ?>" <?php if($category->regions ? in_array('au', $category->regions) : false): echo 'checked'; endif; ?>>
                                                    <label class="form-check-label" for="au-region<?php echo e($category->id); ?>">
                                                        <?php echo app('translator')->get('AU'); ?>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        <?php endif; ?>

        <button type="submit" class="btn btn--primary w-100 h-45 mt-3" form="apiForm"><?php echo app('translator')->get('Submit'); ?></button>

    </form>


<?php $__env->stopSection(); ?>


<?php $__env->startPush('style'); ?>
    <style>


        .list-group.striped .list-group-item:nth-child(odd){
            background-color: #fdfdfd;
        }

        .list-group.striped .list-group-item:nth-child(even){
            background-color: #f0f0f0;
        }

    </style>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home3/dannygue/apuestas.ballosbet.com/core/resources/views/admin/setting/api.blade.php ENDPATH**/ ?>