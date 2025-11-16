

<?php $__env->startSection('panel'); ?>
    <div class="row mb-3">
        <div class="col-lg-12">
            <div class="d-flex flex-wrap gap-3">
                <div class="flex-fill">
                    <?php if (isset($component)) { $__componentOriginal433d6a5be5b58ac8aa6a74031c6196f9 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal433d6a5be5b58ac8aa6a74031c6196f9 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.widget','data' => ['style' => '6','link' => 'javascript:void(0)','title' => 'Ganancias Totales de la Casa','icon' => 'las la-money-bill-wave','value' => ''.e(showAmount($totalEarnings)).'','bg' => 'success','type' => '2']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('widget'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['style' => '6','link' => 'javascript:void(0)','title' => 'Ganancias Totales de la Casa','icon' => 'las la-money-bill-wave','value' => ''.e(showAmount($totalEarnings)).'','bg' => 'success','type' => '2']); ?>
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
                <div class="flex-fill">
                    <?php if (isset($component)) { $__componentOriginal433d6a5be5b58ac8aa6a74031c6196f9 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal433d6a5be5b58ac8aa6a74031c6196f9 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.widget','data' => ['style' => '6','link' => 'javascript:void(0)','title' => 'Ganancias de Hoy','icon' => 'las la-calendar-day','value' => ''.e(showAmount($todayEarnings)).'','bg' => 'primary','type' => '2']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('widget'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['style' => '6','link' => 'javascript:void(0)','title' => 'Ganancias de Hoy','icon' => 'las la-calendar-day','value' => ''.e(showAmount($todayEarnings)).'','bg' => 'primary','type' => '2']); ?>
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
                <div class="flex-fill">
                    <?php if (isset($component)) { $__componentOriginal433d6a5be5b58ac8aa6a74031c6196f9 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal433d6a5be5b58ac8aa6a74031c6196f9 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.widget','data' => ['style' => '6','link' => 'javascript:void(0)','title' => 'Este Mes','icon' => 'las la-calendar-alt','value' => ''.e(showAmount($thisMonthEarnings)).'','bg' => 'info','type' => '2']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('widget'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['style' => '6','link' => 'javascript:void(0)','title' => 'Este Mes','icon' => 'las la-calendar-alt','value' => ''.e(showAmount($thisMonthEarnings)).'','bg' => 'info','type' => '2']); ?>
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
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="show-filter mb-3 text-end">
                <button type="button" class="btn btn-outline--primary showFilterBtn btn-sm">
                    <i class="las la-filter"></i> <?php echo app('translator')->get('Filter'); ?>
                </button>
            </div>
            <div class="card responsive-filter-card mb-4">
                <div class="card-body">
                    <form action="">
                        <div class="d-flex flex-wrap gap-4">
                            <div class="flex-grow-1">
                                <label><?php echo app('translator')->get('Buscar'); ?></label>
                                <input type="text" name="search" value="<?php echo e(request()->search); ?>" 
                                       class="form-control" placeholder="Número de apuesta o usuario">
                            </div>
                            <div class="flex-grow-1">
                                <label><?php echo app('translator')->get('Fecha Inicio'); ?></label>
                                <input type="date" name="start_date" value="<?php echo e(request()->start_date); ?>" 
                                       class="form-control" max="<?php echo e(date('Y-m-d')); ?>">
                            </div>
                            <div class="flex-grow-1">
                                <label><?php echo app('translator')->get('Fecha Fin'); ?></label>
                                <input type="date" name="end_date" value="<?php echo e(request()->end_date); ?>" 
                                       class="form-control" max="<?php echo e(date('Y-m-d')); ?>">
                            </div>
                            <div class="flex-grow-1 align-self-end">
                                <button class="btn btn--primary w-100 h-45"><i class="fas fa-filter"></i> <?php echo app('translator')->get('Filtrar'); ?></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card">
                <div class="card-body p-0">
                    <div class="table-responsive--lg table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                                <tr>
                                    <th><?php echo app('translator')->get('Fecha'); ?></th>
                                    <th><?php echo app('translator')->get('Número de Apuesta'); ?></th>
                                    <th><?php echo app('translator')->get('Usuario'); ?></th>
                                    <th><?php echo app('translator')->get('Monto Apostado'); ?></th>
                                    <th><?php echo app('translator')->get('Comisión'); ?> (%)</th>
                                    <th><?php echo app('translator')->get('Monto de Comisión'); ?></th>
                                    <th><?php echo app('translator')->get('Tipo'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $earnings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $earning): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td>
                                            <?php echo e(showDateTime($earning->created_at, 'd M, Y')); ?><br>
                                            <small class="text-muted"><?php echo e(diffForHumans($earning->created_at)); ?></small>
                                        </td>
                                        <td>
                                            <a href="<?php echo e(route('admin.report.transaction', $earning->user_id)); ?>?search=<?php echo e($earning->bet_number); ?>" class="fw-bold text--primary" title="Ver transacción">
                                                <i class="las la-external-link-alt"></i> <?php echo e($earning->bet_number); ?>

                                            </a>
                                        </td>
                                        <td>
                                            <span class="fw-bold"><?php echo e(@$earning->user->fullname); ?></span>
                                            <br>
                                            <span class="small">
                                                <a href="<?php echo e(route('admin.users.detail', $earning->user_id)); ?>">
                                                    <span>@</span><?php echo e(@$earning->user->username); ?>

                                                </a>
                                            </span>
                                        </td>
                                        <td>
                                            <span class="fw-bold"><?php echo e(showAmount($earning->bet_amount)); ?></span> 
                                            <?php echo e(__(gs('cur_text'))); ?>

                                        </td>
                                        <td>
                                            <span class="badge badge--dark"><?php echo e(getAmount($earning->commission_percent)); ?>%</span>
                                        </td>
                                        <td>
                                            <span class="fw-bold text--success">
                                                <?php echo e(showAmount($earning->commission_amount)); ?> <?php echo e(__(gs('cur_text'))); ?>

                                            </span>
                                        </td>
                                        <td>
                                            <?php if($earning->type == 'bet_commission'): ?>
                                                <span class="badge badge--primary"><?php echo app('translator')->get('Comisión de Apuesta'); ?></span>
                                            <?php elseif($earning->type == 'win_commission'): ?>
                                                <span class="badge badge--success"><?php echo app('translator')->get('Comisión de Ganancia'); ?></span>
                                            <?php else: ?>
                                                <span class="badge badge--info"><?php echo e(ucfirst(str_replace('_', ' ', $earning->type))); ?></span>
                                            <?php endif; ?>
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

                <?php if($earnings->hasPages()): ?>
                    <div class="card-footer py-4">
                        <?php echo e(paginateLinks($earnings)); ?>

                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('breadcrumb-plugins'); ?>
    <a href="<?php echo e(route('admin.dashboard')); ?>" class="btn btn-sm btn-outline--primary">
        <i class="la la-undo"></i> <?php echo app('translator')->get('Back'); ?>
    </a>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('script'); ?>
    <script>
        (function($) {
            "use strict";
            
            // Validar que la fecha de fin no sea menor que la fecha de inicio
            $('input[name="start_date"]').on('change', function() {
                var startDate = $(this).val();
                $('input[name="end_date"]').attr('min', startDate);
            });
            
            $('input[name="end_date"]').on('change', function() {
                var endDate = $(this).val();
                var startDate = $('input[name="start_date"]').val();
                
                if (startDate && endDate < startDate) {
                    alert('La fecha de fin no puede ser menor que la fecha de inicio');
                    $(this).val('');
                }
            });
        })(jQuery);
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home3/dannygue/apuestas.ballosbet.com/core/resources/views/admin/house_earnings/index.blade.php ENDPATH**/ ?>