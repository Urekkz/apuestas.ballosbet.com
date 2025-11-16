<?php $__env->startSection('panel'); ?>
    <div class="row gy-3">
        <div class="col-12 d-flex justify-content-end gap-2 flex-wrap">
            <?php if (isset($component)) { $__componentOriginale48b4598ffc2f41a085f001458a956d1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale48b4598ffc2f41a085f001458a956d1 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.search-form','data' => ['placeholder' => 'Name / Slug']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('search-form'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['placeholder' => 'Name / Slug']); ?>
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
            <div class="bulkStatusBtnArea pointer-events-none">
                <button class="btn btn-outline--info h-100" data-bs-toggle="dropdown" type="button" aria-expanded="true">
                    <i class="las la-ellipsis-v"></i><?php echo app('translator')->get('Bulk Action'); ?>
                </button>

                <div class="dropdown-menu" data-popper-placement="bottom-end">
                    <button class="dropdown-item confirmationBtn enableAction" data-question="<?php echo app('translator')->get('Are you sure to enable the selected leagues?'); ?>" data-action="">
                        <i class="la la-eye"></i> <?php echo app('translator')->get('Enable'); ?>
                    </button>
                    <button class="dropdown-item confirmationBtn disableAction" data-question="<?php echo app('translator')->get('Are you sure to disable the selected leagues?'); ?>" data-action="">
                        <i class="la la-eye-slash"></i> <?php echo app('translator')->get('Disable'); ?>
                    </button>
                </div>
            </div>

            <button class="btn btn--dark" type="button" data-bs-toggle="offcanvas" data-bs-target="#filterData" aria-controls="filterData"> <i class="la la-sliders"></i> <?php echo app('translator')->get('Filter'); ?></button>
        </div>

        <div class="col-lg-12">
            <div class="card b-radius--10">
                <div class="card-body p-0">
                    <div class="table-responsive--md table-responsive">
                        <table class="table--light style--two table">
                            <thead>
                                <tr>
                                    <th>
                                        <div class="d-flex gap-2 align-items-center">
                                            <input type="checkbox" class="form-check-input m-0" id="bulkSelection">
                                            <?php echo app('translator')->get('Name'); ?>
                                        </div>
                                    </th>
                                    <th><?php echo app('translator')->get('Category'); ?></th>
                                    <th><?php echo app('translator')->get('Has Outrights'); ?></th>
                                    <th><?php echo app('translator')->get('In Season'); ?></th>
                                    <th><?php echo app('translator')->get('Status'); ?></th>
                                    <th><?php echo app('translator')->get('Action'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $leagues; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $league): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td>
                                            <div class="d-flex gap-2 justify-content-end justify-content-lg-start">
                                                <input type="checkbox" value="<?php echo e($league->id); ?>" class="bulkStatus">
                                                <div class="user gap-2">
                                                    <div class="thumb">
                                                        <img src="<?php echo e($league->logo()); ?>" alt="image">
                                                    </div>
                                                    <div><?php echo e(__($league->name)); ?></div>
                                                </div>
                                            </div>
                                        </td>

                                        <td><?php echo e(__(@$league->category->name)); ?></td>

                                        <td>
                                            <?php echo e(__($league->has_outrights ? 'Yes' : 'No')); ?>

                                        </td>

                                        <td>
                                            <?php echo $league->apiStatusBadge ?>
                                        </td>
                                        <td>
                                            <?php echo $league->statusBadge ?>
                                        </td>
                                        <td>
                                            <?php
                                                $league->image_with_path = getImage(getFilePath('league') . '/' . $league->image, getFileSize('league'));
                                            ?>
                                            <div class="button--group">
                                                <button type="button" class="btn btn-sm btn-outline--primary cuModalBtn editBtn" data-category_id="<?php echo e($league->category_id); ?>" data-image="<?php echo e($league->image_with_path); ?>" data-resource="<?php echo e($league); ?>" data-modal_title="<?php echo app('translator')->get('Edit League'); ?>">
                                                    <i class="la la-pencil"></i><?php echo app('translator')->get('Edit'); ?>
                                                </button>

                                                <?php if($league->status == Status::DISABLE): ?>
                                                    <button class="btn btn-sm btn-outline--success confirmationBtn" data-question="<?php echo app('translator')->get('Are you sure to enable this league?'); ?>" data-action="<?php echo e(route('admin.league.status', $league->id)); ?>">
                                                        <i class="la la-eye"></i> <?php echo app('translator')->get('Enable'); ?>
                                                    </button>
                                                <?php else: ?>
                                                    <button class="btn btn-sm btn-outline--danger confirmationBtn" data-question="<?php echo app('translator')->get('Are you sure to disable this league?'); ?>" data-action="<?php echo e(route('admin.league.status', $league->id)); ?>">
                                                        <i class="la la-eye-slash"></i> <?php echo app('translator')->get('Disable'); ?>
                                                    </button>
                                                <?php endif; ?>
                                            </div>
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

                <?php if($leagues->hasPages()): ?>
                    <div class="card-footer py-4">
                        <?php echo e(paginateLinks($leagues)); ?>

                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>


    <div class="offcanvas offcanvas-end" tabindex="-1" id="filterData" aria-labelledby="filterDataLabel">
        <div class="offcanvas-header">
            <h5 id="filterDataLabel"><?php echo app('translator')->get('Filter Data'); ?></h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <form action="" method="get" id="filterForm">
                <div class="form-group">
                    <label for="category_id"><?php echo app('translator')->get('Category'); ?></label>
                    <select name="category_id" id="category_id" class="form-control">
                        <option value="" selected><?php echo app('translator')->get('All'); ?></option>
                        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($category->id); ?>" <?php if(request('category_id') == $category->id): echo 'selected'; endif; ?>><?php echo e($category->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>


                <div class="form-group">
                    <label for="has_outrights"><?php echo app('translator')->get('Has Outrights'); ?></label>
                    <select name="has_outrights" id="has_outrights" class="form-control">
                        <option value="" selected><?php echo app('translator')->get('All'); ?></option>
                        <option value="<?php echo e(Status::YES); ?>" <?php if(request('has_outrights') == strval(Status::YES)): echo 'selected'; endif; ?>><?php echo app('translator')->get('Yes'); ?></option>
                        <option value="<?php echo e(Status::NO); ?>" <?php if(request('has_outrights') == strval(Status::NO)): echo 'selected'; endif; ?>><?php echo app('translator')->get('No'); ?></option>
                    </select>
                </div>

                <?php if(!(Route::is('admin.league.api.enabled') || Route::is('admin.league.manual.enabled'))): ?>
                    <div class="form-group">
                        <label><?php echo app('translator')->get('Has API Sport Key'); ?></label>
                        <select name="odds_api_sport_key" class="form-control">
                            <option value="">...</option>
                            <option value="<?php echo e(Status::YES); ?>" <?php if(request('odds_api_sport_key') == strval(Status::YES)): echo 'selected'; endif; ?>><?php echo app('translator')->get('Yes'); ?></option>
                            <option value="<?php echo e(Status::NO); ?>" <?php if(request('odds_api_sport_key') == strval(Status::NO)): echo 'selected'; endif; ?>><?php echo app('translator')->get('No'); ?></option>

                        </select>
                    </div>
                <?php endif; ?>

                <?php if(Route::is('admin.league.index')): ?>
                    <div class="form-group">
                        <label for="status"><?php echo app('translator')->get('In Season'); ?></label>
                        <select name="api_status" id="api_status" class="form-control">
                            <option value=""><?php echo app('translator')->get('Any'); ?></option>
                            <option value="<?php echo e(Status::YES); ?>" <?php if(request('api_status') == strval(Status::YES)): echo 'selected'; endif; ?>><?php echo app('translator')->get('Yes'); ?></option>
                            <option value="<?php echo e(Status::NO); ?>" <?php if(request('api_status') == strval(Status::NO)): echo 'selected'; endif; ?>><?php echo app('translator')->get('No'); ?></option>
                        </select>
                    </div>
                <?php endif; ?>

                <?php if(!(Route::is('admin.league.inseason.enabled') || Route::is('admin.league.api.enabled') || Route::is('admin.league.manual.enabled') || Route::is('admin.league.inseason.disabled'))): ?>
                    <div class="form-group">
                        <label for="status"><?php echo app('translator')->get('Status'); ?></label>
                        <select name="status" id="status" class="form-control">
                            <option value=""><?php echo app('translator')->get('All'); ?></option>
                            <option value="<?php echo e(Status::ENABLE); ?>" <?php if(request('status') == strval(Status::ENABLE)): echo 'selected'; endif; ?>><?php echo app('translator')->get('Enabled'); ?></option>
                            <option value="<?php echo e(Status::DISABLE); ?>" <?php if(request('status') == strval(Status::DISABLE)): echo 'selected'; endif; ?>><?php echo app('translator')->get('Disabled'); ?></option>
                        </select>
                    </div>
                <?php endif; ?>
            </form>
        </div>

        <div class="position-sticky bottom-0 p-3">
            <button type="submit" class="btn btn--primary w-100 h-45" form="filterForm"><?php echo app('translator')->get('Apply Filter'); ?></button>
        </div>
    </div>

    
    <div id="cuModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <form action="<?php echo e(route('admin.league.store')); ?>" method="POST" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <div class="modal-body">

                        <div class="alert alert-info p-3 flex-column" role="alert">
                            <h4><?php echo app('translator')->get('Automatic Add Info'); ?></h4>
                            <p>
                                <?php echo app('translator')->get('Leagues will be automatically fetched when the Fetch Leagues cron job runs on the server, but you must manually enable them to control API costs, allowing only the leagues you want to keep available for betting. You can also add leagues manually.'); ?>
                                <br>
                                <span class="text--danger"><?php echo app('translator')->get('Be careful when entering the API Sport Key—it must match the Sports API\'s "Sport Key" exactly, or games and odds will not be fetched automatically.'); ?></span>

                                <a href="https://the-odds-api.com/sports-odds-data/sports-apis.html" target="blank"><?php echo app('translator')->get('Get your API Sport Key here'); ?></a>
                            </p>
                        </div>

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label><?php echo app('translator')->get('Image'); ?></label>
                                    <?php if (isset($component)) { $__componentOriginaldbcc027cdd3569f61821c56d10b77c01 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaldbcc027cdd3569f61821c56d10b77c01 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.image-uploader','data' => ['image' => ''.e(getImage(getFilePath('league'), getFileSize('league'))).'','class' => 'w-100','type' => 'league','required' => false]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('image-uploader'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['image' => ''.e(getImage(getFilePath('league'), getFileSize('league'))).'','class' => 'w-100','type' => 'league','required' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginaldbcc027cdd3569f61821c56d10b77c01)): ?>
<?php $attributes = $__attributesOriginaldbcc027cdd3569f61821c56d10b77c01; ?>
<?php unset($__attributesOriginaldbcc027cdd3569f61821c56d10b77c01); ?>
<?php endif; ?>
<?php if (isset($__componentOriginaldbcc027cdd3569f61821c56d10b77c01)): ?>
<?php $component = $__componentOriginaldbcc027cdd3569f61821c56d10b77c01; ?>
<?php unset($__componentOriginaldbcc027cdd3569f61821c56d10b77c01); ?>
<?php endif; ?>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label><?php echo app('translator')->get('Category'); ?></label>
                                    <select name="category_id" class="form-control select2" required>
                                        <option value=""><?php echo app('translator')->get('Select One'); ?></option>
                                        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($category->id); ?>"><?php echo e(__($category->name)); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label><?php echo app('translator')->get('Name'); ?></label>
                                    <input type="text" class="form-control makeSlug" name="name" value="<?php echo e(old('name')); ?>" required />
                                </div>

                                <div class="form-group">
                                    <label><?php echo app('translator')->get('Short Name'); ?></label>
                                    <input type="text" class="form-control" name="short_name" value="<?php echo e(old('short_name')); ?>" required />
                                </div>

                                <div class="form-group">
                                    <label><?php echo app('translator')->get('API Sport Key'); ?></label>
                                    <input type="text" class="form-control" name="odds_api_sport_key" value="<?php echo e(old('odds_api_sport_key')); ?>" />
                                </div>

                                <div class="form-group">
                                    <label><?php echo app('translator')->get('Slug'); ?></label>
                                    <input type="text" class="form-control checkSlug" name="slug" value="<?php echo e(old('slug')); ?>" required />
                                    <code><?php echo app('translator')->get('Spaces are not allowed'); ?></code>
                                </div>

                                <div class="form-group">
                                    <label><?php echo app('translator')->get('Has Outrights'); ?></label> <small class="text-muted" title="<?php echo app('translator')->get('Bet on a final outcome of a tournament or competition.'); ?>"><i class="la la-info-circle"></i></small>
                                    <select name="has_outrights" class="form-control">
                                        <option value="<?php echo e(Status::NO); ?>"><?php echo app('translator')->get('No'); ?></option>
                                        <option value="<?php echo e(Status::YES); ?>"><?php echo app('translator')->get('Yes'); ?></option>
                                    </select>

                                    <small class="text--danger outrights-info d-none"><i class="la la-info-circle"></i> <?php echo app('translator')->get('You cant change the value of outrights for automatically added league.'); ?></small>
                                </div>


                                <div class="form-group">
                                    <label><?php echo app('translator')->get('In Season'); ?></label>
                                    <select name="api_status" class="form-control">
                                        <option value="<?php echo e(Status::YES); ?>"><?php echo app('translator')->get('Yes'); ?></option>
                                        <option value="<?php echo e(Status::NO); ?>"><?php echo app('translator')->get('No'); ?></option>
                                    </select>

                                    <small class="text--danger"><i class="la la-info-circle"></i> <?php echo app('translator')->get('This will be automatically managed by the Odds API if it has a valid API Sport Key.'); ?></small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn--primary w-100 h-45"><?php echo app('translator')->get('Submit'); ?></button>
                    </div>
                </form>
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
    <button type="button" class="btn btn-sm btn-outline--primary cuModalBtn" data-modal_title="<?php echo app('translator')->get('Add New League'); ?>">
        <i class="las la-plus"></i><?php echo app('translator')->get('Add New'); ?>
    </button>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('script-lib'); ?>
    <script src="<?php echo e(asset('assets/admin/js/cu-modal.js')); ?>"></script>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('style'); ?>
    <style>
        .bulkStatusBtnArea.pointer-events-none {
            opacity: 0.5;
        }

        .form-check-input {
            border: 1px solid #fff;
        }

        input:focus {
            box-shadow: none !important;
        }
    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('script'); ?>
    <script>
        (function($) {
            "use strict";

            let modal = $('#cuModal');

            $('.editBtn').on('click', function() {

                modal.find('select[name=category_id]').val($(this).data('category_id')).change();
                modal.find('[name=image]').removeAttr('required');
                modal.find('[name=image]').closest('.form-group').find('label').first().removeClass('required');
                modal.find('.image-upload-preview').attr('style', `background-image: url(${$(this).data('image')})`);

                if ($(this).data('resource').manually_added == '<?php echo e(Status::NO); ?>') {
                    $('.outrights-info').removeClass('d-none');
                    modal.find('[name=has_outrights]').attr('readonly', true);
                } else {
                    modal.find('[name=has_outrights]').removeAttr('readonly');
                }

                modal.find('[name=odds_api_sport_key]').attr('readonly', $(this).data('resource').manually_added == '<?php echo e(Status::NO); ?>');
            });

            var placeHolderImage = "<?php echo e(getImage(getFilePath('league'), getFileSize('league'))); ?>";

            $('#cuModal').on('hidden.bs.modal', function() {
                $('.outrights-info').addClass('d-none');
                $('#cuModal form')[0].reset();
                modal.find('select[name=category_id]').val('').change();
                modal.find('.image-upload-preview').attr('style', `background-image: url(${placeHolderImage})`);
                modal.find('[name=image]').attr('required', 'required');
                modal.find('[name=image]').closest('.form-group').find('label').first().addClass('required');
            });

            $('#bulkSelection').on('click', function() {
                $('.bulkStatus').prop('checked', this.checked);
                generateBulkStatusUrl();
            });


            $('.bulkStatus').on('click', function() {
                generateBulkStatusUrl();
            });


            function generateBulkStatusUrl() {
                let status = $('.bulkStatus:checked').map(function() {
                    return $(this).val();
                }).get().join(',');

                const bulkSelection = $('.bulkStatusBtnArea');

                if (status.length > 0) {
                    bulkSelection.removeClass('pointer-events-none');
                    let enableUrl = '<?php echo e(url('admin/leagues/bulk/status')); ?>' + '/<?php echo e(Status::ENABLE); ?>/' + status;
                    let disableUrl = '<?php echo e(url('admin/leagues/bulk/status')); ?>' + '/<?php echo e(Status::DISABLE); ?>/' + status;
                    bulkSelection.find(`.enableAction`).attr('data-action', enableUrl);
                    bulkSelection.find(`.disableAction`).attr('data-action', disableUrl);
                } else {
                    bulkSelection.addClass('pointer-events-none');
                    $('#bulkSelection').prop('checked', false);
                    bulkSelection.find(`.enableAction`).attr('data-action', '');
                    bulkSelection.find(`.disableAction`).attr('data-action', '');
                }
            }

        })(jQuery);
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home3/dannygue/apuestas.ballosbet.com/core/resources/views/admin/league.blade.php ENDPATH**/ ?>