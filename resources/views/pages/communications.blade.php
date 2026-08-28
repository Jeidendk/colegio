@php
    $canBroadcast = in_array($role, ['admin', 'docente'], true);
    $sentMessages = [
        ['type' => 'Curso', 'title' => 'Recordatorio: entrega de la actividad 05', 'text' => 'Enviado a Matemática · 8.º EGB · Paralelo A.', 'date' => 'Hoy'],
        ['type' => 'Representantes', 'title' => 'Convocatoria a reunión de padres', 'text' => 'Enviado a 28 representantes del paralelo A.', 'date' => 'Ayer'],
    ];
@endphp

<x-hero icon="messages-square" title="Comunicaciones" subtitle="Avisos, mensajes y novedades de la comunidad académica."
    :stats="[['Nuevos', '2', 'sin leer'], ['Avisos', '8', 'este mes'], ['Enviados', count($sentMessages), 'este periodo'], ['Reuniones', '1', 'programada']]">
    @if($canBroadcast)
        <button class="hero-button" type="button" data-modal-open="message-modal"><i data-lucide="plus"></i> Nuevo aviso</button>
    @endif
</x-hero>

<div class="communications-layout">
    <section class="panel inbox-list">
        <div class="panel-header">
            <div><small>BANDEJA</small><h2>Mensajes</h2></div>
            <button class="row-action" type="button" title="Marcar todo como leído" data-toast="Todos los mensajes marcados como leídos"><i data-lucide="check-check"></i></button>
        </div>

        <div class="segmented compact" data-tabs>
            <button class="is-active" type="button" data-tab="inbox">Recibidos</button>
            <button type="button" data-tab="sent">Enviados</button>
        </div>

        <label class="search-field"><i data-lucide="search"></i><input type="search" placeholder="Buscar mensaje o remitente..." data-table-search></label>

        <div data-tab-panel="inbox">
            @foreach($notices as $index => $notice)
                <button class="message-row {{ $index === 0 ? 'is-active' : '' }}" type="button" data-search-row
                    data-message-title="{{ $notice['title'] }}" data-message-text="{{ $notice['text'] }}" data-message-type="{{ $notice['type'] }}">
                    <span class="avatar small">{{ substr($notice['type'], 0, 2) }}</span>
                    <div>
                        <span><b>{{ $notice['title'] }}</b><small>{{ $notice['date'] }}</small></span>
                        <p>{{ $notice['text'] }}</p>
                    </div>
                </button>
            @endforeach
        </div>

        <div class="hidden" data-tab-panel="sent">
            @foreach($sentMessages as $message)
                <button class="message-row" type="button" data-search-row
                    data-message-title="{{ $message['title'] }}" data-message-text="{{ $message['text'] }}" data-message-type="{{ $message['type'] }}">
                    <span class="avatar small">{{ substr($message['type'], 0, 2) }}</span>
                    <div>
                        <span><b>{{ $message['title'] }}</b><small>{{ $message['date'] }}</small></span>
                        <p>{{ $message['text'] }}</p>
                    </div>
                </button>
            @endforeach
        </div>
    </section>

    <section class="panel message-detail">
        <div class="message-detail-head">
            <span class="notice-icon large"><i data-lucide="mail-open"></i></span>
            <div class="row-actions">
                <button class="row-action" type="button" title="Archivar" data-toast="Mensaje archivado"><i data-lucide="archive"></i></button>
                <button class="row-action danger" type="button" title="Eliminar" data-toast="Mensaje eliminado en la demostración"><i data-lucide="trash-2"></i></button>
            </div>
        </div>

        <small data-message-type>ACADÉMICO</small>
        <h2 data-message-title>Reunión de seguimiento del periodo</h2>
        <p data-message-text>Miércoles 2 de septiembre, 16:00 · Sala de reuniones Montessori.</p>

        <div class="message-note">
            <b>Estimada comunidad:</b>
            <p>Les recordamos revisar el calendario académico y mantener actualizados los datos de contacto. Esta es una comunicación de demostración.</p>
        </div>

        <form class="reply-form" data-demo-form>
            <label>Responder<textarea required placeholder="Escribe tu respuesta..."></textarea></label>
            <div class="reply-actions">
                <label class="file-chip">
                    <i data-lucide="paperclip"></i> Adjuntar
                    <input type="file">
                </label>
                <button class="pill-button" type="button" data-toast="Borrador guardado">Guardar borrador</button>
                <button class="pill-button solid" type="submit"><i data-lucide="send"></i> Enviar respuesta</button>
            </div>
        </form>
    </section>
</div>

@if($canBroadcast)
    <div class="modal" id="message-modal" aria-hidden="true">
        <form class="modal-card demo-form" data-demo-form>
            <button class="modal-close" type="button" data-modal-close aria-label="Cerrar">×</button>
            <small>COMUNICACIONES</small>
            <h2>Nuevo aviso</h2>
            <div class="form-grid">
                <label>Destinatarios<select><option>Todos mis estudiantes</option><option>Representantes</option><option>Curso específico</option><option>Docentes</option></select></label>
                <label>Prioridad<select><option>Normal</option><option>Alta</option></select></label>
            </div>
            <label>Curso o paralelo<select><option>Todos</option>@foreach($courses as $course)<option>{{ $course['name'] }} · {{ $course['parallel'] }}</option>@endforeach</select></label>
            <label>Asunto<input required placeholder="Asunto del aviso"></label>
            <label>Mensaje<textarea required placeholder="Escribe el aviso"></textarea></label>
            <label class="file-drop">
                <i data-lucide="paperclip"></i>
                <span><b>Adjuntar archivo</b><small>PDF, DOCX o imagen · opcional</small></span>
                <input type="file">
            </label>
            <label class="check-inline"><input type="checkbox" checked> Enviar copia al correo institucional</label>
            <div class="modal-actions">
                <button class="secondary-button" type="button" data-modal-close>Cancelar</button>
                <button class="primary-button dark" type="submit">Enviar aviso</button>
            </div>
        </form>
    </div>
@endif
