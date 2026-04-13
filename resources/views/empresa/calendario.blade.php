@extends('layouts.app')

@section('title', 'Calendario de Asistencias')

@section('content')

@php
    $estatusConfig = [
        'asistencia' => ['label' => 'Asistencia', 'bg' => 'bg-emerald-500', 'text' => 'text-white',    'badge' => 'bg-emerald-50 text-emerald-700 border-emerald-200'],
        'falta'      => ['label' => 'Falta',       'bg' => 'bg-red-500',     'text' => 'text-white',    'badge' => 'bg-red-50 text-red-700 border-red-200'],
        'justificada'=> ['label' => 'Justificada', 'bg' => 'bg-amber-400',   'text' => 'text-white',    'badge' => 'bg-amber-50 text-amber-700 border-amber-200'],
        'retardo'    => ['label' => 'Retardo',     'bg' => 'bg-blue-400',    'text' => 'text-white',    'badge' => 'bg-blue-50 text-blue-700 border-blue-200'],
        null         => ['label' => 'Sin registro','bg' => 'bg-gray-100',    'text' => 'text-gray-400', 'badge' => 'bg-gray-50 text-gray-400 border-gray-200'],
    ];

    $diasNombres      = ['Lun', 'Mar', 'Mié', 'Jue', 'Vie'];
    $totalDias        = count($diasMes);
    $totalAsistencias = $asistencias->where('estatus', 'asistencia')->count();
    $totalFaltas      = $asistencias->where('estatus', 'falta')->count();
    $totalJustificadas= $asistencias->where('estatus', 'justificada')->count();
    $totalRetardos    = $asistencias->where('estatus', 'retardo')->count();
@endphp

