@extends('layouts.app')

@section('title', 'Panel Vinculación')

@section('content')

<div class="max-w-7xl mx-auto px-4 py-8 space-y-6">

    {{-- Encabezado --}}
    <div class="bg-white rounded-[1.75rem] border border-gray-100 shadow-sm p-8">
        <div class="flex items-center justify-between flex-wrap gap-4">
            <div>
                <h1 class="text-2xl font-extrabold text-gray-800 tracking-tight">Panel de Vinculación</h1>
                <p class="text-xs text-gray-400 font-medium mt-1">Bienvenido, {{ session('alumno_nombre') }}</p>
            </div>
            <a href="{{ route('vinculacion.convenios') }}"
               class="flex items-center gap-2 px-6 py-3 rounded-xl text-sm font-bold text-white
                      bg-emerald-700 hover:bg-emerald-800 border-2 border-emerald-900
                      ring-2 ring-emerald-500 ring-offset-2 transition-all shadow-lg">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                Ver convenios
            </a>
        </div>
    </div>

    {{-- Métricas --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">Convenios pendientes</p>
            <p class="text-4xl font-extrabold text-amber-500">{{ $pendientes }}</p>
            <p class="text-xs text-gray-400 mt-1">Requieren tu firma</p>
        </div>

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">Convenios firmados</p>
            <p class="text-4xl font-extrabold text-emerald-600">{{ $firmados }}</p>
            <p class="text-xs text-gray-400 mt-1">Procesados correctamente</p>
        </div>

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">Total alumnos</p>
            <p class="text-4xl font-extrabold text-blue-500">{{ $totalAlumnos }}</p>
            <p class="text-xs text-gray-400 mt-1">Registrados en el sistema</p>
        </div>

    </div>

    {{-- Accesos rápidos --}}
    <div class="bg-white rounded-[1.75rem] border border-gray-100 shadow-sm p-8">
        <h2 class="text-xs font-bold text-gray-400 uppercase tracking-[0.2em] mb-5">Accesos rápidos</h2>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">

            <a href="{{ route('alumnos.index') }}"
               class="flex items-center gap-4 p-4 rounded-2xl border-2 border-gray-100 hover:border-emerald-200 hover:bg-emerald-50 transition-all">
                <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-bold text-gray-700">Alumnos</p>
                    <p class="text-xs text-gray-400">Gestionar registros</p>
                </div>
            </a>

            <a href="{{ route('empresas.index') }}"
               class="flex items-center gap-4 p-4 rounded-2xl border-2 border-gray-100 hover:border-emerald-200 hover:bg-emerald-50 transition-all">
                <div class="w-10 h-10 rounded-xl bg-amber-50 flex items-center justify-center flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-bold text-gray-700">Empresas</p>
                    <p class="text-xs text-gray-400">Gestionar empresas</p>
                </div>
            </a>

            <a href="{{ route('estancias.index') }}"
               class="flex items-center gap-4 p-4 rounded-2xl border-2 border-gray-100 hover:border-emerald-200 hover:bg-emerald-50 transition-all">
                <div class="w-10 h-10 rounded-xl bg-emerald-50 flex items-center justify-center flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-bold text-gray-700">Estancias</p>
                    <p class="text-xs text-gray-400">Ver estancias activas</p>
                </div>
            </a>

        </div>
    </div>

</div>

@endsection