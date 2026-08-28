<div class="course-detail-room">
<div class="course-detail-breadcrumb"><a href="{{ route('portal', ['role' => $role, 'page' => 'aula-virtual', 'vista' => 'cursos']) }}">Área personal</a><i data-lucide="chevron-right"></i><a href="{{ route('portal', ['role' => $role, 'page' => 'aula-virtual', 'vista' => 'cursos']) }}">Mis cursos</a><i data-lucide="chevron-right"></i><span>{{ $selectedCourse['code'] }}</span></div>

<header class="course-detail-header">
    <div><small>{{ $selectedCourse['code'] }} · 8.º EGB · PARALELO {{ $selectedCourse['parallel'] }}</small><h1>{{ $selectedCourse['name'] }}</h1><p>{{ $selectedCourse['teacher'] }} · {{ $selectedCourse['room'] }}</p></div>
    <div class="course-detail-completion"><span>{{ $selectedCourse['progress'] }}%</span><div><i style="width:{{ $selectedCourse['progress'] }}%"></i></div><small>Progreso del curso</small></div>
</header>

@if($isTeacher)
    <div class="teacher-course-adminbar panel">
        <div><span><i data-lucide="settings-2"></i></span><div><small>MODO DOCENTE</small><b>Gestión del aula</b></div></div>
        <button class="edit-toggle" type="button" data-course-edit-toggle><i data-lucide="pencil-ruler"></i> <span data-course-edit-label>Activar edición</span></button>
        <nav><button data-virtual-tab-target="people"><i data-lucide="users"></i> Participantes</button><button data-virtual-tab-target="grades"><i data-lucide="notebook-tabs"></i> Calificaciones</button><button data-toast="Informe del curso preparado"><i data-lucide="chart-no-axes-column-increasing"></i> Informes</button><button data-modal-open="virtual-resource-modal"><i data-lucide="plus"></i> Añadir contenido</button></nav>
    </div>
@endif

<div class="course-detail-nav" role="tablist">
    <button class="is-active" type="button" data-virtual-tab="course"><i data-lucide="book-open"></i> Curso</button>
    <button type="button" data-virtual-tab="people"><i data-lucide="users"></i> Participantes</button>
    <button type="button" data-virtual-tab="grades"><i data-lucide="notebook-tabs"></i> Calificaciones</button>
    <button type="button" data-virtual-tab="skills"><i data-lucide="badge-check"></i> Competencias</button>
    @if($isTeacher)<button type="button" data-virtual-tab="attendance"><i data-lucide="calendar-check-2"></i> Asistencia</button>@endif
</div>

