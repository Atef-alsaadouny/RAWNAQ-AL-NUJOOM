<?php $__env->startSection('page-title', __('Dashboard')); ?>

<?php $__env->startSection('content'); ?>

<div id="statsContainer">
    <?php echo $__env->make('admin.partials.dashboard-stats', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
</div>


<div id="unassignedContainer">
    <?php echo $__env->make('admin.partials.dashboard-unassigned', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
</div>


<div id="recentContainer">
    <?php echo $__env->make('admin.partials.dashboard-recent', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var seenTime = '<?php echo e(now()->toDateTimeString()); ?>';

    function updateDashboard(data) {
        var statsContainer = document.getElementById('statsContainer');
        if (statsContainer && data.stats_html) {
            statsContainer.innerHTML = data.stats_html;
        }
        var unassignedContainer = document.getElementById('unassignedContainer');
        if (unassignedContainer && data.unassigned_html) {
            unassignedContainer.innerHTML = data.unassigned_html;
        }
        var recentContainer = document.getElementById('recentContainer');
        if (recentContainer && data.recent_html) {
            recentContainer.innerHTML = data.recent_html;
        }
    }

    function poll() {
        fetch('<?php echo e(route("admin.dashboard.data")); ?>', {
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': (document.querySelector('meta[name=\"csrf-token\"]') || {}).content
            }
        })
        .then(function(r) {
            if (r.status === 419) { window.location.reload(); return; }
            if (!r.ok) throw new Error('Dashboard poll HTTP ' + r.status);
            return r.json();
        })
        .then(function(data) {
            if (!data) return;
            seenTime = data.server_time;
            updateDashboard(data);
        })
        .catch(function(err) { console.error('Dashboard poll error:', err); });
    }

    setInterval(poll, 10000);
    setTimeout(poll, 2000);
});
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/admin/dashboard.blade.php ENDPATH**/ ?>