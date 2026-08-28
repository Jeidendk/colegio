@php
    $participants = [
        ['JP','Juan Carlos Pérez','M-08021','Matemática','82%','Hoy, 08:32','Al día'],
        ['MR','María Fernanda Ruiz','M-08034','Matemática','74%','Ayer, 19:10','Al día'],
        ['JS','Jorge Silva Andrade','M-08047','Lengua y Literatura','49%','Hace 5 días','En riesgo'],
        ['AC','Andrea Cabrera','M-08052','Lengua y Literatura','88%','Hoy, 07:55','Al día'],
        ['LM','Luis Molina','M-08063','Ciencias Naturales','67%','Hace 2 días','Pendiente'],
        ['SV','Sofía Villacís','M-08071','Ciencias Naturales','91%','Hoy, 09:02','Al día'],
    ];
@endphp

<section class="teacher-courses-heading">
    <div><h1>Participantes de mis cursos</h1><p>Consulta el avance y la última actividad de los estudiantes matriculados.</p></div>
    <button class="pill-button solid" type="button" data-toast="Mensaje grupal preparado"><i data-lucide="send"></i> Mensaje grupal</button>
</section>

<section class="panel users-panel" data-teacher-students>
    <span class="panel-accent" aria-hidden="true"></span>

    <div class="toolbar users-toolbar">
        <label class="search-field"><i data-lucide="search"></i><input type="search" placeholder="Buscar estudiante o código..." data-teacher-student-search></label>

        <select class="select-control" data-teacher-student-status>
            <option value="">Estado: Todos</option>
            <option>Al día</option>
            <option>Pendiente</option>
            <option>En riesgo</option>
        </select>

        <select class="select-control">
            <option>Todos mis cursos</option>
            @foreach($virtualCourses as $course)<option>{{ $course['name'] }}</option>@endforeach
        </select>

        <div class="toolbar-right">
            <button class="pill-button" type="button" data-toast="Lista de participantes preparada"><i data-lucide="download"></i> Exportar</button>
        </div>
    </div>

    <div class="table-wrap">
        <table class="data-table users-table">
            <thead>
                <tr>
                    <th>Estudiante</th>
                    <th>Curso</th>
                    <th>Avance</th>
                    <th>Último acceso</th>
                    <th>Estado</th>
                    <th class="actions-col">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($participants as $person)
                    <tr data-teacher-student-row data-student-status="{{ $person[6] }}">
                        <td>
                            <div class="user-cell">
                                <span class="avatar small">{{ $person[0] }}</span>
                                <div><b>{{ $person[1] }}</b><small>{{ $person[2] }}</small></div>
                            </div>
                        </td>
                        <td>
                            <div class="role-cell">
                                <span class="role-pill role-estudiante"><i data-lucide="book-open"></i> {{ $person[3] }}</span>
                            </div>
                        </td>
                        <td>
                            <div class="table-progress"><span><i style="width:{{ $person[4] }}"></i></span><b>{{ $person[4] }}</b></div>
                        </td>
                        <td class="muted-cell">{{ $person[5] }}</td>
                        <td><x-badge :value="$person[6]" /></td>
                        <td>
                            <div class="row-actions">
                                <button class="row-action" type="button" title="Ver perfil" data-toast="Perfil académico abierto"><i data-lucide="eye"></i></button>
                                <button class="row-action edit" type="button" title="Enviar mensaje" data-toast="Mensaje preparado"><i data-lucide="mail"></i></button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <x-table-footer :count="count($participants)" label="83 estudiantes matriculados en el periodo." />
</section>
