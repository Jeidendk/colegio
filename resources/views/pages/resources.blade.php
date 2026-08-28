@php
    $isFormats = $page === 'formatos';
    $canPublish = in_array($role, ['admin', 'docente'], true);
    $formatDocuments = [
        ['title' => 'Formato de informe de prácticas', 'subject' => 'General', 'type' => 'DOCX', 'size' => '680 KB', 'mode' => 'Dinámico', 'updated' => '26 ago 2026'],
        ['title' => 'Solicitud de préstamo de equipos', 'subject' => 'Trámites', 'type' => 'PDF', 'size' => '320 KB', 'mode' => 'Dinámico', 'updated' => '22 ago 2026'],
        ['title' => 'Acta de entrega-recepción', 'subject' => 'Trámites', 'type' => 'PDF', 'size' => '410 KB', 'mode' => 'Estático', 'updated' => '14 ago 2026'],
        ['title' => 'Plantilla de horario semestral', 'subject' => 'Académico', 'type' => 'DOCX', 'size' => '540 KB', 'mode' => 'Dinámico', 'updated' => '11 ago 2026'],
        ['title' => 'Registro de asistencia a laboratorio', 'subject' => 'Académico', 'type' => 'PDF', 'size' => '295 KB', 'mode' => 'Estático', 'updated' => '05 ago 2026'],
        ['title' => 'Informe de mantenimiento de activos', 'subject' => 'Inventario', 'type' => 'DOCX', 'size' => '720 KB', 'mode' => 'Dinámico', 'updated' => '01 ago 2026'],
    ];
    $items = $isFormats
        ? $formatDocuments
        : array_map(fn ($resource) => $resource + ['mode' => 'Publicado', 'updated' => '20 ago 2026'], $resources);
    $documentTypes = $isFormats ? ['PDF', 'DOCX'] : ['PDF', 'DOCX', 'VIDEO'];
@endphp

<section class="infra-hero">
    <div class="infra-hero-title">
        <span><i data-lucide="{{ $isFormats ? 'file-text' : 'library' }}"></i></span>
        <div>
            <h1>{{ $isFormats ? 'Formatos institucionales' : 'Recursos académicos' }}</h1>
            <p>{{ $isFormats ? 'Plantillas listas para informes, prácticas y solicitudes.' : 'Material de apoyo para el periodo académico 2026-1.' }}</p>
        </div>
    </div>

    <div class="infra-hero-stats">
        <div><i data-lucide="files"></i><span><strong>{{ count($items) }}</strong><small>Documentos</small></span></div>
        <div><i data-lucide="download"></i><span><strong>148</strong><small>Descargas</small></span></div>
        <div><i data-lucide="history"></i><span><strong>6</strong><small>Actualizados</small></span></div>
    </div>
</section>

