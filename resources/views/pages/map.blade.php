<x-hero icon="map-pinned" title="Mapa del campus" subtitle="Localiza aulas, laboratorios y servicios de la Facultad de Informática y Electrónica." :stats="[['Edificios', '5', 'registrados'], ['Espacios', '26', 'disponibles'], ['Laboratorios', '9', 'equipados']]" />
<div class="map-layout">
    <aside class="panel places-panel"><label class="search-field"><i data-lucide="search"></i><input type="search" placeholder="Buscar lugar..." data-place-search></label><div class="place-list">
        @foreach([['building-2','Edificio FIE-A','Aulas 101–305 · Lab. Circuitos'],['flask-conical','Bloque de Laboratorios','Control · Potencia · Energías'],['monitor','Centro de Cómputo','Laboratorios 1 y 2'],['landmark','Bloque Administrativo','Secretaría · Dirección']] as $index => $place)
            <button class="place-item {{ $index === 0 ? 'is-active' : '' }}" data-place="{{ $place[1] }}" data-detail="{{ $place[2] }}"><span><i data-lucide="{{ $place[0] }}"></i></span><div><b>{{ $place[1] }}</b><small>{{ $place[2] }}</small></div><i data-lucide="chevron-right"></i></button>
        @endforeach
    </div><div class="place-detail"><small>UBICACIÓN SELECCIONADA</small><h2 data-place-title>Edificio FIE-A</h2><p data-place-detail>Aulas 101–305 · Lab. Circuitos</p><button class="primary-button" data-toast="Ruta trazada desde tu ubicación"><i data-lucide="navigation"></i> Trazar ruta</button></div>
    </aside>
    <section class="campus-map" aria-label="Mapa ilustrado del campus">
        <div class="map-road road-a"></div><div class="map-road road-b"></div><div class="map-green green-a"></div><div class="map-green green-b"></div>
        <div class="map-building building-a"><span>FIE-A</span></div><div class="map-building building-b"><span>LABS</span></div><div class="map-building building-c"><span>CÓMPUTO</span></div><div class="map-building building-d"><span>ADMIN</span></div>
        @foreach([['pin-a','Edificio FIE-A'],['pin-b','Bloque de Laboratorios'],['pin-c','Centro de Cómputo'],['pin-d','Bloque Administrativo']] as $pin)
            <button class="map-pin {{ $pin[0] }}" title="{{ $pin[1] }}" data-toast="{{ $pin[1] }} seleccionado"><i data-lucide="map-pin"></i></button>
        @endforeach
        <div class="map-controls"><button data-toast="Zoom aumentado">+</button><button data-toast="Zoom reducido">−</button><button data-toast="Mapa centrado"><i data-lucide="locate-fixed"></i></button></div>
        <div class="map-layers"><button class="is-active">Mapa</button><button data-toast="Vista satelital simulada">Satélite</button><button data-toast="Vista híbrida simulada">Híbrido</button></div>
    </section>
</div>
