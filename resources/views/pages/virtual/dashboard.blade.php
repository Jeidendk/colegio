<section class="virtual-welcome">
    <span>MONTESSORI · ENTORNO VIRTUAL DE APRENDIZAJE</span>
    <h1>{{ $isTeacher ? '¡Bienvenido al Aula Virtual!' : '¡Hola, '.$student['firstName'].'!' }}</h1>
    <p>{{ $isTeacher ? 'Administra tus cursos, contenidos y actividades desde un solo lugar.' : 'Aquí tienes un resumen de tu actividad académica en línea.' }}</p>
</section>

<div class="virtual-stat-grid">
    @foreach($isTeacher ? [['book-open','3','Cursos activos','blue'],['clipboard-check','6','Por calificar','red'],['users','83','Estudiantes','green'],['message-square','2','Mensajes nuevos','amber']] : [['book-open','3','Cursos activos','blue'],['calendar-clock','3','Tareas pendientes','red'],['circle-check-big','75%','Progreso general','green'],['message-square','4','Avisos nuevos','amber']] as $stat)
        <article class="panel"><span class="tone-{{ $stat[3] }}"><i data-lucide="{{ $stat[0] }}"></i></span><strong>{{ $stat[1] }}</strong><small>{{ $stat[2] }}</small></article>
    @endforeach
</div>

<div class="virtual-home-grid">
    <section class="panel span-2">
        <div class="panel-header"><div><small>ACCESO RÁPIDO</small><h2>{{ $isTeacher ? 'Aulas a tu cargo' : 'Continúa aprendiendo' }}</h2></div><a href="{{ route('portal', ['role'=>$role,'page'=>'aula-virtual','vista'=>'cursos']) }}">Ver todos</a></div>
        <div class="recent-course-list">
            @foreach($virtualCourses as $course)<a href="{{ route('portal', ['role'=>$role,'page'=>'aula-virtual','curso'=>$course['slug']]) }}"><span class="tone-{{ $course['tone'] }}"><i data-lucide="{{ $course['icon'] }}"></i></span><div><small>{{ $course['code'] }}</small><b>{{ $course['name'] }}</b><p>{{ $isTeacher ? $course['students'].' estudiantes · '.$course['pending'].' por revisar' : $course['teacher'] }}</p></div><em>{{ $isTeacher ? 'Gestionar' : $course['progress'].'%' }}</em><i data-lucide="chevron-right"></i></a>@endforeach
        </div>
    </section>
    <aside class="panel">
        <div class="panel-header"><div><small>PRÓXIMOS 7 DÍAS</small><h2>Actividades</h2></div><a href="{{ route('portal', ['role'=>$role,'page'=>'aula-virtual','vista'=>'calendario']) }}">Calendario</a></div>
        <div class="virtual-timeline">
            @foreach([['31','AGO','Reto: números racionales','Matemática'],['02','SEP','Relato de tradición oral','Lengua y Literatura'],['04','SEP','Bitácora de ecosistemas','Ciencias Naturales']] as $event)<article><time><b>{{ $event[0] }}</b><small>{{ $event[1] }}</small></time><div><b>{{ $event[2] }}</b><small>{{ $event[3] }}</small></div></article>@endforeach
        </div>
    </aside>
</div>

<section class="virtual-security panel"><span><i data-lucide="shield-check"></i></span><div><small>RECOMENDACIÓN ACADÉMICA</small><h3>Mantén tus actividades al día</h3><p>Revisa el calendario y los anuncios de cada aula. Los datos de esta demostración son locales y no se envían a ningún servicio externo.</p></div></section>
