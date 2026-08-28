@php
    $careers = [
        ['name' => 'Ingeniería en Electricidad', 'icon' => 'zap', 'paos' => 9, 'subjects' => 48, 'director' => 'Ing. Roberto Sánchez', 'color' => '#2563eb'],
        ['name' => 'Electrónica y Automatización', 'icon' => 'cpu', 'paos' => 9, 'subjects' => 45, 'director' => 'Ing. Patricia Morales', 'color' => '#0d9488'],
        ['name' => 'Telecomunicaciones', 'icon' => 'radio-tower', 'paos' => 8, 'subjects' => 42, 'director' => 'Ing. Fernando Ruiz', 'color' => '#c026d3'],
    ];
    $curriculum = [
        ['ELEC-501', 'Sistemas Eléctricos de Potencia', 4, 64],
        ['ELEC-502', 'Máquinas Eléctricas II', 4, 64],
        ['ELEC-503', 'Electrónica de Potencia', 3, 48],
        ['ELEC-504', 'Análisis de Señales', 3, 48],
        ['ELEC-505', 'Control Automático', 4, 64],
        ['ELEC-506', 'Instalaciones Eléctricas', 3, 48],
    ];
    $totalCredits = array_sum(array_column($curriculum, 2));
@endphp

<x-hero icon="landmark" title="Estructura académica" subtitle="Gestión de facultades, carreras y malla curricular."
    :stats="[['Facultades', '1', 'FIE'], ['Carreras', count($careers), 'activas'], ['Materias', '135', 'registradas'], ['PAOs', '9', 'Electricidad']]">
    <button class="hero-button" type="button" data-modal-open="career-modal"><i data-lucide="plus"></i> Nueva carrera</button>
</x-hero>

<div class="academic-layout">
    <section class="panel academic-tree">
        <div class="panel-header">
            <div><small>ORGANIZACIÓN</small><h2>Facultades y carreras</h2></div>
            <button class="row-action" type="button" title="Nueva facultad" data-modal-open="faculty-modal"><i data-lucide="plus"></i></button>
        </div>

        <label class="search-field"><i data-lucide="search"></i><input type="search" placeholder="Buscar facultad o carrera..." data-table-search></label>

        <button class="tree-root is-active" type="button">
            <i data-lucide="landmark"></i>
            <span><b>FIE</b><small>Informática y Electrónica</small></span>
        </button>

        <div class="tree-children">
            @foreach($careers as $index => $career)
                <button class="{{ $index === 0 ? 'is-active' : '' }}" type="button" data-search-row>
                    <i data-lucide="{{ $career['icon'] }}" style="color: {{ $career['color'] }}"></i>
                    <span><b>{{ $career['name'] }}</b><small>{{ $career['paos'] }} PAOs · {{ $career['subjects'] }} materias</small></span>
                </button>
            @endforeach
        </div>

        <div class="faculty-card">
            <small>FACULTAD SELECCIONADA</small>
            <div><i data-lucide="user-round"></i> Decano/a <b>Dra. Andrea López</b></div>
            <div><i data-lucide="graduation-cap"></i> Carreras <b>{{ count($careers) }}</b></div>
            <div class="row-actions">
                <button class="secondary-button" type="button" data-modal-open="faculty-modal"><i data-lucide="pencil"></i> Editar facultad</button>
            </div>
        </div>
    </section>

    <section class="panel curriculum">
        <div class="panel-header">
            <div><small>INGENIERÍA EN ELECTRICIDAD</small><h2>Malla curricular · 9 PAOs</h2></div>
            <div class="row-actions">
                <button class="secondary-button" type="button" data-modal-open="career-modal"><i data-lucide="pencil"></i> Editar carrera</button>
                <button class="primary-button" type="button" data-modal-open="subject-modal"><i data-lucide="plus"></i> Nueva materia</button>
            </div>
        </div>

        <div class="career-banner">
            <span class="career-mark" style="background:#2563eb"><i data-lucide="zap"></i></span>
            <div>
                <b>Ingeniería en Electricidad</b>
                <small>Facultad de Informática y Electrónica · Malla de 9 PAOs · Dir. Ing. Roberto Sánchez</small>
            </div>
            <span class="career-credits">{{ $totalCredits }} créditos en este PAO</span>
        </div>

        <div class="curriculum-toolbar">
            <div class="semester-tabs segmented">
                @for($pao = 1; $pao <= 9; $pao++)
                    <button class="{{ $pao === 5 ? 'is-active' : '' }}" type="button" data-semester="{{ $pao }}">{{ $pao }}.º</button>
                @endfor
            </div>
            <label class="search-field"><i data-lucide="search"></i><input type="search" placeholder="Buscar materia..." data-table-search></label>
        </div>

        <div class="subject-grid">
            @foreach($curriculum as $subject)
                <article data-search-row>
                    <span>{{ $subject[0] }}</span>
                    <h3>{{ $subject[1] }}</h3>
                    <p>{{ $subject[2] }} créditos · {{ $subject[3] }} horas</p>
                    <div class="row-actions">
                        <button class="row-action" type="button" title="Editar" data-modal-open="subject-modal"><i data-lucide="pencil"></i></button>
                        <button class="row-action danger" type="button" title="Eliminar" data-toast="{{ $subject[1] }} eliminada en la demostración"><i data-lucide="trash-2"></i></button>
                    </div>
                </article>
            @endforeach
        </div>

        <div class="panel-footer">
            <span><i data-lucide="info"></i> {{ count($curriculum) }} materias en el 5.º PAO · {{ $totalCredits }} créditos.</span>
            <button class="secondary-button" type="button" data-toast="Malla exportada en la demostración"><i data-lucide="download"></i> Exportar malla</button>
        </div>
    </section>
