<x-hero icon="package-search" title="Catálogo de equipos" subtitle="Encuentra herramientas y equipos para tus prácticas de laboratorio." :stats="[['Disponibles', '47', 'unidades'], ['Categorías', '4', 'activas'], ['Mi solicitud', '0', 'equipos']]">
    <button class="hero-button" type="button" data-open-cart><i data-lucide="shopping-basket"></i> Ver solicitud <span data-cart-count>0</span></button>
</x-hero>
<div class="catalog-layout">
    <aside class="filter-panel panel"><div class="panel-header"><div><small>REFINAR</small><h2>Filtros</h2></div><button class="text-button" data-clear-filters>Limpiar</button></div>
        <label class="search-field"><i data-lucide="search"></i><input type="search" placeholder="Buscar equipo..." data-catalog-search></label>
        <fieldset><legend>Categoría</legend><label><input type="radio" name="category" value="all" checked> Todas</label><label><input type="radio" name="category" value="Herramientas"> Herramientas</label><label><input type="radio" name="category" value="Equipos"> Equipos</label><label><input type="radio" name="category" value="Tecnológico"> Tecnológico</label></fieldset>
        <fieldset><legend>Disponibilidad</legend><label><input type="checkbox" data-only-available> Solo disponibles</label></fieldset>
    </aside>
    <section><div class="results-head"><span><b data-result-count>{{ count($catalog) }}</b> equipos encontrados</span><div class="segmented compact"><button class="is-active" data-catalog-view="grid"><i data-lucide="grid-2x2"></i></button><button data-catalog-view="list"><i data-lucide="list"></i></button></div></div>
        <div class="product-grid" data-catalog-grid>
        @foreach($catalog as $item)<article class="product-card" data-product data-name="{{ strtolower($item['name'].' '.$item['serial']) }}" data-category="{{ $item['category'] }}" data-available="{{ $item['stock'] > 0 ? 'true' : 'false' }}">
            <div class="product-image"><img src="{{ $item['image'] }}" alt="{{ $item['name'] }}"><x-badge :value="$item['stock'] > 0 ? 'Disponible' : 'Agotado'" /></div>
            <div class="product-body"><span>{{ $item['category'] }} · {{ $item['serial'] }}</span><h3>{{ $item['name'] }}</h3><p><i data-lucide="map-pin"></i>{{ $item['location'] }}</p><div class="stock-line"><span><i style="width: {{ $item['total'] ? ($item['stock'] / $item['total']) * 100 : 0 }}%"></i></span><b>{{ $item['stock'] }}/{{ $item['total'] }}</b></div>
            <button class="add-button" type="button" data-add-cart data-id="{{ $item['id'] }}" data-name="{{ $item['name'] }}" {{ $item['stock'] === 0 ? 'disabled' : '' }}><i data-lucide="plus"></i>{{ $item['stock'] ? 'Agregar' : 'Sin stock' }}</button></div>
        </article>@endforeach
        </div>
    </section>
</div>
<aside class="cart-drawer" data-cart-drawer aria-hidden="true"><div class="cart-head"><div><small>SOLICITUD</small><h2>Equipos seleccionados</h2></div><button class="icon-button" data-close-cart>×</button></div><div class="cart-items" data-cart-items><div class="empty-cart"><i data-lucide="shopping-basket"></i><p>Aún no agregas equipos.</p></div></div><div class="cart-form"><label>Asignatura<input value="Circuitos Eléctricos I"></label><label>Fecha de uso<input type="date" value="2026-09-02"></label><button class="primary-button" data-submit-cart>Generar solicitud</button></div></aside><div class="drawer-backdrop" data-close-cart></div>