<section data-virtual-panel="course" data-course-topics>
    <div class="course-topic-tabs" role="tablist" aria-label="Unidades del curso">
        <button class="is-active" type="button" data-course-topic="welcome">Bienvenida</button>
        @foreach($selectedCourse['modules'] as $index => $module)<button type="button" data-course-topic="unit-{{ $index + 1 }}">Unidad {{ $index + 1 }}@if($isTeacher)<span class="topic-rename" role="button" tabindex="0" title="Renombrar unidad" data-modal-open="course-section-modal"><i data-lucide="pencil"></i></span>@endif</button>@if($isTeacher)<button class="topic-insert" type="button" title="Insertar unidad aquí" data-modal-open="course-section-modal"><i data-lucide="plus"></i></button>@endif
        @endforeach
        <button type="button" data-course-topic="closing">Cierre</button>
        @if($isTeacher)<button class="topic-add" type="button" data-modal-open="course-section-modal" title="Agregar unidad"><i data-lucide="plus"></i> Unidad</button>@endif
    </div>

    <div class="course-detail-layout">
        <main class="course-content-box">
            <section data-course-topic-panel="welcome">
                <div class="course-detail-cover"><img src="{{ $selectedCourse['image'] }}" alt="Imagen de {{ $selectedCourse['name'] }}"><div><span>MONTESSORI · AULA VIRTUAL</span><h2>{{ $selectedCourse['name'] }}</h2><p>Aprende, explora y comparte tus descubrimientos.</p></div></div>

                <div class="course-section-heading"><i data-lucide="info"></i><span>Sección de información</span><span class="section-edit-actions"><button class="row-action" type="button" title="Editar sección" data-modal-open="course-section-modal"><i data-lucide="pencil"></i></button><button class="row-action" type="button" title="Agregar recurso" data-modal-open="course-activity-modal"><i data-lucide="plus"></i></button><button class="row-action danger" type="button" title="Eliminar sección" data-toast="La sección se eliminaría en la demostración"><i data-lucide="trash-2"></i></button></span></div>
                <div class="course-learning-results"><b>Resultados de aprendizaje</b><ul><li>Comprende los conceptos esenciales de la asignatura y los relaciona con situaciones de su entorno.</li><li>Desarrolla autonomía para investigar, organizar información y comunicar sus ideas.</li><li>Participa con respeto y responsabilidad en experiencias colaborativas.</li></ul></div>
                <div class="activity-line"><button class="course-activity-row" type="button" data-toast="Perfil del docente abierto"><span class="type-file"><i data-lucide="contact"></i></span><div><b>Conoce a tu docente</b><small>{{ $selectedCourse['teacher'] }} · Docente responsable</small></div><i data-lucide="chevron-right"></i></button><span class="activity-edit-actions"><button class="row-action" type="button" title="Editar ajustes" data-modal-open="course-activity-modal"><i data-lucide="pencil"></i></button><button class="row-action" type="button" title="Ocultar a los estudiantes" data-toast="La actividad quedaría oculta"><i data-lucide="eye-off"></i></button><button class="row-action" type="button" title="Duplicar" data-toast="Actividad duplicada en la demostración"><i data-lucide="copy"></i></button><button class="row-action" type="button" title="Mover" data-toast="Usa arrastrar y soltar en el sistema real"><i data-lucide="move"></i></button><button class="row-action danger" type="button" title="Eliminar" data-toast="La actividad se eliminaría en la demostración"><i data-lucide="trash-2"></i></button></span></div>
                <div class="activity-line"><button class="course-activity-row" type="button" data-toast="Plan de aprendizaje abierto"><span class="type-file"><i data-lucide="file-text"></i></span><div><b>Plan de aprendizaje de la asignatura</b><small>Objetivos, unidades, metodología y evaluación · PDF</small></div><i data-lucide="chevron-right"></i></button><span class="activity-edit-actions"><button class="row-action" type="button" title="Editar ajustes" data-modal-open="course-activity-modal"><i data-lucide="pencil"></i></button><button class="row-action" type="button" title="Ocultar a los estudiantes" data-toast="La actividad quedaría oculta"><i data-lucide="eye-off"></i></button><button class="row-action" type="button" title="Duplicar" data-toast="Actividad duplicada en la demostración"><i data-lucide="copy"></i></button><button class="row-action" type="button" title="Mover" data-toast="Usa arrastrar y soltar en el sistema real"><i data-lucide="move"></i></button><button class="row-action danger" type="button" title="Eliminar" data-toast="La actividad se eliminaría en la demostración"><i data-lucide="trash-2"></i></button></span></div>

                <div class="course-schedule-strip"><div><i data-lucide="calendar-days"></i><span><b>Encuentros de clase</b><small>Lunes y miércoles · 07:00 a 09:00</small></span></div><div><i data-lucide="messages-square"></i><span><b>Acompañamiento</b><small>Viernes · 12:00 a 13:00</small></span></div></div>
                <div class="activity-line"><button class="course-activity-row" type="button" data-toast="Evaluación diagnóstica abierta"><span class="type-quiz"><i data-lucide="list-checks"></i></span><div><b>Evaluación diagnóstica</b><small>Disponible hasta el 31 de agosto · 10 puntos</small></div><x-badge value="Pendiente" /></button><span class="activity-edit-actions"><button class="row-action" type="button" title="Editar ajustes" data-modal-open="course-activity-modal"><i data-lucide="pencil"></i></button><button class="row-action" type="button" title="Ocultar a los estudiantes" data-toast="La actividad quedaría oculta"><i data-lucide="eye-off"></i></button><button class="row-action" type="button" title="Duplicar" data-toast="Actividad duplicada en la demostración"><i data-lucide="copy"></i></button><button class="row-action" type="button" title="Mover" data-toast="Usa arrastrar y soltar en el sistema real"><i data-lucide="move"></i></button><button class="row-action danger" type="button" title="Eliminar" data-toast="La actividad se eliminaría en la demostración"><i data-lucide="trash-2"></i></button></span></div>

                <div class="course-section-heading"><i data-lucide="megaphone"></i><span>Sección de comunicación</span><span class="section-edit-actions"><button class="row-action" type="button" title="Editar sección" data-modal-open="course-section-modal"><i data-lucide="pencil"></i></button><button class="row-action" type="button" title="Agregar recurso" data-modal-open="course-activity-modal"><i data-lucide="plus"></i></button><button class="row-action danger" type="button" title="Eliminar sección" data-toast="La sección se eliminaría en la demostración"><i data-lucide="trash-2"></i></button></span></div>
                <div class="activity-line"><button class="course-activity-row" type="button" data-toast="Foro de avisos abierto"><span class="type-forum"><i data-lucide="messages-square"></i></span><div><b>Avisos y novedades</b><small>Información importante publicada por el docente</small></div><em>3 nuevos</em></button><span class="activity-edit-actions"><button class="row-action" type="button" title="Editar ajustes" data-modal-open="course-activity-modal"><i data-lucide="pencil"></i></button><button class="row-action" type="button" title="Ocultar a los estudiantes" data-toast="La actividad quedaría oculta"><i data-lucide="eye-off"></i></button><button class="row-action" type="button" title="Duplicar" data-toast="Actividad duplicada en la demostración"><i data-lucide="copy"></i></button><button class="row-action" type="button" title="Mover" data-toast="Usa arrastrar y soltar en el sistema real"><i data-lucide="move"></i></button><button class="row-action danger" type="button" title="Eliminar" data-toast="La actividad se eliminaría en la demostración"><i data-lucide="trash-2"></i></button></span></div>
                <div class="activity-line"><button class="course-activity-row" type="button" data-toast="Guía de convivencia abierta"><span class="type-file"><i data-lucide="file-heart"></i></span><div><b>Acuerdos de convivencia y participación</b><small>Orientaciones para nuestra comunidad de aprendizaje</small></div><i data-lucide="chevron-right"></i></button><span class="activity-edit-actions"><button class="row-action" type="button" title="Editar ajustes" data-modal-open="course-activity-modal"><i data-lucide="pencil"></i></button><button class="row-action" type="button" title="Ocultar a los estudiantes" data-toast="La actividad quedaría oculta"><i data-lucide="eye-off"></i></button><button class="row-action" type="button" title="Duplicar" data-toast="Actividad duplicada en la demostración"><i data-lucide="copy"></i></button><button class="row-action" type="button" title="Mover" data-toast="Usa arrastrar y soltar en el sistema real"><i data-lucide="move"></i></button><button class="row-action danger" type="button" title="Eliminar" data-toast="La actividad se eliminaría en la demostración"><i data-lucide="trash-2"></i></button></span></div>

                <div class="course-section-heading"><i data-lucide="users"></i><span>Sección de interacción</span><span class="section-edit-actions"><button class="row-action" type="button" title="Editar sección" data-modal-open="course-section-modal"><i data-lucide="pencil"></i></button><button class="row-action" type="button" title="Agregar recurso" data-modal-open="course-activity-modal"><i data-lucide="plus"></i></button><button class="row-action danger" type="button" title="Eliminar sección" data-toast="La sección se eliminaría en la demostración"><i data-lucide="trash-2"></i></button></span></div>
                <div class="activity-line"><button class="course-activity-row" type="button" data-toast="Foro de preguntas abierto"><span class="type-forum"><i data-lucide="message-circle-question"></i></span><div><b>Preguntas, ideas y descubrimientos</b><small>Espacio para conversar y construir respuestas juntos</small></div><i data-lucide="chevron-right"></i></button><span class="activity-edit-actions"><button class="row-action" type="button" title="Editar ajustes" data-modal-open="course-activity-modal"><i data-lucide="pencil"></i></button><button class="row-action" type="button" title="Ocultar a los estudiantes" data-toast="La actividad quedaría oculta"><i data-lucide="eye-off"></i></button><button class="row-action" type="button" title="Duplicar" data-toast="Actividad duplicada en la demostración"><i data-lucide="copy"></i></button><button class="row-action" type="button" title="Mover" data-toast="Usa arrastrar y soltar en el sistema real"><i data-lucide="move"></i></button><button class="row-action danger" type="button" title="Eliminar" data-toast="La actividad se eliminaría en la demostración"><i data-lucide="trash-2"></i></button></span></div>
                <div class="activity-line"><button class="course-activity-row" type="button" data-toast="Registro de asistencia consultado"><span class="type-attendance"><i data-lucide="user-check"></i></span><div><b>Registro de asistencia</b><small>Consulta tu participación en las clases programadas</small></div><x-badge value="Al día" /></button><span class="activity-edit-actions"><button class="row-action" type="button" title="Editar ajustes" data-modal-open="course-activity-modal"><i data-lucide="pencil"></i></button><button class="row-action" type="button" title="Ocultar a los estudiantes" data-toast="La actividad quedaría oculta"><i data-lucide="eye-off"></i></button><button class="row-action" type="button" title="Duplicar" data-toast="Actividad duplicada en la demostración"><i data-lucide="copy"></i></button><button class="row-action" type="button" title="Mover" data-toast="Usa arrastrar y soltar en el sistema real"><i data-lucide="move"></i></button><button class="row-action danger" type="button" title="Eliminar" data-toast="La actividad se eliminaría en la demostración"><i data-lucide="trash-2"></i></button></span></div>
                @if($isTeacher)<button class="activity-add" type="button" data-modal-open="course-activity-modal"><i data-lucide="plus"></i> Añadir una actividad o recurso</button><button class="activity-add subsection-add" type="button" data-modal-open="course-section-modal"><i data-lucide="list-tree"></i> Añadir subsección</button>@endif
            </section>

            @foreach($selectedCourse['modules'] as $index => $module)
                <section class="hidden" data-course-topic-panel="unit-{{ $index + 1 }}">
                    <div class="course-unit-heading"><span>UNIDAD {{ $index + 1 }}</span><h2>{{ $module['title'] }}</h2><p>{{ $module['meta'] }}</p></div>
                    <div class="course-section-heading"><i data-lucide="book-open-check"></i><span>Explorar y comprender</span><span class="section-edit-actions"><button class="row-action" type="button" title="Editar sección" data-modal-open="course-section-modal"><i data-lucide="pencil"></i></button><button class="row-action" type="button" title="Agregar recurso" data-modal-open="course-activity-modal"><i data-lucide="plus"></i></button><button class="row-action danger" type="button" title="Eliminar sección" data-toast="La sección se eliminaría en la demostración"><i data-lucide="trash-2"></i></button></span></div>
                    <div class="activity-line"><button class="course-activity-row" type="button" data-toast="Guía de aprendizaje abierta"><span class="type-file"><i data-lucide="file-text"></i></span><div><b>Guía de aprendizaje de la unidad</b><small>Conceptos, ejemplos y preguntas para explorar</small></div><x-badge :value="$module['done'] ? 'Completado' : 'Pendiente'" /></button><span class="activity-edit-actions"><button class="row-action" type="button" title="Editar ajustes" data-modal-open="course-activity-modal"><i data-lucide="pencil"></i></button><button class="row-action" type="button" title="Ocultar a los estudiantes" data-toast="La actividad quedaría oculta"><i data-lucide="eye-off"></i></button><button class="row-action" type="button" title="Duplicar" data-toast="Actividad duplicada en la demostración"><i data-lucide="copy"></i></button><button class="row-action" type="button" title="Mover" data-toast="Usa arrastrar y soltar en el sistema real"><i data-lucide="move"></i></button><button class="row-action danger" type="button" title="Eliminar" data-toast="La actividad se eliminaría en la demostración"><i data-lucide="trash-2"></i></button></span></div>
                    <div class="activity-line"><button class="course-activity-row" type="button" data-toast="Recurso multimedia abierto"><span class="type-url"><i data-lucide="circle-play"></i></span><div><b>Recurso multimedia interactivo</b><small>Video y material visual · 18 minutos</small></div><i data-lucide="external-link"></i></button><span class="activity-edit-actions"><button class="row-action" type="button" title="Editar ajustes" data-modal-open="course-activity-modal"><i data-lucide="pencil"></i></button><button class="row-action" type="button" title="Ocultar a los estudiantes" data-toast="La actividad quedaría oculta"><i data-lucide="eye-off"></i></button><button class="row-action" type="button" title="Duplicar" data-toast="Actividad duplicada en la demostración"><i data-lucide="copy"></i></button><button class="row-action" type="button" title="Mover" data-toast="Usa arrastrar y soltar en el sistema real"><i data-lucide="move"></i></button><button class="row-action danger" type="button" title="Eliminar" data-toast="La actividad se eliminaría en la demostración"><i data-lucide="trash-2"></i></button></span></div>
                    <div class="course-section-heading"><i data-lucide="pencil-ruler"></i><span>Aplicar y crear</span><span class="section-edit-actions"><button class="row-action" type="button" title="Editar sección" data-modal-open="course-section-modal"><i data-lucide="pencil"></i></button><button class="row-action" type="button" title="Agregar recurso" data-modal-open="course-activity-modal"><i data-lucide="plus"></i></button><button class="row-action danger" type="button" title="Eliminar sección" data-toast="La sección se eliminaría en la demostración"><i data-lucide="trash-2"></i></button></span></div>
                    <div class="activity-line"><button class="course-activity-row" type="button" data-toast="Actividad práctica abierta"><span class="type-quiz"><i data-lucide="clipboard-check"></i></span><div><b>{{ $module['type'] === 'task' ? $module['title'] : 'Actividad práctica de la unidad' }}</b><small>Entrega guiada con retroalimentación del docente</small></div><x-badge value="Pendiente" /></button><span class="activity-edit-actions"><button class="row-action" type="button" title="Editar ajustes" data-modal-open="course-activity-modal"><i data-lucide="pencil"></i></button><button class="row-action" type="button" title="Ocultar a los estudiantes" data-toast="La actividad quedaría oculta"><i data-lucide="eye-off"></i></button><button class="row-action" type="button" title="Duplicar" data-toast="Actividad duplicada en la demostración"><i data-lucide="copy"></i></button><button class="row-action" type="button" title="Mover" data-toast="Usa arrastrar y soltar en el sistema real"><i data-lucide="move"></i></button><button class="row-action danger" type="button" title="Eliminar" data-toast="La actividad se eliminaría en la demostración"><i data-lucide="trash-2"></i></button></span></div>
                    <div class="activity-line"><button class="course-activity-row" type="button" data-toast="Foro colaborativo abierto"><span class="type-forum"><i data-lucide="users-round"></i></span><div><b>Construimos juntos</b><small>Comparte tu proceso, comenta y aprende de tus compañeros</small></div><i data-lucide="chevron-right"></i></button><span class="activity-edit-actions"><button class="row-action" type="button" title="Editar ajustes" data-modal-open="course-activity-modal"><i data-lucide="pencil"></i></button><button class="row-action" type="button" title="Ocultar a los estudiantes" data-toast="La actividad quedaría oculta"><i data-lucide="eye-off"></i></button><button class="row-action" type="button" title="Duplicar" data-toast="Actividad duplicada en la demostración"><i data-lucide="copy"></i></button><button class="row-action" type="button" title="Mover" data-toast="Usa arrastrar y soltar en el sistema real"><i data-lucide="move"></i></button><button class="row-action danger" type="button" title="Eliminar" data-toast="La actividad se eliminaría en la demostración"><i data-lucide="trash-2"></i></button></span></div>
                    @if($isTeacher)<button class="activity-add" type="button" data-modal-open="course-activity-modal"><i data-lucide="plus"></i> Añadir una actividad o recurso</button><button class="activity-add subsection-add" type="button" data-modal-open="course-section-modal"><i data-lucide="list-tree"></i> Añadir subsección</button>@endif
                </section>
            @endforeach

            <section class="hidden" data-course-topic-panel="closing">
                <div class="course-unit-heading"><span>CIERRE DEL CURSO</span><h2>Reflexiona sobre lo aprendido</h2><p>Organiza tus evidencias y reconoce tus avances.</p></div>
                <div class="course-section-heading"><i data-lucide="sparkles"></i><span>Portafolio y despedida</span><span class="section-edit-actions"><button class="row-action" type="button" title="Editar sección" data-modal-open="course-section-modal"><i data-lucide="pencil"></i></button><button class="row-action" type="button" title="Agregar recurso" data-modal-open="course-activity-modal"><i data-lucide="plus"></i></button><button class="row-action danger" type="button" title="Eliminar sección" data-toast="La sección se eliminaría en la demostración"><i data-lucide="trash-2"></i></button></span></div>
                <div class="activity-line"><button class="course-activity-row" type="button" data-toast="Portafolio abierto"><span class="type-file"><i data-lucide="folder-check"></i></span><div><b>Mi portafolio de aprendizaje</b><small>Selección de trabajos, reflexiones y logros</small></div><i data-lucide="chevron-right"></i></button><span class="activity-edit-actions"><button class="row-action" type="button" title="Editar ajustes" data-modal-open="course-activity-modal"><i data-lucide="pencil"></i></button><button class="row-action" type="button" title="Ocultar a los estudiantes" data-toast="La actividad quedaría oculta"><i data-lucide="eye-off"></i></button><button class="row-action" type="button" title="Duplicar" data-toast="Actividad duplicada en la demostración"><i data-lucide="copy"></i></button><button class="row-action" type="button" title="Mover" data-toast="Usa arrastrar y soltar en el sistema real"><i data-lucide="move"></i></button><button class="row-action danger" type="button" title="Eliminar" data-toast="La actividad se eliminaría en la demostración"><i data-lucide="trash-2"></i></button></span></div>
                <div class="activity-line"><button class="course-activity-row" type="button" data-toast="Autoevaluación abierta"><span class="type-quiz"><i data-lucide="badge-check"></i></span><div><b>Autoevaluación final</b><small>Reconoce tus fortalezas y próximos retos</small></div><x-badge value="Pendiente" /></button><span class="activity-edit-actions"><button class="row-action" type="button" title="Editar ajustes" data-modal-open="course-activity-modal"><i data-lucide="pencil"></i></button><button class="row-action" type="button" title="Ocultar a los estudiantes" data-toast="La actividad quedaría oculta"><i data-lucide="eye-off"></i></button><button class="row-action" type="button" title="Duplicar" data-toast="Actividad duplicada en la demostración"><i data-lucide="copy"></i></button><button class="row-action" type="button" title="Mover" data-toast="Usa arrastrar y soltar en el sistema real"><i data-lucide="move"></i></button><button class="row-action danger" type="button" title="Eliminar" data-toast="La actividad se eliminaría en la demostración"><i data-lucide="trash-2"></i></button></span></div>
                @if($isTeacher)<button class="activity-add" type="button" data-modal-open="course-activity-modal"><i data-lucide="plus"></i> Añadir una actividad o recurso</button><button class="activity-add subsection-add" type="button" data-modal-open="course-section-modal"><i data-lucide="list-tree"></i> Añadir subsección</button>@endif
            </section>
        </main>

        <aside class="course-blocks">
            <article><header>Buscar en los foros</header><div><label class="search-field"><i data-lucide="search"></i><input placeholder="Buscar conversaciones"></label><button class="text-button" data-toast="Búsqueda avanzada abierta">Búsqueda avanzada</button></div></article>
            <article><header>Docente del curso</header><div class="course-teacher-block"><span>{{ $selectedCourse['initials'] }}</span><b>{{ $selectedCourse['teacher'] }}</b><small>{{ $selectedCourse['room'] }}</small><button data-toast="Mensaje preparado"><i data-lucide="mail"></i> Enviar mensaje</button></div></article>
            <article><header>Próximos eventos</header><div class="course-event-block"><time>{{ $selectedCourse['date'] }}</time><b>{{ $selectedCourse['next'] }}</b><small>Actividad del curso</small><a href="{{ route('portal', ['role' => $role, 'page' => 'aula-virtual', 'vista' => 'calendario']) }}">Ir al calendario</a></div></article>
            <article><header>Progreso del curso</header><div class="course-block-progress"><strong>{{ $selectedCourse['progress'] }}%</strong><span><i style="width:{{ $selectedCourse['progress'] }}%"></i></span><small>{{ collect($selectedCourse['modules'])->where('done', true)->count() }} de {{ count($selectedCourse['modules']) }} módulos revisados</small></div></article>
        </aside>
    </div>
