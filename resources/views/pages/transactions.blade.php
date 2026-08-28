@php
    $transactionRequests = [
        ['code' => 'SOL-2026-041', 'subject' => 'Préstamo de equipos para práctica de circuitos', 'type' => 'Préstamo', 'requester' => 'Juan Carlos Pérez', 'date' => '25 ago 2026', 'status' => 'Aprobada'],
        ['code' => 'SOL-2026-038', 'subject' => 'Reporte de novedad en laboratorio de control', 'type' => 'Reporte', 'requester' => 'María Fernanda Ruiz', 'date' => '22 ago 2026', 'status' => 'Pendiente'],
        ['code' => 'SOL-2026-031', 'subject' => 'Solicitud de certificado de uso de laboratorio', 'type' => 'Oficio', 'requester' => 'Jorge Andrés Silva', 'date' => '14 ago 2026', 'status' => 'Entregada'],
        ['code' => 'SOL-2026-024', 'subject' => 'Préstamo de osciloscopio para proyecto integrador', 'type' => 'Préstamo', 'requester' => 'Daniela Torres López', 'date' => '02 ago 2026', 'status' => 'Rechazada'],
    ];
    $transactionLoans = [
        ['code' => 'PRE-2026-018', 'subject' => 'Multímetro digital Fluke 87V · 2 unidades', 'type' => 'Equipo', 'requester' => 'Juan Carlos Pérez', 'date' => '26 ago 2026', 'status' => 'Activo'],
        ['code' => 'PRE-2026-015', 'subject' => 'Módulo PLC Siemens S7-1200', 'type' => 'Equipo', 'requester' => 'María Fernanda Ruiz', 'date' => '20 ago 2026', 'status' => 'Por devolver'],
        ['code' => 'PRE-2026-009', 'subject' => 'Pinza amperimétrica · Laboratorio de potencia', 'type' => 'Herramienta', 'requester' => 'Jorge Andrés Silva', 'date' => '08 ago 2026', 'status' => 'Devuelto'],
    ];
    $statusCounts = array_count_values(array_column($transactionRequests, 'status'));
@endphp

