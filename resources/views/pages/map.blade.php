@php
    $places = $campus['buildings'];
    $totalSpaces = array_sum(array_map(fn ($place) => count($place['spaces']), $places));
    $totalLabs = array_sum(array_map(
        fn ($place) => count(array_filter($place['spaces'], fn ($space) => $space['kind'] === 'Laboratorio')),
        $places
    ));
    $placeIcons = ['building-2', 'flask-conical', 'monitor', 'landmark'];
@endphp

<x-hero icon="map-pinned" title="Mapa del campus" subtitle="Localiza aulas, laboratorios y servicios de la institución."
    :stats="[['Edificios', count($places), 'registrados'], ['Espacios', $totalSpaces, 'disponibles'], ['Laboratorios', $totalLabs, 'equipados']]" />

<div class="map-layout">
    <aside class="panel places-panel">
        <label class="search-field"><i data-lucide="search"></i><input type="search" placeholder="Buscar lugar..." data-place-search></label>

        <div class="place-list">
            @foreach($places as $index => $place)
                @php $spaceNames = implode(' · ', array_slice(array_column($place['spaces'], 'name'), 0, 3)); @endphp
                <button class="place-item {{ $index === 0 ? 'is-active' : '' }}" type="button"
                    data-infra-marker
                    data-marker-index="{{ $index }}"
                    data-marker-lat="{{ $place['lat'] }}"
                    data-marker-lng="{{ $place['lng'] }}"
                    data-marker-title="{{ $place['name'] }}"
                    data-marker-detail="{{ $spaceNames }}"
                    data-place-name="{{ mb_strtolower($place['name'].' '.$spaceNames) }}">
                    <span><i data-lucide="{{ $placeIcons[$index % count($placeIcons)] }}"></i></span>
                    <div><b>{{ $place['name'] }}</b><small>{{ $spaceNames }}</small></div>
                    <i data-lucide="chevron-right"></i>
                </button>
            @endforeach
        </div>

        <div class="place-detail">
            <small>UBICACIÓN SELECCIONADA</small>
            <h2 data-place-title>{{ $places[0]['name'] }}</h2>
            <p data-place-detail>{{ implode(' · ', array_slice(array_column($places[0]['spaces'], 'name'), 0, 3)) }}</p>
            <div class="place-detail-meta">
                <span><i data-lucide="layers"></i> {{ $places[0]['floors'] }} pisos</span>
                <span><i data-lucide="door-open"></i> {{ count($places[0]['spaces']) }} espacios</span>
            </div>
            <button class="pill-button solid" type="button" data-toast="Ruta trazada desde tu ubicación"><i data-lucide="navigation"></i> Trazar ruta</button>
        </div>
    </aside>

    <section class="infra-map-view" aria-label="Mapa del campus">
        <div class="campus-map" data-infra-map></div>

        <div class="map-style-switch infra-map-styles">
            <button class="is-active" type="button" data-infra-map-style="street">Mapa</button>
            <button type="button" data-infra-map-style="satellite">Satélite</button>
            <button type="button" data-infra-map-style="hybrid">Híbrido</button>
        </div>

        <div class="infra-map-zoom">
            <button class="icon-button" type="button" data-infra-map-zoom-in aria-label="Acercar"><i data-lucide="plus"></i></button>
            <button class="icon-button" type="button" data-infra-map-zoom-out aria-label="Alejar"><i data-lucide="minus"></i></button>
            <button class="icon-button" type="button" data-infra-map-center aria-label="Centrar"><i data-lucide="locate-fixed"></i></button>
        </div>
    </section>
</div>
