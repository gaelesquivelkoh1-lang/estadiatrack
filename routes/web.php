<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\AlumnoController;
use App\Http\Controllers\EstanciaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\ConvenioController;
use App\Http\Controllers\VinculacionController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\EmpresaAdminController;

// ── LOGIN ──────────────────────────────────────────────────────
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ── ALUMNO ─────────────────────────────────────────────────────
Route::middleware('rol:alumno')->group(function () {
    Route::get('/perfil',             [PerfilController::class, 'index'])->name('perfil');
    Route::get('/convenios/crear',    [ConvenioController::class, 'create'])->name('convenios.create');
    Route::post('/convenios',         [ConvenioController::class, 'store'])->name('convenios.store');
    Route::get('/convenios/preview',  [ConvenioController::class, 'preview'])->name('convenios.preview');
    Route::post('/perfil/avatar',     [PerfilController::class, 'actualizarAvatar'])->name('perfil.avatar');
    Route::get('/mis-asistencias/{estancia}', [EmpresaAdminController::class, 'calendario'])->name('alumno.calendario');
});

// ── EMPRESA ────────────────────────────────────────────────────
Route::middleware('rol:empresa')->group(function () {
    Route::get('/empresa/dashboard',                        [EmpresaAdminController::class, 'dashboard'])->name('empresa.dashboard');
    Route::get('/empresa/estancia/{estancia}/calendario',   [EmpresaAdminController::class, 'calendario'])->name('empresa.calendario');
    Route::post('/empresa/estancia/{estancia}/asistencia',  [EmpresaAdminController::class, 'guardarAsistencia'])->name('empresa.asistencia');
});

// ── VINCULACIÓN + SUPERUSUARIO ─────────────────────────────────
Route::middleware('rol:vinculacion,superusuario')->group(function () {

    Route::get('/estancias/export', [EstanciaController::class, 'export'])->name('estancias.export');

    // Empresas
    Route::prefix('empresas')->group(function () {
        Route::get('/',               [EmpresaController::class, 'index'])->name('empresas.index');
        Route::get('/create',         [EmpresaController::class, 'create'])->name('empresas.create');
        Route::post('/',              [EmpresaController::class, 'store'])->name('empresas.store');
        Route::get('/{empresa}/edit', [EmpresaController::class, 'edit'])->name('empresas.edit');
        Route::put('/{empresa}',      [EmpresaController::class, 'update'])->name('empresas.update');
        Route::delete('/{empresa}',   [EmpresaController::class, 'destroy'])->name('empresas.destroy');
    });

    // Alumnos
    Route::prefix('alumnos')->group(function () {
        Route::get('/',               [AlumnoController::class, 'index'])->name('alumnos.index');
        Route::get('/create',         [AlumnoController::class, 'create'])->name('alumnos.create');
        Route::post('/',              [AlumnoController::class, 'store'])->name('alumnos.store');
        Route::get('/{alumno}/edit',  [AlumnoController::class, 'edit'])->name('alumnos.edit');
        Route::put('/{alumno}',       [AlumnoController::class, 'update'])->name('alumnos.update');
        Route::delete('/{alumno}',    [AlumnoController::class, 'destroy'])->name('alumnos.destroy');
    });

    // Estancias
    Route::get('/estancias',  [EstanciaController::class, 'index'])->name('estancias.index');
    Route::post('/estancias', [EstanciaController::class, 'store'])->name('estancias.store');

    // Carreras
    Route::get('/carreras/{carrera?}', [AlumnoController::class, 'porCarrera'])->name('carreras.index');

    // Vinculación
    Route::get('/vinculacion',                              [VinculacionController::class, 'dashboard'])->name('vinculacion.dashboard');
    Route::get('/vinculacion/convenios',                    [VinculacionController::class, 'convenios'])->name('vinculacion.convenios');
    Route::post('/vinculacion/convenios/{convenio}/firmar', [VinculacionController::class, 'firmar'])->name('vinculacion.firmar');
    Route::post('/vinculacion/firma',                       [VinculacionController::class, 'guardarFirma'])->name('vinculacion.guardarFirma');

    // Asistencias para vinculación/superadmin (rutas con prefijo admin)
    Route::get('/admin/empresa/dashboard',                       [EmpresaAdminController::class, 'dashboard'])->name('empresa.dashboard.admin');
    Route::get('/admin/empresa/estancia/{estancia}/calendario',  [EmpresaAdminController::class, 'calendario'])->name('empresa.calendario.admin');
    Route::post('/admin/empresa/estancia/{estancia}/asistencia', [EmpresaAdminController::class, 'guardarAsistencia'])->name('empresa.asistencia.admin');
});

// ── SOLO SUPERUSUARIO ──────────────────────────────────────────
Route::middleware('rol:superusuario')->group(function () {
    Route::get('/superadmin',                           [SuperAdminController::class, 'dashboard'])->name('superadmin.dashboard');
    Route::get('/superadmin/usuarios',                  [SuperAdminController::class, 'usuarios'])->name('superadmin.usuarios');
    Route::post('/superadmin/usuarios',                 [SuperAdminController::class, 'crear'])->name('superadmin.crear');
    Route::delete('/superadmin/usuarios/{admin}',       [SuperAdminController::class, 'eliminar'])->name('superadmin.eliminar');
    Route::patch('/superadmin/usuarios/{admin}/toggle', [SuperAdminController::class, 'toggle'])->name('superadmin.toggle');
});