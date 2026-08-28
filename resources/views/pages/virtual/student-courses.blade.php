<section class="student-courses-page" data-student-courses>
    <header class="student-courses-heading">
        <div><h1>Mis cursos</h1><p>Vista general de las materias de 8.º EGB · Paralelo A.</p></div>
    </header>

    <div class="student-course-controls">
        <select class="select-control student-course-filter" data-student-course-filter aria-label="Filtrar cursos">
            <option value="">Todos</option>
            <option value="progress">En progreso</option>
            <option value="completed">Completados</option>
            <option value="pending">Con actividades pendientes</option>
        </select>
        <div>
            <select class="select-control" data-student-course-sort aria-label="Ordenar cursos">
                <option value="name">Ordenar por nombre del curso</option>
                <option value="progress">Mayor progreso</option>
                <option value="recent">Actualizados recientemente</option>
            </select>
            <select class="select-control" data-student-course-view aria-label="Tipo de vista">
                <option value="grid">Tarjeta</option>
                <option value="list">Lista</option>
            </select>
        </div>
    </div>

    <label class="search-field student-course-search"><i data-lucide="search"></i><input type="search" placeholder="Buscar cursos..." data-student-course-search></label>

    <div class="student-course-grid" data-student-course-grid>
        @foreach($virtualCourses as $course)
            <a class="student-course-card" href="{{ route('portal', ['role' => $role, 'page' => 'aula-virtual', 'curso' => $course['slug']]) }}"
                data-student-course
                data-course-search="{{ strtolower($course['code'].' '.$course['name'].' '.$course['teacher']) }}"
                data-course-name="{{ strtolower($course['name']) }}"
                data-course-progress="{{ $course['progress'] }}"
                data-course-pending="{{ $course['pending'] }}">
                <div class="student-course-cover">
                    <img src="{{ $course['image'] }}" alt="{{ $course['name'] }}" loading="lazy">
                    <span class="student-course-code">{{ $course['code'] }}</span>
                    <span class="student-course-menu" aria-hidden="true"><i data-lucide="ellipsis-vertical"></i></span>
                </div>
                <div class="student-course-body">
                    <span class="student-course-level">EDUCACIÓN GENERAL BÁSICA</span>
                    <small>CURSO:</small>
                    <h2>{{ $course['name'] }}</h2>
                    <div class="student-course-facts">
                        <div><span><i data-lucide="monitor-play"></i></span><small>Modalidad</small><b>Aula virtual</b></div>
                        <div><span><i data-lucide="clock-3"></i></span><small>Carga semanal</small><b>5 horas</b></div>
                        <div><span><i data-lucide="tag"></i></span><small>Nivel</small><b>8.º EGB</b></div>
                    </div>
                    <p>{{ $course['teacher'] }}</p>
                    <span class="student-course-tag"><i data-lucide="hash"></i>{{ $course['code'] }} · Paralelo {{ $course['parallel'] }}</span>
                </div>
                <footer class="student-course-progress">
                    <span><i data-lucide="circle-check-big"></i>{{ $course['progress'] }}% completado</span>
                    <div><i style="width:{{ $course['progress'] }}%"></i></div>
                    <small>{{ $course['pending'] }} actividades pendientes</small>
                </footer>
            </a>
        @endforeach
    </div>

    <div class="teacher-empty hidden" data-student-course-empty><i data-lucide="search-x"></i><b>No encontramos materias</b><p>Prueba con otro término o filtro.</p></div>
</section>
