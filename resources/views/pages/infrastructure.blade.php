@php
    $buildings = $campus['buildings'];
    $selectedBuilding = $buildings[0];
    $floorLabel = fn (int $floor): string => 'P'.$floor;
    $countByKind = fn (array $building, string $kind): int => count(array_filter($building['spaces'], fn ($space) => $space['kind'] === $kind));
@endphp

<section class="infra-hero">
    <div class="infra-hero-title">
        <span><i data-lucide="building-2"></i></span>
        <div><h1>Infraestructura</h1><p>Edificios, aulas y laboratorios del campus.</p></div>
    </div>

    <div class="infra-view-tabs" role="tablist" aria-label="Vistas de infraestructura">
        <button class="is-active" type="button" role="tab" aria-selected="true" data-infra-view="management"><i data-lucide="layout-grid"></i> Gestión</button>
        <button type="button" role="tab" aria-selected="false" data-infra-view="map"><i data-lucide="map"></i> Mapa campus</button>
    </div>

    <div class="infra-hero-stats">
        <div><i data-lucide="building-2"></i><span><strong>{{ $campus['stats']['buildings'] }}</strong><small>Edificios</small></span></div>
        <div><i data-lucide="door-open"></i><span><strong>{{ $campus['stats']['spaces'] }}</strong><small>Espacios</small></span></div>
        <div><i data-lucide="school"></i><span><strong>{{ $campus['stats']['classrooms'] }}</strong><small>Aulas</small></span></div>
        <div><i data-lucide="flask-conical"></i><span><strong>{{ $campus['stats']['labs'] }}</strong><small>Labs</small></span></div>
    </div>
</section>

