@extends('layouts.app')

@section('title', 'Panel Super Usuario')

@section('content')

<div class="max-w-7xl mx-auto px-4 py-8 space-y-6">

    {{-- Encabezado --}}
    <div class="bg-white rounded-[1.75rem] border border-gray-100 shadow-sm p-8">
        <div class="flex items-center justify-between flex-wrap gap-4">
            <div>
                <div class="flex items-center gap-2 mb-1">
                    <span class="text-[10px] font-bold px-2.5 py-1 rounded-full bg-red-50 text-red-600 border border-red-100 uppercase tracking-wider">
                        Super Usuario
                    </span>
                </div>
                <h1 class="text-2xl font-extrabold text-gray-800 tracking-tight">Panel de Administración</h1>
                <p class="text-xs text-gray-400 font-medium mt-1">Acceso total al sistema · {{ session('alumno_nombre') }}</p>
            </div>
            <a href="{{ route('superadmin.usuarios') }}"
               class="flex items-center gap-2 px-6 py-3 rounded-xl text-sm font-bold text-white
                      bg-emerald-700 hover:bg-emerald-800 border-2 border-emerald-900
                      ring-2 ring-emerald-500 ring-offset-2 transition-all shadow-lg">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
                Gestionar usuarios
            </a>
        </div>
    </div>

    {{-- Métricas --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">Usuarios de vinculación</p>
            <p class="text-4xl font-extrabold text-gray-800">{{ $totalVinculacion }}</p>
            <p class="text-xs text-gray-400 mt-1">Registrados en el sistema</p>
        </div>
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">Usuarios activos</p>
            <p class="text-4xl font-extrabold text-emerald-600">{{ $totalActivos }}</p>
            <p class="text-xs text-gray-400 mt-1">Con acceso habilitado</p>
        </div>
    </div>

    {{-- Accesos rápidos --}}
    <div class="bg-white rounded-[1.75rem] border border-gray-100 shadow-sm p-8">
        <h2 class="text-xs font-bold text-gray-400 uppercase tracking-[0.2em] mb-5">Acceso completo al sistema</h2>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">

            @php
                $accesos = [
                    ['ruta' => 'alumnos.index',        'label' => 'Alumnos',    'sub' => 'Gestionar registros',   'color' => 'bg-blue-50 text-blue-600'],
                    ['ruta' => 'empresas.index',       'label' => 'Empresas',   'sub' => 'Gestionar empresas',    'color' => 'bg-amber-50 text-amber-600'],
                    ['ruta' => 'estancias.index',      'label' => 'Estancias',  'sub' => 'Ver estancias activas', 'color' => 'bg-emerald-50 text-emerald-600'],
                    ['ruta' => 'vinculacion.convenios','label' => 'Convenios',  'sub' => 'Revisar y firmar',      'color' => 'bg-purple-50 text-purple-600'],
                    ['ruta' => 'superadmin.usuarios',  'label' => 'Usuarios',   'sub' => 'Crear y administrar',   'color' => 'bg-red-50 text-red-600'],
                    ['ruta' => 'vinculacion.dashboard','label' => 'Vinculación','sub' => 'Panel de vinculación',  'color' => 'bg-gray-50 text-gray-600'],
                ];
            @endphp

            @foreach($accesos as $acceso)
            <a href="{{ route($acceso['ruta']) }}"
               class="flex items-center gap-4 p-4 rounded-2xl border-2 border-gray-100 hover:border-emerald-200 hover:bg-emerald-50 transition-all">
                <div class="w-10 h-10 rounded-xl {{ $acceso['color'] }} flex items-center justify-center flex-shrink-0 font-extrabold text-sm">
                    {{ strtoupper(substr($acceso['label'], 0, 1)) }}
                </div>
                <div>
                    <p class="text-sm font-bold text-gray-700">{{ $acceso['label'] }}</p>
                    <p class="text-xs text-gray-400">{{ $acceso['sub'] }}</p>
                </div>
            </a>
            @endforeach

        </div>
    </div>

</div>

@endsection