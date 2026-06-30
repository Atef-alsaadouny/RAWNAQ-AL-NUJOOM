@extends('layouts.admin')

@section('page-title', __('Dashboard'))

@section('content')
{{-- Stats Cards --}}
<div id="statsContainer">
    @include('admin.partials.dashboard-stats')
</div>

{{-- Unassigned Appointments --}}
<div id="unassignedContainer">
    @include('admin.partials.dashboard-unassigned')
</div>

{{-- Recent Appointments --}}
<div id="recentContainer">
    @include('admin.partials.dashboard-recent')
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    var seenTime = '{{ now()->toDateTimeString() }}';

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
        fetch('{{ route("admin.dashboard.data") }}', {
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
@endpush
