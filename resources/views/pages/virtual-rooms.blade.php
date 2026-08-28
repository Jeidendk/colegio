@php
    $rooms = $virtualRooms;
    $assignedRooms = array_filter($rooms, fn ($room) => $room['teacher'] !== '');
    $unassignedRooms = count($rooms) - count($assignedRooms);
    $enrolledStudents = array_sum(array_column($rooms, 'students'));
    $teachers = array_values(array_unique(array_filter(array_column($rooms, 'teacher'))));
    $initials = fn (string $name): string => mb_substr($name, 0, 1).mb_substr(strrchr($name, ' ') ?: '', 1, 1);
@endphp

<x-hero icon="monitor-play" title="Aulas virtuales" subtitle="Crea las aulas del periodo y asigna el docente responsable de cada una."
    :stats="[
        ['Aulas', count($rooms), 'del periodo'],
        ['Con docente', count($assignedRooms), 'asignadas'],
        ['Sin asignar', $unassignedRooms, 'pendientes'],
        ['Estudiantes', $enrolledStudents, 'matriculados'],
    ]">
    <button class="hero-button" type="button" data-modal-open="room-modal"><i data-lucide="plus"></i> Nueva aula</button>
</x-hero>

<section class="panel users-panel" data-users-panel>
    <span class="panel-accent" aria-hidden="true"></span>

    <div class="toolbar users-toolbar">
        <label class="search-field"><i data-lucide="search"></i><input type="search" placeholder="Buscar aula, materia o docente..." data-users-search></label>

        <div class="chip-filters" data-users-roles>
            <button class="filter-chip role-chip" type="button" data-user-role="Publicada">Publicadas</button>
            <button class="filter-chip role-chip" type="button" data-user-role="Borrador">Borradores</button>
        </div>

        <select class="select-control" data-users-status>
            <option value="">Curso: Todos</option>
            <option>8.º EGB</option>
            <option>9.º EGB</option>
        </select>

        <button class="text-button" type="button" data-users-clear><i data-lucide="rotate-ccw"></i> Limpiar filtros</button>

        <div class="toolbar-right">
            <button class="pill-button" type="button" data-toast="Listado de aulas exportado"><i data-lucide="download"></i> Exportar</button>
            <button class="pill-button solid" type="button" data-modal-open="assign-teacher-modal"><i data-lucide="user-plus"></i> Asignar docente</button>
        </div>
    </div>

    <div class="table-wrap">
        <table class="data-table users-table">
            <thead>
                <tr>
                    <th class="check-column"><input type="checkbox" aria-label="Seleccionar todo" data-users-select-all></th>
                    <th><button class="sort-header" type="button" data-sort-users="name">Aula <i data-lucide="chevrons-up-down"></i></button></th>
                    <th><button class="sort-header" type="button" data-sort-users="role">Docente responsable <i data-lucide="chevrons-up-down"></i></button></th>
                    <th><button class="sort-header" type="button" data-sort-users="status">Estado <i data-lucide="chevrons-up-down"></i></button></th>
                    <th><button class="sort-header" type="button" data-sort-users="last">Estudiantes <i data-lucide="chevrons-up-down"></i></button></th>
                    <th class="actions-col">Acciones</th>
                </tr>
            </thead>
            <tbody data-users-body>
                @foreach($rooms as $room)
                    <tr data-user-row
                        data-user-search="{{ mb_strtolower($room['code'].' '.$room['subject'].' '.$room['teacher']) }}"
                        data-user-role="{{ $room['status'] }}"
                        data-user-status="{{ $room['grade'] }}"
                        data-sort-name="{{ mb_strtolower($room['subject']) }}"
                        data-sort-role="{{ mb_strtolower($room['teacher'] ?: 'zz sin asignar') }}"
                        data-sort-status="{{ $room['status'] }}"
                        data-sort-last="{{ $room['students'] }}">
                        <td class="check-column"><input type="checkbox" aria-label="Seleccionar {{ $room['code'] }}"></td>
                        <td>
                            <div class="user-cell">
                                <span class="course-mark tone-{{ $room['tone'] }}"><i data-lucide="monitor-play"></i></span>
                                <div><b>{{ $room['subject'] }} · {{ $room['grade'] }}</b><small>{{ $room['code'] }} · Paralelo {{ $room['parallel'] }} · {{ $room['period'] }}</small></div>
                            </div>
                        </td>
                        <td>
                            @if($room['teacher'])
                                <div class="user-cell">
                                    <span class="avatar small">{{ $initials($room['teacher']) }}</span>
                                    <div><b>{{ $room['teacher'] }}</b><small>Docente titular</small></div>
                                </div>
                            @else
                                <button class="assign-pending" type="button" data-modal-open="assign-teacher-modal">
                                    <i data-lucide="user-plus"></i> Sin asignar
                                </button>
                            @endif
                        </td>
                        <td><x-badge :value="$room['status']" /></td>
                        <td><b class="cell-strong">{{ $room['students'] }}</b></td>
                        <td>
                            <div class="row-actions">
                                <button class="row-action" type="button" title="Abrir aula" data-toast="{{ $room['subject'] }} abierta en modo demostración"><i data-lucide="external-link"></i></button>
                                <button class="row-action edit" type="button" title="Editar aula" data-modal-open="room-modal"><i data-lucide="pencil"></i></button>
                                <button class="row-action" type="button" title="Asignar docente" data-modal-open="assign-teacher-modal"><i data-lucide="user-plus"></i></button>
                                <button class="row-action danger" type="button" title="Eliminar" data-toast="{{ $room['code'] }} eliminada en la demostración"><i data-lucide="trash-2"></i></button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <p class="empty-state hidden" data-users-empty><i data-lucide="search-x"></i> Ningún aula coincide con los filtros.</p>
    </div>

    <x-table-footer :count="count($rooms)" data-users-range />
