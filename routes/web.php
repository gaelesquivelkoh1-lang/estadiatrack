<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\AlumnoController;
use App\Http\Controllers\EstanciaController;

// Ruta principal
Route::get('/', function () {
    return view('welcome');
});

// RUTAS DE EMPRESAS
Route::prefix('empresas')->group(function () {
    Route::get('/', [EmpresaController::class, 'index'])->name('empresas.index');
    Route::get('/create', [EmpresaController::class, 'create'])->name('empresas.create');
    Route::post('/', [EmpresaController::class, 'store'])->name('empresas.store');
    // Añadidas para que funcionen los botones de la tabla
    Route::get('/{empresa}/edit', [EmpresaController::class, 'edit'])->name('empresas.edit');
    Route::put('/{empresa}', [EmpresaController::class, 'update'])->name('empresas.update');
    Route::delete('/{empresa}', [EmpresaController::class, 'destroy'])->name('empresas.destroy');
});

// RUTAS DE ALUMNOS
Route::prefix('alumnos')->group(function () {
    Route::get('/', [AlumnoController::class, 'index'])->name('alumnos.index');
    Route::get('/create', [AlumnoController::class, 'create'])->name('alumnos.create');
    Route::post('/', [AlumnoController::class, 'store'])->name('alumnos.store');
    // Estas son las que te daban el error en la imagen 9
    Route::get('/{alumno}/edit', [AlumnoController::class, 'edit'])->name('alumnos.edit');
    Route::put('/{alumno}', [AlumnoController::class, 'update'])->name('alumnos.update');
    Route::delete('/{alumno}', [AlumnoController::class, 'destroy'])->name('alumnos.destroy');
});

// RUTAS DE ESTANCIAS
Route::get('/estancias', [EstanciaController::class, 'index'])->name('estancias.index');
Route::post('/estancias', [EstanciaController::class, 'store'])->name('estancias.store');

// RUTA DE CARRERAS (Filtrado)
Route::get('/carreras/{carrera?}', [AlumnoController::class, 'porCarrera'])->name('carreras.index');