@if(in_array($page, ['tramites','solicitudes'], true))
    @php
        $statusCounts = array_count_values(array_column($requests, 'status'));
        $requestFilters = ['' => 'Todas', 'Pendiente' => 'Pendientes', 'Aprobada' => 'Aprobadas', 'Entregada' => 'Entregadas', 'Rechazada' => 'Rechazadas'];
        $canManageRequests = in_array($role, ['admin', 'docente'], true);
    @endphp

    <x-hero icon="clipboard-list"
        :title="$page === 'tramites' ? 'Centro de trámites' : 'Mis solicitudes'"
        :subtitle="$role === 'representante' ? 'Seguimiento de los recursos solicitados por '.$student['firstName'].'.' : 'Solicitudes y préstamos de equipos en un solo lugar.'"
        :stats="[
            ['Total', count($requests), 'solicitudes'],
            ['Pendientes', $statusCounts['Pendiente'] ?? 0, 'por revisar'],
            ['Aprobadas', $statusCounts['Aprobada'] ?? 0, 'listas'],
            ['Entregadas', $statusCounts['Entregada'] ?? 0, 'completadas'],
        ]">
        @if($role === 'estudiante')
            <a class="hero-button" href="{{ route('portal', ['role' => 'estudiante', 'page' => 'catalogo']) }}"><i data-lucide="plus"></i> Nueva solicitud</a>
        @elseif($canManageRequests)
            <button class="hero-button" type="button" data-modal-open="request-modal"><i data-lucide="plus"></i> Registrar solicitud</button>
        @endif
    </x-hero>

    <section class="panel">
        <div class="toolbar">
            <div class="chip-filters" data-filter-chips>
                @foreach($requestFilters as $value => $label)
                    <button type="button" class="filter-chip {{ $value === '' ? 'is-active' : '' }}" data-filter-chip="{{ $value }}">
                        {{ $label }}<b>{{ $value === '' ? count($requests) : ($statusCounts[$value] ?? 0) }}</b>
                    </button>
                @endforeach
            </div>
            <label class="search-field grow"><i data-lucide="search"></i><input type="search" placeholder="Buscar solicitud, asignatura o equipo..." data-table-search></label>
            <button class="secondary-button" type="button" data-toast="Listado exportado en la demostración"><i data-lucide="download"></i> Exportar</button>
        </div>

        <div class="table-wrap">
            <table class="data-table">
                <thead>
                    <tr><th>Código</th><th>Asignatura</th><th>Equipos</th><th>Fecha</th><th>Estado</th><th class="actions-col">Acciones</th></tr>
                </thead>
                <tbody>
                    @foreach($requests as $request)
                        <tr data-search-row data-filter-value="{{ $request['status'] }}">
                            <td><b>{{ $request['id'] }}</b></td>
                            <td>{{ $request['subject'] }}</td>
                            <td>{{ $request['items'] }}</td>
                            <td>{{ $request['date'] }}</td>
                            <td><x-badge :value="$request['status']" /></td>
                            <td>
                                <div class="row-actions">
                                    <button class="row-action" type="button" title="Ver detalle" data-toast="Detalle de {{ $request['id'] }}"><i data-lucide="eye"></i></button>
                                    <button class="row-action" type="button" title="Descargar PDF" data-toast="PDF de {{ $request['id'] }} generado"><i data-lucide="file-text"></i></button>
                                    @if($canManageRequests)
                                        <button class="row-action" type="button" title="Actualizar estado" data-modal-open="request-status-modal"><i data-lucide="refresh-cw"></i></button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="panel-footer">
            <span><i data-lucide="info"></i> Mostrando {{ count($requests) }} de {{ count($requests) }} solicitudes.</span>
        </div>
    </section>

    @if($canManageRequests)
        <div class="modal" id="request-modal" aria-hidden="true">
            <form class="modal-card demo-form" data-demo-form>
                <button class="modal-close" type="button" data-modal-close aria-label="Cerrar">×</button>
                <small>TRÁMITES</small>
                <h2>Registrar solicitud</h2>
                <label>Solicitante<input required placeholder="Nombre del estudiante o docente"></label>
                <div class="form-grid">
                    <label>Asignatura<select><option>Circuitos Eléctricos I</option><option>Control Automático</option><option>Máquinas Eléctricas II</option></select></label>
                    <label>Fecha de uso<input type="date" value="2026-09-02"></label>
                </div>
                <label>Equipos solicitados<textarea placeholder="Ej. 2 × Multímetro digital, 1 × Osciloscopio"></textarea></label>
                <div class="form-grid">
                    <label>Laboratorio<select><option>Lab. Circuitos</option><option>Lab. Control</option><option>Lab. Potencia</option></select></label>
                    <label>Estado inicial<select><option>Pendiente</option><option>Aprobada</option></select></label>
                </div>
                <div class="modal-actions">
                    <button class="secondary-button" type="button" data-modal-close>Cancelar</button>
                    <button class="primary-button" type="submit">Guardar solicitud</button>
                </div>
            </form>
        </div>

        <div class="modal" id="request-status-modal" aria-hidden="true">
            <form class="modal-card demo-form" data-demo-form>
                <button class="modal-close" type="button" data-modal-close aria-label="Cerrar">×</button>
                <small>SEGUIMIENTO</small>
                <h2>Actualizar estado</h2>
                <label>Nuevo estado<select><option>Pendiente</option><option>Aprobada</option><option>Entregada</option><option>Rechazada</option></select></label>
                <label>Observación<textarea placeholder="Motivo o comentario para el solicitante..."></textarea></label>
                <div class="modal-actions">
                    <button class="secondary-button" type="button" data-modal-close>Cancelar</button>
                    <button class="primary-button" type="submit">Actualizar estado</button>
                </div>
            </form>
        </div>
    @endif