<section class="panel users-panel" data-users-panel>
    <span class="panel-accent" aria-hidden="true"></span>

    <div class="toolbar users-toolbar">
        <label class="search-field"><i data-lucide="search"></i><input type="search" placeholder="{{ $isFormats ? 'Buscar formato...' : 'Buscar por nombre o asignatura...' }}" data-users-search></label>

        <div class="chip-filters" data-users-roles>
            @foreach($documentTypes as $type)
                <button class="filter-chip role-chip" type="button" data-user-role="{{ $type }}">{{ $type }}</button>
            @endforeach
        </div>

        <select class="select-control" data-users-status>
            <option value="">{{ $isFormats ? 'Generación: Todas' : 'Estado: Todos' }}</option>
            @foreach(array_unique(array_column($items, 'mode')) as $mode)
                <option>{{ $mode }}</option>
            @endforeach
        </select>

        <button class="text-button" type="button" data-users-clear><i data-lucide="rotate-ccw"></i> Limpiar filtros</button>

        <div class="toolbar-right">
            <div class="segmented compact layout-switch" data-tabs>
                <button class="is-active" type="button" data-tab="grid" title="Tarjetas"><i data-lucide="layout-grid"></i></button>
                <button type="button" data-tab="list" title="Lista"><i data-lucide="list"></i></button>
            </div>
            @if($canPublish)
                <button class="pill-button" type="button" data-toast="Cambios guardados en la demostración"><i data-lucide="save"></i> Guardar cambios</button>
                <button class="pill-button solid" type="button" data-modal-open="new-resource-modal"><i data-lucide="plus"></i> {{ $isFormats ? 'Nuevo formato' : 'Publicar recurso' }}</button>
            @endif
        </div>
    </div>

    <div data-tab-panel="grid">
        <div class="resource-grid">
            @foreach($items as $item)
                <article class="resource-card" data-user-row
                    data-user-search="{{ mb_strtolower($item['title'].' '.$item['subject']) }}"
                    data-user-role="{{ $item['type'] }}"
                    data-user-status="{{ $item['mode'] }}">
                    <span class="file-icon {{ strtolower($item['type']) }}">
                        <i data-lucide="{{ $item['type'] === 'VIDEO' ? 'circle-play' : 'file-text' }}"></i>
                    </span>
                    <div>
                        <small>{{ $item['subject'] }}</small>
                        <h3>{{ $item['title'] }}</h3>
                        <p>{{ $item['type'] }} · {{ $item['size'] }} · {{ $item['mode'] }}</p>
                    </div>
                    <div class="row-actions">
                        @if($canPublish)
                            <button class="row-action edit" type="button" title="Editar" data-modal-open="new-resource-modal"><i data-lucide="pencil"></i></button>
                            <button class="row-action danger" type="button" title="Eliminar" data-toast="{{ $item['title'] }} eliminado en la demostración"><i data-lucide="trash-2"></i></button>
                        @endif
                        <button class="row-action" type="button" title="Descargar" data-toast="Descarga simulada: {{ $item['title'] }}"><i data-lucide="download"></i></button>
                    </div>
                </article>
            @endforeach
        </div>
    </div>

    <div class="hidden" data-tab-panel="list">
        <div class="table-wrap">
            <table class="data-table users-table">
                <thead>
                    <tr>
                        <th class="check-column"><input type="checkbox" aria-label="Seleccionar todo" data-users-select-all></th>
                        <th><button class="sort-header" type="button" data-sort-users="name">Documento <i data-lucide="chevrons-up-down"></i></button></th>
                        <th><button class="sort-header" type="button" data-sort-users="role">Tipo / {{ $isFormats ? 'Área' : 'Asignatura' }} <i data-lucide="chevrons-up-down"></i></button></th>
                        <th><button class="sort-header" type="button" data-sort-users="status">{{ $isFormats ? 'Generación' : 'Estado' }} <i data-lucide="chevrons-up-down"></i></button></th>
                        <th><button class="sort-header" type="button" data-sort-users="last">Actualizado <i data-lucide="chevrons-up-down"></i></button></th>
                        <th class="actions-col">Acciones</th>
                    </tr>
                </thead>
                <tbody data-users-body>
                    @foreach($items as $item)
                        <tr data-user-row
                            data-user-search="{{ mb_strtolower($item['title'].' '.$item['subject']) }}"
                            data-user-role="{{ $item['type'] }}"
                            data-user-status="{{ $item['mode'] }}"
                            data-sort-name="{{ mb_strtolower($item['title']) }}"
                            data-sort-role="{{ $item['type'] }}"
                            data-sort-status="{{ $item['mode'] }}"
                            data-sort-last="{{ $item['updated'] }}">
                            <td class="check-column"><input type="checkbox" aria-label="Seleccionar {{ $item['title'] }}"></td>
                            <td>
                                <div class="user-cell">
                                    <span class="file-icon {{ strtolower($item['type']) }}"><i data-lucide="{{ $item['type'] === 'VIDEO' ? 'circle-play' : 'file-text' }}"></i></span>
                                    <div><b>{{ $item['title'] }}</b><small>{{ $item['size'] }}</small></div>
                                </div>
                            </td>
                            <td>
                                <div class="role-cell">
                                    <span class="role-pill role-{{ strtolower($item['type']) }}"><i data-lucide="file-type-2"></i> {{ $item['type'] }}</span>
                                    <small>{{ $item['subject'] }}</small>
                                </div>
                            </td>
                            <td><x-badge :value="$item['mode']" /></td>
                            <td>{{ $item['updated'] }}</td>
                            <td>
                                <div class="row-actions">
                                    <button class="row-action" type="button" title="Descargar" data-toast="Descarga simulada: {{ $item['title'] }}"><i data-lucide="download"></i></button>
                                    @if($canPublish)
                                        <button class="row-action edit" type="button" title="Editar" data-modal-open="new-resource-modal"><i data-lucide="pencil"></i></button>
                                        <button class="row-action danger" type="button" title="Eliminar" data-toast="{{ $item['title'] }} eliminado en la demostración"><i data-lucide="trash-2"></i></button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <p class="empty-state hidden" data-users-empty><i data-lucide="search-x"></i> Ningún documento coincide con los filtros.</p>

    <x-table-footer :count="count($items)" data-users-range />
</section>

<div class="modal" id="new-resource-modal" aria-hidden="true">
    <form class="modal-card demo-form wide-modal" data-demo-form>
        <button class="modal-close" type="button" data-modal-close aria-label="Cerrar">×</button>
        <small>{{ $isFormats ? 'FORMATOS' : 'RECURSOS' }}</small>
        <h2>{{ $isFormats ? 'Nuevo formato institucional' : 'Publicar material' }}</h2>

        <label>Título / Nombre<input required placeholder="{{ $isFormats ? 'Ej. Acta de entrega-recepción' : 'Ej. Fundamentos de Redes' }}"></label>

        <div class="form-grid">
            <label>{{ $isFormats ? 'Área' : 'Materia asociada' }}
                <select>
                    @if($isFormats)
                        <option>General</option><option>Trámites</option><option>Académico</option><option>Inventario</option>
                    @else
                        <option>Matemática</option><option>Lengua y Literatura</option><option>Ciencias Naturales</option><option>General</option>
                    @endif
                </select>
            </label>
            <label>Tipo de recurso<select>@foreach($documentTypes as $type)<option>{{ $type }}</option>@endforeach</select></label>
        </div>

        <div class="form-grid">
            <label>Autor(es)<input placeholder="Ej: Kurose, Ross"></label>
            <label>{{ $isFormats ? 'Generación' : 'Formato' }}
                <select>
                    @if($isFormats)<option>Dinámico</option><option>Estático</option>@else<option>Digital</option><option>Físico</option><option>App</option>@endif
                </select>
            </label>
        </div>

        <label>Descripción<textarea placeholder="Breve descripción del contenido..."></textarea></label>
        <label>Enlace de descarga / web<input type="url" placeholder="https://"></label>

        <label class="file-drop">
            <i data-lucide="file-up"></i>
            <span><b>Cargar archivo principal</b><small>PDF o DOCX · máx. 20 MB</small></span>
            <input type="file" accept=".pdf,.docx">
        </label>

        <div class="modal-actions">
            <button class="secondary-button" type="button" data-modal-close>Cancelar</button>
            <button class="primary-button dark" type="submit">{{ $isFormats ? 'Guardar formato' : 'Publicar recurso' }}</button>
        </div>
    </form>
</div>
