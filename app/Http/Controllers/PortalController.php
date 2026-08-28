<?php

namespace App\Http\Controllers;

use App\Support\DemoData;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

final class PortalController extends Controller
{
    private const DEFAULT_PAGES = ['admin' => 'dashboard', 'docente' => 'dashboard', 'estudiante' => 'aula-virtual', 'representante' => 'resumen'];

    private const PAGES = [
        'admin' => ['dashboard', 'tramites', 'horarios', 'aulas', 'activos', 'infraestructura', 'estructura-academica', 'recursos', 'formatos', 'usuarios', 'reportes'],
        'docente' => ['dashboard', 'aula-virtual', 'horario', 'recursos', 'comunicaciones'],
        'estudiante' => ['aula-virtual', 'catalogo', 'solicitudes', 'horarios', 'mapa', 'recursos'],
        'representante' => ['resumen', 'rendimiento', 'horario', 'solicitudes', 'comunicaciones'],
    ];

    public function __invoke(Request $request, string $role, ?string $page = null): View
    {
        $page ??= self::DEFAULT_PAGES[$role];
        abort_unless(in_array($page, self::PAGES[$role], true), 404);

        return view('portal', [
            ...DemoData::all(), 'role' => $role, 'page' => $page,
            'navigation' => self::navigation($role), 'pageMeta' => self::pageMeta($role, $page),
        ]);
    }

    private static function navigation(string $role): array
    {
        return match ($role) {
            'admin' => [
                ['dashboard', 'layout-dashboard', 'Dashboard'], ['tramites', 'inbox', 'Trámites'], ['horarios', 'calendar-days', 'Horarios'], ['aulas', 'monitor-play', 'Aulas virtuales'],
                ['activos', 'package', 'Activos'], ['infraestructura', 'building-2', 'Infraestructura'], ['estructura-academica', 'landmark', 'Estructura acad.'],
                ['recursos', 'library', 'Recursos'], ['formatos', 'file-text', 'Formatos'], ['usuarios', 'users', 'Usuarios'], ['reportes', 'bar-chart-3', 'Reportes'],
            ],
            'docente' => [
                ['dashboard', 'layout-dashboard', 'Dashboard'], ['aula-virtual', 'monitor-play', 'Aula virtual'], ['horario', 'calendar-days', 'Mi horario'], ['recursos', 'library', 'Recursos'],
                ['comunicaciones', 'messages-square', 'Comunicaciones'],
            ],
            'estudiante' => [
                ['aula-virtual', 'monitor-play', 'Aula virtual'], ['catalogo', 'package-search', 'Catálogo'], ['solicitudes', 'clipboard-list', 'Mis solicitudes'], ['horarios', 'calendar-days', 'Horarios'],
                ['mapa', 'map-pinned', 'Ubicaciones'], ['recursos', 'library', 'Recursos'],
            ],
            default => [
                ['resumen', 'layout-dashboard', 'Resumen'], ['rendimiento', 'chart-no-axes-column-increasing', 'Rendimiento'], ['horario', 'calendar-days', 'Horario'],
                ['solicitudes', 'clipboard-list', 'Solicitudes'], ['comunicaciones', 'messages-square', 'Comunicaciones'],
            ],
        };
    }

    private static function pageMeta(string $role, string $page): array
    {
        $meta = [
            'dashboard' => ['Inicio', 'Panel de control', 'Vista general de la comunidad educativa Montessori.'],
            'tramites' => ['Gestión', 'Trámites', 'Solicitudes y préstamos en una sola bandeja.'],
            'aulas' => ['Académico', 'Aulas virtuales', 'Creación de aulas y asignación de docentes.'],
            'horarios' => ['Académico', 'Horarios', 'Planificación de clases y uso de espacios.'], 'horario' => ['Académico', 'Mi horario', 'Agenda semanal de clases y actividades.'],
            'activos' => ['Recursos', 'Activos', 'Inventario, asignaciones y mantenimiento.'], 'infraestructura' => ['Campus', 'Infraestructura', 'Edificios, aulas y laboratorios.'],
            'estructura-academica' => ['Institución', 'Estructura académica', 'Niveles, grados y asignaturas de la institución.'],
            'recursos' => ['Académico', 'Recursos', 'Material didáctico y formatos disponibles.'], 'formatos' => ['Documentos', 'Formatos', 'Plantillas institucionales descargables.'],
            'usuarios' => ['Administración', 'Usuarios', 'Estudiantes, docentes y representantes.'], 'reportes' => ['Analítica', 'Reportes', 'Indicadores y métricas del sistema.'],
            'catalogo' => ['Préstamos', 'Catálogo de equipos', 'Explora los recursos disponibles para tus prácticas.'], 'solicitudes' => ['Préstamos', 'Mis solicitudes', 'Seguimiento de solicitudes y entregas.'],
            'aula-virtual' => ['Académico', 'Aula virtual', 'Cursos, actividades y calificaciones del periodo.'],
            'mapa' => ['Campus', 'Ubicaciones', 'Encuentra aulas, laboratorios y servicios.'], 'cursos' => ['Docencia', 'Mis cursos', 'Paralelos y grupos asignados en este periodo.'],
            'calificaciones' => ['Evaluación', 'Calificaciones', 'Registro demostrativo de notas por curso.'], 'estudiantes' => ['Docencia', 'Estudiantes', 'Seguimiento del avance académico.'],
            'comunicaciones' => ['Comunidad', 'Comunicaciones', 'Avisos y mensajes académicos.'], 'resumen' => ['Familia', 'Resumen del estudiante', 'Seguimiento académico de Juan Carlos Pérez.'],
            'rendimiento' => ['Académico', 'Rendimiento', 'Calificaciones, asistencia y evolución del periodo.'],
        ];

        if ($role === 'representante' && $page === 'solicitudes') {
            return ['Seguimiento', 'Solicitudes', 'Estado de los préstamos y recursos solicitados.'];
        }

        return $meta[$page];
    }
}
