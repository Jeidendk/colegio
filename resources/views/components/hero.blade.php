@props(['icon' => 'sparkles', 'title', 'subtitle', 'stats' => []])
<section class="hero-panel">
    <span class="hero-icon"><i data-lucide="{{ $icon }}"></i></span>
    <div class="hero-copy">
        <h1>{{ $title }}</h1>
        <p>{{ $subtitle }}</p>
    </div>
    @if(count($stats))
        <div class="hero-stats">
            @foreach($stats as $stat)
                <div><span>{{ $stat[0] }}</span><strong>{{ $stat[1] }}</strong><small>{{ $stat[2] }}</small></div>
            @endforeach
        </div>
    @endif
    {{ $slot }}
</section>
