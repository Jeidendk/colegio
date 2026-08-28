@php
    $assetCounts = array_count_values(array_column($inventory, 'status'));
    $categoryOptions = array_values(array_unique(array_column($inventory, 'category')));
    $buildingOptions = array_values(array_unique(array_map(fn ($item) => trim(explode('·', $item['location'])[0]), $inventory)));
@endphp

<div class="assets-page" data-assets>
    <section class="assets-hero">
        <div class="assets-title"><span><i data-lucide="package-open"></i></span><div><h1>Activos</h1><p>Equipos, herramientas, mobiliario y tecnología.</p></div></div>
        <div class="assets-tabs" role="tablist" aria-label="Módulos de activos">
            <button class="is-active" type="button" role="tab" aria-selected="true" data-assets-tab="inventory"><i data-lucide="panels-top-left"></i> Inventario</button>
            <button type="button" role="tab" aria-selected="false" data-assets-tab="assignments"><i data-lucide="user-round-check"></i> Asignaciones</button>
            <button type="button" role="tab" aria-selected="false" data-assets-tab="maintenance"><i data-lucide="wrench"></i> Mantenimiento</button>
        </div>
        <div class="assets-stats">
            <div><i data-lucide="box"></i><span><strong>{{ count($inventory) }}</strong><small>Total</small></span></div>
            <div><i data-lucide="circle-check-big"></i><span><strong>{{ $assetCounts['Bueno'] ?? 0 }}</strong><small>Buen estado</small></span></div>
            <div><i data-lucide="triangle-alert"></i><span><strong>{{ $assetCounts['Malo'] ?? 0 }}</strong><small>Regular / Malo</small></span></div>
            <div><i data-lucide="badge-x"></i><span><strong>{{ $assetCounts['Dañado'] ?? 0 }}</strong><small>Dañados</small></span></div>
        </div>
    </section>

    <section class="assets-panel">
        <div class="assets-toolbar">
            <label class="asset-search"><i data-lucide="search"></i><input type="search" placeholder="Buscar ítem..." data-assets-search></label>
            <label class="asset-filter"><span>Categoría:</span><select data-assets-category><option value="">Todos ({{ count($inventory) }})</option>@foreach($categoryOptions as $category)<option>{{ $category }}</option>@endforeach</select></label>
            <label class="asset-filter"><span>Estado:</span><select data-assets-status><option value="">Todos</option><option>Bueno</option><option>Malo</option><option>Dañado</option><option>Activa</option><option>Devuelta</option><option>Pendiente</option><option>En proceso</option><option>Cerrada</option></select></label>
            <label class="asset-filter"><span>Edificio:</span><select data-assets-building><option value="">Todos</option>@foreach($buildingOptions as $building)<option>{{ $building }}</option>@endforeach</select></label>
            <button class="assets-clear" type="button" data-assets-clear><i data-lucide="rotate-ccw"></i> Limpiar filtros</button>
            <div class="assets-actions">
                <button class="asset-soft-button" type="button" data-modal-open="assets-import-modal"><i data-lucide="upload"></i> Importar</button>
                <button class="asset-soft-button" type="button" data-toast="Inventario exportado en la demostración"><i data-lucide="download"></i> Exportar</button>
                <button class="asset-primary-button" type="button" data-modal-open="asset-register-modal"><i data-lucide="plus"></i> Nuevo ítem</button>
            </div>
        </div>

        <div class="asset-table-area">
            <table class="asset-table">
                <thead data-assets-heading="inventory"><tr><th class="asset-check"><input type="checkbox" aria-label="Seleccionar todos"></th><th>Nombre <i data-lucide="arrow-up-down"></i></th><th>Categoría <i data-lucide="arrow-up-down"></i></th><th>Estado físico <i data-lucide="arrow-up-down"></i></th><th>Ubicación <i data-lucide="arrow-up-down"></i></th><th class="asset-actions-heading">Acciones</th></tr></thead>
                <thead class="hidden" data-assets-heading="assignments"><tr><th class="asset-check"><input type="checkbox" aria-label="Seleccionar todos"></th><th>Activo</th><th>Responsable</th><th>Ubicación</th><th>Desde</th><th>Estado</th><th class="asset-actions-heading">Acciones</th></tr></thead>
                <thead class="hidden" data-assets-heading="maintenance"><tr><th class="asset-check"><input type="checkbox" aria-label="Seleccionar todos"></th><th>Orden</th><th>Activo</th><th>Novedad</th><th>Prioridad</th><th>Apertura</th><th>Estado</th><th class="asset-actions-heading">Acciones</th></tr></thead>

                <tbody data-assets-panel="inventory">
                    @foreach($inventory as $item)
                        @php $building = trim(explode('·', $item['location'])[0]); @endphp
                        <tr data-asset-row data-category="{{ $item['category'] }}" data-status="{{ $item['status'] }}" data-building="{{ $building }}">
                            <td class="asset-check"><input type="checkbox" aria-label="Seleccionar {{ $item['code'] }}"></td>
                            <td><span class="asset-name"><span><i data-lucide="{{ $item['category'] === 'Tecnológico' ? 'monitor' : ($item['category'] === 'Herramientas' ? 'wrench' : 'cpu') }}"></i></span><span><b>{{ $item['name'] }}</b><small>{{ $item['code'] }}</small></span></span></td>
                            <td><span class="asset-category">{{ $item['category'] }}</span></td>
                            <td><x-badge :value="$item['status']" /></td>
                            <td><span class="asset-location"><i data-lucide="map-pin"></i>{{ $item['location'] }}</span></td>
                            <td><div class="asset-row-actions"><button type="button" title="Editar" data-modal-open="asset-register-modal"><i data-lucide="pencil"></i></button><button type="button" title="Asignar" data-modal-open="asset-assignment-modal"><i data-lucide="user-round-plus"></i></button><button type="button" title="Más acciones" data-toast="Acciones para {{ $item['code'] }}"><i data-lucide="ellipsis"></i></button></div></td>
                        </tr>
                    @endforeach
                </tbody>

                <tbody class="hidden" data-assets-panel="assignments">
                    @foreach($assignments as $assignment)
                        <tr data-asset-row data-category="Asignación" data-status="{{ $assignment['status'] }}" data-building="{{ $assignment['place'] }}">
                            <td class="asset-check"><input type="checkbox" aria-label="Seleccionar {{ $assignment['code'] }}"></td><td><span class="asset-name"><span><i data-lucide="package"></i></span><span><b>{{ $assignment['asset'] }}</b><small>{{ $assignment['code'] }}</small></span></span></td><td>{{ $assignment['holder'] }}</td><td>{{ $assignment['place'] }}</td><td>{{ $assignment['since'] }}</td><td><x-badge :value="$assignment['status']" /></td><td><div class="asset-row-actions"><button type="button" data-modal-open="asset-assignment-modal" title="Editar"><i data-lucide="pencil"></i></button><button type="button" data-toast="Devolución registrada para {{ $assignment['code'] }}" title="Registrar devolución"><i data-lucide="undo-2"></i></button></div></td>
                        </tr>
                    @endforeach
                </tbody>

                <tbody class="hidden" data-assets-panel="maintenance">
                    @foreach($maintenance as $order)
                        <tr data-asset-row data-category="Mantenimiento" data-status="{{ $order['status'] }}" data-building="">
                            <td class="asset-check"><input type="checkbox" aria-label="Seleccionar {{ $order['order'] }}"></td><td><b>{{ $order['order'] }}</b></td><td>{{ $order['asset'] }}</td><td>{{ $order['issue'] }}</td><td><span class="priority priority-{{ strtolower($order['priority']) }}">{{ $order['priority'] }}</span></td><td>{{ $order['opened'] }}</td><td><x-badge :value="$order['status']" /></td><td><div class="asset-row-actions"><button type="button" data-modal-open="asset-maintenance-modal" title="Editar"><i data-lucide="pencil"></i></button><button type="button" data-toast="Orden {{ $order['order'] }} cerrada" title="Cerrar orden"><i data-lucide="check"></i></button></div></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="assets-empty hidden" data-assets-empty><i data-lucide="package-open"></i><h3>Sin ítems encontrados</h3><p>No hay resultados que coincidan con los filtros.</p><button type="button" data-modal-open="asset-register-modal"><i data-lucide="plus"></i> Nuevo ítem</button></div>
        </div>

        <footer class="assets-footer"><span><i data-lucide="sliders-horizontal"></i> Mostrando <b data-assets-visible>{{ count($inventory) }}</b> de <b data-assets-total>{{ count($inventory) }}</b> registros</span><label>Filas por página: <select><option>10</option><option>25</option><option>50</option></select></label><div><button disabled><i data-lucide="chevron-left"></i></button><b>1</b><button disabled><i data-lucide="chevron-right"></i></button></div></footer>
    </section>
