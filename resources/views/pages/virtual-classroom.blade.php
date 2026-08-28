@php
    $selectedSlug = request()->query('curso');
    $selectedCourse = collect($virtualCourses)->firstWhere('slug', $selectedSlug);
    $isTeacher = $role === 'docente';
    $virtualView = request()->query('vista', 'inicio');
    $virtualNavigation = [
        ['inicio','house','Inicio'],
        ['area','circle-user-round','Área personal'],
        ['cursos','book-open','Mis cursos'],
        ['calendario','calendar-days','Calendario'],
        ['calificaciones','chart-no-axes-column-increasing','Calificaciones'],
    ];
    if ($isTeacher) {
        $virtualNavigation[] = ['estudiantes','users','Estudiantes'];
    }
@endphp

<nav class="virtual-subnav" aria-label="Navegación del aula virtual">
    @foreach($virtualNavigation as $virtualNav)
        <a class="{{ !$selectedCourse && $virtualView === $virtualNav[0] ? 'is-active' : '' }}" href="{{ route('portal', ['role' => $role, 'page' => 'aula-virtual', 'vista' => $virtualNav[0]]) }}"><i data-lucide="{{ $virtualNav[1] }}"></i>{{ $virtualNav[2] }}</a>
    @endforeach
</nav>

@if(!$selectedCourse && $virtualView === 'inicio')
    @include('pages.virtual.dashboard')
@elseif(!$selectedCourse && $virtualView === 'area')
    @include('pages.virtual.personal-area')
@elseif(!$selectedCourse && $virtualView === 'calendario')
    @include('pages.virtual.calendar')
@elseif(!$selectedCourse && $virtualView === 'calificaciones')
    @include($isTeacher ? 'pages.virtual.teacher-grades' : 'pages.virtual.grades')
@elseif(!$selectedCourse && $virtualView === 'estudiantes' && $isTeacher)
    @include('pages.virtual.teacher-students')
@elseif(!$selectedCourse && $virtualView === 'cursos' && $isTeacher)
    @include('pages.virtual.teacher-courses')
@elseif(!$selectedCourse && $virtualView === 'cursos')
    @include('pages.virtual.student-courses')
@else
@if(!$selectedCourse)
    <x-hero icon="monitor-play" :title="$isTeacher ? 'Aulas virtuales' : 'Mi aula virtual'" :subtitle="$isTeacher ? 'Publica contenidos y acompaña el avance de tus estudiantes.' : 'Continúa tus cursos, revisa actividades y consulta tus calificaciones.'" :stats="[['Cursos', count($virtualCourses), 'activos'], ['Progreso', '75%', 'promedio'], ['Pendientes', '3', 'actividades'], ['Avisos', '4', 'nuevos']]">
        @if($isTeacher)<button class="hero-button" data-modal-open="virtual-resource-modal"><i data-lucide="plus"></i> Publicar recurso</button>@endif
    </x-hero>

    <section class="virtual-toolbar">
        <div><small>AÑO LECTIVO 2026-2027</small><h2>{{ $isTeacher ? 'Cursos que imparto' : 'Mis cursos' }}</h2></div>
        <label class="search-field virtual-search"><i data-lucide="search"></i><input type="search" placeholder="Buscar curso..." data-table-search></label>
    </section>

    <div class="virtual-course-grid">
        @foreach($virtualCourses as $course)
            <article class="virtual-course-card" data-search-row>
                <div class="virtual-cover tone-{{ $course['tone'] }}">
                    <img src="{{ $course['image'] }}" alt="Imagen temática de {{ $course['name'] }}" loading="lazy">
                    <span>{{ $course['code'] }}</span><i data-lucide="zap"></i>
                    <div class="cover-progress"><i style="width: {{ $course['progress'] }}%"></i></div>
                </div>
                <div class="virtual-course-body">
                    <small>8.º EGB · PARALELO {{ $course['parallel'] }}</small>
                    <h2>{{ $course['name'] }}</h2>
                    <div class="virtual-teacher"><span>{{ $course['initials'] }}</span><b>{{ $course['teacher'] }}</b></div>
                    <div class="course-progress-copy"><span>Progreso del curso</span><strong>{{ $course['progress'] }}%</strong></div>
                    <div class="next-activity"><i data-lucide="calendar-clock"></i><div><small>PRÓXIMA ACTIVIDAD · {{ $course['date'] }}</small><b>{{ $course['next'] }}</b></div></div>
                    <a class="continue-course" href="{{ route('portal', ['role' => $role, 'page' => 'aula-virtual', 'curso' => $course['slug']]) }}">
                        {{ $isTeacher ? 'Gestionar aula' : 'Continuar curso' }} <i data-lucide="arrow-right"></i>
                    </a>
                </div>
            </article>
        @endforeach
    </div>
