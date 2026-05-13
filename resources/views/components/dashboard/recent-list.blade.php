{{--
=============================================================================
RECENT LIST WIDGET — SIMelek
=============================================================================
Props:
  $title    : Judul widget
  $items    : Collection/array item (setiap item harus punya: title, subtitle, badge, badgeColor, time, link)
  $icon     : Icon untuk header widget
  $emptyMsg : Pesan jika kosong
  $link     : Link "Lihat Semua"
  $linkText : Teks link
=============================================================================
--}}
@props([
    'title'    => 'Terbaru',
    'items'    => [],
    'icon'     => 'bi-list-ul',
    'emptyMsg' => 'Belum ada data.',
    'link'     => null,
    'linkText' => 'Lihat Semua',
])

<div class="widget-card">
    <div class="widget-header">
        <div class="widget-title">
            <i class="bi {{ $icon }}"></i>
            {{ $title }}
        </div>
        @if($link)
            <a href="{{ $link }}" class="widget-header-link">
                {{ $linkText }} <i class="bi bi-chevron-right"></i>
            </a>
        @endif
    </div>
    <div class="widget-body">
        @forelse($items as $item)
            <div class="recent-item {{ isset($item['link']) ? 'clickable' : '' }}"
                 @if(isset($item['link'])) onclick="window.location='{{ $item['link'] }}'" @endif>
                <div class="recent-item-left">
                    <div class="recent-avatar" style="background: {{ $item['color'] ?? '#6366f1' }}22; color: {{ $item['color'] ?? '#6366f1' }};">
                        <i class="bi {{ $item['icon'] ?? 'bi-circle-fill' }}"></i>
                    </div>
                    <div>
                        <div class="recent-title">{{ $item['title'] ?? '-' }}</div>
                        <div class="recent-sub">{{ $item['subtitle'] ?? '' }}</div>
                    </div>
                </div>
                <div class="recent-item-right">
                    @if(isset($item['badge']))
                        <span class="recent-badge" style="background: {{ $item['badgeColor'] ?? '#6366f1' }}22; color: {{ $item['badgeColor'] ?? '#6366f1' }};">
                            {{ $item['badge'] }}
                        </span>
                    @endif
                    @if(isset($item['time']))
                        <div class="recent-time">{{ $item['time'] }}</div>
                    @endif
                </div>
            </div>
        @empty
            <div class="widget-empty">
                <i class="bi bi-inbox"></i>
                <p>{{ $emptyMsg }}</p>
            </div>
        @endforelse
    </div>
</div>
