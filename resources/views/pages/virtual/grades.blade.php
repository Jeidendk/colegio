<div class="virtual-page-heading">
    <div><h1>Calificaciones</h1><p>Resumen de resultados por materia durante el año lectivo 2026-2027.</p></div>
    <div class="grade-overview"><b>{{ $student['average'] }}</b><small>Promedio general</small></div>
</div>

<section class="panel users-panel">
    <span class="panel-accent" aria-hidden="true"></span>

    <div class="toolbar users-toolbar">
        <label class="search-field"><i data-lucide="search"></i><input type="search" placeholder="Buscar materia..." data-table-search></label>
        <select class="select-control"><option>Año lectivo 2026-2027</option></select>

        <div class="toolbar-right">
            <button class="pill-button" type="button" data-toast="Reporte de calificaciones preparado"><i data-lucide="download"></i> Exportar</button>
        </div>
    </div>

    <div class="table-wrap">
        <table class="data-table users-table">
            <thead>
                <tr>
                    <th>Materia</th>
                    <th>Docente</th>
                    <th>Progreso</th>
                    <th>Calificación</th>
                    <th>Estado</th>
                    <th class="actions-col">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($virtualCourses as $course)
                    <tr data-search-row>
                        <td>
                            <a class="user-cell" href="{{ route('portal', ['role' => $role, 'page' => 'aula-virtual', 'curso' => $course['slug']]) }}">
                                <span class="course-mark tone-{{ $course['tone'] }}"><i data-lucide="book-open"></i></span>
                                <div><b>{{ $course['name'] }}</b><small>{{ $course['code'] }}</small></div>
                            </a>
                        </td>
                        <td class="muted-cell">{{ $course['teacher'] }}</td>
                        <td><div class="table-progress"><span><i style="width:{{ $course['progress'] }}%"></i></span><b>{{ $course['progress'] }}%</b></div></td>
                        <td><strong class="grade-value">{{ $course['grades'][2][1] }}</strong></td>
                        <td><x-badge value="Aprobado" /></td>
                        <td>
                            <div class="row-actions">
                                <a class="row-action" href="{{ route('portal', ['role' => $role, 'page' => 'aula-virtual', 'curso' => $course['slug']]) }}" title="Abrir curso"><i data-lucide="eye"></i></a>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <x-table-footer :count="count($virtualCourses)" :label="'Promedio general '.$student['average'].' sobre 10.'" />
</section>
