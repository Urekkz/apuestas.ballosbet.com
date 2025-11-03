

<?php $__env->startSection('panel'); ?>
    <?php
        $isGameDataExists = $game->id ?? false;
    ?>

    <form action="<?php echo e(route('admin.game.store', $isGameDataExists ?? 0)); ?>" method="POST" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>
        <div class="row justify-content-center">

            <div class="col-xl-8">
                <div class="card">

                    <?php if (isset($component)) { $__componentOriginal18dbbe8156acff638b18e4b090367745 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal18dbbe8156acff638b18e4b090367745 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.ajax-preloader','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ajax-preloader'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal18dbbe8156acff638b18e4b090367745)): ?>
<?php $attributes = $__attributesOriginal18dbbe8156acff638b18e4b090367745; ?>
<?php unset($__attributesOriginal18dbbe8156acff638b18e4b090367745); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal18dbbe8156acff638b18e4b090367745)): ?>
<?php $component = $__componentOriginal18dbbe8156acff638b18e4b090367745; ?>
<?php unset($__componentOriginal18dbbe8156acff638b18e4b090367745); ?>
<?php endif; ?>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label><?php echo app('translator')->get('Event Type'); ?></label>
                                    <select class="form-control select2 slug" name="event_type" required>
                                        <option value="" selected disabled hidden><?php echo app('translator')->get('Select One'); ?></option>
                                        <option value="<?php echo e(Status::EVENT_TYPE_INDIVIDUAL); ?>" <?php if(@$game->is_outright === Status::NO): echo 'selected'; endif; ?>><?php echo app('translator')->get('Individual Match'); ?></option>
                                        <option value="<?php echo e(Status::EVENT_TYPE_OUTRIGHT); ?>" <?php if(@$game->is_outright === Status::YES): echo 'selected'; endif; ?>><?php echo app('translator')->get('Outright'); ?></option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-12" id="leaguesWrapper">
                                <div class="form-group">
                                    <label><?php echo app('translator')->get('League'); ?></label>
                                    <select class="form-control select2 slug" name="league_id" required>
                                        <option value="" selected disabled hidden><?php echo app('translator')->get('Select One'); ?></option>
                                        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <optgroup label="<?php echo e($category->name); ?>">
                                                <?php $__currentLoopData = $category->leagues; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $league): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option data-name="<?php echo e($league->name); ?>" data-logo="<?php echo e($league->logo()); ?>" data-category="<?php echo e($league->category_id); ?>" value="<?php echo e($league->id); ?>" <?php if(@$game->league_id == $league->id): echo 'selected'; endif; ?>><?php echo e(__($league->name)); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </optgroup>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label><?php echo app('translator')->get('Title'); ?></label>
                                    <input class="form-control slug" name="title" type="text" value="<?php echo e(old('title', @$game->title)); ?>" required>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label><?php echo app('translator')->get('Game Starts From'); ?></label>
                                    <input name="start_time" type="datetime-local" class="form-control bg--white"
                                           value="<?php echo e(old('start_time', @$game->start_time)); ?>" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><?php echo app('translator')->get('Bet Starts From'); ?></label>
                                    <input name="bet_start_time" type="datetime-local" class="form-control bg--white"
                                           value="<?php echo e(old('bet_start_time', @$game->bet_start_time)); ?>" required>
                                </div>
                            </div>

<!--  BLOQUE: Control de tiempo de apuesta -->
<div class="col-md-6">
    <div class="form-group">
        <label>Limite de tiempo de apuesta (minutos antes del inicio)</label>
        <input type="range"
               class="form-range"
               name="bet_time_limit"
               min="1"
               max="300"
               value="<?php echo e(old('bet_time_limit', @$game->bet_time_limit ?? 10)); ?>"
               id="betTimeLimitRange">
        <div>
            <output id="betTimeLimitValue" style="font-weight: bold;"><?php echo e(old('bet_time_limit', @$game->bet_time_limit ?? 10)); ?></output> minutos
        </div>
        <small class="form-text text-muted d-block mt-1">
            Arrastra para definir cuantos minutos antes del inicio se cerraran las apuestas.
        </small>
    </div>
