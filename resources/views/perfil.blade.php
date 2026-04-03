{{-- 
    Vista: Perfil del estudiante
    Ruta sugerida: resources/views/perfil.blade.php
    Controller: retornar con Auth::user() y $historial (colección Activity o similar)
--}}

@extends('layouts.app')  {{-- Cambia por tu layout base --}}

@section('title', 'Mi Perfil · Vinculación UTC')

@section('content')

@php
    $initials = collect(explode(' ', $user->nombre))
                ->map(fn($w) => strtoupper($w[0]))
                ->take(2)
                ->implode('');
@endphp
<div class="min-h-screen bg-gray-50 py-8 px-4">
    <div class="max-w-3xl mx-auto space-y-6">

        {{-- ─── Encabezado de perfil ─── --}}
        <div class="bg-white rounded-[1.75rem] border border-gray-100 shadow-sm overflow-hidden">

            {{-- Banner verde UTC --}}
            <div class="h-24 bg-utc relative">
                <div class="absolute -bottom-8 left-8">
                    <div class="w-16 h-16 rounded-2xl bg-white shadow-md flex items-center justify-center
                                text-utc text-xl font-extrabold border-2 border-white">
                        {{ $initials }}
                    </div>
                </div>
            </div>

            <div class="pt-12 pb-6 px-8">
                <div class="flex items-start justify-between flex-wrap gap-4">
                    <div>
                        <h1 class="text-xl font-extrabold text-gray-800 tracking-tight">
                            {{ $user->nombre }}
                        </h1>
                        <p class="text-xs text-gray-400 font-semibold uppercase tracking-widest mt-0.5">
                            Estudiante · Estadía Profesional
                        </p>
                    </div>
                    <span class="inline-flex items-center gap-1.5 bg-emerald-50 text-utc text-[10px]
                                 font-bold px-3 py-1.5 rounded-full uppercase tracking-wider border border-emerald-100">
                        <span class="w-1.5 h-1.5 rounded-full bg-utc"></span>
                        Activo
                    </span>
                </div>
            </div>
        </div>

        {{-- ─── Datos personales ─── --}}
        <div class="bg-white rounded-[1.75rem] border border-gray-100 shadow-sm p-8">

            <h2 class="text-xs font-bold text-gray-400 uppercase tracking-[0.2em] mb-5 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
                Datos personales
            </h2>

            <dl class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                @php
                    $campos = [
                        'Matrícula'       => $user->matricula,
                        'Nombre completo' => $user->nombre,
                        'Correo'          => $user->email ?? 'No registrado',
                        'Carrera'         => $user->carrera ?? 'No registrada',
                        'Cuatrimestre'    => $user->cuatrimestre ?? '—',
                        'Grupo'           => $user->grupo ?? '—',
                    ];
                @endphp

                @foreach($campos as $label => $valor)
                <div class="bg-gray-50 rounded-2xl px-5 py-4">
                    <dt class="text-[9px] font-bold text-gray-400 uppercase tracking-[0.18em] mb-1">
                        {{ $label }}
                    </dt>
                    <dd class="text-sm font-semibold text-gray-800">
                        {{ $valor }}
                    </dd>
                </div>
                @endforeach

            </dl>
        </div>

        {{-- ─── Historial de actividad ─── --}}
        <div class="bg-white rounded-[1.75rem] border border-gray-100 shadow-sm p-8">

            <h2 class="text-xs font-bold text-gray-400 uppercase tracking-[0.2em] mb-5 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Historial de actividad
            </h2>

            @if(isset($historial) && $historial->count())

                <ol class="relative border-l-2 border-gray-100 ml-2 space-y-0">
                    @foreach($historial as $item)

                    @php
                        $colores = [
                            'aprobado'   => ['dot' => 'bg-emerald-500', 'badge' => 'bg-emerald-50 text-emerald-700 border-emerald-100'],
                            'revision'   => ['dot' => 'bg-amber-400',   'badge' => 'bg-amber-50 text-amber-700 border-amber-100'],
                            'rechazado'  => ['dot' => 'bg-red-400',     'badge' => 'bg-red-50 text-red-600 border-red-100'],
                            'registrado' => ['dot' => 'bg-blue-400',    'badge' => 'bg-blue-50 text-blue-700 border-blue-100'],
                        ];
                        $estado  = strtolower($item->estado ?? 'registrado');
                        $color   = $colores[$estado] ?? $colores['registrado'];
                    @endphp

                    <li class="relative pl-7 pb-6 last:pb-0">
                        {{-- Punto en la línea --}}
                        <span class="absolute -left-[5px] top-1 w-2.5 h-2.5 rounded-full border-2 border-white {{ $color['dot'] }}"></span>

                        <div class="flex items-start justify-between gap-4 flex-wrap">
                            <div>
                                <p class="text-sm font-semibold text-gray-700 leading-tight">
                                    {{ $item->descripcion }}
                                </p>
                                @if(!empty($item->detalle))
                                    <p class="text-xs text-gray-400 mt-0.5">{{ $item->detalle }}</p>
                                @endif
                            </div>
                            <div class="flex items-center gap-2 flex-shrink-0">
                                <span class="text-[10px] font-bold px-2.5 py-1 rounded-full border {{ $color['badge'] }}">
                                    {{ ucfirst($item->estado) }}
                                </span>
                                <span class="text-[10px] text-gray-400 font-medium whitespace-nowrap">
                                    {{ \Carbon\Carbon::parse($item->fecha)->format('d M Y') }}
                                </span>
                            </div>
                        </div>
                    </li>
                    @endforeach
                </ol>

            @else
                <div class="text-center py-10">
                    <div class="w-12 h-12 rounded-2xl bg-gray-50 flex items-center justify-center mx-auto mb-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Sin actividad registrada</p>
                </div>
            @endif

        </div>

        {{-- ─── Pie de página ─── --}}
        <div class="text-center pb-4">
            <p class="text-[9px] font-bold text-gray-400 uppercase tracking-[0.25em]">
                Universidad Tecnológica del Centro &copy; 2026
            </p>
        </div>

    </div>
</div>

@endsection