<div class="max-w-5xl mx-auto px-4 py-8 space-y-6">

    {{-- Encabezado --}}
    <div class="bg-white rounded-[1.75rem] border border-gray-100 shadow-sm p-8">
        <div class="flex items-start justify-between flex-wrap gap-4">
            <div>
                {{-- Botón volver adaptado al rol --}}
                @if(session('rol') === 'alumno')
                <a href="{{ route('perfil') }}"
                   class="flex items-center gap-1.5 text-xs font-semibold text-gray-400 hover:text-gray-700 transition-colors mb-3">
                @else
                <a href="{{ route('empresa.dashboard') }}"
                   class="flex items-center gap-1.5 text-xs font-semibold text-gray-400 hover:text-gray-700 transition-colors mb-3">
                @endif
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    Volver
                </a>

                <h1 class="text-2xl font-extrabold text-gray-800 tracking-tight">{{ $alumno->nombre }}</h1>
                <p class="text-xs text-gray-400 font-medium mt-1">
                    {{ $alumno->carrera }} · {{ $alumno->matricula }}
                </p>
                <p class="text-xs text-gray-400 mt-1">
                    Periodo: <span class="font-bold text-gray-600">
                        {{ \Carbon\Carbon::parse($estancia->fecha_inicio)->format('d/m/Y') }} →
                        {{ \Carbon\Carbon::parse($estancia->fecha_fin)->format('d/m/Y') }}
                    </span>
                </p>
            </div>

            {{-- Navegación de mes --}}
            <div class="flex items-center gap-3">
                <a href="?mes={{ $mesAnterior }}"
                   class="w-9 h-9 rounded-xl bg-gray-50 hover:bg-gray-100 flex items-center justify-center transition-all border border-gray-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </a>
                <div class="text-center">
                    <p class="text-sm font-extrabold text-gray-800 capitalize">
                        {{ $fechaMes->locale('es')->isoFormat('MMMM YYYY') }}
                    </p>
                    <p class="text-[10px] text-gray-400 font-medium">{{ $totalDias }} días hábiles</p>
                </div>
                <a href="?mes={{ $mesSiguiente }}"
                   class="w-9 h-9 rounded-xl bg-gray-50 hover:bg-gray-100 flex items-center justify-center transition-all border border-gray-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>
        </div>
    </div>

    {{-- Métricas del mes --}}
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
        <div class="bg-emerald-50 rounded-2xl p-4 text-center border border-emerald-100">
            <p class="text-[10px] font-bold text-emerald-400 uppercase tracking-widest mb-1">Asistencias</p>
            <p class="text-3xl font-extrabold text-emerald-700">{{ $totalAsistencias }}</p>
        </div>
        <div class="bg-red-50 rounded-2xl p-4 text-center border border-red-100">
            <p class="text-[10px] font-bold text-red-400 uppercase tracking-widest mb-1">Faltas</p>
            <p class="text-3xl font-extrabold text-red-700">{{ $totalFaltas }}</p>
        </div>
        <div class="bg-amber-50 rounded-2xl p-4 text-center border border-amber-100">
            <p class="text-[10px] font-bold text-amber-400 uppercase tracking-widest mb-1">Justificadas</p>
            <p class="text-3xl font-extrabold text-amber-700">{{ $totalJustificadas }}</p>
        </div>
        <div class="bg-blue-50 rounded-2xl p-4 text-center border border-blue-100">
            <p class="text-[10px] font-bold text-blue-400 uppercase tracking-widest mb-1">Retardos</p>
            <p class="text-3xl font-extrabold text-blue-700">{{ $totalRetardos }}</p>
        </div>
    </div>

    {{-- Calendario --}}
    <div class="bg-white rounded-[1.75rem] border border-gray-100 shadow-sm overflow-hidden">

        {{-- Leyenda --}}
        <div class="px-8 py-4 border-b border-gray-50 flex items-center gap-4 flex-wrap">
            @foreach(['asistencia' => 'Asistencia', 'falta' => 'Falta', 'justificada' => 'Justificada', 'retardo' => 'Retardo'] as $key => $label)
            <div class="flex items-center gap-1.5">
                <div class="w-3 h-3 rounded-full {{ $estatusConfig[$key]['bg'] }}"></div>
                <span class="text-[10px] font-bold text-gray-500 uppercase tracking-wider">{{ $label }}</span>
            </div>
            @endforeach
            @if($puedeEditar)
            <span class="ml-auto text-[10px] text-gray-400 font-medium">Haz clic en un día para registrar</span>
            @else
            <span class="ml-auto text-[10px] text-gray-400 font-medium">Solo lectura</span>
            @endif
        </div>

        {{-- Grid del calendario --}}
        <div class="p-6">
            @if(count($diasMes) === 0)
            <div class="text-center py-12">
                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Sin días hábiles en este mes dentro del periodo de estancia</p>
            </div>
            @else
            <div class="grid grid-cols-5 gap-3">
                {{-- Encabezados días --}}
                @foreach($diasNombres as $dia)
                <div class="text-center text-[10px] font-black text-gray-400 uppercase tracking-widest pb-2">{{ $dia }}</div>
                @endforeach

                {{-- Spacer para alinear el primer día --}}
                @php
                    $primerDia = $diasMes[0];
                    $diaSemana = $primerDia->dayOfWeekIso - 1;
                @endphp
                @for($i = 0; $i < $diaSemana; $i++)
                <div></div>
                @endfor

                {{-- Días del mes --}}
                @foreach($diasMes as $dia)
                @php
                    $fechaKey  = $dia->format('Y-m-d');
                    $registro  = $asistencias->get($fechaKey);
                    $estatus   = $registro?->estatus ?? null;
                    $config    = $estatusConfig[$estatus] ?? $estatusConfig[null];
                    $esHoy     = $dia->isToday();
                    $tienaNota = $registro?->nota;
                @endphp

                <div
                    @if($puedeEditar)
                    onclick="abrirModal('{{ $fechaKey }}', '{{ $estatus }}', '{{ $puedeVerNotas ? addslashes($tienaNota ?? '') : '' }}')"
                    @endif
                    class="relative rounded-2xl p-3 text-center transition-all
                           {{ $puedeEditar ? 'cursor-pointer hover:scale-105' : '' }}
                           {{ $config['bg'] }}
                           {{ $esHoy ? 'ring-2 ring-gray-800 ring-offset-2' : '' }}">

                    <p class="text-xs font-bold {{ $config['text'] }}">{{ $dia->format('d') }}</p>

                    @if($registro)
                    <div class="mt-1">
                        <span class="text-[8px] font-black uppercase tracking-wider {{ $config['text'] }} opacity-80">
                            {{ substr($config['label'], 0, 3) }}
                        </span>
                    </div>
                    @endif

                    {{-- Punto amarillo de nota: solo visible para quien puede ver notas --}}
                    @if($tienaNota && $puedeVerNotas)
                    <div class="absolute top-1 right-1 w-2 h-2 rounded-full bg-yellow-400"></div>
                    @endif
                </div>
                @endforeach
            </div>
            @endif
        </div>
    </div>

</div>

