@php
    $faculty = $academic['faculty'];
    $careers = $academic['careers'];
    $curriculum = $academic['curriculum'];
    $totalSubjects = array_sum(array_column($careers, 'subjects'));
@endphp

<section class="infra-hero academic-hero">
    <div class="infra-hero-title">
        <span><i data-lucide="{{ $faculty['icon'] }}"></i></span>
        <div><h1>{{ $faculty['name'] }}</h1><p>Institución · {{ count($careers) }} niveles educativos</p></div>
    </div>

    <div class="infra-hero-stats">
        <div><i data-lucide="graduation-cap"></i><span><strong>{{ count($careers) }}</strong><small>Niveles</small></span></div>
        <div><i data-lucide="layers"></i><span><strong>{{ $totalSubjects }}</strong><small>Materias</small></span></div>
        <div><i data-lucide="file-text"></i><span><strong>0</strong><small>Sílabos</small></span></div>
    </div>
</section>

<div class="infra-layout">
    <aside class="panel infra-tree academic-tree">
        <div class="infra-tree-head">
            <h2>Institución y niveles</h2>
            <button class="round-button small" type="button" title="Editar institución" data-modal-open="faculty-modal"><i data-lucide="plus"></i></button>
        </div>

        <label class="search-field"><i data-lucide="search"></i><input type="search" placeholder="Buscar institución o nivel..." data-tree-search></label>

        <div class="infra-tree-list">
            <div class="tree-building is-open" data-tree-building data-building-name="{{ mb_strtolower($faculty['acronym'].' '.$faculty['name']) }}">
                <button class="tree-building-head is-active" type="button" data-tree-toggle>
                    <i class="tree-chevron" data-lucide="chevron-down"></i>
                    <span class="faculty-dot" style="background: {{ $faculty['color'] }}"></span>
                    <b>{{ $faculty['acronym'] }}</b>
                    <span class="tree-count">{{ count($careers) }}</span>
                    <span class="tree-add" role="button" tabindex="0" title="Nuevo nivel" data-modal-open="career-modal"><i data-lucide="plus"></i></span>
                </button>

                <ul class="career-tree">
                    @foreach($careers as $career)
                        <li data-tree-space data-space-name="{{ mb_strtolower($career['name']) }}">
                            <button type="button" data-career-link="{{ $career['slug'] }}" data-career-title="{{ $career['name'] }}" data-career-subjects="{{ $career['subjects'] }}">
                                <span class="career-mark-sm" style="background: {{ $career['color'] }}1a; color: {{ $career['color'] }}"><i data-lucide="{{ $career['icon'] }}"></i></span>
                                <span class="career-tree-name">{{ $career['name'] }}</span>
                            </button>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        <div class="tree-summary">
            <span><i data-lucide="layers"></i></span>
            <div><b>1 institución · {{ count($careers) }} niveles</b><small>Estructura académica</small></div>
        </div>
    </aside>

    <section class="infra-detail">
        <article class="panel faculty-card">
            <span class="faculty-mark" style="background: {{ $faculty['color'] }}1a; color: {{ $faculty['color'] }}"><i data-lucide="{{ $faculty['icon'] }}"></i></span>
            <div class="faculty-identity">
                <h2>{{ $faculty['name'] }} <x-badge :value="$faculty['status']" /></h2>
                <p>{{ $faculty['acronym'] }} · Rector: {{ $faculty['dean'] }} · {{ count($careers) }} niveles</p>
            </div>
            <div class="building-actions">
                <button class="pill-button" type="button" data-modal-open="faculty-modal"><i data-lucide="pencil"></i> Editar institución</button>
                <button class="pill-button danger" type="button" data-toast="La institución se eliminaría en la demostración"><i data-lucide="trash-2"></i> Eliminar</button>
            </div>
        </article>

        <section class="panel careers-panel" data-careers-panel>
            <div class="toolbar careers-toolbar">
                <h2 class="careers-title">Niveles educativos ({{ count($careers) }})</h2>
                <label class="search-field"><i data-lucide="search"></i><input type="search" placeholder="Buscar nivel..." data-career-search></label>

                <div class="segmented compact layout-switch">
                    <button class="is-active" type="button" data-career-layout="grid" title="Tarjetas"><i data-lucide="layout-grid"></i></button>
                    <button type="button" data-career-layout="list" title="Lista"><i data-lucide="list"></i></button>
                </div>

                <button class="pill-button solid" type="button" data-modal-open="career-modal"><i data-lucide="plus"></i> Nuevo nivel</button>
            </div>

            <div class="career-cards" data-career-cards>
                @foreach($careers as $career)
                    <article class="career-card" data-career-item data-career-name="{{ mb_strtolower($career['name']) }}" style="--career-color: {{ $career['color'] }}">
                        <div class="career-card-head">
                            <span class="career-mark-lg" style="background: {{ $career['color'] }}1a; color: {{ $career['color'] }}"><i data-lucide="{{ $career['icon'] }}"></i></span>
                            <x-badge :value="$career['status']" />
                        </div>
                        <h3>{{ $career['name'] }}</h3>
                        <p>Director/a: {{ $career['director'] }}</p>
                        <div class="career-card-foot">
                            <span><i data-lucide="layers"></i> {{ $career['paos'] }} grados</span>
                            <span><i data-lucide="book-open"></i> {{ $career['subjects'] }} materias</span>
                            <button class="row-action" type="button" title="Ver malla curricular" data-career-link="{{ $career['slug'] }}" data-career-title="{{ $career['name'] }}" data-career-subjects="{{ $career['subjects'] }}"><i data-lucide="chevron-right"></i></button>
                        </div>
                    </article>
                @endforeach
            </div>

            <p class="empty-state hidden" data-careers-empty><i data-lucide="search-x"></i> Ningún nivel coincide con la búsqueda.</p>
        </section>

        <section class="panel curriculum-panel hidden" data-curriculum-panel>
            <div class="panel-header">
                <div>
                    <button class="text-button" type="button" data-curriculum-back><i data-lucide="arrow-left"></i> Volver a niveles</button>
                    <h2 data-curriculum-title>Malla curricular</h2>
                </div>
                <div class="row-actions">
                    <button class="pill-button" type="button" data-modal-open="career-modal"><i data-lucide="pencil"></i> Editar nivel</button>
                    <button class="pill-button solid" type="button" data-modal-open="subject-modal"><i data-lucide="plus"></i> Nueva materia</button>
                </div>
            </div>

            <div class="curriculum-toolbar">
                <div class="semester-tabs segmented" data-pao-tabs>
                    @for($pao = 1; $pao <= 9; $pao++)
                        <button class="{{ $pao === 1 ? 'is-active' : '' }}" type="button" data-pao="{{ $pao }}">{{ $pao }}.º</button>
                    @endfor
                </div>
                <label class="search-field"><i data-lucide="search"></i><input type="search" placeholder="Buscar materia..." data-subject-search></label>
            </div>

            @foreach($careers as $career)
                <div class="subject-grid hidden" data-curriculum-for="{{ $career['slug'] }}">
                    @foreach($curriculum[$career['slug']] ?? [] as $subject)
                        <article data-subject data-pao="{{ $subject['pao'] }}" data-subject-name="{{ mb_strtolower($subject['name'].' '.$subject['code']) }}">
                            <span>{{ $subject['code'] }}</span>
                            <h3>{{ $subject['name'] }}</h3>
                            <p>{{ $subject['credits'] }} créditos · {{ $subject['hours'] }} horas</p>
                            <div class="row-actions">
                                <button class="row-action" type="button" title="Editar" data-modal-open="subject-modal"><i data-lucide="pencil"></i></button>
                                <button class="row-action danger" type="button" title="Eliminar" data-toast="{{ $subject['name'] }} eliminada en la demostración"><i data-lucide="trash-2"></i></button>
                            </div>
                        </article>
                    @endforeach
                </div>
            @endforeach

            <p class="empty-state hidden" data-curriculum-empty><i data-lucide="book-dashed"></i> <span data-curriculum-empty-text>Este nivel todavía no tiene asignaturas registradas.</span></p>

            <div class="panel-footer">
                <span><i data-lucide="info"></i> <span data-curriculum-summary></span></span>
                <button class="pill-button" type="button" data-toast="Malla exportada en la demostración"><i data-lucide="download"></i> Exportar malla</button>
            </div>
        </section>
    </section>
