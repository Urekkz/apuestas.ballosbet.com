<?php $__env->startSection('panel'); ?>
    <div class="alert alert-info p-3 flex-column" role="alert">
        <p>
            <?php echo app('translator')->get('If you update the system from an older version and have already added categories, please match the list with the Odds API Sports List and update the "Name in API" field if it matches.'); ?>
        </p>
    </div>

    <div class="row gy-3">
        <div class="col-lg-12">
            <div class="card b-radius--10">
                <div class="card-body p-0">
                    <div class="table-responsive--md table-responsive">
                        <table class="table--light style--two table">
                            <thead>
                                <tr>
                                    <th><?php echo app('translator')->get('Name'); ?></th>
                                    <th><?php echo app('translator')->get('Name in API'); ?></th>
                                    <th><?php echo app('translator')->get('Slug'); ?></th>
                                    <th><?php echo app('translator')->get('Icon'); ?></th>
                                    <th><?php echo app('translator')->get('Leagues'); ?></th>
                                    <th><?php echo app('translator')->get('Teams'); ?></th>
                                    <th><?php echo app('translator')->get('Status'); ?></th>
                                    <th><?php echo app('translator')->get('Action'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td><?php echo e(__($category->name)); ?></td>
                                        <td><?php echo e(__($category->odds_api_name ?? '...')); ?></td>
                                        <td><?php echo e($category->slug); ?></td>
                                        <td><?php echo $category->icon ?></td>
                                        <td><?php echo e($category->leagues_count); ?></td>
                                        <td><?php echo e($category->teams_count); ?></td>
                                        <td>
                                            <?php echo $category->statusBadge ?>
                                        </td>
                                        <td>
                                            <div class="button--group">
                                                <button type="button" class="btn btn-sm btn-outline--primary cuModalBtn editBtn" data-resource="<?php echo e($category); ?>" data-modal_title="<?php echo app('translator')->get('Edit Category'); ?>">
                                                    <i class="la la-pencil"></i><?php echo app('translator')->get('Edit'); ?>
                                                </button>

                                                <?php if($category->status == Status::DISABLE): ?>
                                                    <button class="btn btn-sm btn-outline--success confirmationBtn" data-question="<?php echo app('translator')->get('Are you sure to enable this category?'); ?>" data-action="<?php echo e(route('admin.category.status', $category->id)); ?>">
                                                        <i class="la la-eye"></i> <?php echo app('translator')->get('Enable'); ?>
                                                    </button>
                                                <?php else: ?>
                                                    <button class="btn btn-sm btn-outline--danger confirmationBtn" data-question="<?php echo app('translator')->get('Are you sure to disable this category?'); ?>" data-action="<?php echo e(route('admin.category.status', $category->id)); ?>">
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

                <?php if($categories->hasPages()): ?>
                    <div class="card-footer py-4">
                        <?php echo e(paginateLinks($categories)); ?>

                    </div>
                <?php endif; ?>

            </div>
        </div>
    </div>

    <div id="cuModal" class="modal modal-lg fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <form action="<?php echo e(route('admin.category.store')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <div class="modal-body">

                        <div class="alert alert-info p-3 flex-column" role="alert">
                            <h4><?php echo app('translator')->get('Automatic Add Info'); ?></h4>

                            <p>
                                <?php echo app('translator')->get('You can manually add new categories here or import them from the API. If the "Name in API" field matches the Odds API sports group name, all leagues in that category will be automatically fetched when the Fetch Leagues cron job runs on the server. Otherwise, you will need to add them manually.'); ?>
                                <span class="text--danger"><?php echo app('translator')->get('If the "Name in API" does not match the sports group name in the Odds API, leagues for that category cannot be fetched.'); ?></span>

                                <a href="https://the-odds-api.com/sports-odds-data/sports-apis.html" target="blank"><?php echo app('translator')->get('Click here to see the Odds API sports group names'); ?></a>
                            </p>
                        </div>


                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label><?php echo app('translator')->get('Name'); ?></label>
                                    <input type="text" class="form-control makeSlug" name="name" value="<?php echo e(old('name')); ?>" required />
                                </div>

                                <div class="form-group">
                                    <label><?php echo app('translator')->get('Name in API'); ?></label>
                                    <input type="text" class="form-control" name="odds_api_name" value="<?php echo e(old('odds_api_name')); ?>" />
                                    <small class="text-muted"><i class="la la-info-circle"></i> <?php echo app('translator')->get('To fetch the odds correctly from the API, use the exact name as listed in the "Group" column of the table on the Sports List in the Odds API. Ensure the name matches exactly for accurate data retrieval.'); ?> <a href="https://the-odds-api.com/sports-odds-data/sports-apis.html" target="blank"><?php echo app('translator')->get('View Sports List'); ?>.</a></small>
                                </div>

                                <div class="form-group">
                                    <label><?php echo app('translator')->get('Slug'); ?></label>
                                    <input type="text" class="form-control checkSlug" name="slug" value="<?php echo e(old('slug')); ?>" required />
                                    <code><?php echo app('translator')->get('Spaces are not allowed'); ?></code>
                                </div>
                                <div class="form-group sportsIconParent">
                                    <label><?php echo app('translator')->get('Icon'); ?></label>
                                    <input type="text" class="form-control sportsIcon" autocomplete="off" name="icon" required>
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

    <!-- Modal -->
    <div class="modal fade" id="fetchCategoriesModal" tabindex="-1" aria-labelledby="fetchCategoriesModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="fetchCategoriesModalLabel"><?php echo app('translator')->get('Add Categories from API'); ?></h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><i class="la la-times"></i></button>
                </div>

                <div class="modal-body">
                    <form action="<?php echo e(route('admin.category.fetched.save')); ?>" method="post" id="addCategoriesForm">
                        <?php echo csrf_field(); ?>
                        <div class="categories-list"></div>
                    </form>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn--primary w-100 h-45" form="addCategoriesForm"><?php echo app('translator')->get('Add Selected Category'); ?></button>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('breadcrumb-plugins'); ?>
    <?php if (isset($component)) { $__componentOriginale48b4598ffc2f41a085f001458a956d1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale48b4598ffc2f41a085f001458a956d1 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.search-form','data' => ['placeholder' => 'Name']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('search-form'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['placeholder' => 'Name']); ?>
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

    <button type="button" class="btn btn-outline--dark" data-bs-toggle="modal" data-bs-target="#fetchCategoriesModal">
        <i class="la la-sync"></i> <?php echo app('translator')->get('Fetch Categories'); ?>
    </button>

    <button type="button" class="btn btn-sm btn-outline--primary h-45 cuModalBtn" data-modal_title="<?php echo app('translator')->get('Add New Category'); ?>">
        <i class="las la-plus"></i><?php echo app('translator')->get('Add New'); ?>
    </button>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('style-lib'); ?>
    <link href="<?php echo e(asset('assets/admin/css/sports-iconpicker.css')); ?>" rel="stylesheet">
<?php $__env->stopPush(); ?>

<?php $__env->startPush('script-lib'); ?>
    <script src="<?php echo e(asset('assets/admin/js/sport-icons-picker.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/admin/js/cu-modal.js')); ?>"></script>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('style'); ?>
    <style>
        td .custom-icon {
            font-size: 1.5rem;
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
            const categoryModal = $('#fetchCategoriesModal');

            categoryModal.on('show.bs.modal', function(e) {
                categoryModal.find('.categories-list').html(`<div class="text-center p-5"><i class="la la-circle-notch la-spin la-3x text-muted"></i></div>`);

                fetchCategories();
            });


            function fetchCategories() {
                $.get("<?php echo e(route('admin.category.fetch')); ?>",
                    function(response) {
                        if (response.status == 'error') {
                            categoryModal.find('.categories-list').html(`<h6 class="p-3 text-center text--danger">${response.message}</h6>`);
                        } else {
                            if (response.categories) {
                                if (response.categories.length) {
                                    let result = `<h6 class="text-center mb-3"><?php echo app('translator')->get('Choose categories to add from the list below'); ?></h6>`;
                                    response.categories.forEach((category) => {
                                        result += `
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    <input type="checkbox" class="form-check-input my-0" name="categories[]" id="category-slug" value="${category}">
                                                    ${category}
                                                </label>
                                            </div>`
                                    });
                                    categoryModal.find('.categories-list').html(result);
                                } else {
                                    categoryModal.find('.categories-list').html(`<p class="p-3 text-center">No more categories available</p>`);
                                }

                            }
                        }
                    }
                );
            }

        })(jQuery);
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home3/dannygue/apuestas.ballosbet.com/core/resources/views/admin/category.blade.php ENDPATH**/ ?>