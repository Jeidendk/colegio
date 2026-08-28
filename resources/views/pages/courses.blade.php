@php
    $courseSchedules = [
        'ELEC-501' => 'Lun y Mié · 07:00 - 09:00',
        'ELEC-503' => 'Mar y Jue · 14:00 - 16:00',
        'ELEC-506' => 'Lun y Mié · 10:00 - 12:00',
    ];
@endphp

<x-hero icon="book-open-check" title="Mis cursos" subtitle="Cursos y paralelos asignados para el periodo académico 2026-1."
    :stats="[['Cursos', count($courses), 'asignados'], ['Estudiantes', '83', 'matriculados'], ['Promedio', '8,2', 'general'], ['Pendientes', '6', 'actividades']]">
    <button class="hero-button" type="button" data-modal-open="course-message-modal"><i data-lucide="send"></i> Enviar aviso</button>
</x-hero>

<section class="panel">
    <div class="toolbar">
        <label class="search-field grow"><i data-lucide="search"></i><input type="search" placeholder="Buscar curso o paralelo..." data-table-search></label>
        <select class="select-control" data-table-filter>
            <option value="">Todos los paralelos</option>
            <option>A</option>
            <option>B</option>
        </select>
        <button class="secondary-button" type="button" data-modal-open="course-activity-modal"><i data-lucide="clipboard-pen"></i> Nueva actividad</button>
        <button class="secondary-button" type="button" data-toast="Listado de cursos exportado"><i data-lucide="download"></i> Exportar</button>
    </div>

    <div class="course-grid">
        @foreach($courses as $index => $course)
            <article class="course-card large" data-search-row data-filter-value="{{ $course['parallel'] }}">
                <div class="course-cover tone-{{ $index + 1 }}">
                    <span>{{ $course['code'] }}</span>
                    <i data-lucide="zap"></i>
                </div>
                <div class="course-content">
                    <small>PARALELO {{ $course['parallel'] }}</small>
                    <h2>{{ $course['name'] }}</h2>
                    <p><i data-lucide="map-pin"></i>{{ $course['room'] }} · 4 créditos</p>
                    <p><i data-lucide="clock"></i>{{ $courseSchedules[$course['code']] ?? 'Horario por definir' }}</p>

                    <div class="course-metrics">
                        <span><b>{{ $course['students'] }}</b><small>Estudiantes</small></span>
                        <span><b>{{ $course['average'] }}</b><small>Promedio</small></span>
                        <span><b>{{ 2 + $index }}</b><small>Pendientes</small></span>
                    </div>

                    <div class="course-progress">
                        <div class="progress-head"><span>Avance del sílabo</span><b>{{ 55 + $index * 12 }}%</b></div>
                        <div class="progress-track"><i style="width: {{ 55 + $index * 12 }}%"></i></div>
                    </div>

                    <div class="course-actions">
                        <a href="{{ route('portal', ['role' => 'docente', 'page' => 'calificaciones']) }}"><i data-lucide="clipboard-check"></i> Calificaciones</a>
                        <a href="{{ route('portal', ['role' => 'docente', 'page' => 'estudiantes']) }}"><i data-lucide="users"></i> Estudiantes</a>
                        <button type="button" data-modal-open="course-activity-modal"><i data-lucide="plus"></i> Actividad</button>
                        <button type="button" data-modal-open="course-message-modal"><i data-lucide="send"></i> Aviso</button>
                    </div>
                </div>
            </article>
        @endforeach
    </div>

    <div class="panel-footer">
        <span><i data-lucide="info"></i> {{ count($courses) }} cursos asignados en el periodo 2026-1.</span>
    </div>
</section>

<div class="modal" id="course-message-modal" aria-hidden="true">
    <form class="modal-card demo-form" data-demo-form>
        <button class="modal-close" type="button" data-modal-close aria-label="Cerrar">×</button>
        <small>COMUNICACIÓN</small>
        <h2>Enviar aviso al curso</h2>
        <label>Curso<select>@foreach($courses as $course)<option>{{ $course['name'] }} · {{ $course['parallel'] }}</option>@endforeach</select></label>
        <div class="form-grid">
            <label>Destinatarios<select><option>Todo el paralelo</option><option>Solo estudiantes con pendientes</option><option>Representantes</option></select></label>
            <label>Prioridad<select><option>Normal</option><option>Alta</option></select></label>
        </div>
        <label>Asunto<input required placeholder="Asunto del aviso"></label>
        <label>Mensaje<textarea required placeholder="Escribe el mensaje"></textarea></label>
        <label class="check-inline"><input type="checkbox" checked> Enviar copia al correo institucional</label>
        <div class="modal-actions">
            <button class="secondary-button" type="button" data-modal-close>Cancelar</button>
            <button class="primary-button" type="submit">Enviar aviso</button>
        </div>
    </form>
</div>

<div class="modal" id="course-activity-modal" aria-hidden="true">
    <form class="modal-card demo-form" data-demo-form>
        <button class="modal-close" type="button" data-modal-close aria-label="Cerrar">×</button>
        <small>ACTIVIDADES</small>
        <h2>Nueva actividad</h2>
        <label>Curso<select>@foreach($courses as $course)<option>{{ $course['name'] }} · {{ $course['parallel'] }}</option>@endforeach</select></label>
        <label>Título<input required placeholder="Ej. Informe de laboratorio 05"></label>
        <div class="form-grid">
            <label>Tipo<select><option>Tarea</option><option>Informe</option><option>Cuestionario</option><option>Práctica</option></select></label>
            <label>Puntaje<input type="number" min="1" max="10" value="10"></label>
        </div>
        <div class="form-grid">
            <label>Fecha de entrega<input type="date" value="2026-09-05"></label>
            <label>Hora límite<input type="time" value="23:59"></label>
        </div>
        <label>Instrucciones<textarea placeholder="Describe qué debe entregar el estudiante..."></textarea></label>
        <div class="modal-actions">
            <button class="secondary-button" type="button" data-modal-close>Cancelar</button>
            <button class="primary-button" type="submit">Crear actividad</button>
        </div>
    </form>
</div>
