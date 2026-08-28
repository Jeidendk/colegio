@php
    $isTeacherGradebook = $role === 'docente';
    $atRisk = count(array_filter($roster, fn ($entry) => $entry['status'] === 'En riesgo'));
    $initials = fn (string $name): string => mb_substr($name, 0, 1).mb_substr(strrchr($name, ' ') ?: '', 1, 1);
@endphp

<x-hero icon="chart-no-axes-column-increasing"
    :title="$isTeacherGradebook ? 'Registro de calificaciones' : 'Rendimiento académico'"
    :subtitle="$isTeacherGradebook ? 'Consulta y edita las notas del curso seleccionado.' : 'Avance de '.$student['firstName'].' en el periodo 2026-1.'"
    :stats="$isTeacherGradebook
        ? [['Estudiantes', count($roster), 'en el curso'], ['Promedio', '7,9', 'del curso'], ['Aprobados', count($roster) - $atRisk, 'de '.count($roster)], ['En riesgo', $atRisk, 'requieren apoyo']]
        : [['Promedio', $student['average'], 'sobre 10'], ['Asistencia', $student['attendance'], 'general'], ['Aprobadas', '7/7', 'materias'], ['Mejor nota', '9,1', 'Potencia']]">
    @if($isTeacherGradebook)
        <button class="hero-button" type="button" data-modal-open="grade-activity-modal"><i data-lucide="plus"></i> Registrar actividad</button>
    @endif
</x-hero>

