@php
    $isSchedulePlanner = $role === 'admin';
    $weekDays = ['monday' => 'Lunes', 'tuesday' => 'Martes', 'wednesday' => 'Miércoles', 'thursday' => 'Jueves', 'friday' => 'Viernes'];
    $careerLegend = [
        ['Inicial', '#a855f7'], ['EGB Elemental', '#2563eb'], ['EGB Media', '#0d9488'],
        ['EGB Superior', '#16a34a'], ['Bachillerato', '#f59e0b'], ['English', '#ea580c'],
        ['Proyectos interdisciplinarios', '#c026d3'],
    ];
    $printableHours = ['07H00 - 08H00', '08H00 - 09H00', '09H00 - 10H00', '10H00 - 11H00', '11H00 - 12H00', '12H00 - 13H00', '13H00 - 14H00', '14H00 - 15H00', '15H00 - 16H00', '16H00 - 17H00'];
    $plannerHours = ['07:00 - 08:00', '08:00 - 09:00', '09:00 - 10:00', '10:00 - 11:00', '11:00 - 12:00', '12:00 - 13:00', '13:00 - 14:00', '14:00 - 15:00', '15:00 - 16:00', '16:00 - 17:00'];
    $classesInRoom = 0;
    $usedRooms = [];
    $assignedTeachers = [];
    foreach ($schedule as $row) {
        foreach (array_keys($weekDays) as $dayKey) {
            if ($row[$dayKey]) {
                $classesInRoom++;
                $usedRooms[] = $row[$dayKey]['room'];
                $assignedTeachers[] = $row[$dayKey]['teacher'];
            }
        }
    }
    $mapSpaces = [
        ['name' => 'Bloque de Educación Básica', 'detail' => 'Aulas de EGB Elemental, Media y Superior', 'type' => 'Edificio', 'capacity' => 210, 'lat' => -1.65578, 'lng' => -78.67805, 'image' => 'https://images.unsplash.com/photo-1562774053-701939374585?w=320&h=240&fit=crop'],
        ['name' => 'Laboratorio de Ciencias', 'detail' => 'Ciencias Naturales, Biología y Química', 'type' => 'Laboratorio', 'capacity' => 32, 'lat' => -1.65634, 'lng' => -78.67742, 'image' => 'https://images.unsplash.com/photo-1532094349884-543bc11b234d?w=320&h=240&fit=crop'],
        ['name' => 'Sala de Computación', 'detail' => 'Tecnología, programación y robótica educativa', 'type' => 'Laboratorio', 'capacity' => 30, 'lat' => -1.65522, 'lng' => -78.67874, 'image' => 'https://images.unsplash.com/photo-1497366754035-f200968a6e72?w=320&h=240&fit=crop'],
        ['name' => 'Auditorio Montessori', 'detail' => 'Actos, exposiciones y eventos académicos', 'type' => 'Auditorio', 'capacity' => 160, 'lat' => -1.65476, 'lng' => -78.67692, 'image' => 'https://images.unsplash.com/photo-1498243691581-b145c3f54a5a?w=320&h=240&fit=crop'],
        ['name' => 'Bloque de Educación Inicial', 'detail' => 'Ambientes preparados para Inicial 1 y 2', 'type' => 'Edificio', 'capacity' => 60, 'lat' => -1.65692, 'lng' => -78.67782, 'image' => 'https://images.unsplash.com/photo-1503454537195-1dcabb73ffb9?w=320&h=240&fit=crop'],
        ['name' => 'Biblioteca Montessori', 'detail' => 'Lectura, consulta y estudio colaborativo', 'type' => 'Servicio', 'capacity' => 72, 'lat' => -1.65505, 'lng' => -78.67948, 'image' => 'https://images.unsplash.com/photo-1521587760476-6c12a4b040da?w=320&h=240&fit=crop'],
        ['name' => 'Cancha cubierta', 'detail' => 'Espacio de bienestar estudiantil', 'type' => 'Servicio', 'capacity' => 150, 'lat' => -1.65725, 'lng' => -78.67652, 'image' => 'https://images.unsplash.com/photo-1546519638-68e109498ffc?w=320&h=240&fit=crop'],
    ];
