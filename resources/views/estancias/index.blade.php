@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8 space-y-12">

    {{-- ── FORMULARIO REGISTRAR ESTANCIA ── --}}
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
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
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
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                            Guardar Estancia
                        </button>
                        <button type="button" onclick="document.getElementById('estanciaForm').reset()" class="px-8 bg-gray-100 hover:bg-gray-200 text-gray-500 font-bold py-4 rounded-2xl transition-all">Limpiar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- ── ESTADÍAS POR CARRERA ── --}}
    <div class="space-y-6">
        <div class="flex items-center justify-between border-b border-gray-100 pb-4">
            <div class="flex items-center gap-3">
                <div class="h-3 w-3 bg-blue-600 rounded-full animate-pulse"></div>
                <h2 class="text-2xl font-black text-gray-800 tracking-tight">Estadías por Carrera</h2>
            </div>
        </div>

        @php
            $colorMap = [
                'blue'    => ['bg' => 'bg-blue-50',    'text' => 'text-blue-600',    'bar' => 'bg-blue-500',    'hover' => 'hover:border-blue-200',    'header' => 'bg-blue-600'],
                'red'     => ['bg' => 'bg-red-50',     'text' => 'text-red-600',     'bar' => 'bg-red-500',     'hover' => 'hover:border-red-200',     'header' => 'bg-red-600'],
                'orange'  => ['bg' => 'bg-orange-50',  'text' => 'text-orange-600',  'bar' => 'bg-orange-500',  'hover' => 'hover:border-orange-200',  'header' => 'bg-orange-600'],
                'indigo'  => ['bg' => 'bg-indigo-50',  'text' => 'text-indigo-600',  'bar' => 'bg-indigo-500',  'hover' => 'hover:border-indigo-200',  'header' => 'bg-indigo-600'],
                'emerald' => ['bg' => 'bg-emerald-50', 'text' => 'text-emerald-600', 'bar' => 'bg-emerald-500', 'hover' => 'hover:border-emerald-200', 'header' => 'bg-emerald-600'],
            ];

            $carreras = [
                ['nombre' => 'Licenciatura en Administración',                                        'color' => 'blue',    'icon' => 'M16 8v8m-4-5v5m-4-2v2'],
                ['nombre' => 'Ingeniería en Mantenimiento Industrial',                                'color' => 'red',     'icon' => 'M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4'],
                ['nombre' => 'Licenciatura en Gastronomía',                                           'color' => 'orange',  'icon' => 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253'],
                ['nombre' => 'Ingeniería en Tecnologías de la Información e Innovación Digital',      'color' => 'indigo',  'icon' => 'M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z'],
                ['nombre' => 'Licenciatura en Gestión y Desarrollo Turístico',                        'color' => 'emerald', 'icon' => 'M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064'],
            ];
        @endphp

        {{-- Tarjetas --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($carreras as $c)
            @php
                $style  = $colorMap[$c['color']];
                $slug   = Str::slug($c['nombre']);
                $conteo = $estancias->filter(fn($e) => $e->alumno && $e->alumno->carrera === $c['nombre'])->count();
            @endphp
            <div onclick="toggleCarrera('{{ $slug }}')"
                 id="card-{{ $slug }}"
                 class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm hover:shadow-xl {{ $style['hover'] }} transition-all cursor-pointer group relative overflow-hidden">
                <div class="absolute top-0 right-0 p-4">
                    <span class="text-[10px] font-black px-3 py-1 rounded-full {{ $style['bg'] }} {{ $style['text'] }}">
                        {{ $conteo }} Alumnos
                    </span>
                </div>
                <div class="flex items-center gap-5">
                    <div class="p-4 {{ $style['bg'] }} rounded-2xl {{ $style['text'] }} group-hover:scale-110 transition-transform">
                        <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $c['icon'] }}" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-black text-gray-800 text-sm leading-tight pr-16">{{ $c['nombre'] }}</h3>
                        <p class="text-[10px] text-gray-400 font-bold uppercase mt-1">Clic para ver alumnos</p>
                    </div>
                </div>
                <div class="mt-4 h-1.5 w-full bg-gray-50 rounded-full overflow-hidden">
                    <div class="h-full {{ $style['bar'] }} rounded-full" style="width: {{ $conteo > 0 ? '65%' : '0%' }}"></div>
                </div>
            </div>
            @endforeach
        </div>

        {{-- Paneles expandibles --}}
        @foreach($carreras as $c)
        @php
            $style          = $colorMap[$c['color']];
            $slug           = Str::slug($c['nombre']);
            $alumnosCarrera = $estancias->filter(fn($e) => $e->alumno && $e->alumno->carrera === $c['nombre']);
            $gruposCarrera  = $alumnosCarrera->map(fn($e) => $e->alumno->grupo)->filter()->unique()->sort()->values();
        @endphp

        <div id="panel-{{ $slug }}" class="hidden mt-4">
            <div class="bg-white rounded-3xl border border-gray-100 shadow-xl overflow-hidden">

                {{-- Header --}}
                <div class="{{ $style['header'] }} px-8 py-5 flex items-center justify-between">
                    <h3 class="font-black text-white text-sm">{{ $c['nombre'] }}</h3>
                    <button onclick="toggleCarrera('{{ $slug }}')" class="text-white/70 hover:text-white transition-colors">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                {{-- Filtros --}}
                <div class="px-8 py-5 border-b border-gray-100 bg-gray-50/50">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                        <div>
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1.5">Inicial</label>
                            <select id="inicial-{{ $slug }}" onchange="filtrarPanel('{{ $slug }}')"
                                class="w-full bg-white border border-gray-200 rounded-xl px-3 py-2 text-sm text-gray-700 focus:ring-2 focus:ring-emerald-400 outline-none">
                                <option value="">Todas</option>
                                @foreach(range('A','Z') as $letra)
                                <option value="{{ $letra }}">{{ $letra }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1.5">Fecha inicio desde</label>
                            <input type="date" id="fi-{{ $slug }}" onchange="filtrarPanel('{{ $slug }}')"
                                class="w-full bg-white border border-gray-200 rounded-xl px-3 py-2 text-sm text-gray-700 focus:ring-2 focus:ring-emerald-400 outline-none">
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1.5">Fecha fin hasta</label>
                            <input type="date" id="ff-{{ $slug }}" onchange="filtrarPanel('{{ $slug }}')"
                                class="w-full bg-white border border-gray-200 rounded-xl px-3 py-2 text-sm text-gray-700 focus:ring-2 focus:ring-emerald-400 outline-none">
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1.5">Grupo</label>
                            <select id="grupo-{{ $slug }}" onchange="filtrarPanel('{{ $slug }}')"
                                class="w-full bg-white border border-gray-200 rounded-xl px-3 py-2 text-sm text-gray-700 focus:ring-2 focus:ring-emerald-400 outline-none">
                                <option value="">Todos</option>
                                @foreach($gruposCarrera as $grupo)
                                <option value="{{ strtolower($grupo) }}">{{ $grupo }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="flex items-center justify-between mt-4 flex-wrap gap-3">
                        <button onclick="limpiarFiltros('{{ $slug }}')"
                            class="text-xs font-bold text-gray-400 hover:text-gray-600 flex items-center gap-1 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            Limpiar filtros
                        </button>

                        <a id="excel-{{ $slug }}"
                            href="{{ route('estancias.export', ['carrera' => $c['nombre']]) }}"
                            class="flex items-center gap-2 px-5 py-2 rounded-xl text-xs font-bold text-white
                                   bg-emerald-700 hover:bg-emerald-800 border-2 border-emerald-900
                                   ring-2 ring-emerald-500 ring-offset-1 transition-all shadow-md">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            Descargar Excel
                        </a>
                    </div>
                </div>

                {{-- Tabla --}}
                <table class="w-full">
                    <thead class="bg-gray-50/50 border-b border-gray-100">
                        <tr>
                            <th class="px-8 py-4 text-left text-[10px] font-black text-gray-400 uppercase tracking-widest">Alumno / Empresa</th>
                            <th class="px-8 py-4 text-center text-[10px] font-black text-gray-400 uppercase tracking-widest">Grupo</th>
                            <th class="px-8 py-4 text-center text-[10px] font-black text-gray-400 uppercase tracking-widest">Fechas</th>
                            <th class="px-8 py-4 text-center text-[10px] font-black text-gray-400 uppercase tracking-widest">Estatus</th>
                            <th class="px-8 py-4 text-right text-[10px] font-black text-gray-400 uppercase tracking-widest">Acción</th>
                        </tr>
                    </thead>
                    <tbody id="tbody-{{ $slug }}">
                        @forelse($alumnosCarrera as $estancia)
                        <tr class="fila-carrera hover:bg-gray-50/30 transition-all border-b border-gray-50"
                            data-slug="{{ $slug }}"
                            data-inicial="{{ strtoupper(substr($estancia->alumno->nombre, 0, 1)) }}"
                            data-grupo="{{ strtolower($estancia->alumno->grupo ?? '') }}"
                            data-fecha-inicio="{{ $estancia->fecha_inicio }}"
                            data-fecha-fin="{{ $estancia->fecha_fin }}">
                            <td class="px-8 py-5">
                                <div class="flex items-center gap-4">
                                    <div class="h-9 w-9 rounded-xl {{ $style['bg'] }} flex items-center justify-center {{ $style['text'] }} font-bold text-sm uppercase">
                                        {{ substr($estancia->alumno->nombre, 0, 1) }}
                                    </div>
                                    <div>
                                        <p class="font-bold text-gray-800 text-sm">{{ $estancia->alumno->nombre }}</p>
                                        <p class="text-[10px] {{ $style['text'] }} font-black uppercase">{{ $estancia->empresa->nombre }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-8 py-5 text-center">
                                <span class="text-xs font-bold text-gray-600">{{ $estancia->alumno->grupo ?? '—' }}</span>
                            </td>
                            <td class="px-8 py-5 text-center">
                                <p class="text-xs font-bold text-emerald-600">{{ \Carbon\Carbon::parse($estancia->fecha_inicio)->format('d/m/Y') }}</p>
                                <p class="text-xs text-gray-400">→ {{ \Carbon\Carbon::parse($estancia->fecha_fin)->format('d/m/Y') }}</p>
                            </td>
                            <td class="px-8 py-5 text-center">
                                <span class="text-[9px] font-black uppercase {{ $estancia->estatus == 'Finalizada' ? 'text-emerald-500' : 'text-blue-500' }}">
                                    {{ $estancia->estatus }}
                                </span>
                            </td>
                            <td class="px-8 py-5 text-right">
                                <button class="text-gray-300 hover:text-emerald-600 transition-colors p-2 hover:bg-emerald-50 rounded-lg">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                    </svg>
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-8 py-10 text-center text-gray-400 text-sm">No hay alumnos en esta carrera.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                <div id="sin-{{ $slug }}" class="hidden px-8 py-8 text-center text-gray-400 text-sm">
                    No hay alumnos que coincidan con los filtros.
                </div>
            </div>
        </div>
        @endforeach

    </div>
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

function filtrarPanel(slug) {
    const inicial     = document.getElementById('inicial-' + slug).value.toUpperCase();
    const fechaInicio = document.getElementById('fi-' + slug).value;
    const fechaFin    = document.getElementById('ff-' + slug).value;
    const grupo       = document.getElementById('grupo-' + slug).value.toLowerCase();
    const filas       = document.querySelectorAll('.fila-carrera[data-slug="' + slug + '"]');
    let visibles      = 0;

    filas.forEach(fila => {
        let mostrar = true;
        if (inicial     && fila.getAttribute('data-inicial') !== inicial) mostrar = false;
        if (grupo       && fila.getAttribute('data-grupo') !== grupo) mostrar = false;
        if (fechaInicio && fila.getAttribute('data-fecha-inicio') < fechaInicio) mostrar = false;
        if (fechaFin    && fila.getAttribute('data-fecha-fin') > fechaFin) mostrar = false;
        fila.style.display = mostrar ? 'table-row' : 'none';
        if (mostrar) visibles++;
    });

    document.getElementById('sin-' + slug).classList.toggle('hidden', visibles > 0);

    // Actualizar URL del Excel con filtros activos
    const btnExcel = document.getElementById('excel-' + slug);
    const params   = new URLSearchParams();
    const carrera  = btnExcel.getAttribute('data-carrera');
    if (carrera)     params.append('carrera', carrera);
    if (inicial)     params.append('inicial', inicial);
    if (fechaInicio) params.append('fecha_inicio', fechaInicio);
    if (fechaFin)    params.append('fecha_fin', fechaFin);
    if (grupo)       params.append('grupo', grupo);
    btnExcel.href = '{{ route("estancias.export") }}?' + params.toString();
}

function limpiarFiltros(slug) {
    document.getElementById('inicial-' + slug).value = '';
    document.getElementById('fi-' + slug).value      = '';
    document.getElementById('ff-' + slug).value      = '';
    document.getElementById('grupo-' + slug).value   = '';
    filtrarPanel(slug);
}

function buscarGeneral() {
    const input = document.getElementById('searchInput').value.toLowerCase();
    document.querySelectorAll('.fila-carrera').forEach(fila => {
        fila.style.display = fila.textContent.toLowerCase().includes(input) ? 'table-row' : 'none';
    });
}
</script>
@endpush
@endsection