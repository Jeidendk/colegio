@php
    $isSchedulePlanner = $role === 'admin';
    $weekDays = ['monday' => 'Lunes', 'tuesday' => 'Martes', 'wednesday' => 'Miércoles', 'thursday' => 'Jueves', 'friday' => 'Viernes'];
    $careerLegend = [
        ['Diseño Gráfico', '#a855f7'], ['Electricidad', '#2563eb'], ['Electrónica y Automatización', '#0d9488'],
        ['Electrónica y Telecomunicaciones', '#16a34a'], ['Software', '#f59e0b'], ['Tecnologías de la Información', '#ea580c'],
        ['Telemática', '#c026d3'],
    ];
    $printableHours = ['07H00 - 08H00', '08H00 - 09H00', '09H00 - 10H00', '10H00 - 11H00', '11H00 - 12H00', '12H00 - 13H00', '13H00 - 14H00', '14H00 - 15H00', '15H00 - 16H00', '16H00 - 17H00'];
    $classesInRoom = 0;
    foreach ($schedule as $row) {
        foreach (array_keys($weekDays) as $dayKey) {
            if ($row[$dayKey]) {
                $classesInRoom++;
            }
        }
    }
@endphp

<x-hero icon="calendar-days"
    :title="$role === 'estudiante' || $role === 'representante' ? 'Horario académico' : ($role === 'docente' ? 'Mi horario docente' : 'Horarios')"
    :subtitle="$role === 'representante' ? 'Consulta la jornada semanal de '.$student['firstName'].'.' : ($isSchedulePlanner ? 'Asigne docentes, aulas y edificios a los bloques horarios.' : 'Periodo académico 2026-1 · Ingeniería en Electricidad')"
    :stats="[['Clases', $classesInRoom, 'programadas'], ['Aulas', '12', 'en uso'], ['Docentes', '4', 'asignados']]">
    @if($isSchedulePlanner)
        <div class="hero-segmented">
            <button class="is-active" type="button">Horario semestral</button>
            <button type="button" data-toast="El mapa de espacios llega en la siguiente iteración">Mapa de espacios</button>
        </div>
    @endif
</x-hero>

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
                <span class="location-chip"><i data-lucide="door-open"></i><b data-chip-room>Todas las aulas</b></span>
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
                                        @if($isSchedulePlanner) data-modal-open="class-modal" @else data-toast="{{ $class['subject'] }} · {{ $class['room'] }}" @endif>
                                        <span class="class-title"><i class="dot class-{{ $class['type'] }}"></i>{{ $class['subject'] }}</span>
                                        <span class="class-career">{{ $class['career'] }}</span>
                                        <span class="class-meta"><i data-lucide="map-pin"></i>{{ $class['room'] }}</span>
                                        <span class="class-meta"><i data-lucide="user"></i>{{ $class['teacher'] }}</span>
                                    </button>
                                @elseif($isSchedulePlanner)
                                    <button class="cell-add" type="button" data-modal-open="class-modal" title="Asignar clase el {{ $dayLabel }} a las {{ $row['time'] }}">
                                        <i data-lucide="plus"></i>
                                    </button>
                                @endif
                            </td>
                        @endforeach
                    </tr>
                @endforeach
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
                <option>FIE-201</option>
                <option>FIE-302</option>
                <option>Lab. Control</option>
                <option>Lab. Potencia</option>
            </select>
        </label>

        <label class="export-field">Período académico
            <input value="MARZO 2026 - SEPTIEMBRE 2026" data-export-period>
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
                    <img src="{{ asset('img/espoch-bandera.webp') }}" alt="ESPOCH">
                    <div>
                        <h3>ESCUELA SUPERIOR POLITÉCNICA DE CHIMBORAZO</h3>
                        <p>FACULTAD DE INFORMÁTICA Y ELECTRÓNICA</p>
                    </div>
                </header>

                <h4 class="sheet-room" data-sheet-room>AULA 102</h4>
                <p class="sheet-meta" data-sheet-building>EDIFICIO DE AULAS</p>
                <p class="sheet-meta" data-sheet-period>MARZO 2026 - SEPTIEMBRE 2026</p>

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
                    Panamericana Sur Km. 1 ½. | Teléfono: 593 (03) 2 998-200 | Telefax: (03) 2 317-001 | Código Postal: EC060155.<br>
                    Riobamba - Ecuador
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
                <label>Materia<select><option>Control Automático</option><option>Circuitos Eléctricos I</option><option>Máquinas Eléctricas II</option><option>Análisis de Señales</option></select></label>
                <label>Docente<select><option>Ing. Roberto Sánchez</option><option>Ing. Patricia Morales</option><option>Ing. Fernando Ruiz</option><option>Ing. Ana Gómez</option></select></label>
            </div>
            <div class="form-grid">
                <label>Carrera<select><option>Ingeniería en Electricidad</option><option>Electrónica y Automatización</option><option>Telecomunicaciones</option></select></label>
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
                <label>Edificio<select><option>FIE-A</option><option>Bloque Labs</option><option>Cómputo</option></select></label>
                <label>Piso<select><option>Planta baja</option><option>Piso 1</option><option>Piso 2</option></select></label>
            </div>
            <label>Aula<select><option>FIE-201</option><option>FIE-302</option><option>Lab. Control</option><option>Lab. Potencia</option><option>Lab. Circuitos</option></select></label>
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
                <label>Periodo<select><option>2026-1</option><option>2025-2</option></select></label>
                <label>Aula destino<select><option>Todas las del archivo</option><option>FIE-201</option><option>Lab. Control</option></select></label>
            </div>
            <label class="check-inline"><input type="checkbox" checked> Reemplazar las clases existentes del periodo</label>
            <div class="modal-actions">
                <button class="secondary-button" type="button" data-modal-close>Cancelar</button>
                <button class="primary-button" type="submit">Previsualizar e importar</button>
            </div>
        </form>
    </div>
@endif