</div>

<div class="modal" id="asset-register-modal" aria-hidden="true">
    <form class="modal-card asset-register-card demo-form" data-demo-form>
        <button class="modal-close" type="button" data-modal-close aria-label="Cerrar">×</button>
        <h2>Registrar ítem</h2><p>Agregue equipos, herramientas, tecnología o mobiliario.</p>
        <label class="asset-photo-label">Foto del ítem<span class="asset-photo-drop"><i data-lucide="image-plus"></i><b>Subir foto</b><small>JPG, PNG</small><em><i data-lucide="camera"></i></em><input type="file" accept="image/jpeg,image/png"></span></label>
        <div class="form-grid"><label>Nombre del ítem<input required placeholder="Ej: Módulo PLC..."></label><label>Nº de serie / código<input placeholder="SN-12345"></label></div>
        <label class="asset-quantity">Cantidad<span><input type="number" min="1" value="1"><small>Un solo registro. Sube la cantidad para carga en lote.</small></span></label>
        <div class="asset-form-grid"><label>Categoría<select><option>Equipos</option><option>Herramientas</option><option>Tecnológico</option><option>Mobiliario</option></select></label><label>Aula / ubicación<select><option>Lab. Circuitos</option><option>Lab. Control</option><option>Lab. Potencia</option><option>Aula 201</option></select></label><label>Edificio<select><option>FIE-A</option><option>Bloque Labs</option><option>Cómputo</option></select></label></div>
        <label>Estado físico<select><option>Bueno</option><option>Malo</option><option>Dañado</option></select></label>
        <div class="modal-actions"><button class="asset-cancel" type="button" data-modal-close>Cancelar</button><button class="asset-primary-button" type="submit">Guardar ítem</button></div>
    </form>
