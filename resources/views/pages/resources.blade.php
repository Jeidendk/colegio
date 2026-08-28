@php
    $isFormats = $page === 'formatos';
    $canPublish = in_array($role, ['admin', 'docente'], true);
    $formatDocuments = [
        ['title' => 'Formato de informe de prácticas', 'subject' => 'General', 'type' => 'DOCX', 'size' => '680 KB', 'mode' => 'Dinámico'],
        ['title' => 'Solicitud de préstamo de equipos', 'subject' => 'Trámites', 'type' => 'PDF', 'size' => '320 KB', 'mode' => 'Dinámico'],
        ['title' => 'Acta de entrega-recepción', 'subject' => 'Trámites', 'type' => 'PDF', 'size' => '410 KB', 'mode' => 'Estático'],
        ['title' => 'Plantilla de horario semestral', 'subject' => 'Académico', 'type' => 'DOCX', 'size' => '540 KB', 'mode' => 'Dinámico'],
        ['title' => 'Registro de asistencia a laboratorio', 'subject' => 'Académico', 'type' => 'PDF', 'size' => '295 KB', 'mode' => 'Estático'],
        ['title' => 'Informe de mantenimiento de activos', 'subject' => 'Inventario', 'type' => 'DOCX', 'size' => '720 KB', 'mode' => 'Dinámico'],
    ];
    $items = $isFormats ? $formatDocuments : $resources;
@endphp

<x-hero icon="{{ $isFormats ? 'file-text' : 'library' }}"
    :title="$isFormats ? 'Formatos institucionales' : 'Recursos académicos'"
    :subtitle="$isFormats ? 'Plantillas listas para informes, prácticas y solicitudes.' : 'Material de apoyo para el periodo académico 2026-1.'"
    :stats="[['Documentos', count($items), 'disponibles'], ['Descargas', '148', 'este mes'], ['Actualizados', '6', 'recientes']]">
    @if($canPublish)
        <button class="hero-button" type="button" data-modal-open="new-resource-modal">
            <i data-lucide="plus"></i> {{ $isFormats ? 'Nuevo formato' : 'Publicar recurso' }}
        </button>
    @endif
</x-hero>

<section class="panel">
    <div class="toolbar">
        <div class="segmented" data-tabs>
            <button class="is-active" type="button" data-tab="grid">Tarjetas</button>
            <button type="button" data-tab="list">Lista</button>
        </div>
        <label class="search-field grow"><i data-lucide="search"></i><input type="search" placeholder="{{ $isFormats ? 'Buscar formato...' : 'Buscar por nombre o asignatura...' }}" data-table-search></label>
        <select class="select-control" data-table-filter>
            <option value="">Todos los tipos</option>
            <option>PDF</option>
            <option>DOCX</option>
            @unless($isFormats)<option>VIDEO</option>@endunless
        </select>
        @if($canPublish)
            <button class="secondary-button" type="button" data-toast="Cambios guardados en la demostración"><i data-lucide="save"></i> Guardar cambios</button>
        @endif
    </div>

    <div data-tab-panel="grid">
        <div class="resource-grid">
            @foreach($items as $item)
                <article class="resource-card" data-search-row data-filter-value="{{ $item['type'] }}">
                    <span class="file-icon {{ strtolower($item['type']) }}">
                        <i data-lucide="{{ $item['type'] === 'VIDEO' ? 'circle-play' : 'file-text' }}"></i>
                    </span>
                    <div>
                        <small>{{ $item['subject'] }}</small>
                        <h3>{{ $item['title'] }}</h3>
                        <p>{{ $item['type'] }} · {{ $item['size'] }}@isset($item['mode']) · {{ $item['mode'] }}@endisset</p>
                    </div>
                    <div class="row-actions">
                        @if($canPublish)
                            <button class="row-action" type="button" title="Editar" data-modal-open="new-resource-modal"><i data-lucide="pencil"></i></button>
                            <button class="row-action danger" type="button" title="Eliminar" data-toast="{{ $item['title'] }} eliminado en la demostración"><i data-lucide="trash-2"></i></button>
                        @endif
                        <button class="download-button" type="button" data-toast="Descarga simulada: {{ $item['title'] }}"><i data-lucide="download"></i></button>
                    </div>
                </article>
            @endforeach
        </div>
    </div>

    <div class="hidden" data-tab-panel="list">
        <div class="table-wrap">
            <table class="data-table">
                <thead>
                    <tr><th>Documento</th><th>{{ $isFormats ? 'Área' : 'Asignatura' }}</th><th>Tipo</th><th>Tamaño</th>@if($isFormats)<th>Generación</th>@endif<th class="actions-col">Acciones</th></tr>
                </thead>
                <tbody>
                    @foreach($items as $item)
                        <tr data-search-row data-filter-value="{{ $item['type'] }}">
                            <td><b>{{ $item['title'] }}</b></td>
                            <td>{{ $item['subject'] }}</td>
                            <td>{{ $item['type'] }}</td>
                            <td>{{ $item['size'] }}</td>
                            @if($isFormats)<td><x-badge :value="$item['mode'] ?? 'Estático'" /></td>@endif
                            <td>
                                <div class="row-actions">
                                    <button class="row-action" type="button" title="Descargar" data-toast="Descarga simulada: {{ $item['title'] }}"><i data-lucide="download"></i></button>
                                    @if($canPublish)
                                        <button class="row-action" type="button" title="Editar" data-modal-open="new-resource-modal"><i data-lucide="pencil"></i></button>
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

    <div class="panel-footer">
        <span><i data-lucide="info"></i> {{ count($items) }} documentos disponibles.</span>
        <div class="rows-per-page"><label>Filas:<select><option>12</option><option>24</option><option>48</option></select></label></div>
    </div>
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
                        <option>Circuitos Eléctricos I</option><option>Control Automático</option><option>Sistemas Eléctricos de Potencia</option><option>General</option>
                    @endif
                </select>
            </label>
            <label>Tipo de recurso<select><option>PDF</option><option>DOCX</option>@unless($isFormats)<option>Video</option><option>Enlace</option>@endunless</select></label>
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

        <label class="file-drop">
            <i data-lucide="image-plus"></i>
            <span><b>Portada o ícono</b><small>JPG o PNG · opcional</small></span>
            <input type="file" accept="image/png,image/jpeg">
        </label>

        <div class="modal-actions">
            <button class="secondary-button" type="button" data-modal-close>Cancelar</button>
            <button class="primary-button" type="submit">{{ $isFormats ? 'Guardar formato' : 'Publicar recurso' }}</button>
        </div>
    </form>
</div>
