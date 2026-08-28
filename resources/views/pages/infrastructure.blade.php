@php
    $campusBuildings = [
        ['name' => 'Edificio FIE-A', 'spaces' => '12 espacios', 'status' => 'Operativo', 'floors' => 3, 'area' => '1 850'],
        ['name' => 'Edificio FIE-B', 'spaces' => '8 espacios', 'status' => 'Operativo', 'floors' => 2, 'area' => '1 200'],
        ['name' => 'Bloque de Laboratorios', 'spaces' => '6 espacios', 'status' => 'Operativo', 'floors' => 2, 'area' => '980'],
        ['name' => 'Centro de Cómputo', 'spaces' => '4 espacios', 'status' => 'Operativo', 'floors' => 1, 'area' => '640'],
        ['name' => 'Bloque Administrativo', 'spaces' => '3 espacios', 'status' => 'Mantenimiento', 'floors' => 2, 'area' => '520'],
    ];
    $campusSpaces = [
        ['code' => 'FIE-101', 'type' => 'Aula', 'floor' => 'Planta baja', 'capacity' => 40, 'status' => 'Disponible'],
        ['code' => 'FIE-102', 'type' => 'Aula', 'floor' => 'Planta baja', 'capacity' => 38, 'status' => 'Ocupada'],
        ['code' => 'Lab. Circuitos', 'type' => 'Laboratorio', 'floor' => 'Primer piso', 'capacity' => 24, 'status' => 'Disponible'],
        ['code' => 'FIE-201', 'type' => 'Aula', 'floor' => 'Primer piso', 'capacity' => 45, 'status' => 'Disponible'],
        ['code' => 'FIE-302', 'type' => 'Aula', 'floor' => 'Segundo piso', 'capacity' => 42, 'status' => 'Mantenimiento'],
        ['code' => 'Sala Docentes', 'type' => 'Oficina', 'floor' => 'Segundo piso', 'capacity' => 12, 'status' => 'Disponible'],
    ];
    $totalCapacity = array_sum(array_column($campusSpaces, 'capacity'));
@endphp

<x-hero icon="building-2" title="Infraestructura" subtitle="Gestiona los edificios, aulas y laboratorios del campus."
    :stats="[['Edificios', '5', 'operativos'], ['Espacios', '31', 'registrados'], ['Disponibles', '26', 'ahora'], ['Mantenimiento', '2', 'espacios']]">
    <button class="hero-button" type="button" data-modal-open="building-modal"><i data-lucide="plus"></i> Nuevo edificio</button>
</x-hero>

<div class="master-detail">
    <section class="panel master-panel">
        <div class="panel-header">
            <div><small>CAMPUS</small><h2>Edificios</h2></div>
        </div>
        <label class="search-field"><i data-lucide="search"></i><input type="search" placeholder="Buscar edificio o espacio..." data-table-search></label>
        <div class="building-list">
            @foreach($campusBuildings as $index => $building)
                <button class="building-row {{ $index === 0 ? 'is-active' : '' }}" type="button" data-building="{{ $building['name'] }}" data-search-row>
                    <span class="building-icon"><i data-lucide="building-2"></i></span>
                    <div>
                        <b>{{ $building['name'] }}</b>
                        <small>{{ $building['spaces'] }} · {{ $building['floors'] }} pisos · {{ $building['area'] }} m²</small>
                    </div>
                    <x-badge :value="$building['status']" />
                </button>
            @endforeach
        </div>
        <div class="panel-footer">
            <span><i data-lucide="info"></i> 5 edificios registrados.</span>
            <button class="secondary-button" type="button" data-modal-open="building-modal"><i data-lucide="plus"></i> Agregar</button>
        </div>
    </section>

    <section class="panel detail-panel">
        <div class="panel-header">
            <div><small>EDIFICIO SELECCIONADO</small><h2 data-building-title>Edificio FIE-A</h2></div>
            <div class="row-actions">
                <button class="secondary-button" type="button" data-modal-open="building-modal"><i data-lucide="pencil"></i> Editar</button>
                <button class="primary-button" type="button" data-modal-open="space-modal"><i data-lucide="plus"></i> Agregar espacio</button>
            </div>
        </div>

        <div class="detail-metrics">
            <div><small>Capacidad total</small><strong>{{ $totalCapacity }}</strong><span>Suma de sus espacios</span></div>
            <div><small>Ocupación</small><strong>68%</strong><span>Promedio semanal</span></div>
            <div><small>Área total</small><strong>1 850 m²</strong><span>Construida</span></div>
            <div><small>Pisos</small><strong>3</strong><span>Planta baja + 2</span></div>
        </div>

        <div class="space-grid">
            @foreach($campusSpaces as $space)
                <article>
                    <span><i data-lucide="door-open"></i></span>
                    <small>{{ $space['type'] }} · {{ $space['floor'] }}</small>
                    <h3>{{ $space['code'] }}</h3>
                    <p class="space-capacity"><i data-lucide="users"></i> {{ $space['capacity'] }} personas</p>
                    <x-badge :value="$space['status']" />
                    <div class="row-actions">
                        <button class="row-action" type="button" title="Editar espacio" data-modal-open="space-modal"><i data-lucide="pencil"></i></button>
                        <button class="row-action" type="button" title="Gestionar equipamiento" data-modal-open="equipment-modal"><i data-lucide="package"></i></button>
                        <button class="row-action danger" type="button" title="Eliminar" data-toast="{{ $space['code'] }} eliminado en la demostración"><i data-lucide="trash-2"></i></button>
                    </div>
                </article>
            @endforeach
        </div>
    </section>
