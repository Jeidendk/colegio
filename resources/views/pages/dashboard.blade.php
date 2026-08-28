@php
    $isAdmin = $role === 'admin';
    $isTeacher = $role === 'docente';
    $heroTitle = $isAdmin ? 'Bienvenida, Andrea' : ($isTeacher ? 'Hola, Roberto' : 'Hola, Ana Lucía');
    $heroSubtitle = $isAdmin ? 'Este es el estado general de la comunidad educativa Montessori.' : ($isTeacher ? 'Revisa tus clases, cursos y pendientes del día.' : 'Así avanza Juan Carlos durante el año lectivo 2026-2027.');
    $heroStats = $isAdmin
        ? [['Activos', '184', '+12 este mes'], ['Aulas', '26', '23 disponibles'], ['Solicitudes', '18', '4 pendientes'], ['Estudiantes', '308', 'matriculados']]
        : ($isTeacher
            ? [['Cursos', '3', 'asignados'], ['Estudiantes', '83', 'en total'], ['Clases hoy', '4', 'próxima 10:00'], ['Pendientes', '6', 'por calificar']]
            : [['Promedio', $student['average'], 'sobre 10'], ['Asistencia', $student['attendance'], '+2% este mes'], ['Materias', '7', 'todas aprobadas'], ['Solicitudes', '2', 'activas']]);
@endphp

<x-hero icon="{{ $isAdmin ? 'layout-dashboard' : ($isTeacher ? 'presentation' : 'heart-handshake') }}" :title="$heroTitle" :subtitle="$heroSubtitle" :stats="$heroStats" />

@if($isAdmin)
<div class="dashboard-grid">
    <section class="panel span-2">
        <div class="panel-header"><div><small>ACTIVIDAD</small><h2>Solicitudes por mes</h2></div><button class="ghost-button" data-toast="Reporte de demostración listo">Exportar</button></div>
        <div class="bar-chart" aria-label="Solicitudes de marzo a agosto">
            @foreach([42, 58, 47, 73, 64, 88] as $index => $height)
                <div><span style="height: {{ $height }}%"><b>{{ [18,24,20,31,27,38][$index] }}</b></span><small>{{ ['Mar','Abr','May','Jun','Jul','Ago'][$index] }}</small></div>
            @endforeach
        </div>
    </section>
    <section class="panel">
        <div class="panel-header"><div><small>INVENTARIO</small><h2>Estado de activos</h2></div></div>
        <div class="donut-wrap"><div class="donut"><span><strong>184</strong><small>Total</small></span></div></div>
        <div class="legend"><span><i class="dot success"></i> Buen estado <b>148</b></span><span><i class="dot warning"></i> En revisión <b>24</b></span><span><i class="dot danger"></i> Dañados <b>12</b></span></div>
    </section>
    <section class="panel span-2">
        <div class="panel-header"><div><small>RECIENTES</small><h2>Últimas solicitudes</h2></div><a href="{{ route('portal', ['role' => 'admin', 'page' => 'tramites']) }}">Ver todas</a></div>
        @include('partials.request-table', ['rows' => array_slice($requests, 0, 3)])
    </section>
    <section class="panel">
        <div class="panel-header"><div><small>ALERTAS</small><h2>Requieren atención</h2></div></div>
        <div class="alert-list">
            <button data-toast="Abriendo activo EQ004"><i data-lucide="triangle-alert"></i><span><b>Equipo dañado</b><small>PC Core i7 · Lab. Cómputo 1</small></span></button>
            <button data-toast="Abriendo solicitud SOL-2026-038"><i data-lucide="clock-3"></i><span><b>Solicitud pendiente</b><small>Hace 5 días · Ciencias Naturales</small></span></button>
            <button data-toast="Stock de proyectores revisado"><i data-lucide="package-x"></i><span><b>Stock bajo</b><small>Proyector Epson · 1 disponible</small></span></button>
        </div>
    </section>
