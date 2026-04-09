@extends('layouts.app')

@section('title', 'Convenios · Vinculación')

@section('content')

<div class="max-w-7xl mx-auto px-4 py-8 space-y-6">

    {{-- Encabezado --}}
    <div class="bg-white rounded-[1.75rem] border border-gray-100 shadow-sm p-8">
        <div class="flex items-center justify-between flex-wrap gap-4">
            <div>
                <h1 class="text-2xl font-extrabold text-gray-800 tracking-tight">Convenios recibidos</h1>
                <p class="text-xs text-gray-400 font-medium mt-1">Revisa y firma los convenios enviados por los alumnos</p>
            </div>
            <a href="{{ route('vinculacion.dashboard') }}"
               class="text-sm font-semibold text-gray-500 hover:text-gray-800 flex items-center gap-1 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Volver al panel
            </a>
        </div>
    </div>

    {{-- Firma guardada en sesión --}}
    @if(session('firma_vinculacion'))
    <div class="bg-emerald-50 border border-emerald-100 rounded-2xl px-6 py-4 flex items-center justify-between gap-4">
        <div class="flex items-center gap-3">
            <span class="text-emerald-600 text-lg">✓</span>
            <p class="text-xs font-bold text-emerald-700">Firma cargada en sesión. Se usará automáticamente al aprobar convenios.</p>
        </div>
        <button onclick="document.getElementById('modalFirma').classList.remove('hidden')"
            class="text-xs font-bold text-emerald-700 underline hover:no-underline">
            Cambiar firma
        </button>
    </div>
    @else
    <div class="bg-amber-50 border border-amber-100 rounded-2xl px-6 py-4 flex items-center justify-between gap-4">
        <div class="flex items-center gap-3">
            <span class="text-amber-500 text-lg">⚠️</span>
            <p class="text-xs font-bold text-amber-700">No tienes una firma registrada. Agrégala antes de firmar convenios.</p>
        </div>
        <button onclick="document.getElementById('modalFirma').classList.remove('hidden')"
            class="text-xs font-bold text-white bg-amber-500 hover:bg-amber-600 px-4 py-2 rounded-xl transition-all">
            Registrar firma
        </button>
    </div>
    @endif

    {{-- Lista de convenios --}}
    <div class="bg-white rounded-[1.75rem] border border-gray-100 shadow-sm overflow-hidden">

        @if($convenios->isEmpty())
        <div class="text-center py-20">
            <div class="w-14 h-14 rounded-2xl bg-gray-50 flex items-center justify-center mx-auto mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
            </div>
            <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Sin convenios registrados</p>
        </div>
        @else

        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-gray-500 uppercase text-xs font-bold tracking-wider border-b border-gray-100">
                <tr>
                    <th class="p-4 text-left">Alumno</th>
                    <th class="p-4 text-left">Empresa</th>
                    <th class="p-4 text-left">Fecha</th>
                    <th class="p-4 text-center">Estatus</th>
                    <th class="p-4 text-center">Acción</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @foreach($convenios as $convenio)
                <tr class="hover:bg-gray-50/50 transition-colors">
                    <td class="p-4">
                        <p class="font-bold text-gray-800">{{ $convenio->alumno->nombre ?? '—' }}</p>
                        <p class="text-xs text-gray-400">{{ $convenio->alumno->matricula ?? '' }}</p>
                    </td>
                    <td class="p-4">
                        <p class="font-semibold text-gray-700">{{ $convenio->empresa_nombre }}</p>
                        <p class="text-xs text-gray-400">{{ $convenio->empresa_giro }}</p>
                    </td>
                    <td class="p-4 text-xs text-gray-500 font-medium">
                        {{ \Carbon\Carbon::parse($convenio->created_at)->format('d M Y') }}
                    </td>
                    <td class="p-4 text-center">
                        @php
                            $color = match($convenio->estatus) {
                                'firmado'   => 'bg-emerald-50 text-emerald-700 border-emerald-100',
                                'rechazado' => 'bg-red-50 text-red-600 border-red-100',
                                default     => 'bg-amber-50 text-amber-700 border-amber-100',
                            };
                        @endphp
                        <span class="text-[10px] font-bold px-3 py-1.5 rounded-full border {{ $color }} uppercase tracking-wider">
                            {{ ucfirst($convenio->estatus) }}
                        </span>
                    </td>
                    <td class="p-4 text-center">
                        @if($convenio->estatus === 'pendiente')
                            @if(session('firma_vinculacion'))
                            <form action="{{ route('vinculacion.firmar', $convenio->id) }}" method="POST">
                                @csrf
                                <input type="hidden" name="firma" value="{{ session('firma_vinculacion') }}">
                                <button type="submit"
                                    class="px-4 py-2 rounded-xl text-xs font-bold text-white
                                           bg-emerald-700 hover:bg-emerald-800 border border-emerald-900
                                           transition-all active:scale-[0.98]">
                                    Firmar y aprobar
                                </button>
                            </form>
                            @else
                            <span class="text-xs text-gray-400 font-medium">Registra tu firma primero</span>
                            @endif
                        @else
                            <span class="text-xs text-gray-300 font-medium">Procesado</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>
