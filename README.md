# ESPOCH Electricidad · réplica Laravel

Réplica visual y funcional del sistema académico original, construida con Laravel 13 y Blade.

## Alcance

- Vistas para Administrador, Docente, Estudiante y Representante.
- Aula virtual conectada con inicio, área personal, cursos, calendario, calificaciones y detalle de cada asignatura.
- Sin autenticación, Supabase ni consultas a una base de datos.
- Todos los datos provienen de `app/Support/DemoData.php`.
- Altas, ediciones, filtros, carrito, modales y cambios de estado son demostrativos y no persisten al recargar.
- Estilos e interacciones propios, sin compilación de frontend obligatoria.

## Ejecutar

Con PHP 8.3 o superior y Composer instalados:

```powershell
composer install
php artisan key:generate
php artisan serve
```

Abrir `http://127.0.0.1:8000`. La ruta inicial entra al panel Administrador y el selector de perfil permite cambiar de vista.

En este workspace también existe una copia portátil de PHP en `../scratch/php84/php.exe`, por lo que se puede iniciar con `./start.ps1`.

## Validar

```powershell
php artisan test
```
