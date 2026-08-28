@php
    $gradeRows = [
        ['JP','Juan Carlos Pérez','202145678','Sistemas Eléctricos de Potencia','Actividad 2 · Flujo de potencia','Entregado','—'],
        ['MR','María Fernanda Ruiz','202145691','Sistemas Eléctricos de Potencia','Actividad 2 · Flujo de potencia','Entregado','—'],
        ['JS','Jorge Silva Andrade','202145704','Máquinas Eléctricas II','Informe · Motor trifásico','Borrador','—'],
        ['AC','Andrea Cabrera','202145719','Máquinas Eléctricas II','Taller de transformadores','Calificado','8,7'],
        ['LM','Luis Molina','202145731','Control Automático','Práctica · Control PID','Entregado','—'],
    ];
@endphp

<section class="teacher-courses-heading">
    <div><small>EVALUACIÓN · PERIODO 2026-1</small><h1>Libro de calificaciones</h1><p>Revisa entregas, registra notas y publica la retroalimentación desde una sola bandeja.</p></div>
    <button class="pill-button solid" type="button" data-toast="Las calificaciones guardadas fueron publicadas"><i data-lucide="send"></i> Publicar calificaciones</button>
</section>

<div class="detail-metrics">
    @foreach([['clipboard-clock','22','Por calificar'],['circle-check-big','41','Calificadas'],['clock-3','5','Entregas tardías'],['chart-no-axes-column-increasing','8,4','Promedio general']] as $stat)
        <div><small>{{ $stat[2] }}</small><strong>{{ $stat[1] }}</strong><span><i data-lucide="{{ $stat[0] }}"></i> Periodo 2026-1</span></div>
    @endforeach
</div>

<section class="panel users-panel" data-teacher-gradebook>
    <span class="panel-accent" aria-hidden="true"></span>

    <div class="toolbar users-toolbar">
        <label class="search-field"><i data-lucide="search"></i><input type="search" placeholder="Buscar estudiante, curso o actividad..." data-teacher-grade-search></label>

        <select class="select-control" data-teacher-grade-status>
            <option value="">Estado: Todos</option>
            <option>Entregado</option>
            <option>Borrador</option>
            <option>Calificado</option>
        </select>

        <select class="select-control">
            <option>Todos mis cursos</option>
            @foreach($virtualCourses as $course)<option>{{ $course['name'] }}</option>@endforeach
        </select>

        <div class="toolbar-right">
            <button class="pill-button" type="button" data-toast="Reporte de calificaciones preparado"><i data-lucide="download"></i> Exportar</button>
            <button class="pill-button solid" type="button" data-toast="Calificaciones guardadas en la demostración"><i data-lucide="save"></i> Guardar cambios</button>
        </div>
    </div>

    <div class="table-wrap">
        <table class="data-table users-table">
            <thead>
                <tr>
                    <th>Estudiante</th>
                    <th>Curso / Actividad</th>
                    <th>Estado</th>
                    <th>Nota</th>
                    <th class="actions-col">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($gradeRows as $row)
                    <tr data-teacher-grade-row data-grade-status="{{ $row[5] }}">
                        <td>
                            <div class="user-cell">
                                <span class="avatar small">{{ $row[0] }}</span>
                                <div><b>{{ $row[1] }}</b><small>{{ $row[2] }}</small></div>
                            </div>
                        </td>
                        <td>
                            <div class="role-cell">
                                <span class="role-pill role-estudiante"><i data-lucide="book-open"></i> {{ $row[3] }}</span>
                                <small>{{ $row[4] }}</small>
                            </div>
                        </td>
                        <td><x-badge :value="$row[5]" /></td>
                        <td><strong class="grade-value">{{ $row[6] }}</strong></td>
                        <td>
                            <div class="row-actions">
                                <button class="row-action edit" type="button" title="{{ $row[5] === 'Calificado' ? 'Editar nota' : 'Calificar' }}" data-toast="Evaluador abierto en modo demostración"><i data-lucide="clipboard-pen"></i></button>
                                <button class="row-action" type="button" title="Ver entrega" data-toast="Entrega de {{ $row[1] }}"><i data-lucide="eye"></i></button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <x-table-footer :count="count($gradeRows)" label="22 entregas por calificar en el periodo." />
</section>