<div class="infra-layout" data-infra-panel="management">
    <aside class="panel infra-tree">
        <div class="infra-tree-head">
            <h2>Edificios y espacios</h2>
            <button class="round-button small" type="button" title="Registrar edificio" data-modal-open="building-modal"><i data-lucide="plus"></i></button>
        </div>

        <label class="search-field"><i data-lucide="search"></i><input type="search" placeholder="Buscar edificio o espacio..." data-tree-search></label>

        <div class="infra-tree-list">
            @foreach($buildings as $index => $building)
                <div class="tree-building {{ $index === 0 ? 'is-open' : '' }}" data-tree-building data-building-name="{{ mb_strtolower($building['name']) }}">
                    <button class="tree-building-head {{ $index === 0 ? 'is-active' : '' }}" type="button" data-tree-toggle>
                        <i class="tree-chevron" data-lucide="chevron-down"></i>
                        <span class="tree-mark"><i data-lucide="building-2"></i></span>
                        <b>{{ $building['name'] }}</b>
                        <span class="tree-count">{{ count($building['spaces']) }}</span>
                        <span class="tree-add" role="button" tabindex="0" title="Agregar espacio" data-modal-open="space-modal"><i data-lucide="plus"></i></span>
                    </button>

                    <ul class="tree-spaces">
                        @foreach($building['spaces'] as $space)
                            <li data-tree-space data-space-name="{{ mb_strtolower($space['name']) }}">
                                <button type="button" data-toast="{{ $space['name'] }} · {{ $building['name'] }}">
                                    <i class="dot status-{{ Str::slug($space['status']) }}"></i>
                                    <span>{{ $space['name'] }}</span>
                                    <small>{{ $floorLabel($space['floor']) }}</small>
                                </button>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endforeach
        </div>

        <button class="tree-add-space" type="button" data-modal-open="space-modal"><i data-lucide="plus"></i> Agregar espacio</button>
        <p class="tree-footer">{{ $campus['stats']['buildings'] }} edificios · {{ $campus['stats']['spaces'] }} espacios</p>
    </aside>

    <section class="infra-detail">
        <article class="panel building-card">
            <img class="building-photo" src="{{ $selectedBuilding['photo'] }}" alt="{{ $selectedBuilding['name'] }}">
            <div class="building-identity">
                <h2>{{ mb_strtoupper($selectedBuilding['name']) }} <x-badge :value="$selectedBuilding['status']" /></h2>
                <p><i data-lucide="map-pin"></i> {{ $selectedBuilding['place'] }}</p>
            </div>
            <div class="building-metrics">
                <div><i data-lucide="building"></i><span><strong>{{ $selectedBuilding['floors'] }}</strong><small>pisos</small></span></div>
                <div><i data-lucide="ruler"></i><span><strong>{{ $selectedBuilding['area'] }} m²</strong><small>Área total</small></span></div>
                <div><i data-lucide="layers"></i><span><strong>{{ $selectedBuilding['occupancy'] }}%</strong><small>Ocupación</small></span></div>
            </div>
            <div class="building-actions">
                <button class="pill-button" type="button" data-modal-open="building-modal"><i data-lucide="pencil"></i> Editar</button>
                <button class="pill-button danger" type="button" data-toast="{{ $selectedBuilding['name'] }} eliminado en la demostración"><i data-lucide="trash-2"></i> Eliminar</button>
            </div>
        </article>

        <section class="panel spaces-panel" data-spaces-panel>
            <div class="toolbar spaces-toolbar">
                <label class="search-field"><i data-lucide="search"></i><input type="search" placeholder="Buscar espacio..." data-space-filter-search></label>

                <div class="chip-filters" data-space-chips>
                    <button class="filter-chip is-active" type="button" data-space-kind=""><i data-lucide="layers"></i> Todos<b>{{ count($selectedBuilding['spaces']) }}</b></button>
                    <button class="filter-chip" type="button" data-space-kind="Aula"><i data-lucide="school"></i> Aulas<b>{{ $countByKind($selectedBuilding, 'Aula') }}</b></button>
                    <button class="filter-chip" type="button" data-space-kind="Laboratorio"><i data-lucide="flask-conical"></i> Laboratorios<b>{{ $countByKind($selectedBuilding, 'Laboratorio') }}</b></button>
                </div>

                <select class="select-control" data-space-status>
                    <option value="">Estado: Todos</option>
                    <option>Disponible</option>
                    <option>Ocupada</option>
                    <option>Mantenimiento</option>
                </select>

                <div class="segmented compact layout-switch">
                    <button class="is-active" type="button" data-space-layout="grid" title="Tarjetas"><i data-lucide="layout-grid"></i></button>
                    <button type="button" data-space-layout="list" title="Lista"><i data-lucide="list"></i></button>
                </div>

                <button class="pill-button solid" type="button" data-modal-open="space-modal"><i data-lucide="plus"></i> Agregar espacio</button>
            </div>

            <div class="space-cards" data-space-cards>
                @foreach($selectedBuilding['spaces'] as $space)
                    <article class="space-card" data-space-item
                        data-space-name="{{ mb_strtolower($space['name']) }}"
                        data-space-kind="{{ $space['kind'] }}"
                        data-space-status="{{ $space['status'] }}">
                        <div class="space-cover">
                            <img src="{{ $space['photo'] }}" alt="{{ $space['name'] }}">
                            <x-badge :value="$space['status']" />
                        </div>
                        <div class="space-body">
                            <div class="space-heading">
                                <h3>{{ $space['name'] }}</h3>
                                <span class="space-tag {{ $space['category'] === 'Técnico' ? 'is-technical' : '' }}">
                                    <i data-lucide="{{ $space['category'] === 'Técnico' ? 'wrench' : 'book-open' }}"></i> {{ $space['category'] }}
                                </span>
                            </div>
                            <p class="space-equipment">{{ $space['kind'] }} · {{ $selectedBuilding['name'] }}</p>
                            <div class="space-meta">
                                <span><i data-lucide="file-text"></i> Piso {{ $space['floor'] }}</span>
                                <span><i data-lucide="users"></i> {{ $space['capacity'] }} est.</span>
                                <span><i data-lucide="ruler"></i> {{ $space['area'] }} m²</span>
                                <div class="row-actions">
                                    <button class="row-action" type="button" title="Fotos" data-toast="Galería de {{ $space['name'] }}"><i data-lucide="camera"></i></button>
                                    <button class="row-action" type="button" title="Editar" data-modal-open="space-modal"><i data-lucide="pencil"></i></button>
                                    <button class="row-action danger" type="button" title="Eliminar" data-toast="{{ $space['name'] }} eliminado en la demostración"><i data-lucide="trash-2"></i></button>
                                </div>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>

            <p class="empty-state hidden" data-spaces-empty><i data-lucide="search-x"></i> Ningún espacio coincide con los filtros.</p>
        </section>
    </section>