@else
    @include('pages.virtual.course-detail')
    @if(false)
    <div class="virtual-breadcrumb"><a href="{{ route('portal', ['role' => $role, 'page' => 'aula-virtual']) }}"><i data-lucide="arrow-left"></i> Mis cursos</a><span>/</span><b>{{ $selectedCourse['code'] }}</b></div>

    <section class="course-room-hero tone-{{ $selectedCourse['tone'] }}">
        <div class="course-room-copy"><span>MONTESSORI · AULA VIRTUAL</span><h1>{{ $selectedCourse['name'] }}</h1><div><i>{{ $selectedCourse['initials'] }}</i><b>{{ $selectedCourse['teacher'] }}</b></div></div>
        <div class="course-room-status">
            @if($isTeacher)
                <div class="teacher-room-summary"><b>{{ $selectedCourse['students'] }} estudiantes</b><span>·</span><b>{{ $selectedCourse['pending'] }} entregas pendientes</b></div>
                <button data-teacher-edit-toggle><i data-lucide="pencil"></i> Activar edición</button>
            @else
                <div><span><i style="width: {{ $selectedCourse['progress'] }}%"></i></span><b>{{ $selectedCourse['progress'] }}% completo</b></div><button data-virtual-tab-target="course">Continuar</button>
            @endif
        </div>
    </section>

    @if($isTeacher)
        <div class="teacher-course-adminbar panel">
            <div><span><i data-lucide="settings-2"></i></span><div><small>MODO DOCENTE</small><b>Gestión del aula</b></div></div>
            <nav>
                <button data-virtual-tab-target="people"><i data-lucide="users"></i> Participantes</button>
                <button data-virtual-tab-target="grades"><i data-lucide="notebook-tabs"></i> Libro de calificaciones</button>
                <button data-toast="Informe del curso preparado"><i data-lucide="chart-no-axes-column-increasing"></i> Informes</button>
                <button data-modal-open="virtual-resource-modal"><i data-lucide="plus"></i> Añadir contenido</button>
            </nav>
        </div>
    @endif

    <div class="virtual-tabs" role="tablist">
        <button class="is-active" role="tab" data-virtual-tab="course">Curso</button>
        <button role="tab" data-virtual-tab="grades">Calificaciones</button>
        <button role="tab" data-virtual-tab="skills">Competencias</button>
        <button role="tab" data-virtual-tab="people">{{ $isTeacher ? 'Participantes' : 'Docente' }}</button>
    </div>

    <section data-virtual-panel="course">
        <div class="virtual-section-title"><div><small>CONTENIDO DEL CURSO</small><h2>Módulos de aprendizaje</h2></div>@if($isTeacher)<button class="pill-button" type="button" data-modal-open="virtual-resource-modal"><i data-lucide="plus"></i> Agregar actividad</button>@endif</div>
        <button class="virtual-announcement" data-toast="Foro abierto en modo demostración"><span><i data-lucide="messages-square"></i></span><div><small>COMUNICACIÓN</small><b>Foro de novedades y avisos</b></div><em>3 nuevos</em><i data-lucide="chevron-right"></i></button>
        <article class="course-welcome panel"><span><i data-lucide="sparkles"></i></span><div><h3>Bienvenido a {{ $selectedCourse['name'] }}</h3><p>En este espacio encontrarás contenidos, recursos y actividades del año lectivo. Revisa los anuncios y desarrolla cada módulo a tu ritmo, respetando las fechas establecidas.</p><b>Unidad Educativa Montessori · Educación General Básica</b></div></article>
        <div class="module-list">
            @foreach($selectedCourse['modules'] as $index => $module)
                <article class="module-item">
                    <button class="module-main" type="button" data-module-toggle>
                        <span class="module-icon type-{{ $module['type'] }}"><i data-lucide="{{ ['forum'=>'messages-square','file'=>'file-text','video'=>'circle-play','task'=>'clipboard-check'][$module['type']] }}"></i></span>
                        <div><small>MÓDULO {{ $index + 1 }}</small><h3>{{ $module['title'] }}</h3><p>{{ $module['meta'] }}</p></div>
                        <x-badge :value="$isTeacher ? 'Visible' : ($module['done'] ? 'Completado' : 'Pendiente')" />@if($isTeacher)<span class="teacher-module-edit" data-toast="Opciones de edición abiertas"><i data-lucide="ellipsis-vertical"></i></span>@endif<i data-lucide="chevron-down"></i>
                    </button>
                    <div class="module-details"><p>{{ $module['done'] ? 'Contenido revisado. Puedes abrirlo nuevamente cuando necesites repasar.' : 'Esta actividad está disponible y requiere tu atención antes de la fecha indicada.' }}</p><button data-toast="Contenido abierto en modo demostración">{{ $module['type'] === 'task' ? 'Ver actividad' : 'Abrir recurso' }}</button></div>
                </article>
            @endforeach
        </div>
    </section>

    <section class="hidden" data-virtual-panel="grades">
        <div class="virtual-section-title"><div><small>EVALUACIÓN</small><h2>Calificaciones del curso</h2></div><div class="grade-summary"><b>{{ $selectedCourse['grades'][2][1] }}</b><small>Promedio actual</small></div></div>
        <div class="panel table-wrap"><table class="data-table virtual-grades"><thead><tr><th>Ítem de calificación</th><th>Calificación calculada</th><th>Rango</th><th>Retroalimentación</th></tr></thead><tbody>@foreach($selectedCourse['grades'] as $grade)<tr><td><b>{{ $grade[0] }}</b></td><td><span class="virtual-grade">{{ $grade[1] }}</span></td><td>0 – 10</td><td><button class="text-button" data-toast="Retroalimentación abierta">Ver comentario</button></td></tr>@endforeach<tr class="grade-total"><td><b>Total del curso</b></td><td><span class="virtual-grade">{{ $selectedCourse['grades'][2][1] }}</span></td><td>0 – 10</td><td>—</td></tr></tbody></table></div>
    </section>

    <section class="hidden" data-virtual-panel="skills">
        <div class="virtual-section-title"><div><small>RESULTADOS DE APRENDIZAJE</small><h2>Competencias del curso</h2></div></div>
        <div class="competency-grid">@foreach([['Pensamiento crítico','Analiza información, formula preguntas y comunica sus conclusiones.',88],['Resolución de problemas','Aplica estrategias y conocimientos en situaciones cotidianas.',76],['Trabajo colaborativo','Participa con autonomía, respeto y responsabilidad en proyectos.',92]] as $skill)<article class="panel"><span><i data-lucide="badge-check"></i></span><h3>{{ $skill[0] }}</h3><p>{{ $skill[1] }}</p><div><i style="width:{{ $skill[2] }}%"></i></div><b>{{ $skill[2] }}% alcanzado</b></article>@endforeach</div>
    </section>

    <section class="hidden" data-virtual-panel="people">
        <div class="virtual-section-title"><div><small>COMUNIDAD DEL CURSO</small><h2>{{ $isTeacher ? 'Participantes matriculados' : 'Equipo docente' }}</h2></div></div>
        <div class="people-grid"><article class="panel virtual-person"><span>{{ $selectedCourse['initials'] }}</span><div><small>DOCENTE PRINCIPAL</small><h3>{{ $selectedCourse['teacher'] }}</h3><p>docente@montessori-riobamba.edu.ec</p></div><button data-toast="Mensaje preparado"><i data-lucide="mail"></i></button></article>@if($isTeacher)@foreach([['JP','Juan Carlos Pérez','M-08021'],['MR','María Fernanda Ruiz','M-08034'],['JS','Jorge Silva Andrade','M-08047']] as $person)<article class="panel virtual-person"><span>{{ $person[0] }}</span><div><small>ESTUDIANTE</small><h3>{{ $person[1] }}</h3><p>{{ $person[2] }} · 8.º EGB A</p></div><button data-toast="Perfil académico abierto"><i data-lucide="eye"></i></button></article>@endforeach @endif</div>
    </section>
    @endif
