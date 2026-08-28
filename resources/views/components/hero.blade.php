@props(['icon' => 'sparkles', 'title', 'subtitle', 'stats' => []])
{{-- Banner común a todas las pantallas: chip de ícono, título y franja de indicadores. --}}
<section class="infra-hero">
    <div class="infra-hero-title">
        <span><i data-lucide="{{ $icon }}"></i></span>
        <div><h1>{{ $title }}</h1><p>{{ $subtitle }}</p></div>
    </div>

    @if(count($stats))
        <div class="infra-hero-stats">
            @foreach($stats as $stat)
                <div>
                    <span>
                        <strong>{{ $stat[1] }}</strong>
                        <small>{{ $stat[0] }}</small>
                        @isset($stat[2])<em>{{ $stat[2] }}</em>@endisset
                    </span>
                </div>
            @endforeach
        </div>
    @endif
    @if(trim($slot) !== '')
        <div class="infra-hero-actions">{{ $slot }}</div>
    @endif
</section>