</div>

<div class="modal" id="building-modal" aria-hidden="true">
    <form class="modal-card demo-form wide-modal" data-demo-form>
        <button class="modal-close" type="button" data-modal-close aria-label="Cerrar">×</button>
        <small>INFRAESTRUCTURA</small>
        <h2>Nuevo edificio</h2>
        <label>Nombre del edificio<input required placeholder="Edificio FIE-C"></label>
        <div class="form-grid">
            <label>Pisos<input type="number" min="1" value="3"></label>
            <label>Área (m²)<input type="number" min="0" placeholder="1000"></label>
        </div>
        <div class="form-grid">
            <label>Estado<select><option>Operativo</option><option>Mantenimiento</option><option>Fuera de servicio</option></select></label>
            <label>Ícono representativo<select><option>Edificio</option><option>Laboratorio</option><option>Cómputo</option><option>Administrativo</option></select></label>
        </div>
        <label>Capacidad total (auto)<input value="{{ $totalCapacity }}" readonly><small class="field-hint">Se calcula sumando la capacidad de sus espacios.</small></label>
        <label class="file-drop">
            <i data-lucide="image-plus"></i>
            <span><b>Imagen del edificio</b><small>Clic para subir · JPG o PNG, máx. 5 MB</small></span>
            <input type="file" accept="image/png,image/jpeg">
        </label>
        <div class="map-picker" data-toast="Ubicación seleccionada en el mapa">
            <i data-lucide="map-pin"></i>
            <span><b>Ubicación en mapa</b><small>Haz clic para ubicar el edificio en el campus.</small></span>
        </div>
        <div class="modal-actions">
            <button class="secondary-button" type="button" data-modal-close>Cancelar</button>
            <button class="primary-button" type="submit">Guardar edificio</button>
        </div>
    </form>
</div>

<div class="modal" id="space-modal" aria-hidden="true">
    <form class="modal-card demo-form" data-demo-form>
        <button class="modal-close" type="button" data-modal-close aria-label="Cerrar">×</button>
        <small>ESPACIOS</small>
        <h2>Agregar espacio</h2>
        <label>Nombre<input required placeholder="Lab. de Electrónica"></label>
        <div class="form-grid">
            <label>Tipo<select><option>Aula</option><option>Laboratorio</option><option>Oficina</option><option>Auditorio</option></select></label>
            <label>Piso<select><option>Planta baja</option><option>Primer piso</option><option>Segundo piso</option></select></label>
        </div>
        <div class="form-grid">
            <label>Capacidad<input type="number" min="1" value="30"></label>
            <label>Estado<select><option>Disponible</option><option>Ocupada</option><option>Mantenimiento</option></select></label>
        </div>
        <label>Edificio<select>@foreach($campusBuildings as $building)<option>{{ $building['name'] }}</option>@endforeach</select></label>
        <label>Observaciones<textarea placeholder="Equipamiento fijo, aire acondicionado, proyector..."></textarea></label>
        <div class="modal-actions">
            <button class="secondary-button" type="button" data-modal-close>Cancelar</button>
            <button class="primary-button" type="submit">Guardar espacio</button>
        </div>
    </form>
</div>

<div class="modal" id="equipment-modal" aria-hidden="true">
    <form class="modal-card demo-form" data-demo-form>
        <button class="modal-close" type="button" data-modal-close aria-label="Cerrar">×</button>
        <small>EQUIPAMIENTO</small>
        <h2>Equipos del espacio</h2>
        <label class="search-field"><i data-lucide="search"></i><input type="search" placeholder="Buscar equipo del inventario..."></label>
        <div class="check-list">
            @foreach($inventory as $item)
                <label class="check-inline"><input type="checkbox" @checked($loop->index < 2)> {{ $item['name'] }} <span class="check-meta">{{ $item['code'] }}</span></label>
            @endforeach
        </div>
        <div class="modal-actions">
            <button class="secondary-button" type="button" data-modal-close>Cancelar</button>
            <button class="primary-button" type="submit">Guardar equipamiento</button>
        </div>
    </form>
</div>
