<?php

namespace App\Support;

final class DemoData
{
    public static function all(): array
    {
        return [
            'student' => [
                'name' => 'Juan Carlos Pérez López', 'firstName' => 'Juan Carlos', 'code' => '202145678',
                'career' => 'Ingeniería en Electricidad', 'semester' => '5.º PAO', 'period' => '2026-1',
                'average' => '8,74', 'attendance' => '94%',
            ],
            'catalog' => [
                ['id' => 'EQ001', 'serial' => 'MUL-1001', 'name' => 'Multímetro Digital Fluke 87V', 'category' => 'Herramientas', 'stock' => 8, 'total' => 10, 'location' => 'Lab. Circuitos', 'image' => 'https://images.unsplash.com/photo-1581092162384-8987c1d64718?w=600&h=420&fit=crop'],
                ['id' => 'EQ002', 'serial' => 'OSC-2005', 'name' => 'Osciloscopio Tektronix TBS1072C', 'category' => 'Herramientas', 'stock' => 3, 'total' => 5, 'location' => 'Lab. Circuitos', 'image' => 'https://images.unsplash.com/photo-1581092160562-40aa08e78837?w=600&h=420&fit=crop'],
                ['id' => 'EQ003', 'serial' => 'GEN-001', 'name' => 'Generador de Funciones GW Instek', 'category' => 'Herramientas', 'stock' => 0, 'total' => 4, 'location' => 'Lab. Circuitos', 'image' => 'https://images.unsplash.com/photo-1518770660439-4636190af475?w=600&h=420&fit=crop'],
                ['id' => 'EQ004', 'serial' => 'PLC-1200', 'name' => 'Módulo PLC Siemens S7-1200', 'category' => 'Equipos', 'stock' => 6, 'total' => 8, 'location' => 'Lab. Control', 'image' => 'https://images.unsplash.com/photo-1558618666-fcd25c85f82e?w=600&h=420&fit=crop'],
                ['id' => 'EQ005', 'serial' => 'MOT-3F01', 'name' => 'Motor Trifásico WEG 5HP', 'category' => 'Equipos', 'stock' => 2, 'total' => 3, 'location' => 'Lab. Potencia', 'image' => 'https://images.unsplash.com/photo-1565793298595-6a879b1d9492?w=600&h=420&fit=crop'],
                ['id' => 'EQ007', 'serial' => 'PROY-012', 'name' => 'Proyector Epson PowerLite X51+', 'category' => 'Tecnológico', 'stock' => 1, 'total' => 2, 'location' => 'Aula Magna', 'image' => 'https://images.unsplash.com/photo-1478737270239-2f02b77fc618?w=600&h=420&fit=crop'],
                ['id' => 'EQ008', 'serial' => 'PC-3001', 'name' => 'Computadora HP ProDesk i7', 'category' => 'Tecnológico', 'stock' => 12, 'total' => 20, 'location' => 'Lab. Cómputo 1', 'image' => 'https://images.unsplash.com/photo-1593062096033-9a26b09da705?w=600&h=420&fit=crop'],
                ['id' => 'EQ011', 'serial' => 'PROTO-01', 'name' => 'Protoboard Grande 2390 puntos', 'category' => 'Herramientas', 'stock' => 15, 'total' => 30, 'location' => 'Lab. Electrónica', 'image' => 'https://images.unsplash.com/photo-1555664424-778a1e5e1b48?w=600&h=420&fit=crop'],
            ],
            'inventory' => [
                ['code' => 'EQ001', 'name' => 'Multímetro Digital Fluke', 'category' => 'Herramientas', 'location' => 'FIE-A · Lab. Circuitos', 'status' => 'Bueno'],
                ['code' => 'EQ002', 'name' => 'Osciloscopio Tektronix', 'category' => 'Herramientas', 'location' => 'FIE-A · Lab. Circuitos', 'status' => 'Malo'],
                ['code' => 'EQ008', 'name' => 'Módulo PLC S7-1200', 'category' => 'Equipos', 'location' => 'Bloque Labs · Lab. Control', 'status' => 'Bueno'],
                ['code' => 'EQ003', 'name' => 'Computadora Core i7', 'category' => 'Tecnológico', 'location' => 'Cómputo · Lab. 1', 'status' => 'Bueno'],
                ['code' => 'EQ004', 'name' => 'Computadora Core i7', 'category' => 'Tecnológico', 'location' => 'Cómputo · Lab. 1', 'status' => 'Dañado'],
                ['code' => 'EQ007', 'name' => 'Proyector Epson PowerLite', 'category' => 'Tecnológico', 'location' => 'FIE-A · Aula 201', 'status' => 'Bueno'],
            ],
            'requests' => [
                ['id' => 'SOL-2026-041', 'subject' => 'Circuitos Eléctricos I', 'items' => '2 × Multímetro digital', 'date' => '25 ago 2026', 'status' => 'Aprobada'],
                ['id' => 'SOL-2026-038', 'subject' => 'Control Automático', 'items' => '1 × Módulo PLC S7-1200', 'date' => '22 ago 2026', 'status' => 'Pendiente'],
                ['id' => 'SOL-2026-031', 'subject' => 'Máquinas Eléctricas II', 'items' => '1 × Pinza amperimétrica', 'date' => '14 ago 2026', 'status' => 'Entregada'],
                ['id' => 'SOL-2026-024', 'subject' => 'Electrónica de Potencia', 'items' => '1 × Osciloscopio', 'date' => '02 ago 2026', 'status' => 'Rechazada'],
            ],
            'schedule' => [
                ['time' => '07:00 - 09:00',
                    'monday' => ['subject' => 'Sistemas Eléctricos de Potencia', 'room' => 'FIE-201', 'type' => 'normal', 'teacher' => 'Ing. Roberto Sánchez', 'career' => 'Electricidad'],
                    'tuesday' => ['subject' => 'Electrónica de Potencia', 'room' => 'Aula 101', 'type' => 'normal', 'teacher' => 'Ing. Carlos Mendoza', 'career' => 'Electricidad'],
                    'wednesday' => ['subject' => 'Sistemas Eléctricos de Potencia', 'room' => 'FIE-201', 'type' => 'normal', 'teacher' => 'Ing. Roberto Sánchez', 'career' => 'Electricidad'],
                    'thursday' => ['subject' => 'Lab. Electrónica de Potencia', 'room' => 'Lab. Electrónica', 'type' => 'lab', 'teacher' => 'Ing. Carlos Mendoza', 'career' => 'Electricidad'],
                    'friday' => ['subject' => 'Instalaciones Eléctricas', 'room' => 'Lab. Redes', 'type' => 'lab', 'teacher' => 'Ing. Fernando Ruiz', 'career' => 'Electricidad']],
                ['time' => '09:00 - 10:00',
                    'monday' => null,
                    'tuesday' => null,
                    'wednesday' => ['subject' => 'Máquinas Eléctricas II', 'room' => 'Lab. Potencia', 'type' => 'lab', 'teacher' => 'Ing. Patricia Morales', 'career' => 'Electricidad'],
                    'thursday' => null,
                    'friday' => null],
                ['time' => '10:00 - 12:00',
                    'monday' => ['subject' => 'Máquinas Eléctricas II', 'room' => 'FIE-302', 'type' => 'normal', 'teacher' => 'Ing. Patricia Morales', 'career' => 'Electricidad'],
                    'tuesday' => ['subject' => 'Análisis de Señales', 'room' => 'Lab. Cómputo 1', 'type' => 'normal', 'teacher' => 'Ing. Ana Gómez', 'career' => 'Electricidad'],
                    'wednesday' => ['subject' => 'Máquinas Eléctricas II', 'room' => 'Lab. Potencia', 'type' => 'lab', 'teacher' => 'Ing. Patricia Morales', 'career' => 'Electricidad'],
                    'thursday' => ['subject' => 'Análisis de Señales', 'room' => 'FIE-105', 'type' => 'normal', 'teacher' => 'Ing. Ana Gómez', 'career' => 'Electricidad'],
                    'friday' => ['subject' => 'Tutoría Académica', 'room' => 'FIE-201', 'type' => 'tutoria', 'teacher' => 'Ing. Roberto Sánchez', 'career' => 'Electricidad']],
                ['time' => '14:00 - 16:00',
                    'monday' => ['subject' => 'Lab. Circuitos Eléctricos', 'room' => 'Lab. Circuitos', 'type' => 'lab', 'teacher' => 'Ing. Carlos Mendoza', 'career' => 'Electricidad'],
                    'tuesday' => ['subject' => 'Control Automático', 'room' => 'Lab. Control', 'type' => 'normal', 'teacher' => 'Ing. Fernando Ruiz', 'career' => 'Electricidad'],
                    'wednesday' => ['subject' => 'Instalaciones Eléctricas', 'room' => 'Aula 102', 'type' => 'normal', 'teacher' => 'Ing. Fernando Ruiz', 'career' => 'Electricidad'],
                    'thursday' => ['subject' => 'Control Automático', 'room' => 'Lab. Control', 'type' => 'lab', 'teacher' => 'Ing. Fernando Ruiz', 'career' => 'Electricidad'],
                    'friday' => null],
            ],
            'buildings' => [
                ['name' => 'FIE-A', 'floors' => [
                    ['label' => 'Planta baja', 'rooms' => ['Aula 101', 'Aula 102', 'Lab. Circuitos']],
                    ['label' => 'Piso 1', 'rooms' => ['FIE-105', 'FIE-201']],
                    ['label' => 'Piso 2', 'rooms' => ['FIE-302', 'Aula Magna']],
                ]],
                ['name' => 'Bloque Labs', 'floors' => [
                    ['label' => 'Planta baja', 'rooms' => ['Lab. Control', 'Lab. Potencia']],
                    ['label' => 'Piso 1', 'rooms' => ['Lab. Electrónica', 'Lab. Redes']],
                ]],
                ['name' => 'Cómputo', 'floors' => [
                    ['label' => 'Planta baja', 'rooms' => ['Lab. Cómputo 1', 'Lab. Cómputo 2']],
                ]],
            ],
            'campus' => [
                'stats' => ['buildings' => 9, 'spaces' => 84, 'classrooms' => 49, 'labs' => 35],
                'center' => ['lat' => -1.65605, 'lng' => -78.67795],
                'buildings' => [
                    [
                        'id' => 'edificio-aulas', 'name' => 'Edificio de Aulas', 'status' => 'Operativo', 'place' => 'Campus Politécnico',
                        'floors' => 3, 'area' => 400, 'occupancy' => 0, 'lat' => -1.65572, 'lng' => -78.67712,
                        'photo' => 'https://images.unsplash.com/photo-1562774053-701939374585?w=640&h=420&fit=crop',
                        'spaces' => [
                            ['name' => 'Aula 102', 'floor' => 1, 'kind' => 'Aula', 'category' => 'Académica', 'capacity' => 30, 'area' => 60, 'status' => 'Disponible', 'photo' => 'https://images.unsplash.com/photo-1523240795612-9a054b0db644?w=640&h=420&fit=crop'],
                            ['name' => 'Aula 103', 'floor' => 1, 'kind' => 'Aula', 'category' => 'Académica', 'capacity' => 30, 'area' => 60, 'status' => 'Disponible', 'photo' => 'https://images.unsplash.com/photo-1523240795612-9a054b0db644?w=640&h=420&fit=crop'],
                            ['name' => 'Lab. Telecomunicaciones 1', 'floor' => 1, 'kind' => 'Laboratorio', 'category' => 'Técnico', 'capacity' => 20, 'area' => 60, 'status' => 'Disponible', 'photo' => 'https://images.unsplash.com/photo-1581092918056-0c4c3acd3789?w=640&h=420&fit=crop'],
                            ['name' => 'Lab. Telecomunicaciones 2', 'floor' => 1, 'kind' => 'Laboratorio', 'category' => 'Técnico', 'capacity' => 20, 'area' => 60, 'status' => 'Ocupada', 'photo' => 'https://images.unsplash.com/photo-1581092918056-0c4c3acd3789?w=640&h=420&fit=crop'],
                            ['name' => 'Aula 201', 'floor' => 2, 'kind' => 'Aula', 'category' => 'Académica', 'capacity' => 32, 'area' => 64, 'status' => 'Disponible', 'photo' => 'https://images.unsplash.com/photo-1523240795612-9a054b0db644?w=640&h=420&fit=crop'],
                            ['name' => 'Aula 202', 'floor' => 2, 'kind' => 'Aula', 'category' => 'Académica', 'capacity' => 32, 'area' => 64, 'status' => 'Disponible', 'photo' => 'https://images.unsplash.com/photo-1523240795612-9a054b0db644?w=640&h=420&fit=crop'],
                            ['name' => 'Aula 203', 'floor' => 2, 'kind' => 'Aula', 'category' => 'Académica', 'capacity' => 28, 'area' => 58, 'status' => 'Disponible', 'photo' => 'https://images.unsplash.com/photo-1523240795612-9a054b0db644?w=640&h=420&fit=crop'],
                            ['name' => 'Aula 204', 'floor' => 2, 'kind' => 'Aula', 'category' => 'Académica', 'capacity' => 28, 'area' => 58, 'status' => 'Mantenimiento', 'photo' => 'https://images.unsplash.com/photo-1523240795612-9a054b0db644?w=640&h=420&fit=crop'],
                            ['name' => 'Aula 205', 'floor' => 2, 'kind' => 'Aula', 'category' => 'Académica', 'capacity' => 30, 'area' => 60, 'status' => 'Disponible', 'photo' => 'https://images.unsplash.com/photo-1523240795612-9a054b0db644?w=640&h=420&fit=crop'],
                            ['name' => 'Aula 301', 'floor' => 3, 'kind' => 'Aula', 'category' => 'Académica', 'capacity' => 35, 'area' => 70, 'status' => 'Disponible', 'photo' => 'https://images.unsplash.com/photo-1523240795612-9a054b0db644?w=640&h=420&fit=crop'],
                            ['name' => 'Aula 302', 'floor' => 3, 'kind' => 'Aula', 'category' => 'Académica', 'capacity' => 35, 'area' => 70, 'status' => 'Disponible', 'photo' => 'https://images.unsplash.com/photo-1523240795612-9a054b0db644?w=640&h=420&fit=crop'],
                            ['name' => 'Aula 303', 'floor' => 3, 'kind' => 'Aula', 'category' => 'Académica', 'capacity' => 30, 'area' => 60, 'status' => 'Disponible', 'photo' => 'https://images.unsplash.com/photo-1523240795612-9a054b0db644?w=640&h=420&fit=crop'],
                            ['name' => 'Aula 304', 'floor' => 3, 'kind' => 'Aula', 'category' => 'Académica', 'capacity' => 30, 'area' => 60, 'status' => 'Disponible', 'photo' => 'https://images.unsplash.com/photo-1523240795612-9a054b0db644?w=640&h=420&fit=crop'],
                            ['name' => 'Aula 305', 'floor' => 3, 'kind' => 'Aula', 'category' => 'Académica', 'capacity' => 30, 'area' => 60, 'status' => 'Disponible', 'photo' => 'https://images.unsplash.com/photo-1523240795612-9a054b0db644?w=640&h=420&fit=crop'],
                        ],
                    ],
                    [
                        'id' => 'bloque-laboratorios', 'name' => 'Bloque de Laboratorios', 'status' => 'Operativo', 'place' => 'Campus Politécnico',
                        'floors' => 2, 'area' => 980, 'occupancy' => 62, 'lat' => -1.65642, 'lng' => -78.67668,
                        'photo' => 'https://images.unsplash.com/photo-1581092918056-0c4c3acd3789?w=640&h=420&fit=crop',
                        'spaces' => [
                            ['name' => 'Lab. Circuitos', 'floor' => 1, 'kind' => 'Laboratorio', 'category' => 'Técnico', 'capacity' => 24, 'area' => 72, 'status' => 'Disponible', 'photo' => 'https://images.unsplash.com/photo-1581092918056-0c4c3acd3789?w=640&h=420&fit=crop'],
                            ['name' => 'Lab. Control', 'floor' => 1, 'kind' => 'Laboratorio', 'category' => 'Técnico', 'capacity' => 22, 'area' => 68, 'status' => 'Ocupada', 'photo' => 'https://images.unsplash.com/photo-1581092918056-0c4c3acd3789?w=640&h=420&fit=crop'],
                            ['name' => 'Lab. Potencia', 'floor' => 2, 'kind' => 'Laboratorio', 'category' => 'Técnico', 'capacity' => 28, 'area' => 84, 'status' => 'Disponible', 'photo' => 'https://images.unsplash.com/photo-1581092918056-0c4c3acd3789?w=640&h=420&fit=crop'],
                            ['name' => 'Lab. Electrónica', 'floor' => 2, 'kind' => 'Laboratorio', 'category' => 'Técnico', 'capacity' => 24, 'area' => 72, 'status' => 'Mantenimiento', 'photo' => 'https://images.unsplash.com/photo-1581092918056-0c4c3acd3789?w=640&h=420&fit=crop'],
                        ],
                    ],
                    [
                        'id' => 'centro-computo', 'name' => 'Centro de Cómputo', 'status' => 'Operativo', 'place' => 'Campus Politécnico',
                        'floors' => 1, 'area' => 640, 'occupancy' => 48, 'lat' => -1.65688, 'lng' => -78.67781,
                        'photo' => 'https://images.unsplash.com/photo-1517048676732-d65bc937f952?w=640&h=420&fit=crop',
                        'spaces' => [
                            ['name' => 'Lab. Cómputo 1', 'floor' => 1, 'kind' => 'Laboratorio', 'category' => 'Técnico', 'capacity' => 30, 'area' => 90, 'status' => 'Disponible', 'photo' => 'https://images.unsplash.com/photo-1517048676732-d65bc937f952?w=640&h=420&fit=crop'],
                            ['name' => 'Lab. Cómputo 2', 'floor' => 1, 'kind' => 'Laboratorio', 'category' => 'Técnico', 'capacity' => 30, 'area' => 90, 'status' => 'Disponible', 'photo' => 'https://images.unsplash.com/photo-1517048676732-d65bc937f952?w=640&h=420&fit=crop'],
                            ['name' => 'Sala de Servidores', 'floor' => 1, 'kind' => 'Laboratorio', 'category' => 'Técnico', 'capacity' => 8, 'area' => 24, 'status' => 'Ocupada', 'photo' => 'https://images.unsplash.com/photo-1517048676732-d65bc937f952?w=640&h=420&fit=crop'],
                        ],
                    ],
                    [
                        'id' => 'bloque-administrativo', 'name' => 'Bloque Administrativo', 'status' => 'Mantenimiento', 'place' => 'Campus Politécnico',
                        'floors' => 2, 'area' => 520, 'occupancy' => 30, 'lat' => -1.6552, 'lng' => -78.6784,
                        'photo' => 'https://images.unsplash.com/photo-1562774053-701939374585?w=640&h=420&fit=crop',
                        'spaces' => [
                            ['name' => 'Sala Docentes', 'floor' => 1, 'kind' => 'Oficina', 'category' => 'Académica', 'capacity' => 12, 'area' => 36, 'status' => 'Disponible', 'photo' => 'https://images.unsplash.com/photo-1523240795612-9a054b0db644?w=640&h=420&fit=crop'],
                            ['name' => 'Secretaría FIE', 'floor' => 1, 'kind' => 'Oficina', 'category' => 'Académica', 'capacity' => 6, 'area' => 24, 'status' => 'Disponible', 'photo' => 'https://images.unsplash.com/photo-1523240795612-9a054b0db644?w=640&h=420&fit=crop'],
                            ['name' => 'Aula Magna', 'floor' => 2, 'kind' => 'Aula', 'category' => 'Académica', 'capacity' => 120, 'area' => 320, 'status' => 'Disponible', 'photo' => 'https://images.unsplash.com/photo-1523240795612-9a054b0db644?w=640&h=420&fit=crop'],
                        ],
                    ],
                ],
            ],
            'users' => [
                ['name' => 'María Fernanda Ruiz', 'email' => 'maria.ruiz@espoch.edu.ec', 'role' => 'Estudiante', 'detail' => 'Electricidad · 5.º PAO', 'status' => 'Activo'],
                ['name' => 'Ing. Roberto Sánchez', 'email' => 'roberto.sanchez@espoch.edu.ec', 'role' => 'Docente', 'detail' => 'Sistemas de Potencia', 'status' => 'Activo'],
                ['name' => 'Ana Lucía Pérez', 'email' => 'ana.perez@email.com', 'role' => 'Representante', 'detail' => 'Representante de Juan C. Pérez', 'status' => 'Activo'],
                ['name' => 'Carlos Mendoza', 'email' => 'carlos.mendoza@espoch.edu.ec', 'role' => 'Docente', 'detail' => 'Circuitos Eléctricos', 'status' => 'Activo'],
                ['name' => 'Jorge Silva', 'email' => 'jorge.silva@espoch.edu.ec', 'role' => 'Estudiante', 'detail' => 'Electricidad · 4.º PAO', 'status' => 'Inactivo'],
            ],
            'courses' => [
                ['code' => 'ELEC-501', 'name' => 'Sistemas Eléctricos de Potencia', 'parallel' => 'A', 'students' => 28, 'average' => '8,6', 'room' => 'FIE-201'],
                ['code' => 'ELEC-503', 'name' => 'Circuitos Eléctricos I', 'parallel' => 'B', 'students' => 24, 'average' => '8,2', 'room' => 'Lab. Circuitos'],
                ['code' => 'ELEC-506', 'name' => 'Máquinas Eléctricas II', 'parallel' => 'A', 'students' => 31, 'average' => '7,9', 'room' => 'FIE-302'],
            ],
            'virtualCourses' => [
                [
                    'slug' => 'sistemas-potencia', 'code' => 'ELEC-501', 'name' => 'Sistemas Eléctricos de Potencia',
                    'teacher' => 'Ing. Roberto Sánchez', 'initials' => 'RS', 'progress' => 78, 'tone' => 'navy',
                    'next' => 'Cuestionario: Flujo de potencia', 'date' => '31 AGO',
                    'modules' => [
                        ['type' => 'forum', 'title' => 'Foro de novedades y avisos', 'meta' => '3 publicaciones nuevas', 'done' => true],
                        ['type' => 'file', 'title' => 'Unidad 1 · Introducción a los sistemas de potencia', 'meta' => 'PDF · 4,8 MB', 'done' => true],
                        ['type' => 'video', 'title' => 'Unidad 2 · Flujo de carga y diagramas unifilares', 'meta' => 'Video · 32 min', 'done' => true],
                        ['type' => 'task', 'title' => 'Actividad 2 · Simulación de flujo de potencia', 'meta' => 'Entrega: 31 de agosto · 23:59', 'done' => false],
                    ],
                    'grades' => [['Actividad diagnóstica', '9,0'], ['Informe de laboratorio 1', '8,8'], ['Cuestionario unidad 1', '8,9']],
                ],
                [
                    'slug' => 'maquinas-electricas', 'code' => 'ELEC-502', 'name' => 'Máquinas Eléctricas II',
                    'teacher' => 'Ing. Patricia Morales', 'initials' => 'PM', 'progress' => 62, 'tone' => 'red',
                    'next' => 'Informe: Motor trifásico', 'date' => '02 SEP',
                    'modules' => [
                        ['type' => 'forum', 'title' => 'Avisos generales del curso', 'meta' => '1 publicación nueva', 'done' => true],
                        ['type' => 'file', 'title' => 'Unidad 1 · Transformadores eléctricos', 'meta' => 'PDF · 6,2 MB', 'done' => true],
                        ['type' => 'video', 'title' => 'Unidad 2 · Máquinas de inducción', 'meta' => 'Video · 41 min', 'done' => false],
                        ['type' => 'task', 'title' => 'Informe de práctica · Motor trifásico', 'meta' => 'Entrega: 2 de septiembre · 20:00', 'done' => false],
                    ],
                    'grades' => [['Prueba de entrada', '8,2'], ['Taller de transformadores', '8,6'], ['Práctica 1', '8,4']],
                ],
                [
                    'slug' => 'control-automatico', 'code' => 'ELEC-505', 'name' => 'Control Automático',
                    'teacher' => 'Ing. Fernando Ruiz', 'initials' => 'FR', 'progress' => 86, 'tone' => 'amber',
                    'next' => 'Práctica: Control PID', 'date' => '04 SEP',
                    'modules' => [
                        ['type' => 'forum', 'title' => 'Foro de dudas y anuncios', 'meta' => 'Sin publicaciones nuevas', 'done' => true],
                        ['type' => 'file', 'title' => 'Unidad 1 · Modelado de sistemas dinámicos', 'meta' => 'PDF · 3,1 MB', 'done' => true],
                        ['type' => 'video', 'title' => 'Unidad 2 · Respuesta temporal', 'meta' => 'Video · 28 min', 'done' => true],
                        ['type' => 'task', 'title' => 'Práctica 4 · Ajuste de controlador PID', 'meta' => 'Entrega: 4 de septiembre · 23:59', 'done' => false],
                    ],
                    'grades' => [['Modelado de sistemas', '8,7'], ['Cuestionario 1', '9,1'], ['Laboratorio PLC', '8,6']],
                ],
            ],
            'grades' => [
                ['subject' => 'Sistemas Eléctricos de Potencia', 'p1' => '8,7', 'p2' => '9,1', 'final' => '8,9', 'status' => 'Aprobado'],
                ['subject' => 'Máquinas Eléctricas II', 'p1' => '8,2', 'p2' => '8,5', 'final' => '8,4', 'status' => 'Aprobado'],
                ['subject' => 'Electrónica de Potencia', 'p1' => '9,0', 'p2' => '8,8', 'final' => '8,9', 'status' => 'Aprobado'],
                ['subject' => 'Análisis de Señales', 'p1' => '7,8', 'p2' => '8,1', 'final' => '8,0', 'status' => 'Aprobado'],
                ['subject' => 'Control Automático', 'p1' => '8,5', 'p2' => '9,0', 'final' => '8,8', 'status' => 'Aprobado'],
            ],
            'notices' => [
                ['type' => 'Académico', 'title' => 'Reunión de seguimiento del periodo', 'text' => 'Miércoles 2 de septiembre, 16:00 · Sala de reuniones FIE.', 'date' => 'Hoy'],
                ['type' => 'Docente', 'title' => 'Nuevo material en Control Automático', 'text' => 'Se publicó la guía de práctica del laboratorio de PLC.', 'date' => 'Ayer'],
                ['type' => 'Sistema', 'title' => 'Solicitud de equipo aprobada', 'text' => 'La solicitud SOL-2026-041 está lista para retiro.', 'date' => '25 ago'],
            ],
            'assignments' => [
                ['code' => 'EQ001', 'asset' => 'Multímetro Digital Fluke', 'holder' => 'Ing. Roberto Sánchez', 'place' => 'Lab. Circuitos', 'since' => '12 ago 2026', 'status' => 'Activa'],
                ['code' => 'EQ008', 'asset' => 'Módulo PLC S7-1200', 'holder' => 'Ing. Patricia Morales', 'place' => 'Lab. Control', 'since' => '18 ago 2026', 'status' => 'Activa'],
                ['code' => 'EQ007', 'asset' => 'Proyector Epson PowerLite', 'holder' => 'Secretaría FIE', 'place' => 'Aula Magna', 'since' => '02 ago 2026', 'status' => 'Activa'],
                ['code' => 'EQ011', 'asset' => 'Protoboard 2390 puntos', 'holder' => 'Ing. Fernando Ruiz', 'place' => 'Lab. Electrónica', 'since' => '25 jul 2026', 'status' => 'Devuelta'],
            ],
            'maintenance' => [
                ['order' => 'OM-2026-014', 'asset' => 'Osciloscopio Tektronix', 'issue' => 'Canal 2 sin señal', 'priority' => 'Alta', 'opened' => '20 ago 2026', 'status' => 'Pendiente'],
                ['order' => 'OM-2026-012', 'asset' => 'Computadora Core i7', 'issue' => 'Fuente de poder dañada', 'priority' => 'Alta', 'opened' => '17 ago 2026', 'status' => 'En proceso'],
                ['order' => 'OM-2026-009', 'asset' => 'Proyector Epson PowerLite', 'issue' => 'Lámpara con bajo brillo', 'priority' => 'Media', 'opened' => '09 ago 2026', 'status' => 'En proceso'],
                ['order' => 'OM-2026-004', 'asset' => 'Motor Trifásico WEG', 'issue' => 'Mantenimiento preventivo', 'priority' => 'Baja', 'opened' => '28 jul 2026', 'status' => 'Cerrada'],
            ],
            'resources' => [
                ['title' => 'Guía de laboratorio: Circuitos RLC', 'subject' => 'Circuitos Eléctricos I', 'type' => 'PDF', 'size' => '2,4 MB'],
                ['title' => 'Práctica 04: Control de motores', 'subject' => 'Control Automático', 'type' => 'DOCX', 'size' => '1,1 MB'],
                ['title' => 'Introducción a sistemas de potencia', 'subject' => 'Sistemas Eléctricos', 'type' => 'VIDEO', 'size' => '18 min'],
                ['title' => 'Formato de informe de prácticas', 'subject' => 'General', 'type' => 'DOCX', 'size' => '680 KB'],
            ],
        ];
    }
}
