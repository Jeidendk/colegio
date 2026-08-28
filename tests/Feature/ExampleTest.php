<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    public function test_home_redirects_to_the_admin_dashboard(): void
    {
        $this->get('/')->assertRedirect('/admin/dashboard');
    }

    public function test_every_role_has_a_public_hardcoded_home(): void
    {
        $pages = [
            '/admin/dashboard' => 'Bienvenida, Andrea',
            '/docente/dashboard' => 'Hola, Roberto',
            '/estudiante/aula-virtual' => '¡Hola, Juan Carlos!',
            '/representante/resumen' => 'Hola, Ana Lucía',
        ];

        foreach ($pages as $url => $text) {
            $this->get($url)->assertOk()->assertSee($text);
        }
    }

    public function test_technician_role_was_removed(): void
    {
        $this->get('/tecnico/dashboard')->assertNotFound();
    }

    public function test_unknown_role_page_returns_not_found(): void
    {
        $this->get('/docente/inventario')->assertNotFound();
    }

    public function test_every_demo_page_renders_without_a_database(): void
    {
        $pages = [
            'admin' => ['dashboard', 'tramites', 'horarios', 'activos', 'infraestructura', 'estructura-academica', 'recursos', 'formatos', 'usuarios', 'reportes'],
            'docente' => ['dashboard', 'aula-virtual', 'horario', 'cursos', 'calificaciones', 'recursos', 'estudiantes', 'comunicaciones'],
            'estudiante' => ['aula-virtual', 'catalogo', 'solicitudes', 'horarios', 'mapa', 'recursos'],
            'representante' => ['resumen', 'rendimiento', 'horario', 'solicitudes', 'comunicaciones'],
        ];

        foreach ($pages as $role => $rolePages) {
            foreach ($rolePages as $page) {
                $this->get("/{$role}/{$page}")->assertOk();
            }
        }
    }

    public function test_virtual_classroom_connected_screens_render(): void
    {
        $screens = [
            '/estudiante/aula-virtual' => 'Continúa aprendiendo',
            '/estudiante/aula-virtual?vista=area' => 'Próximas actividades',
            '/estudiante/aula-virtual?vista=cursos' => 'Mis cursos',
            '/estudiante/aula-virtual?vista=calendario' => 'Calendario académico',
            '/estudiante/aula-virtual?vista=calificaciones' => 'Resumen de resultados por curso',
            '/estudiante/aula-virtual?curso=sistemas-potencia' => 'Módulos de aprendizaje',
            '/docente/aula-virtual' => 'Administra tus cursos',
        ];

        foreach ($screens as $url => $text) {
            $this->get($url)->assertOk()->assertSee($text);
        }
    }
}
