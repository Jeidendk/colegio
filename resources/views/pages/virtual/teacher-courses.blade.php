@php
    $totalStudents = collect($virtualCourses)->sum('students');
    $totalPending = collect($virtualCourses)->sum('pending');
@endphp

<section class="teacher-courses-heading">
    <div>
        <small>AULA VIRTUAL · PERIODO 2026-1</small>
        <h1>Cursos que imparto</h1>
        <p>Gestiona el contenido, las actividades y el seguimiento de cada materia a tu cargo.</p>
    </div>
    <button class="pill-button solid" type="button" data-toast="La solicitud de nueva aula quedó preparada"><i data-lucide="circle-plus"></i> Solicitar nueva aula</button>
</section>

<div class="detail-metrics">
    @foreach([
        ['book-open-check', count($virtualCourses), 'Cursos activos'],
        ['users', $totalStudents, 'Estudiantes'],
        ['clipboard-clock', $totalPending, 'Entregas por revisar'],
        ['bell-ring', 3, 'Avisos recientes'],
    ] as $stat)
        <div><small>{{ $stat[2] }}</small><strong>{{ $stat[1] }}</strong><span><i data-lucide="{{ $stat[0] }}"></i> Periodo 2026-1</span></div>
    @endforeach
</div>

<section class="panel teacher-course-library" data-teacher-course-library>
    <header class="teacher-library-header"><div><small>VISTA GENERAL</small><h2>Mis aulas activas</h2></div></header>

    <div class="teacher-library-controls">
        <select class="select-control" data-teacher-course-filter aria-label="Filtrar cursos"><option value="">Todos los cursos</option><option value="visible">Visibles para estudiantes</option><option value="pending">Con entregas pendientes</option></select>
        <div class="teacher-controls-right">
            <select class="select-control" data-teacher-course-sort aria-label="Ordenar cursos"><option value="name">Ordenar por nombre del curso</option><option value="updated">Actualizados recientemente</option><option value="pending">Más entregas pendientes</option></select>
            <select class="select-control" aria-label="Periodo académico"><option>Periodo 2026-1</option><option>Periodo 2025-2</option></select>
            <div class="segmented compact layout-switch" aria-label="Cambiar vista">
                <button class="is-active" type="button" data-teacher-course-view="grid" aria-label="Vista de tarjetas"><i data-lucide="layout-grid"></i></button>
                <button type="button" data-teacher-course-view="list" aria-label="Vista de lista"><i data-lucide="list"></i></button>
            </div>
        </div>
    </div>
    <label class="search-field teacher-course-search"><i data-lucide="search"></i><input type="search" placeholder="Buscar cursos..." data-teacher-course-search></label>

    <div class="teacher-course-grid" data-teacher-course-grid>
        @foreach($virtualCourses as $course)
            <article class="teacher-course-card" data-teacher-course data-course-search="{{ strtolower($course['code'].' '.$course['name'].' paralelo '.$course['parallel']) }}" data-course-visible="{{ $course['visible'] ? 'true' : 'false' }}" data-course-pending="{{ $course['pending'] > 0 ? 'true' : 'false' }}" data-course-name="{{ strtolower($course['name']) }}" data-course-pending-count="{{ $course['pending'] }}">
                <div class="teacher-course-cover tone-{{ $course['tone'] }}">
                    <img src="{{ $course['image'] }}" alt="Imagen temática de {{ $course['name'] }}" loading="lazy">
                    <div><span class="teacher-course-code">{{ $course['code'] }}</span><span class="teacher-visible-badge"><i data-lucide="eye"></i> Visible</span></div>
                    <button data-toast="Menú del curso abierto" aria-label="Opciones de {{ $course['name'] }}"><i data-lucide="ellipsis-vertical"></i></button>
                </div>
                <div class="teacher-course-content">
                    <span class="teacher-course-category">INGENIERÍA EN ELECTRICIDAD</span>
                    <div class="teacher-course-title"><div><small>CURSO · PARALELO {{ $course['parallel'] }}</small><h3>{{ $course['name'] }}</h3></div></div>
                    <div class="teacher-course-meta"><span><i data-lucide="users"></i>{{ $course['students'] }} estudiantes</span><span><i data-lucide="layers-3"></i>Paralelo {{ $course['parallel'] }}</span><span><i data-lucide="map-pin"></i>{{ $course['room'] }}</span></div>
                    <div class="teacher-course-numbers">
                        <div><b>{{ $course['sections'] }}</b><small>Secciones</small></div><div><b>{{ $course['activities'] }}</b><small>Actividades</small></div><div class="has-pending"><b>{{ $course['pending'] }}</b><small>Por revisar</small></div>
                    </div>
                    <div class="teacher-course-update"><i data-lucide="refresh-cw"></i><span>Actualizado {{ $course['updated'] }}</span></div>
                    <div class="teacher-course-readiness"><span><i data-lucide="circle-check-big"></i>{{ $course['readiness'] }}% del aula preparada</span><div><i style="width:{{ $course['readiness'] }}%"></i></div></div>
                    <div class="teacher-course-actions">
                        <a class="pill-button solid" href="{{ route('portal', ['role' => $role, 'page' => 'aula-virtual', 'curso' => $course['slug']]) }}"><i data-lucide="settings-2"></i> Administrar curso</a>
                        <a class="pill-button" href="{{ route('portal', ['role' => $role, 'page' => 'aula-virtual', 'curso' => $course['slug']]) }}#calificaciones" data-toast="Libro de calificaciones abierto"><i data-lucide="notebook-tabs"></i><span>Calificaciones</span></a>
                    </div>
                </div>
            </article>
        @endforeach
    </div>

    <div class="teacher-empty hidden" data-teacher-course-empty><i data-lucide="search-x"></i><b>No encontramos cursos</b><p>Prueba con otro nombre, código o filtro.</p></div>
</section>