</div>

{{-- ══════════════════════════════════
     MODAL FIRMA CANVAS
══════════════════════════════════ --}}
<div id="modalFirma"
     class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-[1.75rem] shadow-2xl p-8 w-full max-w-lg">

        <div class="flex items-center justify-between mb-6">
            <h2 class="text-lg font-extrabold text-gray-800">Registrar firma</h2>
            <button onclick="document.getElementById('modalFirma').classList.add('hidden')"
                class="text-gray-400 hover:text-gray-700 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <p class="text-xs text-gray-400 font-medium mb-4">Dibuja tu firma en el recuadro. Se guardará durante tu sesión.</p>

        <canvas id="firmaCanvas"
            class="w-full border-2 border-dashed border-gray-200 rounded-2xl cursor-crosshair bg-gray-50"
            height="200">
        </canvas>

        <div class="flex items-center justify-between mt-4 gap-3">
            <button onclick="limpiarFirma()"
                class="px-4 py-2 rounded-xl text-xs font-bold text-gray-500 bg-gray-100 hover:bg-gray-200 transition-all">
                Limpiar
            </button>
            <button onclick="guardarFirma()"
                class="px-6 py-2 rounded-xl text-xs font-bold text-white
                       bg-emerald-700 hover:bg-emerald-800 border border-emerald-900
                       ring-2 ring-emerald-500 ring-offset-1 transition-all">
                Guardar firma
            </button>
        </div>

        {{-- Form oculto para guardar la firma vía POST --}}
        <form id="firmaForm" action="{{ route('vinculacion.guardarFirma') }}" method="POST">
            @csrf
            <input type="hidden" name="firma" id="firmaData">
        </form>

    </div>
</div>

@push('scripts')
<script>
    // ── Canvas de firma ──
    const canvas  = document.getElementById('firmaCanvas');
    const ctx     = canvas.getContext('2d');
    let dibujando = false;

    // Ajustar resolución del canvas al tamaño visual
    function ajustarCanvas() {
        const rect = canvas.getBoundingClientRect();
        canvas.width  = rect.width;
        canvas.height = 200;
        ctx.strokeStyle = '#1f2937';
        ctx.lineWidth   = 2.5;
        ctx.lineCap     = 'round';
        ctx.lineJoin    = 'round';
    }
    ajustarCanvas();
    window.addEventListener('resize', ajustarCanvas);

    function getPosicion(e) {
        const rect = canvas.getBoundingClientRect();
        if (e.touches) {
            return { x: e.touches[0].clientX - rect.left, y: e.touches[0].clientY - rect.top };
        }
        return { x: e.clientX - rect.left, y: e.clientY - rect.top };
    }

    canvas.addEventListener('mousedown',  e => { dibujando = true; ctx.beginPath(); const p = getPosicion(e); ctx.moveTo(p.x, p.y); });
    canvas.addEventListener('mousemove',  e => { if (!dibujando) return; const p = getPosicion(e); ctx.lineTo(p.x, p.y); ctx.stroke(); });
    canvas.addEventListener('mouseup',    () => dibujando = false);
    canvas.addEventListener('mouseleave', () => dibujando = false);
    canvas.addEventListener('touchstart', e => { e.preventDefault(); dibujando = true; ctx.beginPath(); const p = getPosicion(e); ctx.moveTo(p.x, p.y); });
    canvas.addEventListener('touchmove',  e => { e.preventDefault(); if (!dibujando) return; const p = getPosicion(e); ctx.lineTo(p.x, p.y); ctx.stroke(); });
    canvas.addEventListener('touchend',   () => dibujando = false);

    function limpiarFirma() {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
    }

    function guardarFirma() {
        const dataUrl = canvas.toDataURL('image/png');
        document.getElementById('firmaData').value = dataUrl;
        document.getElementById('firmaForm').submit();
    }

    // Notificación SweetAlert si hay mensaje de éxito
    @if(session('success'))
        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'success',
            title: "{{ session('success') }}",
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true
        });
    @endif
</script>
@endpush

@endsection