</div>

<div class="infra-map-view hidden" data-infra-panel="map">
    <div class="campus-map" data-infra-map></div>

    <div class="map-style-switch infra-map-styles">
        <button class="is-active" type="button" data-infra-map-style="street">Mapa</button>
        <button type="button" data-infra-map-style="satellite">Satélite</button>
        <button type="button" data-infra-map-style="hybrid">Híbrido</button>
    </div>

    <div class="infra-map-actions">
        <button class="pill-button solid" type="button" data-modal-open="building-modal"><i data-lucide="plus"></i> Edificio</button>
        <button class="pill-button solid" type="button" data-modal-open="space-modal"><i data-lucide="plus"></i> Espacio</button>
    </div>

    <div class="infra-map-zoom">
        <button class="icon-button" type="button" data-infra-map-zoom-in aria-label="Acercar"><i data-lucide="plus"></i></button>
        <button class="icon-button" type="button" data-infra-map-zoom-out aria-label="Alejar"><i data-lucide="minus"></i></button>
        <button class="icon-button" type="button" data-infra-map-center aria-label="Centrar"><i data-lucide="navigation"></i></button>
    </div>

    @foreach($buildings as $index => $building)
        <span hidden data-infra-marker
            data-marker-index="{{ $index }}"
            data-marker-lat="{{ $building['lat'] }}"
            data-marker-lng="{{ $building['lng'] }}"
            data-marker-title="{{ $building['name'] }}"
            data-marker-detail="{{ count($building['spaces']) }} espacios · {{ $building['floors'] }} pisos"></span>
    @endforeach
</div>

<div class="modal" id="building-modal" aria-hidden="true">
    <form class="modal-card demo-form split-modal" data-demo-form>
        <button class="modal-close" type="button" data-modal-close aria-label="Cerrar">×</button>
        <h2>Registrar edificio</h2>
        <p class="modal-subtitle">Agregue un nuevo edificio al campus.</p>

        <div class="split-modal-body">
            <div class="split-modal-media">
                <span class="field-label">Imagen del edificio</span>
                <label class="photo-drop">
                    <i data-lucide="image"></i>
                    <b>Clic para subir imagen</b>
                    <small>JPG, PNG — Máx. 5MB</small>
                    <span class="photo-drop-badge"><i data-lucide="camera"></i></span>
                    <input type="file" accept="image/png,image/jpeg">
                </label>

                <div class="field-label-row">
                    <span class="field-label">Ubicación en mapa</span>
                    <button class="link-action" type="button" data-toast="Ubicación tomada de tu posición actual"><i data-lucide="map-pin"></i> Usar mi ubicación</button>
                </div>
                <div class="modal-map" data-modal-map></div>
                <p class="field-hint warning"><i data-lucide="info"></i> Haz clic en el mapa para ubicar.</p>
            </div>

            <div class="split-modal-fields">
                <label class="export-field">Nombre del edificio<input required placeholder="Bloque de Bachillerato"></label>

                <span class="field-label">Ícono representativo</span>
                <div class="icon-picker" data-icon-picker>
                    <button class="is-active" type="button" data-icon="building-2"><i data-lucide="building-2"></i></button>
                    <button type="button" data-icon="flask-conical"><i data-lucide="flask-conical"></i></button>
                    <button type="button" data-icon="book-open"><i data-lucide="book-open"></i></button>
                    <button type="button" data-icon="monitor"><i data-lucide="monitor"></i></button>
                    <button type="button" data-icon="activity"><i data-lucide="activity"></i></button>
                    <button type="button" data-icon="coffee"><i data-lucide="coffee"></i></button>
                </div>

                <div class="form-grid">
                    <label class="export-field">Pisos<input type="number" min="1" value="1"></label>
                    <label class="export-field">Área (m²)<input type="number" min="0" placeholder="1000"></label>
                </div>

                <div class="form-grid">
                    <label class="export-field">Aulas académicas<input type="number" min="0" value="0"></label>
                    <label class="export-field">Laboratorios<input type="number" min="0" value="0"></label>
                </div>

                <label class="export-field">Estado<select><option>Operativo</option><option>Mantenimiento</option><option>Fuera de servicio</option></select></label>

                <div class="auto-capacity">
                    <div><span>Capacidad total (auto)</span><small>Suma de capacidad de sus espacios</small></div>
                    <strong>0</strong>
                </div>
            </div>
        </div>

        <div class="modal-actions">
            <button class="secondary-button" type="button" data-modal-close>Cancelar</button>
            <button class="primary-button" type="submit">Registrar</button>
        </div>
    </form>
