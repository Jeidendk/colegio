@php
    $gradeRows = [
        ['JP','Juan Carlos Pérez','M-08021','Matemática','Actividad 2 · Números racionales','Entregado','—'],
        ['MR','María Fernanda Ruiz','M-08034','Matemática','Actividad 2 · Números racionales','Entregado','—'],
        ['JS','Jorge Silva Andrade','M-08047','Lengua y Literatura','Relato de tradición oral','Borrador','—'],
        ['AC','Andrea Cabrera','M-08052','Lengua y Literatura','Taller de escritura comunitaria','Calificado','8,7'],
        ['LM','Luis Molina','M-08063','Ciencias Naturales','Bitácora · Ecosistemas','Entregado','—'],
    ];
@endphp

<section class="teacher-courses-heading">
    <div><h1>Libro de calificaciones</h1><p>Revisa entregas, registra notas y publica la retroalimentación desde una sola bandeja.</p></div>
    <button class="pill-button solid" type="button" data-toast="Las calificaciones guardadas fueron publicadas"><i data-lucide="send"></i> Publicar calificaciones</button>
</section>

<section class="panel users-panel" data-teacher-gradebook>
    <span class="panel-accent" aria-hidden="true"></span>

    <div class="toolbar users-toolbar">
        <label class="search-field"><i data-lucide="search"></i><input type="search" placeholder="Buscar estudiante, curso o actividad..." data-teacher-grade-search></label>

        <select class="select-control" data-teacher-grade-status>
            <option value="">Estado: Todos</option>
            <option>Entregado</option>
            <option>Borrador</option>
            <option>Calificado</option>
        </select>

        <select class="select-control">
            <option>Todos mis cursos</option>
            @foreach($virtualCourses as $course)<option>{{ $course['name'] }}</option>@endforeach
        </select>

        <div class="toolbar-right">
            <button class="pill-button" type="button" data-toast="Reporte de calificaciones preparado"><i data-lucide="download"></i> Exportar</button>
            <button class="pill-button solid" type="button" data-toast="Calificaciones guardadas en la demostración"><i data-lucide="save"></i> Guardar cambios</button>
        </div>
    </div>

    <div class="table-wrap">
        <table class="data-table users-table">
            <thead>
                <tr>
                    <th>Estudiante</th>
                    <th>Curso / Actividad</th>
                    <th>Estado</th>
                    <th>Nota</th>
                    <th class="actions-col">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($gradeRows as $row)
                    <tr data-teacher-grade-row data-grade-status="{{ $row[5] }}">
                        <td>
                            <div class="user-cell">
                                <span class="avatar small">{{ $row[0] }}</span>
                                <div><b>{{ $row[1] }}</b><small>{{ $row[2] }}</small></div>
                            </div>
                        </td>
                        <td>
                            <div class="role-cell">
                                <span class="role-pill role-estudiante"><i data-lucide="book-open"></i> {{ $row[3] }}</span>
                                <small>{{ $row[4] }}</small>
                            </div>
                        </td>
                        <td><x-badge :value="$row[5]" /></td>
                        <td><strong class="grade-value">{{ $row[6] }}</strong></td>
                        <td>
                            <div class="row-actions">
                                <button class="row-action edit" type="button" title="{{ $row[5] === 'Calificado' ? 'Editar nota' : 'Calificar' }}" data-toast="Evaluador abierto en modo demostración"><i data-lucide="clipboard-pen"></i></button>
                                <button class="row-action" type="button" title="Ver entrega" data-toast="Entrega de {{ $row[1] }}"><i data-lucide="eye"></i></button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <x-table-footer :count="count($gradeRows)" />
</section>
