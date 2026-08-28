<div class="virtual-page-heading calendar-heading"><div><h1>Calendario académico</h1><p>Actividades, entregas y eventos de todos tus cursos.</p></div><button class="pill-button solid" type="button" data-modal-open="calendar-event-modal"><i data-lucide="plus"></i> Nuevo evento</button></div>

<section class="panel virtual-calendar">
    <div class="calendar-toolbar"><button class="icon-button" data-calendar-prev><i data-lucide="chevron-left"></i></button><h2 data-calendar-title>Agosto 2026</h2><button class="icon-button" data-calendar-next><i data-lucide="chevron-right"></i></button><button class="secondary-button" data-calendar-today>Hoy</button><select class="select-control"><option>Todos los cursos</option><option>Matemática</option><option>Lengua y Literatura</option><option>Ciencias Naturales</option></select></div>
    <div class="month-grid">
        @foreach(['Lunes','Martes','Miércoles','Jueves','Viernes','Sábado','Domingo'] as $dayName)<div class="month-head">{{ $dayName }}</div>@endforeach
        @foreach([27,28,29,30,31] as $previous)<div class="month-cell is-muted"><b>{{ $previous }}</b></div>@endforeach
        @foreach(range(1,30) as $calendarDay)<div class="month-cell {{ $calendarDay===27 ? 'is-today' : '' }}"><b>{{ $calendarDay }}</b>@if($calendarDay===27)<button class="calendar-event red" data-toast="Encuentro virtual · Matemática">Clase virtual · Proporciones</button>@elseif($calendarDay===28)<button class="calendar-event blue" data-toast="Entrega de relato">Entrega · Relato oral</button>@endif</div>@endforeach
        <div class="month-cell"><b>31</b><button class="calendar-event amber" data-modal-open="calendar-detail-modal">Reto · Racionales</button></div>
        @foreach(range(1,6) as $nextMonthDay)<div class="month-cell is-muted"><b>{{ $nextMonthDay }}</b></div>@endforeach
    </div>
    <div class="calendar-legend"><span><i class="dot danger"></i> Clases</span><span><i class="dot class-normal"></i> Entregas</span><span><i class="dot warning"></i> Evaluaciones</span></div>
</section>

<div class="modal" id="calendar-detail-modal" aria-hidden="true"><div class="modal-card"><button class="modal-close" data-modal-close>×</button><small class="modal-kicker">31 DE AGOSTO · 23:59</small><h2>Reto: números racionales</h2><p class="modal-copy">Actividad práctica de la Unidad 1 del curso Matemática.</p><a class="pill-button solid" href="{{ route('portal',['role'=>$role,'page'=>'aula-virtual','curso'=>'matematica-octavo']) }}">Ir a la actividad</a></div></div>
<div class="modal" id="calendar-event-modal" aria-hidden="true"><form class="modal-card demo-form" data-demo-form><button class="modal-close" data-modal-close>×</button><h2>Crear evento personal</h2><label>Título<input required placeholder="Nombre del evento"></label><div class="form-grid"><label>Fecha<input type="date" value="2026-08-31"></label><label>Hora<input type="time" value="18:00"></label></div><label>Descripción<textarea placeholder="Notas adicionales"></textarea></label><button class="primary-button dark" type="submit">Guardar evento</button></form></div>
