@extends('layouts.app')

@section('title', 'Panel de Empresa')

@section('content')

@php
    $colorMap = [
        'Licenciatura en Administración'                                        => ['bg' => 'bg-blue-50',    'text' => 'text-blue-600',    'bar' => 'bg-blue-500',    'hover' => 'hover:border-blue-200',    'header' => 'bg-blue-600'],
        'Ingeniería en Mantenimiento Industrial'                                => ['bg' => 'bg-red-50',     'text' => 'text-red-600',     'bar' => 'bg-red-500',     'hover' => 'hover:border-red-200',     'header' => 'bg-red-600'],
        'Licenciatura en Gastronomía'                                           => ['bg' => 'bg-orange-50',  'text' => 'text-orange-600',  'bar' => 'bg-orange-500',  'hover' => 'hover:border-orange-200',  'header' => 'bg-orange-600'],
        'Ingeniería en Tecnologías de la Información e Innovación Digital'      => ['bg' => 'bg-indigo-50',  'text' => 'text-indigo-600',  'bar' => 'bg-indigo-500',  'hover' => 'hover:border-indigo-200',  'header' => 'bg-indigo-600'],
        'Licenciatura en Gestión y Desarrollo Turístico'                        => ['bg' => 'bg-emerald-50', 'text' => 'text-emerald-600', 'bar' => 'bg-emerald-500', 'hover' => 'hover:border-emerald-200', 'header' => 'bg-emerald-600'],
    ];
    $defaultColor = ['bg' => 'bg-gray-50', 'text' => 'text-gray-600', 'bar' => 'bg-gray-500', 'hover' => 'hover:border-gray-200', 'header' => 'bg-gray-600'];
@endphp

