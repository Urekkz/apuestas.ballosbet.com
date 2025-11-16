<div class="col-12">
    <div class="card custom--card mb-4">
        <div class="card-body">
            <div class="widget-card-inner">
                <div class="widget-card bg--success">
                    <a href="<?php echo e(url()->route('admin.withdraw.data.approved', request()->all())); ?>" class="widget-card-link"></a>
                    <div class="widget-card-left">
                        <div class="widget-card-icon">
                            <i class="las la-check-circle"></i>
                        </div>
                        <div class="widget-card-content">
                            <h6 class="widget-card-amount"><?php echo e(showAmount($successful)); ?></h6>
                            <p class="widget-card-title"><?php echo app('translator')->get('Approved Withdrawal'); ?></p>
                        </div>
                    </div>
                    <span class="widget-card-arrow">
                        <i class="las la-angle-right"></i>
                    </span>
                </div>

                <div class="widget-card bg--warning">
                    <a href="<?php echo e(url()->route('admin.withdraw.data.pending', request()->all())); ?>" class="widget-card-link"></a>
                    <div class="widget-card-left">
                        <div class="widget-card-icon">
                            <i class="fas fa-spinner"></i>
                        </div>
                        <div class="widget-card-content">
                            <h6 class="widget-card-amount"><?php echo e(showAmount($pending)); ?></h6>
                            <p class="widget-card-title"><?php echo app('translator')->get('Pending Withdrawals'); ?></p>
                        </div>
                    </div>
                    <span class="widget-card-arrow">
                        <i class="las la-angle-right"></i>
                    </span>
                </div>

                <div class="widget-card bg--danger">
                    <a href="<?php echo e(url()->route('admin.withdraw.data.rejected', request()->all())); ?>" class="widget-card-link"></a>
                    <div class="widget-card-left">
                        <div class="widget-card-icon">
                            <i class="fas fa-ban"></i>
                        </div>
                        <div class="widget-card-content">
                            <h6 class="widget-card-amount"><?php echo e(showAmount($rejected)); ?></h6>
                            <p class="widget-card-title"><?php echo app('translator')->get('Rejected Withdrawals'); ?></p>
                        </div>
                    </div>
                    <span class="widget-card-arrow">
                        <i class="las la-angle-right"></i>
                    </span>
                </div>

            </div>
        </div>
    </div>
</div>
<?php /**PATH /home3/dannygue/apuestas.ballosbet.com/core/resources/views/admin/withdraw/widget.blade.php ENDPATH**/ ?>