@elseif($page === 'activos')
    <x-hero icon="package" title="Activos" subtitle="Inventario, asignaciones y mantenimiento de recursos físicos."
        :stats="[['Total', '184', 'activos'], ['Buen estado', '148', '80%'], ['En revisión', '24', '13%'], ['Dañados', '12', '7%']]">
        <button class="hero-button" type="button" data-modal-open="asset-modal"><i data-lucide="plus"></i> Nuevo activo</button>
    </x-hero>

    <section class="panel">
        <div class="toolbar">
            <div class="segmented" data-tabs>
                <button class="is-active" type="button" data-tab="inventory">Inventario</button>
                <button type="button" data-tab="assignments">Asignaciones</button>
                <button type="button" data-tab="maintenance">Mantenimiento</button>
            </div>
            <label class="search-field grow"><i data-lucide="search"></i><input type="search" placeholder="Buscar activo, código o ubicación..." data-table-search></label>
            <button class="secondary-button" type="button" data-toast="Inventario exportado"><i data-lucide="download"></i> Exportar</button>
        </div>

        <div data-tab-panel="inventory">
            <div class="table-wrap">
                <table class="data-table">
                    <thead><tr><th>Código</th><th>Activo</th><th>Categoría</th><th>Ubicación</th><th>Estado</th><th class="actions-col">Acciones</th></tr></thead>
                    <tbody>
                        @foreach($inventory as $item)
                            <tr data-search-row>
                                <td><b>{{ $item['code'] }}</b></td>
                                <td>{{ $item['name'] }}</td>
                                <td>{{ $item['category'] }}</td>
                                <td>{{ $item['location'] }}</td>
                                <td><x-badge :value="$item['status']" /></td>
                                <td>
                                    <div class="row-actions">
                                        <button class="row-action" type="button" title="Editar" data-modal-open="asset-modal"><i data-lucide="pencil"></i></button>
                                        <button class="row-action" type="button" title="Asignar" data-modal-open="assignment-modal"><i data-lucide="user-round-check"></i></button>
                                        <button class="row-action danger" type="button" title="Dar de baja" data-toast="{{ $item['code'] }} dado de baja en la demostración"><i data-lucide="trash-2"></i></button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="hidden" data-tab-panel="assignments">
            <div class="table-wrap">
                <table class="data-table">
                    <thead><tr><th>Código</th><th>Activo</th><th>Responsable</th><th>Ubicación</th><th>Desde</th><th>Estado</th><th class="actions-col">Acciones</th></tr></thead>
                    <tbody>
                        @foreach($assignments as $assignment)
                            <tr data-search-row>
                                <td><b>{{ $assignment['code'] }}</b></td>
                                <td>{{ $assignment['asset'] }}</td>
                                <td>{{ $assignment['holder'] }}</td>
                                <td>{{ $assignment['place'] }}</td>
                                <td>{{ $assignment['since'] }}</td>
                                <td><x-badge :value="$assignment['status']" /></td>
                                <td>
                                    <div class="row-actions">
                                        <button class="row-action" type="button" title="Editar asignación" data-modal-open="assignment-modal"><i data-lucide="pencil"></i></button>
                                        <button class="row-action" type="button" title="Registrar devolución" data-toast="Devolución registrada para {{ $assignment['code'] }}"><i data-lucide="undo-2"></i></button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="panel-footer">
                <span><i data-lucide="info"></i> {{ count($assignments) }} asignaciones registradas en el periodo.</span>
                <button class="secondary-button" type="button" data-modal-open="assignment-modal"><i data-lucide="plus"></i> Nueva asignación</button>
            </div>
        </div>

        <div class="hidden" data-tab-panel="maintenance">
            <div class="table-wrap">
                <table class="data-table">
                    <thead><tr><th>Orden</th><th>Activo</th><th>Novedad</th><th>Prioridad</th><th>Apertura</th><th>Estado</th><th class="actions-col">Acciones</th></tr></thead>
                    <tbody>
                        @foreach($maintenance as $order)
                            <tr data-search-row>
                                <td><b>{{ $order['order'] }}</b></td>
                                <td>{{ $order['asset'] }}</td>
                                <td>{{ $order['issue'] }}</td>
                                <td><span class="priority priority-{{ strtolower($order['priority']) }}">{{ $order['priority'] }}</span></td>
                                <td>{{ $order['opened'] }}</td>
                                <td><x-badge :value="$order['status']" /></td>
                                <td>
                                    <div class="row-actions">
                                        <button class="row-action" type="button" title="Editar orden" data-modal-open="maintenance-modal"><i data-lucide="pencil"></i></button>
                                        <button class="row-action" type="button" title="Cerrar orden" data-toast="Orden {{ $order['order'] }} cerrada"><i data-lucide="check"></i></button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="panel-footer">
                <span><i data-lucide="info"></i> {{ count($maintenance) }} órdenes registradas.</span>
                <button class="secondary-button" type="button" data-modal-open="maintenance-modal"><i data-lucide="plus"></i> Nueva orden</button>
            </div>
        </div>
    </section>

    <div class="modal" id="asset-modal" aria-hidden="true">
        <form class="modal-card demo-form" data-demo-form>
            <button class="modal-close" type="button" data-modal-close aria-label="Cerrar">×</button>
            <small>INVENTARIO</small>
            <h2>Registrar activo</h2>
            <label>Nombre del equipo<input required placeholder="Ej. Multímetro digital Fluke 87V"></label>
            <div class="form-grid">
                <label>Código<input placeholder="EQ019"></label>
                <label>Nº de serie<input placeholder="MUL-1009"></label>
            </div>
            <div class="form-grid">
                <label>Categoría<select><option>Equipos</option><option>Herramientas</option><option>Tecnológico</option></select></label>
                <label>Estado<select><option>Bueno</option><option>Malo</option><option>Dañado</option></select></label>
            </div>
            <div class="form-grid">
                <label>Edificio<select><option>FIE-A</option><option>Bloque Labs</option><option>Cómputo</option></select></label>
                <label>Espacio<select><option>Lab. Circuitos</option><option>Lab. Control</option><option>Lab. Potencia</option><option>Aula 201</option></select></label>
            </div>
            <label>Observaciones<textarea placeholder="Detalles de compra, garantía o accesorios..."></textarea></label>
            <div class="modal-actions">
                <button class="secondary-button" type="button" data-modal-close>Cancelar</button>
                <button class="primary-button" type="submit">Guardar activo</button>
            </div>
        </form>
    </div>

    <div class="modal" id="assignment-modal" aria-hidden="true">
        <form class="modal-card demo-form" data-demo-form>
            <button class="modal-close" type="button" data-modal-close aria-label="Cerrar">×</button>
            <small>ASIGNACIONES</small>
            <h2>Asignar activo</h2>
            <label>Activo<select><option>Multímetro Digital Fluke</option><option>Módulo PLC S7-1200</option><option>Proyector Epson PowerLite</option></select></label>
            <div class="form-grid">
                <label>Responsable<input required placeholder="Docente o área"></label>
                <label>Desde<input type="date" value="2026-08-27"></label>
            </div>
            <label>Ubicación de uso<select><option>Lab. Circuitos</option><option>Lab. Control</option><option>Aula Magna</option></select></label>
            <div class="modal-actions">
                <button class="secondary-button" type="button" data-modal-close>Cancelar</button>
                <button class="primary-button" type="submit">Guardar asignación</button>
            </div>
        </form>
    </div>

    <div class="modal" id="maintenance-modal" aria-hidden="true">
        <form class="modal-card demo-form" data-demo-form>
            <button class="modal-close" type="button" data-modal-close aria-label="Cerrar">×</button>
            <small>MANTENIMIENTO</small>
            <h2>Nueva orden</h2>
            <label>Activo<select><option>Osciloscopio Tektronix</option><option>Computadora Core i7</option><option>Motor Trifásico WEG</option></select></label>
            <label>Novedad<textarea required placeholder="Describe la falla detectada..."></textarea></label>
            <div class="form-grid">
                <label>Prioridad<select><option>Alta</option><option>Media</option><option>Baja</option></select></label>
                <label>Responsable técnico<input placeholder="Nombre del técnico"></label>
            </div>
            <div class="modal-actions">
                <button class="secondary-button" type="button" data-modal-close>Cancelar</button>
                <button class="primary-button" type="submit">Crear orden</button>
            </div>
        </form>
    </div>