</div>

<div class="modal" id="space-modal" aria-hidden="true">
    <form class="modal-card demo-form split-modal" data-demo-form>
        <button class="modal-close" type="button" data-modal-close aria-label="Cerrar">×</button>
        <h2>Registrar espacio</h2>
        <p class="modal-subtitle">Agregue un aula o laboratorio.</p>

        <div class="split-modal-body">
            <div class="split-modal-media">
                <span class="field-label">Fotos</span>
                <div class="photo-drop-pair">
                    <label class="photo-drop compact">
                        <i data-lucide="image"></i>
                        <b>Entrada</b>
                        <span class="photo-drop-badge"><i data-lucide="camera"></i></span>
                        <input type="file" accept="image/png,image/jpeg">
                    </label>
                    <label class="photo-drop compact">
                        <i data-lucide="image"></i>
                        <b>Interior</b>
                        <span class="photo-drop-badge"><i data-lucide="camera"></i></span>
                        <input type="file" accept="image/png,image/jpeg">
                    </label>
                </div>

                <div class="field-label-row">
                    <span class="field-label">Ubicación en mapa</span>
                    <button class="link-action" type="button" data-toast="Ubicación tomada de tu posición actual"><i data-lucide="map-pin"></i> Usar mi ubicación</button>
                </div>
                <div class="modal-map" data-modal-map></div>
                <p class="field-hint warning"><i data-lucide="info"></i> Haz clic en el mapa para ubicar.</p>
            </div>

            <div class="split-modal-fields">
                <div class="form-grid">
                    <label class="export-field">Nombre<input required placeholder="Lab. de Electrónica"></label>
                    <label class="export-field">Edificio<select>@foreach($buildings as $building)<option>{{ mb_strtoupper($building['name']) }}</option>@endforeach</select></label>
                </div>

                <div class="form-grid">
                    <label class="export-field">Piso<input type="number" min="1" value="1"></label>
                    <label class="export-field">Tipo<select><option>Aula (Académica)</option><option>Laboratorio (Técnico)</option><option>Oficina</option><option>Auditorio</option></select></label>
                </div>

                <div class="form-grid">
                    <label class="export-field">Capacidad<input type="number" min="1" value="20"></label>
                    <label class="export-field">Área (m²)<input type="number" min="1" value="60"></label>
                </div>

                <div class="field-label-row">
                    <span class="field-label">Equipamiento <em>(opcional)</em></span>
                    <button class="link-action" type="button" data-modal-close data-toast="Selecciona los equipos desde Activos"><i data-lucide="plus"></i> Vincular del inventario</button>
                </div>
                <input class="plain-input" placeholder="Ej. Proyector, Pizarra digital (opcional)">
            </div>
        </div>

        <div class="modal-actions">
            <button class="secondary-button" type="button" data-modal-close>Cancelar</button>
            <button class="primary-button dark" type="submit">Registrar</button>
        </div>
    </form>
</div>