{{-- Modal de registro (solo para quien puede editar) --}}
@if($puedeEditar)
<div id="modalAsistencia" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4"
     onclick="if(event.target===this) cerrarModal()">
    <div class="bg-white rounded-[1.75rem] shadow-2xl p-8 w-full max-w-md">

        <div class="flex items-center justify-between mb-6">
            <h2 class="text-lg font-extrabold text-gray-800" id="modalFecha">Registrar asistencia</h2>
            <button onclick="cerrarModal()" class="text-gray-400 hover:text-gray-700 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <div class="grid grid-cols-2 gap-3 mb-5">
            @foreach(['asistencia' => ['Asistencia', 'bg-emerald-500 text-white', 'bg-emerald-50 text-emerald-700 border-emerald-200'],
                      'falta'       => ['Falta',       'bg-red-500 text-white',     'bg-red-50 text-red-700 border-red-200'],
                      'justificada' => ['Justificada', 'bg-amber-400 text-white',   'bg-amber-50 text-amber-700 border-amber-200'],
                      'retardo'     => ['Retardo',     'bg-blue-400 text-white',    'bg-blue-50 text-blue-700 border-blue-200']] as $val => $opt)
            <button type="button"
                onclick="seleccionarEstatus('{{ $val }}')"
                id="btn-{{ $val }}"
                class="estatus-btn py-3 rounded-2xl text-sm font-bold border-2 transition-all
                       {{ $opt[2] }} border-current">
                {{ $opt[0] }}
            </button>
            @endforeach
        </div>

        @if($puedeVerNotas)
        <div class="mb-5">
            <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">Nota del día (opcional)</label>
            <textarea id="notaInput" rows="3"
                placeholder="Escribe una observación sobre este día..."
                class="w-full bg-gray-50 border-2 border-gray-100 rounded-2xl px-4 py-3 text-sm text-gray-700
                       focus:border-emerald-400 focus:ring-4 focus:ring-emerald-500/10 outline-none transition-all resize-none"></textarea>
        </div>
        @else
        <input type="hidden" id="notaInput" value="">
        @endif

        <div class="flex gap-3">
            <button onclick="cerrarModal()"
                class="flex-1 px-4 py-3 rounded-xl text-sm font-semibold text-gray-500 bg-gray-100 hover:bg-gray-200 transition-all">
                Cancelar
            </button>
            <button onclick="guardarAsistencia()"
                class="flex-1 px-4 py-3 rounded-xl text-sm font-bold text-white
                       bg-emerald-700 hover:bg-emerald-800 border-2 border-emerald-900
                       ring-2 ring-emerald-500 ring-offset-1 transition-all">
                Guardar
            </button>
        </div>
    </div>
</div>
@endif

@push('scripts')
<script>
let fechaSeleccionada    = null;
let estatusSeleccionado  = null;

function abrirModal(fecha, estatusActual, notaActual) {
    fechaSeleccionada   = fecha;
    estatusSeleccionado = estatusActual || null;

    const [y, m, d] = fecha.split('-');
    document.getElementById('modalFecha').textContent = `${d}/${m}/${y}`;

    const notaEl = document.getElementById('notaInput');
    if (notaEl) notaEl.value = notaActual || '';

    document.querySelectorAll('.estatus-btn').forEach(btn => {
        btn.classList.remove('ring-4', 'ring-offset-2', 'scale-105');
    });
    if (estatusActual) {
        const btn = document.getElementById('btn-' + estatusActual);
        if (btn) btn.classList.add('ring-4', 'ring-offset-2', 'scale-105');
    }

    document.getElementById('modalAsistencia').classList.remove('hidden');
}

function cerrarModal() {
    document.getElementById('modalAsistencia').classList.add('hidden');
    fechaSeleccionada   = null;
    estatusSeleccionado = null;
}

function seleccionarEstatus(val) {
    estatusSeleccionado = val;
    document.querySelectorAll('.estatus-btn').forEach(btn => {
        btn.classList.remove('ring-4', 'ring-offset-2', 'scale-105');
    });
    document.getElementById('btn-' + val).classList.add('ring-4', 'ring-offset-2', 'scale-105');
}

function guardarAsistencia() {
    if (!estatusSeleccionado) {
        Swal.fire({ toast: true, position: 'top-end', icon: 'warning', title: 'Selecciona un estatus', showConfirmButton: false, timer: 2000 });
        return;
    }

    const notaEl = document.getElementById('notaInput');
    const nota   = notaEl ? notaEl.value : '';

    fetch('{{ route("empresa.asistencia", $estancia->id) }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            fecha:   fechaSeleccionada,
            estatus: estatusSeleccionado,
            nota:    nota
        })
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            cerrarModal();
            Swal.fire({ toast: true, position: 'top-end', icon: 'success', title: 'Asistencia guardada', showConfirmButton: false, timer: 2000, timerProgressBar: true });
            setTimeout(() => location.reload(), 1500);
        }
    })
    .catch(() => {
        Swal.fire({ toast: true, position: 'top-end', icon: 'error', title: 'Error al guardar', showConfirmButton: false, timer: 2000 });
    });
}
</script>
@endpush

@endsection