</div>
<!--  FIN BLOQUE -->

                            <div class="col-12">
                                <div class="form-group">
                                    <label><?php echo app('translator')->get('Anuncio del Juego'); ?></label>
                                    <textarea class="form-control" name="announcement" rows="3" placeholder="Escribe un anuncio sobre este juego (opcional)..."><?php echo e(old('announcement', @$game->announcement)); ?></textarea>
                                    <small class="text-muted">Este anuncio aparecerá en la página principal cuando el juego esté activo</small>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label><?php echo app('translator')->get('Slug'); ?></label>
                                    <input class="form-control" name="slug" type="text" value="<?php echo e(old('slug', @$game->slug)); ?>" required>
                                </div>
                            </div>

                        </div>

                        <button class="btn btn--primary w-100 h-45" type="submit"><?php echo app('translator')->get('Submit'); ?></button>
                    </div>
                </div>
            </div>
        </div>
    </form>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('breadcrumb-plugins'); ?>
    <?php if (isset($component)) { $__componentOriginal3b9bf6c313f6db4d5c9389e5666c89a5 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3b9bf6c313f6db4d5c9389e5666c89a5 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.back','data' => ['route' => ''.e(route('admin.game.index')).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('back'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => ''.e(route('admin.game.index')).'']); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal3b9bf6c313f6db4d5c9389e5666c89a5)): ?>
<?php $attributes = $__attributesOriginal3b9bf6c313f6db4d5c9389e5666c89a5; ?>
<?php unset($__attributesOriginal3b9bf6c313f6db4d5c9389e5666c89a5); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal3b9bf6c313f6db4d5c9389e5666c89a5)): ?>
<?php $component = $__componentOriginal3b9bf6c313f6db4d5c9389e5666c89a5; ?>
<?php unset($__componentOriginal3b9bf6c313f6db4d5c9389e5666c89a5); ?>
<?php endif; ?>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('script-lib'); ?>
    <script src="<?php echo e(asset('assets/admin/js/moment.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/global/js/daterangepicker.min.js')); ?>"></script>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('style-lib'); ?>
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('assets/global/css/daterangepicker.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startPush('script'); ?>
    <script>
        (function($) {
            "use strict";

            let isExistTeamOne = "<?php echo e($isGameDataExists ? $game->team_one_id : old('team_one_id')); ?>";
            let isExistTeamTwo = "<?php echo e($isGameDataExists ? $game->team_two_id : old('team_two_id')); ?>";

            let counter = false;

            <?php if(old('league_id')): ?>
                $('[name=league_id]').val(<?php echo e(old('league_id')); ?>)
            <?php endif; ?>

            $('[name="event_type"]').on('change', function() {
                const type = $(this).val();
                if (type == `<?php echo e(Status::EVENT_TYPE_INDIVIDUAL); ?>`) {
                    removeTeams();
                    setIndvidualTeams();
                    getTeamsByCategory();
                } else {
                    removeTeams();
                }
            }).change();

            function setIndvidualTeams() {
                let teamOne = teamComponent('<?php echo app('translator')->get('Team One'); ?>', 'team_one_id');
                let teamTwo = teamComponent('<?php echo app('translator')->get('Team Two'); ?>', 'team_two_id');

                $('#leaguesWrapper').after(teamOne);
                $(teamOne).after(teamTwo);

                initializeSelect2($('.teamInput select'));
            }

            function removeTeams() {
                $('.teamInput').remove();
            }

            function teamComponent(label, name) {
                return $(`
                <div class="col-sm-6 teamInput">
                    <div class="form-group">
                        <label class="required">${label}</label>
                        <select class="form-control teams slug" name="${name}" required>
                            <option value="" selected disabled><?php echo app('translator')->get('Select One'); ?></option>
                        </select>
                    </div>
                </div>`);
            }

            function initializeSelect2(elements) {
                elements.each(function(i, e) {
                    $(e).wrap(`<div class="position-relative"></div>`).select2({
                        dropdownParent: $(this).parent(),
                    });
                });
            }

            function getTeamsByCategory() {
                let categoryId = $('[name=league_id]').find(":selected").data('category');
                if(!categoryId) return;

                $('.ajax-preloader').removeClass('d-none');

                $.ajax({
                    type: "get",
                    url: `<?php echo e(route('admin.game.teams', '')); ?>/${categoryId}`,
                    dataType: "json",
                    success: function(response) {
                        if (response.teams) {
                            $('.teams').removeAttr('disabled');
                            $('[name=team_one_id]').html(`<option value="" disabled <?php echo e($isGameDataExists ? '' : 'selected'); ?>><?php echo app('translator')->get('Select One'); ?></option>`);
                            $('[name=team_two_id]').html(`<option value="" disabled <?php echo e($isGameDataExists ? '' : 'selected'); ?>><?php echo app('translator')->get('Select One'); ?></option>`);
                            $.each(response.teams, function(i, team) {
                                $('[name=team_one_id]').append(`<option value="${team.id}" ${(isExistTeamOne == team.id) ? 'selected' : ''}> ${team.name}</option>`);
                                $('[name=team_two_id]').append(`<option value="${team.id}" ${(isExistTeamTwo == team.id) ? 'selected' : ''}> ${team.name}</option>`);
                            });
                            $('.ajax-preloader').addClass('d-none');
                        } else {
                            $('[name=team_one_id], [name=team_two_id]').html(`<option value="" selected disabled><?php echo app('translator')->get('Select One'); ?></option>`);
                            $('.ajax-preloader').addClass('d-none');
                            notify('error', response.error);
                        }
                    }
                });
            }

            $('[name=league_id]').on('change', function() {
                if (!this.value) return;
                if($('[name="event_type"]').val() == `<?php echo e(Status::EVENT_TYPE_INDIVIDUAL); ?>`) {
                    getTeamsByCategory();
                }
            }).change();

            $(document).on('change', '[name=team_one_id]', function() {
                let teamOneValue = this.value;
                let teamTwoValue = $('[name=team_two_id]').val();

                if (teamOneValue == teamTwoValue) {
                    $('[name=team_one_id]').val('');
                    notify('error', "Same team can't be opponent");
                }
                makeTitle();
            });

            $(document).on('change', '[name=team_two_id]', function() {
                let teamOneValue = $('[name=team_one_id]').val();
                let teamTwoValue = this.value;

                if (teamOneValue == teamTwoValue) {
                    $('[name=team_two_id]').val('');
                    notify('error', "Same team can't be opponent");
                }
                makeTitle();
            });

            $(document).on('change', '.slug', function() {
                makeGameSlug();
            });

function makeTitle() {
    let title = ``;
    if ($(document).find('[name=team_one_id]').val()) {
        title += `${$(document).find('[name=team_one_id]').find(':selected').html()} `;
    }
    if ($('[name=team_two_id]').val()) {
        title += `${' vs ' + $('[name=team_two_id]').find(':selected').html()} `;
    }
    $('[name=title]').val(title.trim());
}

function makeGameSlug() {
    let slug = ``;
    if ($('[name=league_id]').val()) {
        slug = `${$('[name=league_id]').find(':selected').data('name')} `;
    }
    let title = $('[name=title]').val();
    if (title) slug += title;
    slug = slug.trim().replace(/\s+/g, '-').toLowerCase();
    $('[name=slug]').val(slug);
}

// 🧩 Sincroniza el valor del control de rango con el texto mostrado
$('#betTimeLimitRange').on('input change', function() {
    $('#betTimeLimitValue').text(this.value);
});

})(jQuery)

    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home3/dannygue/apuestas.ballosbet.com/core/resources/views/admin/game/form.blade.php ENDPATH**/ ?>