<div class="transactions-page" data-transactions>
    <section class="transactions-hero">
        <div class="transactions-title">
            <span class="transactions-icon"><i data-lucide="inbox"></i></span>
            <div>
                <h1>Trámites</h1>
                <p>Bandeja de oficios y reportes enviados por los estudiantes.</p>
            </div>
        </div>

        <div class="transactions-tabs" role="tablist" aria-label="Tipo de trámite">
            <button class="is-active" type="button" role="tab" aria-selected="true" data-transaction-tab="requests">
                <i data-lucide="file-text"></i> Solicitudes
            </button>
            <button type="button" role="tab" aria-selected="false" data-transaction-tab="loans">
                <i data-lucide="arrow-left-right"></i> Préstamos
            </button>
        </div>

        <div class="transactions-stats" aria-label="Resumen de trámites">
            <div><i data-lucide="layers-3"></i><span><strong>{{ count($transactionRequests) }}</strong><small>Total</small></span></div>
            <div><i data-lucide="clock-3"></i><span><strong>{{ $statusCounts['Pendiente'] ?? 0 }}</strong><small>Pendientes</small></span></div>
            <div><i data-lucide="circle-check-big"></i><span><strong>{{ $statusCounts['Aprobada'] ?? 0 }}</strong><small>Aprobados</small></span></div>
            <div><i data-lucide="circle-x"></i><span><strong>{{ $statusCounts['Rechazada'] ?? 0 }}</strong><small>Rechazados</small></span></div>
        </div>
    </section>

    <section class="transactions-panel">
        <div class="transactions-toolbar">
            <label class="transaction-search">
                <i data-lucide="search"></i>
                <input type="search" placeholder="Buscar por asunto o solicitante" data-transaction-search>
            </label>

            <label class="transaction-filter">
                <i data-lucide="layers-3"></i>
                <span>Estado:</span>
                <select data-transaction-status aria-label="Filtrar por estado">
                    <option value="">Todos</option>
                    <option>Pendiente</option><option>Aprobada</option><option>Entregada</option><option>Rechazada</option>
                    <option>Activo</option><option>Por devolver</option><option>Devuelto</option>
                </select>
            </label>

            <label class="transaction-filter">
                <i data-lucide="tag"></i>
                <span>Tipo:</span>
                <select data-transaction-type aria-label="Filtrar por tipo">
                    <option value="">Todos</option>
                    <option>Préstamo</option><option>Reporte</option><option>Oficio</option><option>Equipo</option><option>Herramienta</option>
                </select>
            </label>

            <label class="transaction-filter">
                <i data-lucide="calendar-days"></i>
                <span>Fecha:</span>
                <select data-transaction-date aria-label="Filtrar por fecha">
                    <option value="">Todas</option><option value="ago 2026">Agosto 2026</option><option value="25 ago">Últimos 7 días</option>
                </select>
            </label>

            <button class="transactions-clear" type="button" data-transaction-clear><i data-lucide="rotate-ccw"></i> Limpiar filtros</button>

            <div class="transactions-actions">
                <button class="transactions-export" type="button" data-toast="Listado de trámites exportado"><i data-lucide="download"></i> Exportar</button>
                <button class="transactions-import" type="button" data-modal-open="transactions-import-modal"><i data-lucide="upload"></i> Importar</button>
            </div>
        </div>

        <div class="transaction-table-wrap">
            <table class="transaction-table">
                <thead>
                    <tr>
                        <th class="check-column"><input type="checkbox" aria-label="Seleccionar todos los trámites"></th>
                        <th>Asunto <i data-lucide="arrow-up-down"></i></th>
                        <th>Tipo <i data-lucide="arrow-up-down"></i></th>
                        <th>Solicitante <i data-lucide="arrow-up-down"></i></th>
                        <th>Fecha <i data-lucide="arrow-up-down"></i></th>
                        <th>Estado <i data-lucide="arrow-up-down"></i></th>
                        <th class="transaction-actions-heading">Acciones</th>
                    </tr>
                </thead>
                <tbody data-transaction-panel="requests">
                    @foreach($transactionRequests as $request)
                        <tr data-transaction-row data-status="{{ $request['status'] }}" data-type="{{ $request['type'] }}" data-date="{{ $request['date'] }}">
                            <td class="check-column"><input type="checkbox" aria-label="Seleccionar {{ $request['code'] }}"></td>
                            <td><span class="transaction-subject"><b>{{ $request['subject'] }}</b><small>{{ $request['code'] }}</small></span></td>
                            <td><span class="transaction-type-pill"><i data-lucide="{{ $request['type'] === 'Préstamo' ? 'arrow-left-right' : ($request['type'] === 'Reporte' ? 'triangle-alert' : 'file-text') }}"></i>{{ $request['type'] }}</span></td>
                            <td><span class="transaction-person"><span>{{ collect(explode(' ', $request['requester']))->map(fn ($word) => mb_substr($word, 0, 1))->take(2)->join('') }}</span>{{ $request['requester'] }}</span></td>
                            <td>{{ $request['date'] }}</td>
                            <td><x-badge :value="$request['status']" /></td>
                            <td><div class="transaction-row-actions"><button type="button" title="Ver detalle" data-transaction-detail="{{ $request['code'] }}" data-modal-open="transaction-detail-modal"><i data-lucide="eye"></i></button><button type="button" title="Más acciones" data-toast="Acciones para {{ $request['code'] }}"><i data-lucide="ellipsis"></i></button></div></td>
                        </tr>
                    @endforeach
                </tbody>
                <tbody class="hidden" data-transaction-panel="loans">
                    @foreach($transactionLoans as $loan)
                        <tr data-transaction-row data-status="{{ $loan['status'] }}" data-type="{{ $loan['type'] }}" data-date="{{ $loan['date'] }}">
                            <td class="check-column"><input type="checkbox" aria-label="Seleccionar {{ $loan['code'] }}"></td>
                            <td><span class="transaction-subject"><b>{{ $loan['subject'] }}</b><small>{{ $loan['code'] }}</small></span></td>
                            <td><span class="transaction-type-pill"><i data-lucide="package"></i>{{ $loan['type'] }}</span></td>
                            <td><span class="transaction-person"><span>{{ collect(explode(' ', $loan['requester']))->map(fn ($word) => mb_substr($word, 0, 1))->take(2)->join('') }}</span>{{ $loan['requester'] }}</span></td>
                            <td>{{ $loan['date'] }}</td>
                            <td><x-badge :value="$loan['status']" /></td>
                            <td><div class="transaction-row-actions"><button type="button" title="Ver detalle" data-transaction-detail="{{ $loan['code'] }}" data-modal-open="transaction-detail-modal"><i data-lucide="eye"></i></button><button type="button" title="Más acciones" data-toast="Acciones para {{ $loan['code'] }}"><i data-lucide="ellipsis"></i></button></div></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="transactions-empty hidden" data-transactions-empty>
                <i data-lucide="file-x-2"></i>
                <h3>Sin trámites encontrados</h3>
                <p>No hay resultados que coincidan con los filtros seleccionados.</p>
            </div>
        </div>

        <footer class="transactions-footer">
            <span><i data-lucide="sliders-horizontal"></i> Mostrando <b data-transaction-visible>{{ count($transactionRequests) }}</b> de <b data-transaction-total>{{ count($transactionRequests) }}</b> registros</span>
            <label>Filas por página: <select aria-label="Filas por página"><option>10</option><option>25</option><option>50</option></select></label>
            <div class="transactions-pagination"><button type="button" disabled aria-label="Página anterior"><i data-lucide="chevron-left"></i></button><b>1</b><button type="button" disabled aria-label="Página siguiente"><i data-lucide="chevron-right"></i></button></div>
        </footer>
    </section>
</div>

<div class="modal" id="transactions-import-modal" aria-hidden="true">
    <form class="modal-card demo-form" data-demo-form>
        <button class="modal-close" type="button" data-modal-close aria-label="Cerrar">×</button>
        <small>TRÁMITES</small>
        <h2>Importar solicitudes</h2>
        <label>Archivo de datos<input type="file" accept=".csv,.xlsx"></label>
        <div class="info-strip"><i data-lucide="info"></i> Esta demostración no almacena el archivo; solo simula la importación.</div>
        <div class="modal-actions"><button class="secondary-button" type="button" data-modal-close>Cancelar</button><button class="primary-button" type="submit">Importar archivo</button></div>
    </form>
</div>

<div class="modal" id="transaction-detail-modal" aria-hidden="true">
    <div class="modal-card transaction-detail-card">
        <button class="modal-close" type="button" data-modal-close aria-label="Cerrar">×</button>
        <span class="transaction-detail-icon"><i data-lucide="file-check-2"></i></span>
        <small>DETALLE DEL TRÁMITE</small>
        <h2 data-transaction-detail-title>Solicitud</h2>
        <p>Revisa la información, documentos adjuntos y seguimiento de esta solicitud.</p>
        <div class="transaction-detail-grid"><span><small>Responsable</small><b>Secretaría académica</b></span><span><small>Última actualización</small><b>27 ago 2026</b></span></div>
        <div class="modal-actions"><button class="secondary-button" type="button" data-modal-close>Cerrar</button><button class="primary-button" type="button" data-toast="Estado actualizado en la demostración">Actualizar estado</button></div>
    </div>
</div>
