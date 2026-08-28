<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Sistema académico ESPOCH Electricidad, demostración Laravel sin base de datos ni autenticación.">
    <title>{{ $pageMeta[1] }} · ESPOCH Electricidad</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @if($role === 'admin' && $page === 'horarios')
        <link rel="stylesheet" href="{{ asset('vendor/leaflet/leaflet.css') }}">
    @endif
    <script src="https://unpkg.com/lucide@0.468.0/dist/umd/lucide.min.js" defer></script>
    @if($role === 'admin' && $page === 'horarios')
        <script src="{{ asset('vendor/leaflet/leaflet.js') }}" defer></script>
    @endif
    <script src="{{ asset('js/app.js') }}" defer></script>
</head>
<body data-role="{{ $role }}" data-page="{{ $page }}">
@php
    $people = [
        'admin' => ['Dra. Andrea López', 'Administrador', 'AL'],
        'docente' => ['Ing. Roberto Sánchez', 'Docente', 'RS'],
        'estudiante' => [$student['name'], 'Estudiante', 'JP'],
        'representante' => ['Ana Lucía Pérez', 'Representante', 'AP'],
    ];
    $homes = ['admin' => 'dashboard', 'docente' => 'dashboard', 'estudiante' => 'aula-virtual', 'representante' => 'resumen'];
@endphp
<div class="app-shell">
    <div class="mobile-backdrop" data-close-sidebar></div>
    <aside class="sidebar" id="sidebar">
        <a class="brand" href="{{ route('portal', ['role' => $role, 'page' => $homes[$role]]) }}">
            <span class="brand-mark"><i data-lucide="graduation-cap"></i></span>
            <span><strong>ESPOCH</strong><small>ELECTRICIDAD</small></span>
        </a>

        <nav class="side-nav" aria-label="Navegación principal">
            @foreach($navigation as $item)
                <a class="side-link {{ $page === $item[0] ? 'is-active' : '' }}" href="{{ route('portal', ['role' => $role, 'page' => $item[0]]) }}">
                    <i data-lucide="{{ $item[1] }}"></i><span>{{ $item[2] }}</span>
                </a>
            @endforeach
        </nav>

        <div class="clock" aria-label="Reloj local">
            <strong data-clock>--:--</strong><span data-day>CARGANDO</span><small data-date>---</small>
        </div>
        <div class="demo-note"><i data-lucide="flask-conical"></i><span>Demostración<br><small>Datos locales no persistentes</small></span></div>
    </aside>

    <main class="main-shell">
        <header class="topbar">
            <button class="icon-button mobile-only" type="button" data-toggle-sidebar aria-label="Abrir menú"><i data-lucide="menu"></i></button>
            <div class="page-identity">
                <span class="page-icon"><i data-lucide="{{ $navigation[array_search($page, array_column($navigation, 0))][1] ?? 'layout-grid' }}"></i></span>
                <span><small>{{ $pageMeta[0] }} / <b>{{ $pageMeta[1] }}</b></small><strong>{{ $pageMeta[2] }}</strong></span>
            </div>
            <div class="top-actions">
                <button class="icon-button" type="button" data-theme-toggle aria-label="Cambiar tema"><i data-lucide="moon"></i></button>
                <button class="icon-button notification-button" type="button" data-toast="No tienes notificaciones nuevas" aria-label="Notificaciones"><i data-lucide="bell"></i><span></span></button>
                <div class="role-switcher">
                    <button class="profile-trigger" type="button" data-dropdown-toggle="profile-menu">
                        <span class="avatar">{{ $people[$role][2] }}</span>
                        <span class="profile-copy"><strong>{{ $people[$role][0] }}</strong><small>{{ $people[$role][1] }}</small></span>
                        <i data-lucide="chevron-down"></i>
                    </button>
                    <div class="dropdown" id="profile-menu">
                        <small class="dropdown-label">CAMBIAR VISTA</small>
                        @foreach(['admin' => 'Administrador', 'docente' => 'Docente', 'estudiante' => 'Estudiante', 'representante' => 'Representante'] as $roleKey => $label)
                            <a class="dropdown-item {{ $role === $roleKey ? 'is-current' : '' }}" href="{{ route('portal', ['role' => $roleKey, 'page' => $homes[$roleKey]]) }}">
                                <i data-lucide="{{ $roleKey === 'representante' ? 'heart-handshake' : ($roleKey === 'docente' ? 'presentation' : ($roleKey === 'estudiante' ? 'graduation-cap' : 'shield-check')) }}"></i>{{ $label }}
                            </a>
                        @endforeach
                        <button class="dropdown-item" type="button" data-modal-open="profile-modal"><i data-lucide="user-round"></i> Mi perfil</button>
                        <button class="dropdown-item" type="button" data-toast="Esta réplica no utiliza autenticación"><i data-lucide="log-out"></i> Salir de la demo</button>
                    </div>
                </div>
            </div>
        </header>

        <div class="workspace">
            @yield('content')
        </div>
    </main>
</div>

<div class="modal" id="profile-modal" aria-hidden="true">
    <div class="modal-card compact-modal">
        <button class="modal-close" type="button" data-modal-close aria-label="Cerrar">×</button>
        <div class="profile-large">{{ $people[$role][2] }}</div>
        <h2>{{ $people[$role][0] }}</h2>
        <p>{{ $people[$role][1] }} · ESPOCH Electricidad</p>
        <div class="info-strip"><i data-lucide="info"></i> Perfil demostrativo sin cuenta ni autenticación.</div>
    </div>
</div>
<div class="toast" role="status" aria-live="polite"></div>
</body>
</html>
