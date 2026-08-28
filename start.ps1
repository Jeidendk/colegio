$ErrorActionPreference = 'Stop'
$localPhp = Join-Path $PSScriptRoot '..\scratch\php84\php.exe'
$php = if (Get-Command php -ErrorAction SilentlyContinue) { 'php' } elseif (Test-Path $localPhp) { $localPhp } else { throw 'Se requiere PHP 8.3 o superior.' }

& $php artisan serve --host=127.0.0.1 --port=8000