@endphp

@if($isSchedulePlanner)
    <section class="schedule-reference-hero">
        <div class="schedule-reference-title">
            <span><i data-lucide="clock-3"></i></span>
            <div><h1>Horarios</h1><p>Asigne docentes, aulas y edificios a los bloques horarios.</p></div>
        </div>
        <div class="schedule-view-tabs" role="tablist" aria-label="Vistas de horarios">
            <button class="is-active" type="button" role="tab" aria-selected="true" data-schedule-view="planner">Horario semestral</button>
            <button type="button" role="tab" aria-selected="false" data-schedule-view="spaces">Mapa de espacios</button>
        </div>
        <div class="schedule-reference-stats">
            <div><i data-lucide="calendar-days"></i><span><strong>03</strong><small>Clases</small></span></div>
            <div><i data-lucide="door-open"></i><span><strong>02</strong><small>Aulas</small></span></div>
            <div><i data-lucide="user-round"></i><span><strong>02</strong><small>Docentes</small></span></div>
        </div>
    </section>
@else
    <x-hero icon="calendar-days"
        :title="$role === 'estudiante' || $role === 'representante' ? 'Horario académico' : 'Mi horario docente'"
        :subtitle="$role === 'representante' ? 'Consulta la jornada semanal de '.$student['firstName'].'.' : 'Año lectivo 2026-2027 · Unidad Educativa Montessori'"
        :stats="[['Clases', $classesInRoom, 'programadas'], ['Aulas', count(array_unique($usedRooms)), 'en uso'], ['Docentes', count(array_unique($assignedTeachers)), 'asignados']]" />
@endif

