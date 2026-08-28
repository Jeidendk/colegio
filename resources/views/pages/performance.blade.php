@php
    $isTeacherGradebook = $role === 'docente';
    $classRoster = [
        ['name' => 'María Fernanda Ruiz', 'code' => '202145678', 'p1' => '8,7', 'p2' => '9,1', 'final' => '8,9', 'status' => 'Aprobado'],
        ['name' => 'Jorge Silva Andrade', 'code' => '202145702', 'p1' => '7,2', 'p2' => '6,8', 'final' => '7,0', 'status' => 'Aprobado'],
        ['name' => 'Juan Carlos Pérez', 'code' => '202145711', 'p1' => '8,2', 'p2' => '8,6', 'final' => '8,4', 'status' => 'Aprobado'],
        ['name' => 'Diana Carolina Vaca', 'code' => '202145733', 'p1' => '5,4', 'p2' => '6,1', 'final' => '5,8', 'status' => 'En riesgo'],
        ['name' => 'Luis Alberto Naranjo', 'code' => '202145750', 'p1' => '9,0', 'p2' => '9,4', 'final' => '9,2', 'status' => 'Aprobado'],
    ];
@endphp

<x-hero icon="chart-no-axes-column-increasing"
    :title="$isTeacherGradebook ? 'Registro de calificaciones' : 'Rendimiento académico'"
    :subtitle="$isTeacherGradebook ? 'Consulta y edita las notas del curso seleccionado.' : 'Avance de '.$student['firstName'].' en el periodo 2026-1.'"
    :stats="$isTeacherGradebook
        ? [['Estudiantes', count($classRoster), 'en el curso'], ['Promedio', '7,9', 'del curso'], ['Aprobados', '4', 'de 5'], ['En riesgo', '1', 'estudiante']]
        : [['Promedio', $student['average'], 'sobre 10'], ['Asistencia', $student['attendance'], 'general'], ['Aprobadas', '7/7', 'materias'], ['Mejor nota', '9,1', 'Potencia']]">
    @if($isTeacherGradebook)
        <button class="hero-button" type="button" data-modal-open="grade-activity-modal"><i data-lucide="plus"></i> Registrar actividad</button>
    @endif
</x-hero>

<div class="performance-layout">
    <section class="panel span-2">
        <div class="panel-header">
            <div><small>CALIFICACIONES</small><h2>{{ $isTeacherGradebook ? 'Notas por estudiante' : 'Detalle por asignatura' }}</h2></div>
            @if($isTeacherGradebook)
                <div class="row-actions">
                    <button class="secondary-button" type="button" data-toast="Reporte de notas exportado"><i data-lucide="download"></i> Exportar</button>
                    <button class="secondary-button" type="button" data-modal-open="publish-grades-modal"><i data-lucide="send"></i> Publicar</button>
                </div>
            @endif
        </div>

        @if($isTeacherGradebook)
            <div class="toolbar">
                <select class="select-control">
                    @foreach($courses as $course)<option>{{ $course['name'] }} · {{ $course['parallel'] }}</option>@endforeach
                </select>
                <select class="select-control" data-table-filter>
                    <option value="">Todos los estados</option>
                    <option>Aprobado</option>
                    <option>En riesgo</option>
                </select>
                <label class="search-field grow"><i data-lucide="search"></i><input type="search" placeholder="Buscar estudiante o código..." data-table-search></label>
            </div>

            <div class="table-wrap">
                <table class="data-table grades-table">
                    <thead>
                        <tr><th>Estudiante</th><th>Código</th><th>Parcial 1</th><th>Parcial 2</th><th>Final</th><th>Estado</th><th class="actions-col">Acciones</th></tr>
                    </thead>
                    <tbody>
                        @foreach($classRoster as $entry)
                            <tr data-search-row data-filter-value="{{ $entry['status'] }}">
                                <td>
                                    <div class="person-cell">
                                        <span class="avatar small">{{ substr($entry['name'], 0, 1) }}{{ substr(strrchr($entry['name'], ' ') ?: '', 1, 1) }}</span>
                                        <b>{{ $entry['name'] }}</b>
                                    </div>
                                </td>
                                <td>{{ $entry['code'] }}</td>
                                <td><input class="grade-input" type="text" inputmode="decimal" value="{{ $entry['p1'] }}" aria-label="Parcial 1 de {{ $entry['name'] }}"></td>
                                <td><input class="grade-input" type="text" inputmode="decimal" value="{{ $entry['p2'] }}" aria-label="Parcial 2 de {{ $entry['name'] }}"></td>
                                <td><strong class="grade-value">{{ $entry['final'] }}</strong></td>
                                <td><x-badge :value="$entry['status']" /></td>
                                <td>
                                    <div class="row-actions">
                                        <button class="row-action" type="button" title="Ver detalle" data-toast="Detalle de {{ $entry['name'] }}"><i data-lucide="eye"></i></button>
                                        <button class="row-action" type="button" title="Observación" data-modal-open="grade-note-modal"><i data-lucide="message-square"></i></button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="panel-footer">
                <span><i data-lucide="info"></i> Las ediciones son visuales y no se guardan.</span>
                <button class="primary-button" type="button" data-toast="Calificaciones actualizadas en la demostración"><i data-lucide="save"></i> Guardar cambios</button>
            </div>
        @else
            <div class="table-wrap">
                <table class="data-table grades-table">
                    <thead>
                        <tr><th>Asignatura</th><th>Parcial 1</th><th>Parcial 2</th><th>Final</th><th>Estado</th></tr>
                    </thead>
                    <tbody>
                        @foreach($grades as $grade)
                            <tr data-search-row>
                                <td><b>{{ $grade['subject'] }}</b></td>
                                <td>{{ $grade['p1'] }}</td>
                                <td>{{ $grade['p2'] }}</td>
                                <td><strong class="grade-value">{{ $grade['final'] }}</strong></td>
                                <td><x-badge :value="$grade['status']" /></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="panel-footer">
                <span><i data-lucide="info"></i> Promedio general {{ $student['average'] }} sobre 10.</span>
                <button class="secondary-button" type="button" data-toast="Reporte de notas descargado"><i data-lucide="download"></i> Descargar reporte</button>
            </div>
        @endif
    </section>

    <aside class="panel">
        <div class="panel-header"><div><small>EVOLUCIÓN</small><h2>Promedio mensual</h2></div></div>
        <div class="mini-bars">
            @foreach([['Abr', 72], ['May', 78], ['Jun', 81], ['Jul', 85], ['Ago', 87]] as $bar)
                <div><span style="height:{{ $bar[1] }}%"><b>{{ number_format($bar[1] / 10, 1, ',') }}</b></span><small>{{ $bar[0] }}</small></div>
            @endforeach
        </div>
        <div class="achievement">
            <i data-lucide="award"></i>
            <div>
                <b>Desempeño destacado</b>
                <p>El promedio mejoró 1,5 puntos desde abril.</p>
            </div>
        </div>
        @if($isTeacherGradebook)
            <div class="legend">
                <span><i class="dot success"></i> Aprobados <b>4</b></span>
                <span><i class="dot danger"></i> En riesgo <b>1</b></span>
            </div>
        @endif
    </aside>
