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

    <section class="panel users-panel">
        <span class="panel-accent" aria-hidden="true"></span>

        <div class="toolbar users-toolbar">
            <div class="chip-filters" data-filter-chips>
                @foreach($requestFilters as $value => $label)
                    <button type="button" class="filter-chip {{ $value === '' ? 'is-active' : '' }}" data-filter-chip="{{ $value }}">
                        {{ $label }}<b>{{ $value === '' ? count($requests) : ($statusCounts[$value] ?? 0) }}</b>
                    </button>
                @endforeach
            </div>
            <label class="search-field"><i data-lucide="search"></i><input type="search" placeholder="Buscar solicitud, asignatura o equipo..." data-table-search></label>
            <div class="toolbar-right">
                <button class="pill-button" type="button" data-toast="Listado exportado en la demostración"><i data-lucide="download"></i> Exportar</button>
            </div>
        </div>

        <div class="table-wrap">
            <table class="data-table users-table">
                <thead>
                    <tr>
                        <th class="check-column"><input type="checkbox" aria-label="Seleccionar todo" data-users-select-all></th>
                        <th>Solicitud</th>
                        <th>Asignatura / Equipos</th>
                        <th>Estado</th>
                        <th>Fecha</th>
                        <th class="actions-col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($requests as $request)
                        <tr data-search-row data-filter-value="{{ $request['status'] }}">
                            <td class="check-column"><input type="checkbox" aria-label="Seleccionar {{ $request['id'] }}"></td>
                            <td>
                                <div class="user-cell">
                                    <span class="request-mark"><i data-lucide="clipboard-list"></i></span>
                                    <div><b>{{ $request['id'] }}</b><small>Solicitud de préstamo</small></div>
                                </div>
                            </td>
                            <td>
                                <div class="role-cell">
                                    <span class="role-pill role-estudiante"><i data-lucide="book-open"></i> {{ $request['subject'] }}</span>
                                    <small>{{ $request['items'] }}</small>
                                </div>
                            </td>
                            <td><x-badge :value="$request['status']" /></td>
                            <td class="muted-cell">{{ $request['date'] }}</td>
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

        <x-table-footer :count="count($requests)" />
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
                    <label>Laboratorio<select><option>Laboratorio de Ciencias</option><option>Sala de Computación</option><option>Taller de Arte</option></select></label>
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
            <button class="pill-button" type="button" data-toast="Inventario exportado"><i data-lucide="download"></i> Exportar</button>
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
                <button class="pill-button" type="button" data-modal-open="assignment-modal"><i data-lucide="plus"></i> Nueva asignación</button>
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
                <button class="pill-button" type="button" data-modal-open="maintenance-modal"><i data-lucide="plus"></i> Nueva orden</button>
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
                <label>Edificio<select><option>Bloque EGB</option><option>Bloque de Ciencias</option><option>Bloque Tecnológico</option></select></label>
                <label>Espacio<select><option>Laboratorio de Ciencias</option><option>Sala de Computación</option><option>Biblioteca</option><option>Aula 8A</option></select></label>
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
            <label>Activo<select><option>Microscopio binocular escolar</option><option>Kit educativo de robótica</option><option>Proyector Epson PowerLite</option></select></label>
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
        $roleCounts = array_count_values(array_column($users, 'role'));
        $visibleUsers = $isUsersPage ? $users : array_values(array_filter($users, fn ($user) => $user['role'] === 'Estudiante'));
        $activeUsers = count(array_filter($visibleUsers, fn ($user) => $user['status'] === 'Activo'));
        $roleFilters = ['Administrador', 'Docente', 'Estudiante', 'Representante'];
        $initials = fn (string $name): string => mb_substr($name, 0, 1).mb_substr(strrchr($name, ' ') ?: '', 1, 1);
    @endphp

    <section class="infra-hero users-hero">
        <div class="infra-hero-title">
            <span><i data-lucide="users"></i></span>
            <div>
                <h1>{{ $isUsersPage ? 'Gestión de usuarios y docentes' : 'Estudiantes' }}</h1>
                <p>{{ $isUsersPage ? 'Administración de cuentas y del catálogo docente.' : 'Seguimiento de los estudiantes asignados a tus cursos.' }}</p>
            </div>
        </div>

        <div class="infra-hero-stats">
            <div><i data-lucide="users"></i><span><strong>{{ count($visibleUsers) }}</strong><small>Registros</small></span></div>
            <div><i data-lucide="user-check"></i><span><strong>{{ $activeUsers }}</strong><small>Activos</small></span></div>
            <div><i data-lucide="graduation-cap"></i><span><strong>{{ $roleCounts['Estudiante'] ?? 0 }}</strong><small>Estudiantes</small></span></div>
            <div><i data-lucide="book-open"></i><span><strong>{{ $roleCounts['Docente'] ?? 0 }}</strong><small>Docentes</small></span></div>
        </div>
    </section>

    <section class="panel users-panel" data-users-panel>
        <span class="panel-accent" aria-hidden="true"></span>

        <div class="toolbar users-toolbar">
            <label class="search-field"><i data-lucide="search"></i><input type="search" placeholder="Buscar usuario o docente..." data-users-search></label>

            @if($isUsersPage)
                <div class="chip-filters" data-users-roles>
                    @foreach($roleFilters as $role)
                        <button class="filter-chip role-chip" type="button" data-user-role="{{ $role }}">{{ $role }}</button>
                    @endforeach
                </div>
            @endif

            <select class="select-control" data-users-status>
                <option value="">Estado: Todos</option>
                <option>Activo</option>
                <option>Inactivo</option>
            </select>

            <button class="text-button" type="button" data-users-clear><i data-lucide="rotate-ccw"></i> Limpiar filtros</button>

            <div class="toolbar-right">
                <button class="pill-button" type="button" data-toast="Listado exportado en la demostración"><i data-lucide="download"></i> Exportar</button>
                <button class="pill-button solid" type="button" data-modal-open="user-modal"><i data-lucide="plus"></i> Nuevo registro</button>
            </div>
        </div>

        <div class="table-wrap">
            <table class="data-table users-table">
                <thead>
                    <tr>
                        <th class="check-column"><input type="checkbox" aria-label="Seleccionar todo" data-users-select-all></th>
                        <th><button class="sort-header" type="button" data-sort-users="name">Usuario / Docente <i data-lucide="chevrons-up-down"></i></button></th>
                        <th><button class="sort-header" type="button" data-sort-users="role">Rol / Departamento <i data-lucide="chevrons-up-down"></i></button></th>
                        <th><button class="sort-header" type="button" data-sort-users="status">Estado <i data-lucide="chevrons-up-down"></i></button></th>
                        <th><button class="sort-header" type="button" data-sort-users="last">Última conexión <i data-lucide="chevrons-up-down"></i></button></th>
                        <th class="actions-col">Acciones</th>
                    </tr>
                </thead>
                <tbody data-users-body>
                    @foreach($visibleUsers as $user)
                        <tr data-user-row
                            data-user-search="{{ mb_strtolower($user['name'].' '.$user['email'].' '.$user['department']) }}"
                            data-user-role="{{ $user['role'] }}"
                            data-user-status="{{ $user['status'] }}"
                            data-sort-name="{{ mb_strtolower($user['name']) }}"
                            data-sort-role="{{ $user['role'] }}"
                            data-sort-status="{{ $user['status'] }}"
                            data-sort-last="{{ $user['last_seen'] === 'Sin registro' ? '' : $user['last_seen'] }}">
                            <td class="check-column"><input type="checkbox" aria-label="Seleccionar {{ $user['name'] }}"></td>
                            <td>
                                <div class="user-cell">
                                    <span class="avatar small">{{ $initials($user['name']) }}</span>
                                    <div><b>{{ $user['name'] }}</b><small>{{ $user['email'] }}</small></div>
                                </div>
                            </td>
                            <td>
                                <div class="role-cell">
                                    <span class="role-pill role-{{ Str::slug($user['role']) }}"><i data-lucide="shield-check"></i> {{ $user['role'] }}</span>
                                    <small>{{ $user['department'] }}</small>
                                </div>
                            </td>
                            <td><x-badge :value="$user['status']" /></td>
                            <td class="{{ $user['last_seen'] === 'Sin registro' ? 'muted-cell' : '' }}">{{ $user['last_seen'] }}</td>
                            <td>
                                <div class="row-actions">
                                    <button class="row-action edit" type="button" title="Editar" data-modal-open="user-modal"><i data-lucide="pencil"></i></button>
                                    <button class="row-action danger" type="button" title="Eliminar" data-toast="{{ $user['name'] }} eliminado en la demostración"><i data-lucide="trash-2"></i></button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <p class="empty-state hidden" data-users-empty><i data-lucide="search-x"></i> Ningún registro coincide con los filtros.</p>
        </div>

        <x-table-footer :count="count($visibleUsers)" data-users-range />
        </div>
    </section>

    <div class="modal" id="user-modal" aria-hidden="true">
        <form class="modal-card demo-form" data-demo-form>
            <button class="modal-close" type="button" data-modal-close aria-label="Cerrar">×</button>
            <small>USUARIOS</small>
            <h2>Nuevo registro</h2>
            <label>Nombre completo<input required placeholder="Nombre y apellido"></label>
            <div class="form-grid">
                <label>Correo institucional<input type="email" required placeholder="correo@espoch.edu.ec"></label>
                <label>Cédula<input placeholder="0603XXXXXX"></label>
            </div>
            <div class="form-grid">
                <label>Rol<select>@foreach($roleFilters as $role)<option>{{ $role }}</option>@endforeach</select></label>
                <label>Estado<select><option>Activo</option><option>Inactivo</option></select></label>
            </div>
            <div class="form-grid">
                <label>Nivel o departamento<select><option>EGB Elemental</option><option>EGB Media</option><option>EGB Superior</option><option>Coordinación Académica</option></select></label>
                <label>PAO<select><option>No aplica</option>@for($pao = 1; $pao <= 9; $pao++)<option>{{ $pao }}.º</option>@endfor</select></label>
            </div>
            <div class="modal-actions">
                <button class="secondary-button" type="button" data-modal-close>Cancelar</button>
                <button class="primary-button dark" type="submit">Guardar registro</button>
            </div>
        </form>
    </div>