@elseif(in_array($page, ['usuarios','estudiantes'], true))
    @php
        $isUsersPage = $page === 'usuarios';
        $roleFilters = ['' => 'Todos', 'Estudiante' => 'Estudiantes', 'Docente' => 'Docentes', 'Representante' => 'Representantes'];
        $roleCounts = array_count_values(array_column($users, 'role'));
    @endphp

    <x-hero icon="users"
        :title="$isUsersPage ? 'Usuarios' : 'Estudiantes'"
        :subtitle="$isUsersPage ? 'Gestión demostrativa de estudiantes, docentes y representantes.' : 'Seguimiento de los estudiantes asignados a tus cursos.'"
        :stats="[
            ['Total', $isUsersPage ? '412' : '83', 'registros'],
            ['Activos', $isUsersPage ? '396' : '81', 'vigentes'],
            ['Docentes', '38', 'registrados'],
            ['Representantes', '126', 'vinculados'],
        ]">
        <button class="hero-button" type="button" data-modal-open="user-modal"><i data-lucide="user-plus"></i> Nuevo {{ $isUsersPage ? 'usuario' : 'registro' }}</button>
    </x-hero>

    <section class="panel">
        <div class="toolbar">
            @if($isUsersPage)
                <div class="chip-filters" data-filter-chips>
                    @foreach($roleFilters as $value => $label)
                        <button type="button" class="filter-chip {{ $value === '' ? 'is-active' : '' }}" data-filter-chip="{{ $value }}">
                            {{ $label }}<b>{{ $value === '' ? count($users) : ($roleCounts[$value] ?? 0) }}</b>
                        </button>
                    @endforeach
                </div>
            @endif
            <label class="search-field grow"><i data-lucide="search"></i><input type="search" placeholder="Buscar por nombre o correo..." data-table-search></label>
            <button class="secondary-button" type="button" data-toast="Listado exportado"><i data-lucide="download"></i> Exportar</button>
        </div>

        <div class="table-wrap">
            <table class="data-table">
                <thead><tr><th>Nombre</th><th>Correo</th><th>Rol</th><th>Detalle</th><th>Estado</th><th class="actions-col">Acciones</th></tr></thead>
                <tbody>
                    @foreach($users as $user)
                        <tr data-search-row data-filter-value="{{ $user['role'] }}">
                            <td>
                                <div class="person-cell">
                                    <span class="avatar small">{{ substr($user['name'], 0, 1) }}{{ substr(strrchr($user['name'], ' ') ?: '', 1, 1) }}</span>
                                    <b>{{ $user['name'] }}</b>
                                </div>
                            </td>
                            <td>{{ $user['email'] }}</td>
                            <td>{{ $isUsersPage ? $user['role'] : 'Estudiante' }}</td>
                            <td>{{ $user['detail'] }}</td>
                            <td><x-badge :value="$user['status']" /></td>
                            <td>
                                <div class="row-actions">
                                    <button class="row-action" type="button" title="Ver perfil" data-toast="Perfil de {{ $user['name'] }}"><i data-lucide="eye"></i></button>
                                    <button class="row-action" type="button" title="Editar" data-modal-open="user-modal"><i data-lucide="pencil"></i></button>
                                    <button class="row-action danger" type="button" title="Desactivar" data-toast="{{ $user['name'] }} desactivado en la demostración"><i data-lucide="user-round-x"></i></button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="panel-footer">
            <span><i data-lucide="info"></i> Mostrando {{ count($users) }} registros.</span>
            <div class="rows-per-page">
                <label>Filas:<select><option>10</option><option>25</option><option>50</option></select></label>
            </div>
        </div>
    </section>

    <div class="modal" id="user-modal" aria-hidden="true">
        <form class="modal-card demo-form" data-demo-form>
            <button class="modal-close" type="button" data-modal-close aria-label="Cerrar">×</button>
            <small>USUARIOS</small>
            <h2>Nuevo usuario</h2>
            <label>Nombre completo<input required placeholder="Nombre y apellido"></label>
            <div class="form-grid">
                <label>Correo institucional<input type="email" required placeholder="correo@espoch.edu.ec"></label>
                <label>Cédula<input placeholder="0603XXXXXX"></label>
            </div>
            <div class="form-grid">
                <label>Rol<select><option>Estudiante</option><option>Docente</option><option>Representante</option><option>Administrador</option></select></label>
                <label>Estado<select><option>Activo</option><option>Inactivo</option></select></label>
            </div>
            <div class="form-grid">
                <label>Carrera<select><option>Ingeniería en Electricidad</option><option>Electrónica y Automatización</option><option>Telecomunicaciones</option></select></label>
                <label>PAO<select>@for($pao = 1; $pao <= 9; $pao++)<option>{{ $pao }}.º</option>@endfor</select></label>
            </div>
            <div class="modal-actions">
                <button class="secondary-button" type="button" data-modal-close>Cancelar</button>
                <button class="primary-button" type="submit">Guardar usuario</button>
            </div>
        </form>
    </div>