</div>

<div class="modal" id="faculty-modal" aria-hidden="true">
    <form class="modal-card demo-form identity-modal" data-demo-form>
        <div class="identity-modal-head">
            <span class="identity-icon"><i data-lucide="building-2"></i></span>
            <div><h2>Editar institución</h2><p>Actualiza los datos institucionales</p></div>
            <button class="modal-close" type="button" data-modal-close aria-label="Cerrar">×</button>
        </div>

        <div class="form-grid">
            <label class="export-field">Siglas <em>*</em><input required placeholder="Ej: UEM" value="UEM"></label>
            <label class="export-field">Estado<select><option>Activa</option><option>Inactiva</option></select></label>
        </div>

        <label class="export-field">Nombre completo <em>*</em><input required placeholder="Unidad Educativa..." value="Unidad Educativa Montessori"></label>
        <label class="export-field">Decano/a actual<input placeholder="Nombre del Decano"></label>

        <div class="identity-section">
            <span class="section-label">Diseño corporativo</span>

            <label class="export-field">Color hexadecimal
                <span class="color-field">
                    <input type="color" value="{{ $academic['palette'][1] }}" data-color-input>
                    <input type="text" value="{{ $academic['palette'][1] }}" data-color-text>
                </span>
            </label>

            <div class="color-swatches" data-color-swatches>
                @foreach($academic['palette'] as $color)
                    <button type="button" style="background: {{ $color }}" data-color="{{ $color }}" title="{{ $color }}"></button>
                @endforeach
            </div>

            <span class="field-label">Ícono o logotipo SVG</span>
            <div class="icon-picker icon-grid" data-icon-picker>
                @foreach($academic['icons'] as $index => $icon)
                    <button class="{{ $index === count($academic['icons']) - 1 ? 'is-active' : '' }}" type="button" data-icon="{{ $icon }}"><i data-lucide="{{ $icon }}"></i></button>
                @endforeach
            </div>

            <label class="upload-button">
                <i data-lucide="upload"></i> Subir SVG personalizado
                <input type="file" accept="image/svg+xml">
            </label>
        </div>

        <div class="modal-actions">
            <button class="secondary-button" type="button" data-modal-close>Cancelar</button>
            <button class="primary-button dark" type="submit">Guardar institución</button>
        </div>
    </form>
