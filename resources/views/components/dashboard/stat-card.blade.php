{{--
=============================================================================
REUSABLE STAT CARD WIDGET — SIMelek
=============================================================================
Props:
  $title    : Judul kartu (string)
  $value    : Nilai/angka utama
  $subtitle : Teks kecil di bawah value (opsional)
  $icon     : Bootstrap Icon class (contoh: 'bi-people')
  $color    : Warna aksen (hex atau CSS var)
  $gradient : Gradient class atau inline style (opsional)
  $link     : URL untuk link "Lihat detail" (opsional)
  $linkText : Teks link (default: 'Lihat Detail')
  $trend    : Nilai trend (opsional, misal: '+5 bulan ini')
  $trendUp  : boolean — warna trend (hijau jika true, merah jika false)
=============================================================================
--}}
@props([
    'title'    => 'Statistik',
    'value'    => '0',
    'subtitle' => null,
    'icon'     => 'bi-bar-chart',
    'color'    => '#6366f1',
    'link'     => null,
    'linkText' => 'Lihat Detail',
    'trend'    => null,
    'trendUp'  => true,
])

<div class="stat-card">
    <div class="stat-card-body">
        <div class="stat-card-icon" style="background: {{ $color }}22; color: {{ $color }};">
            <i class="bi {{ $icon }}"></i>
        </div>
        <div class="stat-card-content">
            <div class="stat-value">{{ $value }}</div>
            <div class="stat-title">{{ $title }}</div>
            @if($subtitle)
                <div class="stat-subtitle">{{ $subtitle }}</div>
            @endif
            @if($trend)
                <div class="stat-trend {{ $trendUp ? 'trend-up' : 'trend-down' }}">
                    <i class="bi bi-{{ $trendUp ? 'arrow-up-right' : 'arrow-down-right' }}"></i>
                    {{ $trend }}
                </div>
            @endif
        </div>
    </div>
    @if($link)
        <a href="{{ $link }}" class="stat-card-link">
            {{ $linkText }} <i class="bi bi-arrow-right"></i>
        </a>
    @endif
</div>