</section>

<section class="hidden" data-virtual-panel="grades">
    <div class="virtual-section-title"><div><small>EVALUACIÓN</small><h2>Calificaciones del curso</h2></div><div class="grade-summary"><b>{{ $selectedCourse['grades'][2][1] }}</b><small>Promedio actual</small></div></div>
    <div class="panel table-wrap"><table class="data-table virtual-grades"><thead><tr><th>Actividad</th><th>Calificación</th><th>Rango</th><th>Retroalimentación</th></tr></thead><tbody>@foreach($selectedCourse['grades'] as $grade)<tr><td><b>{{ $grade[0] }}</b></td><td><span class="virtual-grade">{{ $grade[1] }}</span></td><td>0 – 10</td><td><button class="text-button" data-toast="Retroalimentación abierta">Ver comentario</button></td></tr>@endforeach</tbody></table></div>
</section>

<section class="hidden" data-virtual-panel="skills"><div class="virtual-section-title"><div><small>APRENDIZAJES</small><h2>Competencias del curso</h2></div></div><div class="competency-grid">@foreach([['Pensamiento crítico','Analiza información y comunica conclusiones.',88],['Autonomía','Organiza su proceso y toma decisiones responsables.',82],['Trabajo colaborativo','Participa con respeto y aporta al grupo.',92]] as $skill)<article class="panel"><span><i data-lucide="badge-check"></i></span><h3>{{ $skill[0] }}</h3><p>{{ $skill[1] }}</p><div><i style="width:{{ $skill[2] }}%"></i></div><b>{{ $skill[2] }}% alcanzado</b></article>@endforeach</div></section>

