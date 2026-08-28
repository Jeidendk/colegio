<?php

use App\Http\Controllers\PortalController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/admin/dashboard');

Route::get('/{role}/{page?}', PortalController::class)
    ->whereIn('role', ['admin', 'docente', 'estudiante', 'representante'])
    ->where('page', '[a-z0-9-]+')
    ->name('portal');