</section>

<div class="modal" id="room-modal" aria-hidden="true">
    <form class="modal-card demo-form wide-modal" data-demo-form>
        <button class="modal-close" type="button" data-modal-close aria-label="Cerrar">×</button>
        <small>AULAS VIRTUALES</small>
        <h2>Nueva aula virtual</h2>

        <div class="form-grid">
            <label class="export-field">Materia<select><option>Matemática</option><option>Lengua y Literatura</option><option>Ciencias Naturales</option><option>Estudios Sociales</option><option>English</option><option>Computación y Robótica</option></select></label>
            <label class="export-field">Código<input required placeholder="Ej. MAT-8B"></label>
        </div>

        <div class="form-grid">
            <label class="export-field">Curso<select><option>8.º EGB</option><option>9.º EGB</option><option>10.º EGB</option></select></label>
            <label class="export-field">Paralelo<select><option>A</option><option>B</option><option>C</option></select></label>
        </div>

        <div class="form-grid">
            <label class="export-field">Periodo lectivo<select><option>2026-2027</option><option>2025-2026</option></select></label>
            <label class="export-field">Cupo de estudiantes<input type="number" min="1" max="45" value="32"></label>
        </div>

        <div class="form-grid">
            <label class="export-field">Docente responsable<select><option>Sin asignar</option>@foreach($teachers as $teacher)<option>{{ $teacher }}</option>@endforeach</select></label>
            <label class="export-field">Visibilidad<select><option>Publicada</option><option>Borrador</option></select></label>
        </div>

        <label class="export-field">Descripción<textarea placeholder="Breve presentación del aula para los estudiantes..."></textarea></label>

        <label class="file-drop">
            <i data-lucide="image-plus"></i>
            <span><b>Imagen de portada</b><small>JPG o PNG · opcional</small></span>
            <input type="file" accept="image/png,image/jpeg">
        </label>

        <label class="check-inline"><input type="checkbox" checked> Crear las unidades base (Bienvenida, Unidades 1 a 4 y Cierre)</label>

        <div class="modal-actions">
            <button class="secondary-button" type="button" data-modal-close>Cancelar</button>
            <button class="primary-button dark" type="submit">Crear aula</button>
        </div>
    </form>
</div>

<div class="modal" id="assign-teacher-modal" aria-hidden="true">
    <form class="modal-card demo-form" data-demo-form>
        <button class="modal-close" type="button" data-modal-close aria-label="Cerrar">×</button>
        <small>ASIGNACIÓN</small>
        <h2>Asignar docente al aula</h2>

        <label class="export-field">Aula<select>@foreach($rooms as $room)<option>{{ $room['code'] }} · {{ $room['subject'] }} · {{ $room['grade'] }} {{ $room['parallel'] }}</option>@endforeach</select></label>

        <div class="form-grid">
            <label class="export-field">Docente<select>@foreach($teachers as $teacher)<option>{{ $teacher }}</option>@endforeach</select></label>
            <label class="export-field">Rol en el aula<select><option>Titular</option><option>Apoyo</option><option>Suplente</option></select></label>
        </div>

        <div class="form-grid">
            <label class="export-field">Desde<input type="date" value="2026-09-01"></label>
            <label class="export-field">Hasta<input type="date" value="2027-07-15"></label>
        </div>

        <label class="check-inline"><input type="checkbox" checked> Notificar al docente por correo institucional</label>
        <div class="info-strip"><i data-lucide="info"></i> El docente podrá editar el contenido del aula en cuanto quede asignado.</div>

        <div class="modal-actions">
            <button class="secondary-button" type="button" data-modal-close>Cancelar</button>
            <button class="primary-button dark" type="submit">Asignar docente</button>
        </div>
    </form>
</div>