@else
    <x-hero icon="bar-chart-3" title="Reportes" subtitle="Indicadores de gestión académica y uso de recursos."
        :stats="[['Solicitudes', '126', 'periodo'], ['Préstamos', '98', 'entregados'], ['Uso de aulas', '87%', 'promedio'], ['Asistencia', '92%', 'general']]">
        <button class="hero-button" type="button" data-modal-open="report-modal"><i data-lucide="file-down"></i> Generar reporte</button>
    </x-hero>

    <div class="dashboard-grid">
        <section class="panel span-2">
            <div class="panel-header">
                <div><small>TENDENCIA</small><h2>Uso de recursos por mes</h2></div>
                <div class="row-actions">
                    <button class="secondary-button" type="button" data-toast="Reporte PDF generado"><i data-lucide="file-text"></i> PDF</button>
                    <button class="secondary-button" type="button" data-toast="Reporte Excel generado"><i data-lucide="table"></i> Excel</button>
                </div>
            </div>
            <div class="bar-chart tall">
                @foreach([54, 65, 48, 80, 72, 91] as $index => $height)
                    <div><span style="height:{{ $height }}%"><b>{{ [45,52,39,68,59,76][$index] }}</b></span><small>{{ ['Mar','Abr','May','Jun','Jul','Ago'][$index] }}</small></div>
                @endforeach
            </div>
        </section>
        <section class="panel">
            <div class="panel-header"><div><small>DISTRIBUCIÓN</small><h2>Solicitudes por estado</h2></div></div>
            <div class="donut-wrap"><div class="donut report"><span><strong>126</strong><small>Total</small></span></div></div>
            <div class="legend">
                <span><i class="dot success"></i> Aprobadas <b>72</b></span>
                <span><i class="dot warning"></i> Pendientes <b>18</b></span>
                <span><i class="dot danger"></i> Rechazadas <b>12</b></span>
            </div>
        </section>
    </div>

    <div class="modal" id="report-modal" aria-hidden="true">
        <form class="modal-card demo-form" data-demo-form>
            <button class="modal-close" type="button" data-modal-close aria-label="Cerrar">×</button>
            <small>REPORTES</small>
            <h2>Generar reporte</h2>
            <label>Tipo de reporte<select><option>Uso de recursos</option><option>Solicitudes por estado</option><option>Ocupación de aulas</option><option>Rendimiento académico</option></select></label>
            <div class="form-grid">
                <label>Desde<input type="date" value="2026-03-01"></label>
                <label>Hasta<input type="date" value="2026-08-31"></label>
            </div>
            <label>Formato<select><option>PDF</option><option>Excel</option><option>CSV</option></select></label>
            <div class="modal-actions">
                <button class="secondary-button" type="button" data-modal-close>Cancelar</button>
                <button class="primary-button" type="submit">Generar</button>
            </div>
        </form>
    </div>
@endif