<section class="hidden" data-virtual-panel="people"><div class="virtual-section-title"><div><small>COMUNIDAD DEL CURSO</small><h2>{{ $isTeacher ? 'Participantes matriculados' : 'Docente y compañeros' }}</h2></div></div><div class="people-grid"><article class="panel virtual-person"><span>{{ $selectedCourse['initials'] }}</span><div><small>DOCENTE PRINCIPAL</small><h3>{{ $selectedCourse['teacher'] }}</h3><p>docente@montessori-riobamba.edu.ec</p></div><button data-toast="Mensaje preparado"><i data-lucide="mail"></i></button></article>@foreach([['JP','Juan Carlos Pérez','M-08021'],['MR','María Fernanda Ruiz','M-08034'],['JS','Jorge Silva Andrade','M-08047']] as $person)<article class="panel virtual-person"><span>{{ $person[0] }}</span><div><small>ESTUDIANTE</small><h3>{{ $person[1] }}</h3><p>{{ $person[2] }} · 8.º EGB A</p></div><button data-toast="Perfil académico abierto"><i data-lucide="eye"></i></button></article>@endforeach</div></section>

@if($isTeacher)
    <div class="modal" id="course-section-modal" aria-hidden="true">
        <form class="modal-card demo-form" data-demo-form>
            <button class="modal-close" type="button" data-modal-close aria-label="Cerrar">&times;</button>
            <small>ESTRUCTURA DEL AULA</small>
            <h2>Nueva unidad o sección</h2>
            <label class="export-field">Nombre<input required placeholder="Ej. Unidad 5 · Energía y movimiento"></label>
            <div class="form-grid">
                <label class="export-field">Tipo<select><option>Unidad</option><option>Subsección</option><option>Sección de información</option><option>Sección de comunicación</option><option>Cierre</option></select></label>
                <label class="export-field">Dentro de<select><option>Nivel principal del curso</option><option>Unidad 1</option><option>Unidad 2</option><option>Unidad 3</option><option>Unidad 4</option></select></label>
            </div>
            <div class="form-grid">
                <label class="export-field">Disponible desde<input type="date" value="2026-09-01"></label>
                <label class="export-field">Disponible hasta<input type="date" value="2026-12-19"></label>
            </div>
            <label class="export-field">Descripción<textarea placeholder="Qué encontrará el estudiante en esta unidad..."></textarea></label>
            <label class="check-inline"><input type="checkbox" checked> Visible para los estudiantes</label>
            <div class="modal-actions">
                <button class="secondary-button" type="button" data-modal-close>Cancelar</button>
                <button class="primary-button dark" type="submit">Guardar unidad</button>
            </div>
        </form>
    </div>

    <div class="modal" id="course-activity-modal" aria-hidden="true">
        <form class="modal-card demo-form settings-modal" data-demo-form>
            <button class="modal-close" type="button" data-modal-close aria-label="Cerrar">&times;</button>
            <small>CONTENIDO DEL AULA</small>
            <h2 data-activity-title>Nueva actividad o recurso</h2>

            <span class="field-label">Tipo de contenido</span>
            <div class="chooser-tabs segmented compact" data-chooser-tabs>
                <button class="is-active" type="button" data-chooser-tab="all">Todas</button>
                <button type="button" data-chooser-tab="activity">Actividades</button>
                <button type="button" data-chooser-tab="resource">Recursos</button>
            </div>
            <label class="search-field"><i data-lucide="search"></i><input type="search" placeholder="Buscar tipo de contenido..." data-chooser-search></label>

            <div class="icon-picker activity-picker" data-icon-picker>
                <button class="is-active" type="button" data-chooser-item data-chooser-kind="activity" data-chooser-name="tarea" data-chooser-label="Tarea"><i data-lucide="clipboard-pen"></i><small>Tarea</small></button>
                <button type="button" data-chooser-item data-chooser-kind="activity" data-chooser-name="foro" data-chooser-label="Foro"><i data-lucide="message-square"></i><small>Foro</small></button>
                <button type="button" data-chooser-item data-chooser-kind="activity" data-chooser-name="cuestionario" data-chooser-label="Cuestionario"><i data-lucide="list-checks"></i><small>Cuestionario</small></button>
                <button type="button" data-chooser-item data-chooser-kind="activity" data-chooser-name="asistencia" data-chooser-label="Asistencia"><i data-lucide="calendar-check-2"></i><small>Asistencia</small></button>
                <button type="button" data-chooser-item data-chooser-kind="activity" data-chooser-name="glosario" data-chooser-label="Glosario"><i data-lucide="book-a"></i><small>Glosario</small></button>
                <button type="button" data-chooser-item data-chooser-kind="activity" data-chooser-name="encuesta consulta" data-chooser-label="Encuesta"><i data-lucide="clipboard-list"></i><small>Encuesta</small></button>
                <button type="button" data-chooser-item data-chooser-kind="resource" data-chooser-name="archivo" data-chooser-label="Archivo"><i data-lucide="file-text"></i><small>Archivo</small></button>
                <button type="button" data-chooser-item data-chooser-kind="resource" data-chooser-name="carpeta" data-chooser-label="Carpeta"><i data-lucide="folder"></i><small>Carpeta</small></button>
                <button type="button" data-chooser-item data-chooser-kind="resource" data-chooser-name="url enlace" data-chooser-label="URL"><i data-lucide="link"></i><small>URL</small></button>
                <button type="button" data-chooser-item data-chooser-kind="resource" data-chooser-name="pagina" data-chooser-label="Página"><i data-lucide="file-code-2"></i><small>Página</small></button>
                <button type="button" data-chooser-item data-chooser-kind="resource" data-chooser-name="etiqueta area de texto" data-chooser-label="Etiqueta"><i data-lucide="tag"></i><small>Etiqueta</small></button>
                <button type="button" data-chooser-item data-chooser-kind="resource" data-chooser-name="video" data-chooser-label="Video"><i data-lucide="circle-play"></i><small>Video</small></button>
            </div>
            <p class="empty-state hidden" data-chooser-empty><i data-lucide="search-x"></i> Ningún tipo coincide con la búsqueda.</p>

            <details class="settings-group" open>
                <summary><i data-lucide="chevron-down"></i> General</summary>

                <label class="export-field">Nombre <em>*</em><input required placeholder="Ej. Cuestionario de la unidad 1"></label>

                <span class="field-label">Descripción</span>
                <div class="editor-box">
                    <div class="editor-toolbar" role="toolbar" aria-label="Formato del texto">
                        <button type="button" title="Deshacer" data-toast="Deshacer"><i data-lucide="undo-2"></i></button>
                        <button type="button" title="Rehacer" data-toast="Rehacer"><i data-lucide="redo-2"></i></button>
                        <span class="editor-divider"></span>
                        <button type="button" title="Negrita" data-toast="Negrita"><b>B</b></button>
                        <button type="button" title="Cursiva" data-toast="Cursiva"><i>I</i></button>
                        <button type="button" title="Lista" data-toast="Lista"><i data-lucide="list"></i></button>
                        <span class="editor-divider"></span>
                        <button type="button" title="Imagen" data-toast="Insertar imagen"><i data-lucide="image"></i></button>
                        <button type="button" title="Video" data-toast="Insertar video"><i data-lucide="video"></i></button>
                        <button type="button" title="Audio" data-toast="Grabar audio"><i data-lucide="mic"></i></button>
                        <button type="button" title="Enlace" data-toast="Insertar enlace"><i data-lucide="link"></i></button>
                        <span class="editor-divider"></span>
                        <button type="button" title="Tabla" data-toast="Insertar tabla"><i data-lucide="table"></i></button>
                        <button type="button" title="Pantalla completa" data-toast="Pantalla completa"><i data-lucide="maximize-2"></i></button>
                    </div>
                    <textarea placeholder="Describe la actividad, las instrucciones y los criterios de evaluación..."></textarea>
                </div>

                <label class="check-inline"><input type="checkbox"> Mostrar la descripción en la página del curso</label>
            </details>

            <details class="settings-group">
                <summary><i data-lucide="chevron-down"></i> Disponibilidad</summary>
                <div class="form-grid">
                    <label class="export-field">Unidad<select><option>Bienvenida</option><option>Unidad 1</option><option>Unidad 2</option><option>Unidad 3</option><option>Unidad 4</option><option>Cierre</option></select></label>
                    <label class="export-field">Visibilidad<select><option>Mostrar en la página del curso</option><option>Ocultar a los estudiantes</option></select></label>
                </div>
                <div class="form-grid">
                    <label class="export-field">Disponible desde<input type="date" value="2026-09-02"></label>
                    <label class="export-field">Fecha de entrega<input type="date" value="2026-09-12"></label>
                </div>
            </details>

            <details class="settings-group">
                <summary><i data-lucide="chevron-down"></i> Calificación</summary>
                <div class="form-grid">
                    <label class="export-field">Puntaje máximo<input type="number" min="0" max="10" value="10"></label>
                    <label class="export-field">Intentos permitidos<select><option>1</option><option>2</option><option>Ilimitados</option></select></label>
                </div>
                <label class="export-field">Categoría de calificación<select><option>Sin categorizar</option><option>Parcial 1</option><option>Parcial 2</option><option>Examen final</option></select></label>
            </details>

            <details class="settings-group">
                <summary><i data-lucide="chevron-down"></i> Archivos adjuntos</summary>
                <label class="file-drop">
                    <i data-lucide="file-up"></i>
                    <span><b>Arrastra o selecciona un archivo</b><small>PDF, DOCX, imagen o video &middot; máx. 50 MB</small></span>
                    <input type="file">
                </label>
                <label class="check-inline"><input type="checkbox" checked> Notificar a la clase al publicar</label>
            </details>

            <div class="modal-actions settings-actions">
                <button class="secondary-button" type="button" data-modal-close>Cancelar</button>
                <button class="pill-button" type="submit">Guardar y volver al curso</button>
                <button class="primary-button dark" type="submit">Guardar y mostrar</button>
            </div>
        </form>
    </div>