@endif
@endif

<div class="modal" id="virtual-resource-modal" aria-hidden="true">
    <form class="modal-card demo-form wide-modal" data-demo-form>
        <button class="modal-close" type="button" data-modal-close aria-label="Cerrar">&times;</button>
        <h2>Publicar contenido</h2>
        <div class="form-grid">
            <label>Curso<select>@foreach($virtualCourses as $course)<option>{{ $course['name'] }}</option>@endforeach</select></label>
            <label>Unidad<select><option>Unidad 1</option><option>Unidad 2</option><option>Unidad 3</option></select></label>
        </div>
        <div class="form-grid">
            <label>Tipo<select><option>Recurso</option><option>Actividad</option><option>Foro</option><option>Video</option><option>Cuestionario</option></select></label>
            <label>Visibilidad<select><option>Visible</option><option>Oculto hasta la fecha</option></select></label>
        </div>
        <label>Título<input required placeholder="Nombre del contenido"></label>
        <label>Descripción / instrucciones<textarea placeholder="Instrucciones para los estudiantes"></textarea></label>
        <div class="form-grid">
            <label>Fecha de entrega<input type="date" value="2026-09-05"></label>
            <label>Hora límite<input type="time" value="23:59"></label>
        </div>
        <div class="form-grid">
            <label>Puntaje<input type="number" min="0" max="10" value="10"></label>
            <label>Intentos permitidos<select><option>1</option><option>2</option><option>Ilimitados</option></select></label>
        </div>
        <label class="file-drop">
            <i data-lucide="file-up"></i>
            <span><b>Adjuntar material</b><small>PDF, DOCX, video o enlace · opcional</small></span>
            <input type="file">
        </label>
        <label class="check-inline"><input type="checkbox" checked> Notificar a los estudiantes del curso</label>
        <div class="modal-actions">
            <button class="pill-button" type="button" data-modal-close>Cancelar</button>
            <button class="primary-button dark" type="submit">Publicar contenido</button>
        </div>
    </form>
</div>
