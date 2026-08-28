<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Acceso demostrativo a la plataforma académica de la Unidad Educativa Particular Montessori.">
    <title>Iniciar sesión · Unidad Educativa Montessori</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&family=Playfair+Display:wght@700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <script src="https://unpkg.com/lucide@0.468.0/dist/umd/lucide.min.js" defer></script>
    <script src="{{ asset('js/login.js') }}" defer></script>
</head>
<body>
<main class="school-login">
    <section class="school-login-panel" aria-labelledby="login-title">
        <img class="school-login-logo" src="{{ asset('img/montessori-logo.png') }}" alt="Unidad Educativa Montessori">

        <div class="school-brand-divider"><span></span><i data-lucide="star"></i><span></span></div>
        <p class="school-login-kicker">PLATAFORMA ACADÉMICA</p>
        <h1 id="login-title">Hola, bienvenido a Colegio Montessori</h1>
        <p class="school-login-subtitle">Ingrese sus datos para iniciar sesión en su cuenta</p>

        <form class="school-login-form" action="{{ route('portal', ['role' => 'admin', 'page' => 'dashboard']) }}" method="get" data-login-demo>
            <label>
                <span>Nombre de usuario</span>
                <div class="school-input"><i data-lucide="user-round"></i><input name="usuario" autocomplete="username" placeholder="Nombre de usuario" value="administrador"></div>
            </label>
            <label>
                <span>Contraseña</span>
                <div class="school-input"><i data-lucide="lock-keyhole"></i><input name="clave" type="password" autocomplete="current-password" placeholder="Contraseña" value="montessori2026" data-login-password><button type="button" data-toggle-password aria-label="Mostrar contraseña"><i data-lucide="eye"></i></button></div>
            </label>
            <button class="school-forgot" type="button" data-login-help>¿Olvidó su contraseña?</button>
            <button class="school-login-submit" type="submit"><span>Iniciar sesión</span><i data-lucide="arrow-right"></i></button>
        </form>

        <div class="school-login-note"><i data-lucide="shield-check"></i><span><b>Acceso demostrativo</b><small>No se validan ni almacenan credenciales.</small></span></div>
        <p class="school-login-footer">Unidad Educativa Particular Montessori · Guayaquil</p>
    </section>

    <section class="school-login-visual" aria-label="Comunidad educativa Montessori">
        <div class="school-login-visual-copy"><span>EDUCACIÓN PARA LA VIDA</span><h2>Desarrollando<br>potencialidades</h2><p>Formación integral, pensamiento crítico y aprendizaje con responsabilidad social.</p><div><i data-lucide="sparkles"></i> Aprender · Crear · Convivir</div></div>
    </section>
</main>
<div class="school-login-toast" role="status" aria-live="polite">Comuníquese con Secretaría para recuperar su acceso.</div>
</body>
</html>