</div>

@if($isTeacherGradebook)
    <div class="modal" id="grade-activity-modal" aria-hidden="true">
        <form class="modal-card demo-form" data-demo-form>
            <button class="modal-close" type="button" data-modal-close aria-label="Cerrar">×</button>
            <small>CALIFICACIONES</small>
            <h2>Registrar actividad</h2>
            <label>Curso<select>@foreach($courses as $course)<option>{{ $course['name'] }} · {{ $course['parallel'] }}</option>@endforeach</select></label>
            <label>Nombre de la actividad<input required placeholder="Ej. Informe de laboratorio 05"></label>
            <div class="form-grid">
                <label>Aporte<select><option>Parcial 1</option><option>Parcial 2</option><option>Examen final</option></select></label>
                <label>Puntaje máximo<input type="number" min="1" max="10" value="10"></label>
            </div>
            <div class="form-grid">
                <label>Fecha<input type="date" value="2026-09-05"></label>
                <label>Peso (%)<input type="number" min="1" max="100" value="20"></label>
            </div>
            <div class="modal-actions">
                <button class="secondary-button" type="button" data-modal-close>Cancelar</button>
                <button class="primary-button" type="submit">Crear actividad</button>
            </div>
        </form>
    </div>

    <div class="modal" id="grade-note-modal" aria-hidden="true">
        <form class="modal-card demo-form" data-demo-form>
            <button class="modal-close" type="button" data-modal-close aria-label="Cerrar">×</button>
            <small>SEGUIMIENTO</small>
            <h2>Observación del estudiante</h2>
            <label>Tipo<select><option>Académica</option><option>Asistencia</option><option>Comportamiento</option></select></label>
            <label>Observación<textarea required placeholder="Escribe la observación para el estudiante y su representante..."></textarea></label>
            <label class="check-inline"><input type="checkbox" checked> Notificar al representante</label>
            <div class="modal-actions">
                <button class="secondary-button" type="button" data-modal-close>Cancelar</button>
                <button class="primary-button" type="submit">Guardar observación</button>
            </div>
        </form>
    </div>

    <div class="modal" id="publish-grades-modal" aria-hidden="true">
        <form class="modal-card demo-form" data-demo-form>
            <button class="modal-close" type="button" data-modal-close aria-label="Cerrar">×</button>
            <small>PUBLICACIÓN</small>
            <h2>Publicar calificaciones</h2>
            <label>Curso<select>@foreach($courses as $course)<option>{{ $course['name'] }} · {{ $course['parallel'] }}</option>@endforeach</select></label>
            <label>Aporte<select><option>Parcial 1</option><option>Parcial 2</option><option>Examen final</option></select></label>
            <label class="check-inline"><input type="checkbox" checked> Notificar a estudiantes y representantes</label>
            <div class="info-strip"><i data-lucide="info"></i> Una vez publicadas, las notas quedan visibles en el portal del estudiante.</div>
            <div class="modal-actions">
                <button class="secondary-button" type="button" data-modal-close>Cancelar</button>
                <button class="primary-button" type="submit">Publicar</button>
            </div>
        </form>
    </div>
@endif
