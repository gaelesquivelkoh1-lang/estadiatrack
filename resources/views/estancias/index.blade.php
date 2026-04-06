@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8 space-y-12">

    <div class="max-w-4xl mx-auto">
        <div class="mb-6 flex justify-between items-end">
            <div>
                <h1 class="text-3xl font-black text-gray-800 tracking-tight">Registrar Estancia</h1>
                <p class="text-gray-500 text-sm font-medium">Vinculación de alumnos con el sector productivo</p>
            </div>
            <div class="relative hidden md:block">
                <input type="text" id="searchInput" onkeyup="buscarGeneral()" 
                    placeholder="Buscar por nombre o empresa..." 
                    class="pl-10 pr-4 py-2 bg-white border border-gray-200 rounded-xl text-xs focus:ring-2 focus:ring-emerald-500 w-64 shadow-sm outline-none transition-all">
                <div class="absolute left-3 top-2.5 text-gray-400">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-3xl shadow-xl shadow-gray-100 border border-gray-100 overflow-hidden">
            <div class="h-1.5 bg-emerald-500 w-full"></div>
            <div class="p-8">
                <form id="estanciaForm" action="{{ route('estancias.store') }}" method="POST" class="space-y-6">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">Alumno</label>
                            <select name="alumno_id" class="w-full bg-gray-50 border-none rounded-2xl px-4 py-3.5 text-sm text-gray-700 focus:ring-2 focus:ring-emerald-500 transition-all cursor-pointer" required>
                                <option value="">Selecciona un alumno...</option>
                                @foreach($alumnos as $alumno)
                                    <option value="{{ $alumno->id }}">{{ $alumno->nombre }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">Empresa</label>
                            <select name="empresa_id" class="w-full bg-gray-50 border-none rounded-2xl px-4 py-3.5 text-sm text-gray-700 focus:ring-2 focus:ring-emerald-500 transition-all cursor-pointer" required>
                                <option value="">Selecciona una empresa...</option>
                                @foreach($empresas as $empresa)
                                    <option value="{{ $empresa->id }}">{{ $empresa->nombre }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1 text-emerald-600">Fecha de Inicio</label>
                            <input type="date" name="fecha_inicio" class="w-full bg-gray-50 border-none rounded-2xl px-4 py-3.5 text-sm text-gray-700 focus:ring-2 focus:ring-emerald-500 transition-all" required>
                        </div>

                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1 text-red-400">Fecha de Fin</label>
                            <input type="date" name="fecha_fin" class="w-full bg-gray-50 border-none rounded-2xl px-4 py-3.5 text-sm text-gray-700 focus:ring-2 focus:ring-emerald-500 transition-all" required>
                        </div>

                        <div class="md:col-span-2 space-y-2">
                            <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">Estatus del Proceso</label>
                            <select name="estatus" class="w-full bg-gray-50 border-none rounded-2xl px-4 py-3.5 text-sm text-gray-700 focus:ring-2 focus:ring-emerald-500 transition-all" required>
                                <option value="En Proceso" selected>En Proceso</option>
                                <option value="Finalizada">Finalizada</option>
                            </select>
                        </div>
                    </div>

                    <div class="pt-4 flex gap-4">
                        <button type="submit" class="flex-1 bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-4 rounded-2xl shadow-lg shadow-emerald-100 transition-all flex justify-center items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" /></svg>
                            Guardar Estancia
                        </button>
                        <button type="button" onclick="document.getElementById('estanciaForm').reset()" class="px-8 bg-gray-100 hover:bg-gray-200 text-gray-500 font-bold py-4 rounded-2xl transition-all">Limpiar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="space-y-8">
        <div class="flex items-center justify-between border-b border-gray-100 pb-4">
            <div class="flex items-center gap-3">
                <div class="h-3 w-3 bg-blue-600 rounded-full animate-pulse"></div>
                <h2 class="text-2xl font-black text-gray-800 tracking-tight">Estadías por Carrera</h2>
            </div>
            <button onclick="filtrarCarrera('todas')" class="text-xs font-black text-blue-600 uppercase tracking-widest hover:bg-blue-50 px-4 py-2 rounded-xl transition-all">
                Ver todas las carreras
            </button>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @php
                // Definición manual de clases para asegurar que Tailwind las reconozca
                $colorMap = [
                    'blue' => ['bg' => 'bg-blue-50', 'text' => 'text-blue-600', 'bar' => 'bg-blue-500', 'hover' => 'hover:border-blue-200'],
                    'red' => ['bg' => 'bg-red-50', 'text' => 'text-red-600', 'bar' => 'bg-red-500', 'hover' => 'hover:border-red-200'],
                    'orange' => ['bg' => 'bg-orange-50', 'text' => 'text-orange-600', 'bar' => 'bg-orange-500', 'hover' => 'hover:border-orange-200'],
                    'indigo' => ['bg' => 'bg-indigo-50', 'text' => 'text-indigo-600', 'bar' => 'bg-indigo-500', 'hover' => 'hover:border-indigo-200'],
                    'emerald' => ['bg' => 'bg-emerald-50', 'text' => 'text-emerald-600', 'bar' => 'bg-emerald-500', 'hover' => 'hover:border-emerald-200'],
                ];

                $carreras = [
                    ['nombre' => 'Licenciatura en Administración', 'color' => 'blue', 'icon' => 'M16 8v8m-4-5v5m-4-2v2'],
                    ['nombre' => 'Ingeniería en Mantenimiento Industrial', 'color' => 'red', 'icon' => 'M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 001.066 2.573c.94.313 1.572 1.226 1.572 2.218 0 .992-.632 1.905-1.572 2.218a1.724 1.724 0 00-1.066 2.573c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-.94.313-1.572-.632-1.572-1.572 0-.94.313-1.572 1.066-2.573a1.724 1.724 0 000-3.35 1.724 1.724 0 001.066-2.573c.313-.94.632-1.572 1.572-1.572s1.226.632 1.572 1.572a1.724 1.724 0 002.573 1.066z'],
                    ['nombre' => 'Licenciatura en Gastronomía', 'color' => 'orange', 'icon' => 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253'],
                    ['nombre' => 'Ingeniería en Tecnologías de la Información e Innovación Digital', 'color' => 'indigo', 'icon' => 'M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z'],
                    ['nombre' => 'Licenciatura en Gestión y Desarrollo Turístico', 'color' => 'emerald', 'icon' => 'M3.055 11H5a2 2 0 012 2v1M8 11a4 4 0 128 0 4 4 0 02-8 0zm13.055 0H19a2 2 0 00-2 2v1']
                ];
            @endphp

            @foreach($carreras as $c)
                @php 
                    $conteo = $estancias->where('alumno.carrera', $c['nombre'])->count(); 
                    $style = $colorMap[$c['color']];
                @endphp
                <div onclick="filtrarCarrera('{{ $c['nombre'] }}')" 
                     class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm hover:shadow-xl {{ $style['hover'] }} transition-all cursor-pointer group relative overflow-hidden">
                    <div class="absolute top-0 right-0 p-4">
                        <span class="text-[10px] font-black px-3 py-1 rounded-full {{ $style['bg'] }} {{ $style['text'] }} group-hover:bg-opacity-100 transition-all">
                            {{ $conteo }} Alumnos
                        </span>
                    </div>
                    <div class="flex items-center gap-5">
                        <div class="p-4 {{ $style['bg'] }} rounded-2xl {{ $style['text'] }} group-hover:scale-110 transition-transform">
                            <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $c['icon'] }}" /></svg>
                        </div>
                        <div>
                            <h3 class="font-black text-gray-800 text-sm leading-tight pr-16">{{ $c['nombre'] }}</h3>
                            <p class="text-[10px] text-gray-400 font-bold uppercase mt-1">Clic para filtrar</p>
                        </div>
                    </div>
                    <div class="mt-4 h-1.5 w-full bg-gray-50 rounded-full overflow-hidden">
                        <div class="h-full {{ $style['bar'] }} rounded-full transition-all duration-700" style="width: {{ $conteo > 0 ? '65%' : '0%' }}"></div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="bg-white rounded-3xl shadow-xl shadow-gray-100 border border-gray-100 overflow-hidden">
            <table class="w-full">
                <thead class="bg-gray-50/50 border-b border-gray-100">
                    <tr>
                        <th class="px-8 py-5 text-left text-[10px] font-black text-gray-400 uppercase tracking-widest">Alumno / Empresa</th>
                        <th class="px-8 py-5 text-center text-[10px] font-black text-gray-400 uppercase tracking-widest">Estatus de Estadía</th>
                        <th class="px-8 py-5 text-right text-[10px] font-black text-gray-400 uppercase tracking-widest">Acción</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50" id="tableBody">
                    @forelse($estancias as $estancia)
                    <tr class="estancia-row hover:bg-gray-50/30 transition-all duration-300" 
                        data-carrera="{{ $estancia->alumno->carrera }}"
                        data-search="{{ strtolower($estancia->alumno->nombre) }} {{ strtolower($estancia->empresa->nombre) }}"> 
                        <td class="px-8 py-6">
                            <div class="flex items-center gap-4">
                                <div class="h-10 w-10 rounded-xl bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center text-gray-500 font-bold text-sm uppercase">
                                    {{ substr($estancia->alumno->nombre, 0, 1) }}
                                </div>
                                <div>
                                    <p class="font-bold text-gray-800 text-sm">{{ $estancia->alumno->nombre }}</p>
                                    <p class="text-[10px] text-emerald-600 font-black uppercase">{{ $estancia->empresa->nombre }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-6">
                            <div class="flex flex-col items-center gap-1">
                                <span class="text-[9px] font-black uppercase {{ $estancia->estatus == 'Finalizada' ? 'text-emerald-500' : 'text-blue-500' }}">
                                    {{ $estancia->estatus }}
                                </span>
                                <div class="w-32 h-1.5 bg-gray-100 rounded-full overflow-hidden">
                                    <div class="h-full {{ $estancia->estatus == 'Finalizada' ? 'bg-emerald-500' : 'bg-blue-500' }}" style="width: 100%"></div>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-6 text-right">
                            <button class="text-gray-300 hover:text-emerald-600 transition-colors p-2 hover:bg-emerald-50 rounded-lg">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" /></svg>
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="px-8 py-12 text-center text-gray-400 font-medium">
                            No hay estancias registradas actualmente.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
// BUSCADOR POR NOMBRE O EMPRESA
function buscarGeneral() {
    const input = document.getElementById('searchInput').value.toLowerCase();
    const filas = document.querySelectorAll('.estancia-row');
    
    filas.forEach(fila => {
        const contenido = fila.getAttribute('data-search');
        fila.style.display = contenido.includes(input) ? 'table-row' : 'none';
    });
}

// FILTRO POR CARRERA
function filtrarCarrera(nombreCarrera) {
    const filas = document.querySelectorAll('.estancia-row');
    const buscado = nombreCarrera.trim();

    filas.forEach(fila => {
        const carreraFila = fila.getAttribute('data-carrera').trim();
        if (buscado === 'todas' || carreraFila === buscado) {
            fila.style.display = 'table-row';
            fila.style.opacity = '1';
        } else {
            fila.style.display = 'none';
        }
    });
}
</script>
@endsection