</div>
@elseif($isTeacher)
<div class="dashboard-grid">
    <section class="panel span-2">
        <div class="panel-header"><div><small>MI JORNADA</small><h2>Clases de hoy</h2></div><span class="date-chip">Jueves, 27 de agosto</span></div>
        <div class="timeline">
            @foreach([['07:00','Matemática','Aula 8A','Finalizada'],['10:00','Lengua y Literatura','Biblioteca','Próxima'],['14:00','Ciencias Naturales','Laboratorio de Ciencias','Pendiente']] as $class)
                <div class="timeline-row"><time>{{ $class[0] }}</time><span class="timeline-dot"></span><div><b>{{ $class[1] }}</b><small>{{ $class[2] }}</small></div><x-badge :value="$class[3]" /></div>
            @endforeach
        </div>
    </section>
    <section class="panel">
        <div class="panel-header"><div><small>PENDIENTES</small><h2>Acciones rápidas</h2></div></div>
        <div class="quick-actions">
            <a href="{{ route('portal', ['role' => 'docente', 'page' => 'aula-virtual', 'vista' => 'calificaciones']) }}"><i data-lucide="clipboard-pen"></i><span><b>Registrar notas</b><small>22 entregas por revisar</small></span></a>
            <button data-modal-open="new-resource-modal"><i data-lucide="upload"></i><span><b>Publicar recurso</b><small>Para tus cursos</small></span></button>
            <a href="{{ route('portal', ['role' => 'docente', 'page' => 'comunicaciones']) }}"><i data-lucide="send"></i><span><b>Enviar aviso</b><small>A un curso o paralelo</small></span></a>
        </div>
    </section>
    <section class="panel span-3">
        <div class="panel-header"><div><small>AÑO LECTIVO 2026-2027</small><h2>Mis cursos</h2></div><a href="{{ route('portal', ['role' => 'docente', 'page' => 'aula-virtual', 'vista' => 'cursos']) }}">Abrir aula virtual</a></div>
        <div class="course-grid compact">
            @foreach($courses as $course)
                <article class="course-card"><span class="course-code">{{ $course['code'] }}</span><h3>{{ $course['name'] }}</h3><p>Paralelo {{ $course['parallel'] }} · {{ $course['room'] }}</p><div><span><i data-lucide="users"></i>{{ $course['students'] }} estudiantes</span><b>{{ $course['average'] }} prom.</b></div></article>
            @endforeach
        </div>
    </section>
</div>
@else
<div class="representative-layout">
    <section class="student-card panel">
        <div class="student-avatar">JP</div><div><small>ESTUDIANTE VINCULADO</small><h2>{{ $student['name'] }}</h2><p>{{ $student['code'] }} · {{ $student['career'] }}</p></div><x-badge value="Matrícula activa" />
    </section>
    <div class="dashboard-grid">
        <section class="panel span-2">
            <div class="panel-header"><div><small>RENDIMIENTO</small><h2>Progreso por materia</h2></div><a href="{{ route('portal', ['role' => 'representante', 'page' => 'rendimiento']) }}">Ver detalle</a></div>
            <div class="progress-list">
                @foreach(array_slice($grades, 0, 4) as $grade)
                    <div><span><b>{{ $grade['subject'] }}</b><strong>{{ $grade['final'] }}</strong></span><div><i style="width: {{ ((float) str_replace(',', '.', $grade['final'])) * 10 }}%"></i></div></div>
                @endforeach
            </div>
        </section>
        <section class="panel">
            <div class="panel-header"><div><small>PRÓXIMAS</small><h2>Actividades</h2></div></div>
            <div class="mini-calendar"><b>28</b><span>AGO<small>Entrega informe de laboratorio</small></span></div>
            <div class="mini-calendar"><b>02</b><span>SEP<small>Evaluación de Matemática</small></span></div>
            <div class="mini-calendar"><b>05</b><span>SEP<small>Reunión de representantes</small></span></div>
        </section>
        <section class="panel span-3">
            <div class="panel-header"><div><small>ACTUALIZACIONES</small><h2>Novedades recientes</h2></div></div>
            <div class="notice-list">
                @foreach($notices as $notice)
                    <article><span class="notice-icon"><i data-lucide="bell-ring"></i></span><div><small>{{ $notice['type'] }} · {{ $notice['date'] }}</small><h3>{{ $notice['title'] }}</h3><p>{{ $notice['text'] }}</p></div></article>
                @endforeach
            </div>
        </section>
    </div>
</div>
@endif

<div class="modal" id="new-resource-modal" aria-hidden="true"><form class="modal-card demo-form" data-demo-form><button class="modal-close" type="button" data-modal-close>×</button><small>RECURSO ACADÉMICO</small><h2>Publicar nuevo material</h2><label>Título<input required placeholder="Ej. Guía de lectura 05"></label><label>Curso<select><option>Matemática</option><option>Lengua y Literatura</option><option>Ciencias Naturales</option></select></label><label>Descripción<textarea placeholder="Describe el contenido..."></textarea></label><button class="primary-button" type="submit">Publicar recurso</button></form></div>
