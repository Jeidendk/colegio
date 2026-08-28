<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    public function test_home_redirects_to_the_login_screen(): void
    {
        $this->get('/')->assertRedirect('/login');
    }

    public function test_login_is_a_visual_demo_that_opens_the_dashboard(): void
    {
        $this->get('/login')
            ->assertOk()
            ->assertSee('Unidad Educativa Montessori')
            ->assertSee('Riobamba')
            ->assertSee('Iniciar sesión')
            ->assertSee('/admin/dashboard', false)
            ->assertSee('No se validan ni almacenan credenciales.');
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
            'docente' => ['dashboard', 'aula-virtual', 'horario', 'recursos', 'comunicaciones'],
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
            '/estudiante/aula-virtual?vista=calificaciones' => 'Resumen de resultados por materia',
            '/estudiante/aula-virtual?curso=matematica-octavo' => 'Sección de información',
            '/docente/aula-virtual' => 'Administra tus cursos',
            '/docente/aula-virtual?vista=cursos' => 'Mis cursos',
            '/docente/aula-virtual?vista=calificaciones' => 'Libro de calificaciones',
            '/docente/aula-virtual?vista=estudiantes' => 'Participantes de mis cursos',
        ];

        foreach ($screens as $url => $text) {
            $this->get($url)->assertOk()->assertSee($text);
        }
    }

    public function test_teacher_course_management_is_consolidated_in_virtual_classroom(): void
    {
        $this->get('/docente/aula-virtual?vista=cursos')
            ->assertOk()
            ->assertSee('Mis cursos')
            ->assertDontSee('class="detail-metrics"', false)
            ->assertSee('Administrar curso')
            ->assertSee('Solicitar nueva aula')
            ->assertSee('Buscar cursos...')
            ->assertSee('Ordenar por nombre del curso')
            ->assertSee('images.unsplash.com')
            ->assertSee('del aula preparada')
            ->assertDontSee('href="http://localhost/docente/cursos"', false);

        foreach (['area', 'calificaciones', 'estudiantes'] as $cleanView) {
            $this->get('/docente/aula-virtual?vista='.$cleanView)
                ->assertOk()
                ->assertDontSee('class="detail-metrics"', false)
                ->assertDontSee('class="virtual-stat-grid personal-stats"', false);
        }

        foreach (['cursos', 'calificaciones', 'estudiantes'] as $removedPage) {
            $this->get("/docente/{$removedPage}")->assertNotFound();
        }
    }

    public function test_student_course_library_has_eight_clickable_filtered_subjects(): void
    {
        $response = $this->get('/estudiante/aula-virtual?vista=cursos')
            ->assertOk()
            ->assertSee('Mis cursos')
            ->assertSee('Ordenar por nombre del curso')
            ->assertSee('Buscar cursos...')
            ->assertSee('Computación y Robótica')
            ->assertSee('Educación Física')
            ->assertDontSee('Continuar curso');

        $this->assertSame(8, substr_count($response->getContent(), 'class="student-course-card"'));
    }

    public function test_admin_transactions_screen_uses_the_adapted_workflow(): void
    {
        $this->get('/admin/tramites')
            ->assertOk()
            ->assertSee('Bandeja de oficios y reportes enviados por los estudiantes.')
            ->assertSee('Solicitudes')
            ->assertSee('Préstamos')
            ->assertSee('SOL-2026-041')
            ->assertSee('PRE-2026-018')
            ->assertSee('Importar solicitudes');
    }

    public function test_admin_schedule_includes_planner_and_spaces_map(): void
    {
        $this->get('/admin/horarios')
            ->assertOk()
            ->assertSee('Horario semestral')
            ->assertSee('Mapa de espacios')
            ->assertSee('Explorador de espacios')
            ->assertSee('Bloque de Educación Básica')
            ->assertSee('Aula 102')
            ->assertSee('spaces-leaflet-map')
            ->assertSee('images.unsplash.com')
            ->assertSee('Nueva clase');
    }

    public function test_admin_assets_screen_includes_inventory_workflows(): void
    {
        $this->get('/admin/activos')
            ->assertOk()
            ->assertSee('Equipos, herramientas, mobiliario y tecnología.')
            ->assertSee('Inventario')
            ->assertSee('Asignaciones')
            ->assertSee('Mantenimiento')
            ->assertSee('Microscopio binocular escolar')
            ->assertSee('Registrar ítem')
            ->assertSee('Subir foto');
    }
}