</div>

<div class="modal" id="faculty-modal" aria-hidden="true">
    <form class="modal-card demo-form" data-demo-form>
        <button class="modal-close" type="button" data-modal-close aria-label="Cerrar">×</button>
        <small>ESTRUCTURA ACADÉMICA</small>
        <h2>Nueva facultad</h2>
        <label>Nombre<input required placeholder="Facultad de..."></label>
        <div class="form-grid">
            <label>Siglas<input placeholder="Ej: FIE"></label>
            <label>Estado<select><option>Activa</option><option>Inactiva</option></select></label>
        </div>
        <label>Decano/a actual<input placeholder="Nombre del Decano"></label>
        <label class="file-drop">
            <i data-lucide="image-plus"></i>
            <span><b>Ícono o logotipo</b><small>SVG o PNG · fondo transparente</small></span>
            <input type="file" accept="image/svg+xml,image/png">
        </label>
        <div class="modal-actions">
            <button class="secondary-button" type="button" data-modal-close>Cancelar</button>
            <button class="primary-button" type="submit">Guardar facultad</button>
        </div>
    </form>
</div>

<div class="modal" id="career-modal" aria-hidden="true">
    <form class="modal-card demo-form" data-demo-form>
        <button class="modal-close" type="button" data-modal-close aria-label="Cerrar">×</button>
        <small>CARRERAS</small>
        <h2>Nueva carrera</h2>
        <label>Nombre<input required placeholder="Ej: Ingeniería de Software"></label>
        <div class="form-grid">
            <label>Facultad<select><option>FIE · Informática y Electrónica</option></select></label>
            <label>N° PAO<input type="number" min="1" max="12" value="9"></label>
        </div>
        <div class="form-grid">
            <label>Director/a de carrera<input placeholder="Ing. Nombre Apellido"></label>
            <label>Estado<select><option>Activa</option><option>Inactiva</option></select></label>
        </div>
        <div class="form-grid">
            <label>Color hexadecimal<input type="color" value="#2563eb"></label>
            <label>Ícono representativo<select><option>Electricidad</option><option>Electrónica</option><option>Telecomunicaciones</option><option>Software</option></select></label>
        </div>
        <label class="file-drop">
            <i data-lucide="image-plus"></i>
            <span><b>Ícono o logotipo</b><small>SVG o PNG · se usa en la grilla de horarios</small></span>
            <input type="file" accept="image/svg+xml,image/png">
        </label>
        <div class="modal-actions">
            <button class="secondary-button" type="button" data-modal-close>Cancelar</button>
            <button class="primary-button" type="submit">Guardar carrera</button>
        </div>
    </form>
</div>

<div class="modal" id="subject-modal" aria-hidden="true">
    <form class="modal-card demo-form" data-demo-form>
        <button class="modal-close" type="button" data-modal-close aria-label="Cerrar">×</button>
        <small>MALLA CURRICULAR</small>
        <h2>Nueva materia</h2>
        <label>Nombre de la materia<input required placeholder="Ej. Sistemas Distribuidos"></label>
        <div class="form-grid">
            <label>Código<input placeholder="Ej. SW-401"></label>
            <label>PAO<select>@for($pao = 1; $pao <= 9; $pao++)<option @selected($pao === 5)>{{ $pao }}.º</option>@endfor</select></label>
        </div>
        <div class="form-grid">
            <label>Créditos<input type="number" min="1" max="8" value="3"></label>
            <label>Horas<input type="number" min="8" step="8" value="48"></label>
        </div>
        <label>Carrera<select>@foreach($careers as $career)<option>{{ $career['name'] }}</option>@endforeach</select></label>
        <div class="modal-actions">
            <button class="secondary-button" type="button" data-modal-close>Cancelar</button>
            <button class="primary-button" type="submit">Guardar materia</button>
        </div>
    </form>
</div>