<section class="panel schedule-panel" data-schedule-root>
    <span class="panel-accent" aria-hidden="true"></span>

    <div class="toolbar schedule-toolbar">
        @if($isSchedulePlanner)
            <button class="round-button" type="button" data-locations-toggle title="Ubicaciones (edificios, pisos y aulas)"><i data-lucide="building-2"></i></button>
        @endif

        <label class="search-field schedule-search"><i data-lucide="search"></i><input type="search" placeholder="Buscar clase, docente..." data-schedule-search></label>

        @if($isSchedulePlanner)
            <div class="location-chips">
                <span class="location-chip"><i data-lucide="building-2"></i><b data-chip-building>Edificio de aulas</b></span>
                <span class="location-chip"><i data-lucide="layers"></i><b data-chip-floor>Piso 1</b></span>
                <span class="location-chip"><i data-lucide="door-open"></i><b data-chip-room>Aula 102</b></span>
            </div>
        @endif

        <div class="toolbar-right">
            @if($isSchedulePlanner)
                <button class="pill-button" type="button" data-toast="Formato aplicado a todas las aulas"><i data-lucide="file-text"></i> Formatear todos</button>
                <button class="pill-button danger" type="button" data-toast="Se eliminarían las {{ $classesInRoom }} clases del aula filtrada"><i data-lucide="trash-2"></i> Borrar aula</button>
                <button class="pill-button" type="button" data-modal-open="import-schedule-modal"><i data-lucide="upload"></i> Importar</button>
            @endif
            <button class="pill-button" type="button" data-export-open><i data-lucide="download"></i> Exportar</button>
            @if($isSchedulePlanner)
                <button class="pill-button solid" type="button" data-modal-open="class-modal"><i data-lucide="plus"></i> Nueva clase</button>
            @endif
        </div>
    </div>

    <div class="schedule-wrap">
        <table class="schedule-table">
            <thead>
                <tr>
                    <th class="hour-col">Hora</th>
                    @foreach($weekDays as $dayLabel)
                        <th>{{ $dayLabel }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @if($isSchedulePlanner)
                    @foreach($plannerHours as $hour)
                        <tr>
                            <th class="hour-col">{{ $hour }}</th>
                            @foreach($weekDays as $dayLabel)
                                <td>
                                    <button class="cell-add" type="button" data-modal-open="class-modal" title="Asignar clase el {{ $dayLabel }} a las {{ $hour }}">
                                        <i data-lucide="plus"></i>
                                    </button>
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                @else
                    @foreach($schedule as $row)
                        <tr>
                            <th class="hour-col">{{ $row['time'] }}</th>
                            @foreach($weekDays as $dayKey => $dayLabel)
                                @php $class = $row[$dayKey]; @endphp
                                <td>
                                    @if($class)
                                        <button class="class-block {{ $class['type'] }}" type="button"
                                            data-class-cell
                                            data-search-text="{{ mb_strtolower($class['subject'].' '.$class['teacher'].' '.$class['room']) }}"
                                            data-room="{{ $class['room'] }}"
                                            data-toast="{{ $class['subject'] }} · {{ $class['room'] }}">
                                            <span class="class-title"><i class="dot class-{{ $class['type'] }}"></i>{{ $class['subject'] }}</span>
                                            <span class="class-career">{{ $class['career'] }}</span>
                                            <span class="class-meta"><i data-lucide="map-pin"></i>{{ $class['room'] }}</span>
                                            <span class="class-meta"><i data-lucide="user"></i>{{ $class['teacher'] }}</span>
                                        </button>
                                    @endif
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>

    <div class="schedule-footer">
        <div class="career-legend">
            @foreach($careerLegend as $career)
                <span><i class="dot" style="background:{{ $career[1] }}"></i> {{ $career[0] }}</span>
            @endforeach
        </div>
        <span class="footer-note"><i data-lucide="info"></i> Los horarios se muestran en hora local.</span>
    </div>

    @if($isSchedulePlanner)
        <aside class="locations-panel" data-locations-panel aria-hidden="true">
            <div class="locations-head">
                <div><small>UBICACIONES</small><h2>Edificios, pisos y aulas</h2></div>
                <button class="icon-button" type="button" data-locations-close aria-label="Cerrar">×</button>
            </div>
            <div class="locations-body">
                <div class="locations-list">
                    @foreach($buildings as $index => $building)
                        <button class="location-building {{ $index === 0 ? 'is-active' : '' }}" type="button" data-building-tab="{{ $index }}">
                            <i data-lucide="building-2"></i>
                            <span><b>{{ $building['name'] }}</b><small>{{ count($building['floors']) }} pisos</small></span>
                            <i data-lucide="chevron-right"></i>
                        </button>
                    @endforeach
                </div>
                <div class="locations-detail">
                    @foreach($buildings as $index => $building)
                        <div class="{{ $index === 0 ? '' : 'hidden' }}" data-building-panel="{{ $index }}">
                            @foreach($building['floors'] as $floor)
                                <div class="floor-group">
                                    <h3><i data-lucide="layers"></i> {{ $floor['label'] }}</h3>
                                    <div class="room-chips">
                                        @foreach($floor['rooms'] as $room)
                                            <button class="room-chip" type="button"
                                                data-pick-room="{{ $room }}"
                                                data-pick-building="{{ $building['name'] }}"
                                                data-pick-floor="{{ $floor['label'] }}">{{ $room }}</button>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                </div>
            </div>
        </aside>
        <div class="locations-backdrop" data-locations-close></div>
    @endif
</section>

@if($isSchedulePlanner)
    <section class="spaces-view hidden" data-spaces-view>
        <aside class="spaces-explorer">
            <header><i data-lucide="map-pin"></i><h2>Explorador de espacios</h2></header>
            <label class="spaces-search"><i data-lucide="search"></i><input type="search" placeholder="Buscar por nombre o detalle..." data-space-search></label>
            <label class="spaces-filter"><i data-lucide="sliders-horizontal"></i><select data-space-filter aria-label="Filtrar espacios por tipo"><option value="">Todos los tipos</option><option>Edificio</option><option>Laboratorio</option><option>Auditorio</option><option>Servicio</option></select></label>
            <div class="spaces-list">
                @foreach($mapSpaces as $index => $space)
                    <button class="space-result {{ $index === 0 ? 'is-active' : '' }}" type="button" data-space-card data-space-name="{{ mb_strtolower($space['name'].' '.$space['detail']) }}" data-space-type="{{ $space['type'] }}" data-space-index="{{ $index }}" data-space-lat="{{ $space['lat'] }}" data-space-lng="{{ $space['lng'] }}">
                        <span class="space-thumb"><img src="{{ $space['image'] }}" alt="{{ $space['name'] }}" loading="lazy"><i data-lucide="{{ $space['type'] === 'Laboratorio' ? 'flask-conical' : ($space['type'] === 'Auditorio' ? 'presentation' : 'building-2') }}"></i></span>
                        <span class="space-result-copy"><b>{{ $space['name'] }}</b><small>{{ $space['detail'] }}</small><em><i data-lucide="users"></i> Cap: {{ $space['capacity'] }} <strong>Operativo</strong></em></span>
                        <span class="space-kind">{{ $space['type'] }}</span>
                    </button>
                @endforeach
            </div>
        </aside>

        <div class="campus-spaces-map" data-campus-map>
            <div class="leaflet-campus-map" id="spaces-leaflet-map" data-leaflet-map aria-label="Mapa interactivo de espacios Montessori Riobamba"></div>
            <div class="map-style-switch"><button class="is-active" type="button" data-map-style="street">Mapa</button><button type="button" data-map-style="satellite">Satélite</button><button type="button" data-map-style="hybrid">Híbrido</button></div>
            <div class="map-zoom"><button type="button" data-map-zoom-in aria-label="Acercar">+</button><button type="button" data-map-zoom-out aria-label="Alejar">−</button><button type="button" data-map-center aria-label="Centrar mapa"><i data-lucide="locate-fixed"></i></button></div>
            <div class="spaces-map-legend"><b><i data-lucide="layers-3"></i> Leyenda</b><span><i class="dot available"></i> Disponible / Operativo</span><span><i class="dot occupied"></i> Ocupado</span></div>
            <div class="space-map-detail"><small>ESPACIO SELECCIONADO</small><b data-space-detail-title>{{ $mapSpaces[0]['name'] }}</b><span data-space-detail-copy>{{ $mapSpaces[0]['detail'] }}</span></div>
        </div>
    </section>
@endif

{{-- Generar formato: réplica de la pantalla de exportación del sistema original --}}
<section class="export-view" data-export-view hidden>
    <aside class="export-sidebar">
        <div class="export-sidebar-head">
            <h2><i data-lucide="file-down"></i> Generar formato</h2>
            <button class="icon-button" type="button" data-export-close aria-label="Cerrar">×</button>
        </div>

        <label class="export-field">Edificio / Ubicación
            <select data-export-building>
                @foreach($buildings as $building)<option>{{ $building['name'] }}</option>@endforeach
                <option selected>Edificio de aulas</option>
            </select>
        </label>

        <label class="export-field">Aula o laboratorio
            <select data-export-room>
                <option selected>Aula 102</option>
                <option>Aula 8A</option>
                <option>Aula 8B</option>
                <option>Laboratorio de Ciencias</option>
                <option>Sala de Computación</option>
            </select>
        </label>

        <label class="export-field">Año lectivo
            <input value="2026 - 2027" data-export-period>
        </label>

        <div class="export-tabs segmented compact" data-tabs>
            <button class="is-active" type="button" data-tab="options">Opciones</button>
            <button type="button" data-tab="generation">Generación</button>
        </div>

        <div data-tab-panel="options">
            <span class="export-label">Orientación</span>
            <div class="segmented compact export-toggle">
                <button type="button"><i data-lucide="rectangle-vertical"></i> Vertical</button>
                <button class="is-active" type="button"><i data-lucide="rectangle-horizontal"></i> Horizontal</button>
            </div>

            <div class="export-grid">
                <div>
                    <span class="export-label">Tamaño de papel</span>
                    <div class="segmented compact">
                        <button class="is-active" type="button">A4</button>
                        <button type="button">Carta</button>
                    </div>
                </div>
                <div>
                    <span class="export-label">Pie institucional</span>
                    <button class="toggle-yes is-active" type="button" data-export-footer><i data-lucide="check"></i> Sí</button>
                </div>
            </div>

            <div class="export-grid">
                <label class="export-field">Tamaño de fuente<input type="number" min="8" max="16" value="11"></label>
                <label class="export-field">Tipografía
                    <select><option>Inter</option><option>Montserrat</option><option>Arial</option><option>Helvetica</option><option>Open Sans</option><option>Roboto</option><option>Tahoma</option><option>Times New Roman</option><option>Verdana</option><option>Courier New</option></select>
                </label>
            </div>
        </div>

        <div class="hidden" data-tab-panel="generation">
            <label class="check-inline"><input type="checkbox" checked> Incluir docente en cada bloque</label>
            <label class="check-inline"><input type="checkbox" checked> Incluir carrera</label>
            <label class="check-inline"><input type="checkbox"> Incluir bloques vacíos</label>
            <label class="check-inline"><input type="checkbox" checked> Repetir cabecera en cada página</label>
        </div>

        <div class="export-summary">
            <small>Resumen de selección</small>
            <div><i data-lucide="building-2"></i> Edificio / Ubicación <b data-summary-building>Edificio de aulas</b></div>
            <div><i data-lucide="door-open"></i> Aula o laboratorio <b data-summary-room>Aula 102</b></div>
            <div><i data-lucide="clock"></i> Generado el <b>27 ago 2026, 20:06</b></div>
        </div>

        <button class="primary-button export-print" type="button" data-toast="Enviando el formato a la impresora"><i data-lucide="printer"></i> Imprimir</button>
    </aside>

    <div class="export-preview">
        <div class="export-toolbar">
            <span class="export-stamp"><i data-lucide="calendar"></i><span><small>Última generación</small><b>27 ago 2026, 20:06</b></span></span>
            <span class="export-ready"><i class="dot"></i> Vista lista para impresión</span>
            <div class="export-zoom">
                <button class="icon-button" type="button" data-toast="Zoom 90%"><i data-lucide="zoom-out"></i></button>
                <b>Zoom 100%</b>
                <button class="icon-button" type="button" data-toast="Zoom 110%"><i data-lucide="zoom-in"></i></button>
            </div>
            <div class="export-pager"><small>Página</small><button class="icon-button" type="button"><i data-lucide="chevron-left"></i></button><b>1 / 1</b><button class="icon-button" type="button"><i data-lucide="chevron-right"></i></button></div>
            <button class="pill-button" type="button" data-toast="Vista ajustada al ancho"><i data-lucide="maximize-2"></i> Ajustar al ancho</button>
            <div class="export-downloads">
                <button class="format-button pdf" type="button" data-toast="PDF generado en la demostración"><i data-lucide="file-text"></i> PDF</button>
                <button class="format-button docx" type="button" data-toast="DOCX generado en la demostración"><i data-lucide="file-type-2"></i> DOCX</button>
            </div>
        </div>

        <div class="export-sheet-wrap">
            <article class="export-sheet">
                <header class="sheet-head">
                    <img src="{{ asset('img/montessori-logo.png') }}" alt="Unidad Educativa Montessori">
                    <div>
                        <h3>UNIDAD EDUCATIVA MONTESSORI</h3>
                        <p>RIOBAMBA · CHIMBORAZO</p>
                    </div>
                </header>

                <h4 class="sheet-room" data-sheet-room>AULA 102</h4>
                <p class="sheet-meta" data-sheet-building>EDIFICIO DE AULAS</p>
                <p class="sheet-meta" data-sheet-period>AÑO LECTIVO 2026 - 2027</p>

                <table class="sheet-table">
                    <thead>
                        <tr><th>Hora</th>@foreach($weekDays as $dayLabel)<th>{{ $dayLabel }}</th>@endforeach</tr>
                    </thead>
                    <tbody>
                        @foreach($printableHours as $hour)
                            <tr><td class="sheet-hour">{{ $hour }}</td>@foreach($weekDays as $dayKey => $dayLabel)<td></td>@endforeach</tr>
                        @endforeach
                    </tbody>
                </table>

                <footer class="sheet-foot">
                    Sector Las Acacias · Riobamba, Chimborazo<br>
                    Documento demostrativo · Unidad Educativa Montessori
                </footer>
            </article>
        </div>
    </div>
</section>

@if($isSchedulePlanner)
    <div class="modal" id="class-modal" aria-hidden="true">
        <form class="modal-card demo-form" data-demo-form>
            <button class="modal-close" type="button" data-modal-close aria-label="Cerrar">×</button>
            <small>HORARIOS</small>
            <h2>Nueva clase</h2>
            <div class="form-grid">
                <label>Materia<select><option>Matemática</option><option>Lengua y Literatura</option><option>Ciencias Naturales</option><option>Estudios Sociales</option></select></label>
                <label>Docente<select><option>Lcdo. Roberto Sánchez</option><option>Lcda. Patricia Morales</option><option>Lcdo. Fernando Ruiz</option><option>Lcda. Ana Gómez</option></select></label>
            </div>
            <div class="form-grid">
                <label>Nivel<select><option>EGB Elemental</option><option>EGB Media</option><option>EGB Superior</option><option>Bachillerato</option></select></label>
                <label>Paralelo<select><option>A</option><option>B</option></select></label>
            </div>
            <div class="form-grid">
                <label>Día<select><option>Lunes</option><option>Martes</option><option>Miércoles</option><option>Jueves</option><option>Viernes</option></select></label>
                <label>Tipo de clase<select><option>Clase</option><option>Laboratorio</option><option>Tutoría</option></select></label>
            </div>
            <div class="form-grid">
                <label>Hora inicio<input type="time" value="07:00"></label>
                <label>Hora fin<input type="time" value="09:00"></label>
            </div>
            <div class="form-grid">
                <label>Edificio<select><option>Bloque EGB</option><option>Bloque Inicial</option><option>Bloque Bachillerato</option></select></label>
                <label>Piso<select><option>Planta baja</option><option>Piso 1</option><option>Piso 2</option></select></label>
            </div>
            <label>Aula<select><option>Aula 8A</option><option>Aula 8B</option><option>Laboratorio de Ciencias</option><option>Sala de Computación</option><option>Biblioteca</option></select></label>
            <div class="modal-actions">
                <button class="secondary-button" type="button" data-modal-close>Cancelar</button>
                <button class="primary-button" type="submit">Guardar clase</button>
            </div>
        </form>
    </div>

    <div class="modal" id="import-schedule-modal" aria-hidden="true">
        <form class="modal-card demo-form" data-demo-form>
            <button class="modal-close" type="button" data-modal-close aria-label="Cerrar">×</button>
            <small>HORARIOS</small>
            <h2>Importar horario</h2>
            <label class="file-drop">
                <i data-lucide="file-spreadsheet"></i>
                <span><b>Selecciona un archivo .xlsx o .csv</b><small>Se valida fila por fila antes de aplicar los cambios.</small></span>
                <input type="file" accept=".xlsx,.csv">
            </label>
            <div class="form-grid">
                <label>Año lectivo<select><option>2026-2027</option><option>2025-2026</option></select></label>
                <label>Aula destino<select><option>Todas las del archivo</option><option>Aula 8A</option><option>Laboratorio de Ciencias</option></select></label>
            </div>
            <label class="check-inline"><input type="checkbox" checked> Reemplazar las clases existentes del periodo</label>
            <div class="modal-actions">
                <button class="secondary-button" type="button" data-modal-close>Cancelar</button>
                <button class="primary-button" type="submit">Previsualizar e importar</button>
            </div>
        </form>
    </div>
@endif