</div>

<div class="modal" id="career-modal" aria-hidden="true">
    <form class="modal-card demo-form identity-modal" data-demo-form>
        <div class="identity-modal-head">
            <span class="identity-icon"><i data-lucide="book-open"></i></span>
            <div><h2>Nuevo nivel educativo</h2><p>Asignación e identidad visual</p></div>
            <button class="modal-close" type="button" data-modal-close aria-label="Cerrar">×</button>
        </div>

        <label class="export-field">Institución a la que pertenece <em>*</em>
            <select><option>{{ $faculty['name'] }}</option></select>
        </label>

        <label class="export-field">Nombre del nivel <em>*</em><input required placeholder="Ej: EGB Superior"></label>

        <div class="form-grid">
            <label class="export-field">N.º de grados<input type="number" min="1" max="10" value="3"></label>
            <label class="export-field">Estado<select><option>Activa</option><option>Inactiva</option></select></label>
        </div>

        <label class="export-field">Coordinador/a del nivel<input placeholder="Lcdo. Nombre Apellido"></label>

        <div class="identity-section">
            <span class="section-label">Diseño visual del nivel</span>
            <p class="section-note">Nota: el color ayuda a identificar el nivel dentro de la institución.</p>

            <label class="export-field">Color hexadecimal
                <span class="color-field">
                    <input type="color" value="{{ $academic['palette'][1] }}" data-color-input>
                    <input type="text" value="{{ $academic['palette'][1] }}" data-color-text>
                </span>
            </label>

            <div class="color-swatches" data-color-swatches>
                @foreach($academic['palette'] as $color)
                    <button type="button" style="background: {{ $color }}" data-color="{{ $color }}" title="{{ $color }}"></button>
                @endforeach
            </div>

            <span class="field-label">Ícono o logotipo (SVG, PNG)</span>
            <div class="icon-picker icon-grid" data-icon-picker>
                @foreach($academic['icons'] as $icon)
                    <button class="{{ $icon === 'book-open' ? 'is-active' : '' }}" type="button" data-icon="{{ $icon }}"><i data-lucide="{{ $icon }}"></i></button>
                @endforeach
            </div>

            <label class="upload-button">
                <i data-lucide="upload"></i> Subir imagen
                <input type="file" accept="image/svg+xml,image/png">
            </label>
        </div>

        <div class="modal-actions">
            <button class="secondary-button" type="button" data-modal-close>Cancelar</button>
            <button class="primary-button dark" type="submit">Crear nivel</button>
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
            <label>Grado<select>@for($pao = 1; $pao <= 10; $pao++)<option>{{ $pao }}.º</option>@endfor</select></label>
        </div>
        <div class="form-grid">
            <label>Créditos<input type="number" min="1" max="8" value="3"></label>
            <label>Horas<input type="number" min="8" step="8" value="48"></label>
        </div>
        <label>Nivel educativo<select>@foreach($careers as $career)<option>{{ $career['name'] }}</option>@endforeach</select></label>
        <div class="modal-actions">
            <button class="secondary-button" type="button" data-modal-close>Cancelar</button>
            <button class="primary-button" type="submit">Guardar materia</button>
        </div>
    </form>
</div>