@else
    <section class="infra-hero">
        <div class="infra-hero-title">
            <span><i data-lucide="bar-chart-3"></i></span>
            <div><h1>Reportes</h1><p>Indicadores de gestión académica y uso de recursos.</p></div>
        </div>

        <div class="infra-hero-stats">
            <div><i data-lucide="clipboard-list"></i><span><strong>126</strong><small>Solicitudes</small></span></div>
            <div><i data-lucide="package-check"></i><span><strong>98</strong><small>Préstamos</small></span></div>
            <div><i data-lucide="door-open"></i><span><strong>87%</strong><small>Uso de aulas</small></span></div>
            <div><i data-lucide="user-check"></i><span><strong>92%</strong><small>Asistencia</small></span></div>
        </div>
    </section>

    <div class="dashboard-grid">
        <section class="panel span-2">
            <div class="panel-header">
                <div><small>TENDENCIA</small><h2>Uso de recursos por mes</h2></div>
                <div class="row-actions">
                    <button class="pill-button" type="button" data-toast="Reporte PDF generado"><i data-lucide="file-text"></i> PDF</button>
                    <button class="pill-button" type="button" data-toast="Reporte Excel generado"><i data-lucide="table"></i> Excel</button>
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

    <section class="panel users-panel" data-users-panel>
        <span class="panel-accent" aria-hidden="true"></span>

        <div class="toolbar users-toolbar">
            <label class="search-field"><i data-lucide="search"></i><input type="search" placeholder="Buscar reporte..." data-users-search></label>

            <div class="chip-filters" data-users-roles>
                <button class="filter-chip role-chip" type="button" data-user-role="PDF">PDF</button>
                <button class="filter-chip role-chip" type="button" data-user-role="Excel">Excel</button>
                <button class="filter-chip role-chip" type="button" data-user-role="CSV">CSV</button>
            </div>

            <select class="select-control" data-users-status>
                <option value="">Estado: Todos</option>
                <option>Generado</option>
                <option>Archivado</option>
            </select>

            <button class="text-button" type="button" data-users-clear><i data-lucide="rotate-ccw"></i> Limpiar filtros</button>

            <div class="toolbar-right">
                <button class="pill-button" type="button" data-toast="Listado exportado en la demostración"><i data-lucide="download"></i> Exportar</button>
                <button class="pill-button solid" type="button" data-modal-open="report-modal"><i data-lucide="plus"></i> Generar reporte</button>
            </div>
        </div>

        <div class="table-wrap">
            <table class="data-table users-table">
                <thead>
                    <tr>
                        <th class="check-column"><input type="checkbox" aria-label="Seleccionar todo" data-users-select-all></th>
                        <th><button class="sort-header" type="button" data-sort-users="name">Reporte <i data-lucide="chevrons-up-down"></i></button></th>
                        <th><button class="sort-header" type="button" data-sort-users="role">Periodo / Formato <i data-lucide="chevrons-up-down"></i></button></th>
                        <th><button class="sort-header" type="button" data-sort-users="status">Estado <i data-lucide="chevrons-up-down"></i></button></th>
                        <th><button class="sort-header" type="button" data-sort-users="last">Generado <i data-lucide="chevrons-up-down"></i></button></th>
                        <th class="actions-col">Acciones</th>
                    </tr>
                </thead>
                <tbody data-users-body>
                    @foreach($reports as $report)
                        <tr data-user-row
                            data-user-search="{{ mb_strtolower($report['name'].' '.$report['code'].' '.$report['author']) }}"
                            data-user-role="{{ $report['format'] }}"
                            data-user-status="{{ $report['status'] }}"
                            data-sort-name="{{ mb_strtolower($report['name']) }}"
                            data-sort-role="{{ $report['format'] }}"
                            data-sort-status="{{ $report['status'] }}"
                            data-sort-last="{{ $report['date'] }}">
                            <td class="check-column"><input type="checkbox" aria-label="Seleccionar {{ $report['name'] }}"></td>
                            <td>
                                <div class="user-cell">
                                    <span class="file-icon {{ strtolower($report['format']) }}"><i data-lucide="file-text"></i></span>
                                    <div><b>{{ $report['name'] }}</b><small>{{ $report['code'] }}</small></div>
                                </div>
                            </td>
                            <td>
                                <div class="role-cell">
                                    <span class="role-pill role-{{ strtolower($report['format']) }}"><i data-lucide="file-type-2"></i> {{ $report['format'] }}</span>
                                    <small>{{ $report['period'] }}</small>
                                </div>
                            </td>
                            <td><x-badge :value="$report['status']" /></td>
                            <td>
                                <div class="role-cell">
                                    <b class="cell-strong">{{ $report['date'] }}</b>
                                    <small>{{ $report['author'] }}</small>
                                </div>
                            </td>
                            <td>
                                <div class="row-actions">
                                    <button class="row-action" type="button" title="Descargar" data-toast="Descargando {{ $report['code'] }}"><i data-lucide="download"></i></button>
                                    <button class="row-action edit" type="button" title="Regenerar" data-modal-open="report-modal"><i data-lucide="refresh-cw"></i></button>
                                    <button class="row-action danger" type="button" title="Eliminar" data-toast="{{ $report['code'] }} eliminado en la demostración"><i data-lucide="trash-2"></i></button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <p class="empty-state hidden" data-users-empty><i data-lucide="search-x"></i> Ningún reporte coincide con los filtros.</p>
        </div>

        <x-table-footer :count="count($reports)" data-users-range />
    </section>

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
                <button class="primary-button dark" type="submit">Generar</button>
            </div>
        </form>
    </div>
@endif
