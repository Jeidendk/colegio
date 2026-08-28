@props(['value'])
@php
    $normalized = strtolower(str_replace(['á','é','í','ó','ú','ñ'], ['a','e','i','o','u','n'], $value));
    $tone = str_contains($normalized, 'apro') || in_array($normalized, ['activo','bueno','entregada'], true) ? 'success' : (str_contains($normalized, 'pend') || $normalized === 'malo' ? 'warning' : (str_contains($normalized, 'rech') || str_contains($normalized, 'dana') || $normalized === 'inactivo' ? 'danger' : 'info'));
@endphp
<span class="badge badge-{{ $tone }}">{{ $value }}</span>
