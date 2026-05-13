{{--
=============================================================================
ACTIVITY FEED WIDGET — SIMelek
=============================================================================
Props:
  $activities : Collection/array ActivityLog (model ActivityLog)
  $limit      : Jumlah item yang ditampilkan (default: 8)
  $link       : Link "Lihat Semua"
=============================================================================
--}}
@props([
    'activities' => [],
    'limit'      => 8,
    'link'       => null,
])

<div class="widget-card">
    <div class="widget-header">
        <div class="widget-title">
            <i class="bi bi-clock-history"></i>
            Log Aktivitas Sistem
        </div>
        @if($link)
            <a href="{{ $link }}" class="widget-header-link">
                Lihat Semua <i class="bi bi-chevron-right"></i>
            </a>
        @endif
    </div>
    <div class="widget-body activity-feed">
        @forelse($activities->take($limit) as $activity)
            <div class="activity-item">
                <div class="activity-dot"></div>
                <div class="activity-content">
                    <div class="activity-text">
                        <strong>{{ $activity->user->name ?? 'System' }}</strong>
                        {{ $activity->description ?? $activity->action ?? '-' }}
                    </div>
                    <div class="activity-time">
                        <i class="bi bi-clock"></i>
                        {{ optional($activity->created_at)->diffForHumans() ?? '-' }}
                    </div>
                </div>
            </div>
        @empty
            <div class="widget-empty">
                <i class="bi bi-clock-history"></i>
                <p>Belum ada aktivitas tercatat.</p>
            </div>
        @endforelse
    </div>
</div>