<div class="performance-layout">
    <section class="panel users-panel span-2" data-users-panel>
        <span class="panel-accent" aria-hidden="true"></span>

        @if($isTeacherGradebook)
            <div class="toolbar users-toolbar">
                <label class="search-field"><i data-lucide="search"></i><input type="search" placeholder="Buscar estudiante o código..." data-users-search></label>

                <select class="select-control">
                    @foreach($courses as $course)<option>{{ $course['name'] }} · {{ $course['parallel'] }}</option>@endforeach
                </select>

                <div class="chip-filters" data-users-roles>
                    <button class="filter-chip role-chip" type="button" data-user-role="Aprobado">Aprobados</button>
                    <button class="filter-chip role-chip" type="button" data-user-role="En riesgo">En riesgo</button>
                </div>

                <button class="text-button" type="button" data-users-clear><i data-lucide="rotate-ccw"></i> Limpiar filtros</button>

                <div class="toolbar-right">
                    <button class="pill-button" type="button" data-toast="Reporte de notas exportado"><i data-lucide="download"></i> Exportar</button>
                    <button class="pill-button" type="button" data-modal-open="publish-grades-modal"><i data-lucide="send"></i> Publicar</button>
                    <button class="pill-button solid" type="button" data-toast="Calificaciones actualizadas en la demostración"><i data-lucide="save"></i> Guardar cambios</button>
                </div>
            </div>

            <div class="table-wrap">
                <table class="data-table users-table grades-table">
                    <thead>
                        <tr>
                            <th class="check-column"><input type="checkbox" aria-label="Seleccionar todo" data-users-select-all></th>
                            <th><button class="sort-header" type="button" data-sort-users="name">Estudiante <i data-lucide="chevrons-up-down"></i></button></th>
                            <th>Parcial 1</th>
                            <th>Parcial 2</th>
                            <th><button class="sort-header" type="button" data-sort-users="last">Final <i data-lucide="chevrons-up-down"></i></button></th>
                            <th><button class="sort-header" type="button" data-sort-users="status">Estado <i data-lucide="chevrons-up-down"></i></button></th>
                            <th class="actions-col">Acciones</th>
                        </tr>
                    </thead>
                    <tbody data-users-body>
                        @foreach($roster as $entry)
                            <tr data-user-row
                                data-user-search="{{ mb_strtolower($entry['name'].' '.$entry['code']) }}"
                                data-user-role="{{ $entry['status'] }}"
                                data-user-status="{{ $entry['status'] }}"
                                data-sort-name="{{ mb_strtolower($entry['name']) }}"
                                data-sort-status="{{ $entry['status'] }}"
                                data-sort-last="{{ $entry['final'] }}">
                                <td class="check-column"><input type="checkbox" aria-label="Seleccionar {{ $entry['name'] }}"></td>
                                <td>
                                    <div class="user-cell">
                                        <span class="avatar small">{{ $initials($entry['name']) }}</span>
                                        <div><b>{{ $entry['name'] }}</b><small>{{ $entry['code'] }}</small></div>
                                    </div>
                                </td>
                                <td><input class="grade-input" type="text" inputmode="decimal" value="{{ $entry['p1'] }}" aria-label="Parcial 1 de {{ $entry['name'] }}"></td>
                                <td><input class="grade-input" type="text" inputmode="decimal" value="{{ $entry['p2'] }}" aria-label="Parcial 2 de {{ $entry['name'] }}"></td>
                                <td><strong class="grade-value">{{ $entry['final'] }}</strong></td>
                                <td><x-badge :value="$entry['status']" /></td>
                                <td>
                                    <div class="row-actions">
                                        <button class="row-action" type="button" title="Ver detalle" data-toast="Detalle de {{ $entry['name'] }}"><i data-lucide="eye"></i></button>
                                        <button class="row-action edit" type="button" title="Observación" data-modal-open="grade-note-modal"><i data-lucide="message-square"></i></button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <p class="empty-state hidden" data-users-empty><i data-lucide="search-x"></i> Ningún estudiante coincide con los filtros.</p>
            </div>

            <x-table-footer :count="count($roster)" label="Las ediciones son visuales y no se guardan." data-users-range />
        @else
            <div class="panel-header">
                <div><small>CALIFICACIONES</small><h2>Detalle por asignatura</h2></div>
                <button class="pill-button" type="button" data-toast="Reporte de notas descargado"><i data-lucide="download"></i> Descargar reporte</button>
            </div>

            <div class="table-wrap">
                <table class="data-table users-table grades-table">
                    <thead>
                        <tr>
                            <th><button class="sort-header" type="button" data-sort-users="name">Asignatura <i data-lucide="chevrons-up-down"></i></button></th>
                            <th>Parcial 1</th>
                            <th>Parcial 2</th>
                            <th><button class="sort-header" type="button" data-sort-users="last">Final <i data-lucide="chevrons-up-down"></i></button></th>
                            <th><button class="sort-header" type="button" data-sort-users="status">Estado <i data-lucide="chevrons-up-down"></i></button></th>
                        </tr>
                    </thead>
                    <tbody data-users-body>
                        @foreach($grades as $grade)
                            <tr data-user-row
                                data-user-search="{{ mb_strtolower($grade['subject']) }}"
                                data-user-status="{{ $grade['status'] }}"
                                data-sort-name="{{ mb_strtolower($grade['subject']) }}"
                                data-sort-status="{{ $grade['status'] }}"
                                data-sort-last="{{ $grade['final'] }}">
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

            <x-table-footer :count="count($grades)" :label="'Promedio general '.$student['average'].' sobre 10.'" />
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
                <span><i class="dot success"></i> Aprobados <b>{{ count($roster) - $atRisk }}</b></span>
                <span><i class="dot danger"></i> En riesgo <b>{{ $atRisk }}</b></span>
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
            <label class="export-field">Curso<select>@foreach($courses as $course)<option>{{ $course['name'] }} · {{ $course['parallel'] }}</option>@endforeach</select></label>
            <label class="export-field">Nombre de la actividad<input required placeholder="Ej. Informe de laboratorio 05"></label>
            <div class="form-grid">
                <label class="export-field">Aporte<select><option>Parcial 1</option><option>Parcial 2</option><option>Examen final</option></select></label>
                <label class="export-field">Puntaje máximo<input type="number" min="1" max="10" value="10"></label>
            </div>
            <div class="form-grid">
                <label class="export-field">Fecha<input type="date" value="2026-09-05"></label>
                <label class="export-field">Peso (%)<input type="number" min="1" max="100" value="20"></label>
            </div>
            <div class="modal-actions">
                <button class="secondary-button" type="button" data-modal-close>Cancelar</button>
                <button class="primary-button dark" type="submit">Crear actividad</button>
            </div>
        </form>
    </div>

    <div class="modal" id="grade-note-modal" aria-hidden="true">
        <form class="modal-card demo-form" data-demo-form>
            <button class="modal-close" type="button" data-modal-close aria-label="Cerrar">×</button>
            <small>SEGUIMIENTO</small>
            <h2>Observación del estudiante</h2>
            <label class="export-field">Tipo<select><option>Académica</option><option>Asistencia</option><option>Comportamiento</option></select></label>
            <label class="export-field">Observación<textarea required placeholder="Escribe la observación para el estudiante y su representante..."></textarea></label>
            <label class="check-inline"><input type="checkbox" checked> Notificar al representante</label>
            <div class="modal-actions">
                <button class="secondary-button" type="button" data-modal-close>Cancelar</button>
                <button class="primary-button dark" type="submit">Guardar observación</button>
            </div>
        </form>
    </div>

    <div class="modal" id="publish-grades-modal" aria-hidden="true">
        <form class="modal-card demo-form" data-demo-form>
            <button class="modal-close" type="button" data-modal-close aria-label="Cerrar">×</button>
            <small>PUBLICACIÓN</small>
            <h2>Publicar calificaciones</h2>
            <label class="export-field">Curso<select>@foreach($courses as $course)<option>{{ $course['name'] }} · {{ $course['parallel'] }}</option>@endforeach</select></label>
            <label class="export-field">Aporte<select><option>Parcial 1</option><option>Parcial 2</option><option>Examen final</option></select></label>
            <label class="check-inline"><input type="checkbox" checked> Notificar a estudiantes y representantes</label>
            <div class="info-strip"><i data-lucide="info"></i> Una vez publicadas, las notas quedan visibles en el portal del estudiante.</div>
            <div class="modal-actions">
                <button class="secondary-button" type="button" data-modal-close>Cancelar</button>
                <button class="primary-button dark" type="submit">Publicar</button>
            </div>
        </form>
    </div>
@endif