@endif

@if($isTeacher)
<section class="hidden" data-virtual-panel="attendance">
    <div class="virtual-section-title">
        <div><small>CONTROL DE CLASE</small><h2>Asistencia del curso</h2></div>
        <div class="row-actions">
            <button class="pill-button" type="button" data-attendance-all><i data-lucide="check-check"></i> Todos presentes</button>
            <button class="pill-button" type="button" data-toast="Registro de asistencia exportado"><i data-lucide="download"></i> Exportar</button>
            <button class="pill-button solid" type="button" data-toast="Asistencia guardada en la demostración"><i data-lucide="save"></i> Guardar asistencia</button>
        </div>
    </div>

    <section class="panel users-panel" data-attendance>
        <span class="panel-accent" aria-hidden="true"></span>

        <div class="toolbar users-toolbar">
            <label class="export-field inline-field">Fecha de clase<input type="date" value="2026-09-02"></label>
            <label class="export-field inline-field">Sesión<select><option>Unidad 1 · Sesión 1</option><option>Unidad 1 · Sesión 2</option><option>Unidad 2 · Sesión 1</option></select></label>
            <label class="search-field"><i data-lucide="search"></i><input type="search" placeholder="Buscar estudiante..." data-attendance-search></label>

            <div class="attendance-summary">
                <span class="attendance-chip presente"><b data-attendance-count="Presente">0</b> presentes</span>
                <span class="attendance-chip atraso"><b data-attendance-count="Atraso">0</b> atrasos</span>
                <span class="attendance-chip ausente"><b data-attendance-count="Ausente">0</b> ausentes</span>
                <span class="attendance-chip justificado"><b data-attendance-count="Justificado">0</b> justificados</span>
            </div>
        </div>

        <div class="table-wrap">
            <table class="data-table users-table">
                <thead>
                    <tr>
                        <th>Estudiante</th>
                        <th>Estado de la clase</th>
                        <th>Observación</th>
                        <th>Asistencia acumulada</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($roster as $entry)
                        <tr data-attendance-row data-attendance-search="{{ mb_strtolower($entry['name'].' '.$entry['code']) }}">
                            <td>
                                <div class="user-cell">
                                    <span class="avatar small">{{ mb_substr($entry['name'], 0, 1) }}{{ mb_substr(strrchr($entry['name'], ' ') ?: '', 1, 1) }}</span>
                                    <div><b>{{ $entry['name'] }}</b><small>{{ $entry['code'] }}</small></div>
                                </div>
                            </td>
                            <td>
                                <div class="attendance-options" role="group" aria-label="Estado de {{ $entry['name'] }}">
                                    <button class="is-active" type="button" data-attendance-state="Presente">Presente</button>
                                    <button type="button" data-attendance-state="Atraso">Atraso</button>
                                    <button type="button" data-attendance-state="Ausente">Ausente</button>
                                    <button type="button" data-attendance-state="Justificado">Justificado</button>
                                </div>
                            </td>
                            <td><input class="plain-input attendance-note" placeholder="Observación (opcional)"></td>
                            <td>
                                <div class="table-progress"><span><i style="width:{{ 88 + $loop->index }}%"></i></span><b>{{ 88 + $loop->index }}%</b></div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <x-table-footer :count="count($roster)" />
    </section>
</section>
@endif
</div>