</div>

<div class="modal" id="assets-import-modal" aria-hidden="true"><form class="modal-card demo-form" data-demo-form><button class="modal-close" type="button" data-modal-close>×</button><small>INVENTARIO</small><h2>Importar activos</h2><label class="file-drop"><i data-lucide="file-spreadsheet"></i><span><b>Selecciona un archivo .xlsx o .csv</b><small>La carga es simulada y no se almacena.</small></span><input type="file" accept=".xlsx,.csv"></label><div class="modal-actions"><button class="secondary-button" type="button" data-modal-close>Cancelar</button><button class="primary-button" type="submit">Importar</button></div></form></div>

<div class="modal" id="asset-assignment-modal" aria-hidden="true"><form class="modal-card demo-form" data-demo-form><button class="modal-close" type="button" data-modal-close>×</button><small>ASIGNACIONES</small><h2>Nueva asignación</h2><label>Activo<select>@foreach($inventory as $item)<option>{{ $item['name'] }}</option>@endforeach</select></label><div class="form-grid"><label>Responsable<input required placeholder="Docente o área"></label><label>Desde<input type="date" value="2026-08-27"></label></div><label>Ubicación<select><option>Lab. Circuitos</option><option>Lab. Control</option><option>Aula Magna</option></select></label><div class="modal-actions"><button class="secondary-button" type="button" data-modal-close>Cancelar</button><button class="primary-button" type="submit">Guardar asignación</button></div></form></div>

<div class="modal" id="asset-maintenance-modal" aria-hidden="true"><form class="modal-card demo-form" data-demo-form><button class="modal-close" type="button" data-modal-close>×</button><small>MANTENIMIENTO</small><h2>Nueva orden</h2><label>Activo<select>@foreach($inventory as $item)<option>{{ $item['name'] }}</option>@endforeach</select></label><label>Novedad<textarea required placeholder="Describe la falla detectada..."></textarea></label><div class="form-grid"><label>Prioridad<select><option>Alta</option><option>Media</option><option>Baja</option></select></label><label>Responsable docente<input placeholder="Nombre del docente"></label></div><div class="modal-actions"><button class="secondary-button" type="button" data-modal-close>Cancelar</button><button class="primary-button" type="submit">Crear orden</button></div></form></div>
