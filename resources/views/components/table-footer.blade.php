@props(['count' => 0, 'label' => null])
<div class="users-footer">
    <span class="range-chip"><i class="dot"></i> <span {{ $attributes->only('data-users-range') }}>1-{{ $count }} de {{ $count }}</span></span>
    @if($label)<span class="footer-note">{{ $label }}</span>@endif
    <div class="rows-per-page"><label>Filas:<select><option>10</option><option>25</option><option>50</option></select></label></div>
    <div class="users-pagination">
        <button class="icon-button" type="button" disabled aria-label="Anterior"><i data-lucide="chevron-left"></i></button>
        <button class="page-number is-active" type="button">1</button>
        <button class="icon-button" type="button" disabled aria-label="Siguiente"><i data-lucide="chevron-right"></i></button>
    </div>
</div>