<div class="max-w-7xl mx-auto px-4 py-8 space-y-8">

    {{-- Encabezado --}}
    <div class="bg-white rounded-[1.75rem] border border-gray-100 shadow-sm p-8">
        <div class="flex items-center justify-between flex-wrap gap-4">
            <div>
                <h1 class="text-2xl font-extrabold text-gray-800 tracking-tight">Panel de Empresa</h1>
                <p class="text-xs text-gray-400 font-medium mt-1">
                    Bienvenido, {{ session('alumno_nombre') }} —
                    @if(session('rol') === 'empresa')
                        Alumnos asignados a tu empresa
                    @else
                        Vista completa de asistencias
                    @endif
                </p>
            </div>
            <div class="flex items-center gap-3">
                <div class="bg-gray-50 rounded-2xl px-5 py-3 text-center">
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Total alumnos</p>
                    <p class="text-2xl font-extrabold text-gray-800">{{ $estancias->count() }}</p>
                </div>
                <div class="bg-emerald-50 rounded-2xl px-5 py-3 text-center">
                    <p class="text-[10px] font-bold text-emerald-400 uppercase tracking-widest">Carreras</p>
                    <p class="text-2xl font-extrabold text-emerald-700">{{ $porCarrera->count() }}</p>
                </div>
            </div>
        </div>
    </div>

    @if($estancias->isEmpty())
    <div class="bg-white rounded-[1.75rem] border border-gray-100 shadow-sm p-16 text-center">
        <div class="w-16 h-16 rounded-2xl bg-gray-50 flex items-center justify-center mx-auto mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
        </div>
        <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">No hay alumnos asignados</p>
    </div>
    @else

    {{-- Tarjetas de carreras --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
        @foreach($porCarrera as $carrera => $estanciasCarrera)
        @php
            $style  = $colorMap[$carrera] ?? $defaultColor;
            $slug   = Str::slug($carrera);
            $conteo = $estanciasCarrera->count();
        @endphp
        <div onclick="toggleCarrera('{{ $slug }}')"
             id="card-{{ $slug }}"
             class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm hover:shadow-xl {{ $style['hover'] }} transition-all cursor-pointer group relative overflow-hidden">
            <div class="absolute top-0 right-0 p-4">
                <span class="text-[10px] font-black px-3 py-1 rounded-full {{ $style['bg'] }} {{ $style['text'] }}">
                    {{ $conteo }} {{ $conteo === 1 ? 'Alumno' : 'Alumnos' }}
                </span>
            </div>
            <div class="flex items-center gap-4">
                <div class="p-3 {{ $style['bg'] }} rounded-2xl {{ $style['text'] }} group-hover:scale-110 transition-transform">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0v6"/>
                    </svg>
                </div>
                <div class="pr-16">
                    <h3 class="font-black text-gray-800 text-sm leading-tight">{{ $carrera }}</h3>
                    <p class="text-[10px] text-gray-400 font-bold uppercase mt-1">Clic para ver alumnos</p>
                </div>
            </div>
            <div class="mt-4 h-1.5 w-full bg-gray-50 rounded-full overflow-hidden">
                <div class="h-full {{ $style['bar'] }} rounded-full" style="width: 75%"></div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Paneles expandibles por carrera --}}
    @foreach($porCarrera as $carrera => $estanciasCarrera)
    @php
        $style = $colorMap[$carrera] ?? $defaultColor;
        $slug  = Str::slug($carrera);
    @endphp
    <div id="panel-{{ $slug }}" class="hidden">
        <div class="bg-white rounded-3xl border border-gray-100 shadow-xl overflow-hidden">

            {{-- Header --}}
            <div class="{{ $style['header'] }} px-8 py-5 flex items-center justify-between">
                <h3 class="font-black text-white text-sm">{{ $carrera }}</h3>
                <button onclick="toggleCarrera('{{ $slug }}')" class="text-white/70 hover:text-white transition-colors">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            {{-- Tabla de alumnos --}}
            <table class="w-full">
                <thead class="bg-gray-50/50 border-b border-gray-100">
                    <tr>
                        <th class="px-8 py-4 text-left text-[10px] font-black text-gray-400 uppercase tracking-widest">Alumno</th>
                        <th class="px-8 py-4 text-center text-[10px] font-black text-gray-400 uppercase tracking-widest">Empresa</th>
                        <th class="px-8 py-4 text-center text-[10px] font-black text-gray-400 uppercase tracking-widest">Periodo</th>
                        <th class="px-8 py-4 text-center text-[10px] font-black text-gray-400 uppercase tracking-widest">Estatus</th>
                        <th class="px-8 py-4 text-center text-[10px] font-black text-gray-400 uppercase tracking-widest">Asistencias</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach($estanciasCarrera as $estancia)
                    @php
                        $rutaCalendario = session('rol') === 'alumno'
                            ? route('alumno.calendario', $estancia->id)
                            : route('empresa.calendario', $estancia->id);
                    @endphp
                    <tr class="hover:bg-gray-50/30 transition-all border-b border-gray-50">
                        <td class="px-8 py-5">
                            <div class="flex items-center gap-3">
                                <div class="h-9 w-9 rounded-xl {{ $style['bg'] }} flex items-center justify-center {{ $style['text'] }} font-bold text-sm uppercase">
                                    {{ substr($estancia->alumno->nombre, 0, 1) }}
                                </div>
                                <div>
                                    <p class="font-bold text-gray-800 text-sm">{{ $estancia->alumno->nombre }}</p>
                                    <p class="text-[10px] text-gray-400">{{ $estancia->alumno->matricula }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-5 text-center">
                            <p class="text-xs font-bold {{ $style['text'] }}">{{ $estancia->empresa->nombre ?? '—' }}</p>
                        </td>
                        <td class="px-8 py-5 text-center">
                            <p class="text-xs font-bold text-emerald-600">{{ \Carbon\Carbon::parse($estancia->fecha_inicio)->format('d/m/Y') }}</p>
                            <p class="text-xs text-gray-400">→ {{ \Carbon\Carbon::parse($estancia->fecha_fin)->format('d/m/Y') }}</p>
                        </td>
                        <td class="px-8 py-5 text-center">
                            <span class="text-[10px] font-black uppercase
                                {{ $estancia->estatus === 'Finalizada' ? 'text-emerald-500' : 'text-blue-500' }}">
                                {{ $estancia->estatus }}
                            </span>
                        </td>
                        <td class="px-8 py-5 text-center">
                            <a href="{{ $rutaCalendario }}"
                               class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-bold
                                      {{ $style['bg'] }} {{ $style['text'] }} hover:opacity-80 transition-all border border-current/20">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                Ver calendario
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endforeach

    @endif
</div>

@push('scripts')
<script>
function toggleCarrera(slug) {
    const panel  = document.getElementById('panel-' + slug);
    const abierto = !panel.classList.contains('hidden');
    document.querySelectorAll('[id^="panel-"]').forEach(p => p.classList.add('hidden'));
    if (!abierto) {
        panel.classList.remove('hidden');
        setTimeout(() => panel.scrollIntoView({ behavior: 'smooth', block: 'start' }), 50);
    }
}
</script>
@endpush

@endsection