@extends('layouts.app')

@section('title', 'Mi Perfil · Vinculación UTC')

@section('content')

@php
    $avatares = [
        'avatar_admin.svg'        => 'Administración',
        'avatar_industrial.svg'   => 'Industrial',
        'avatar_gastronomia.svg'  => 'Gastronomía',
        'avatar_tecnologias.svg'  => 'Tecnologías',
        'avatar_turismo.svg'      => 'Turismo',
        'avatar_astronauta.svg'   => 'Astronauta',
        'avatar_artista.svg'      => 'Artista',
        'avatar_cientifico.svg'   => 'Científico',
        'avatar_musico.svg'       => 'Músico',
    ];
    $avatarActual = $user->avatar ?? 'avatar_admin.svg';
@endphp

<div class="min-h-screen bg-gray-50 py-8 px-4">
    <div class="max-w-3xl mx-auto space-y-6">

        {{-- Encabezado --}}
        <div class="bg-white rounded-[1.75rem] border border-gray-100 shadow-sm overflow-hidden">
            <div class="h-24 bg-utc relative"></div>
            <div class="pt-2 pb-6 px-8">
                <div class="flex items-end justify-between flex-wrap gap-4 -mt-12">

                    {{-- Avatar + botón editar --}}
                    <div class="flex flex-col items-center gap-2">
                        <div class="w-24 h-24 rounded-2xl bg-white shadow-lg border-4 border-white overflow-hidden">
                            <img src="{{ asset('images/avatares/' . $avatarActual) }}"
                                 alt="Avatar de perfil"
                                 class="w-full h-full object-cover"
                                 id="avatarPreview">
                        </div>
                        <button type="button" id="btnAbrirModal"
                            class="flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-[10px] font-bold
                                   text-emerald-700 bg-emerald-50 hover:bg-emerald-100
                                   border border-emerald-200 transition-all">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                            </svg>
                            Editar imagen de perfil
                        </button>
                    </div>

                    <div class="flex-1 pt-14">
                        <h1 class="text-xl font-extrabold text-gray-800 tracking-tight">{{ $user->nombre }}</h1>
                        <p class="text-xs text-gray-400 font-semibold uppercase tracking-widest mt-0.5">
                            Estudiante · Estadía Profesional
                        </p>
                    </div>

                    <span class="inline-flex items-center gap-1.5 bg-emerald-50 text-utc text-[10px]
                                 font-bold px-3 py-1.5 rounded-full uppercase tracking-wider border border-emerald-100 mt-10">
                        <span class="w-1.5 h-1.5 rounded-full bg-utc"></span>
                        Activo
                    </span>
                </div>
            </div>
        </div>

        {{-- Modal selector de avatares (inline, sin position:fixed) --}}
        <div id="modalAvatares" class="hidden bg-white rounded-[1.75rem] border-2 border-emerald-200 shadow-2xl p-8">

            <div class="flex items-center justify-between mb-2">
                <h2 class="text-lg font-extrabold text-gray-800">Elige tu avatar</h2>
                <button type="button" id="btnCerrarModal"
                    class="text-gray-400 hover:text-gray-700 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <p class="text-xs text-gray-400 mb-5">No se permiten imágenes personalizadas. Solo avatares preestablecidos.</p>

            <form action="{{ route('perfil.avatar') }}" method="POST" id="avatarForm">
                @csrf
                <input type="hidden" name="avatar" id="avatarSeleccionado" value="{{ $avatarActual }}">

                <div class="grid grid-cols-3 gap-3 mb-6">
                    @foreach($avatares as $archivo => $nombre)
                    @php $cardId = 'card-' . str_replace('.', '-', $archivo); @endphp
                    <div onclick="seleccionarAvatar('{{ $archivo }}')"
                         id="{{ $cardId }}"
                         class="avatar-option flex flex-col items-center gap-2 p-3 rounded-2xl border-2 cursor-pointer transition-all
                                {{ $avatarActual === $archivo ? 'border-emerald-500 bg-emerald-50' : 'border-gray-100 hover:border-emerald-200 hover:bg-emerald-50/50' }}">
                        <img src="{{ asset('images/avatares/' . $archivo) }}"
                             alt="{{ $nombre }}"
                             class="w-16 h-16 rounded-xl">
                        <span class="text-[10px] font-bold text-gray-500 text-center leading-tight">{{ $nombre }}</span>
                    </div>
                    @endforeach
                </div>

                <div class="flex gap-3">
                    <button type="button" id="btnCancelar"
                        class="flex-1 px-4 py-3 rounded-xl text-sm font-semibold text-gray-500 bg-gray-100 hover:bg-gray-200 transition-all">
                        Cancelar
                    </button>
                    <button type="submit"
                        class="flex-1 px-4 py-3 rounded-xl text-sm font-bold text-white
                               bg-emerald-700 hover:bg-emerald-800 border-2 border-emerald-900
                               ring-2 ring-emerald-500 ring-offset-1 transition-all">
                        Guardar avatar
                    </button>
                </div>
            </form>
        </div>

        {{-- Datos personales --}}
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
                    <dt class="text-[9px] font-bold text-gray-400 uppercase tracking-[0.18em] mb-1">{{ $label }}</dt>
                    <dd class="text-sm font-semibold text-gray-800">{{ $valor }}</dd>
                </div>
                @endforeach
            </dl>
        </div>

        {{-- Historial --}}
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
                            'en proceso' => ['dot' => 'bg-blue-400',    'badge' => 'bg-blue-50 text-blue-700 border-blue-100'],
                            'revision'   => ['dot' => 'bg-amber-400',   'badge' => 'bg-amber-50 text-amber-700 border-amber-100'],
                            'rechazado'  => ['dot' => 'bg-red-400',     'badge' => 'bg-red-50 text-red-600 border-red-100'],
                            'registrado' => ['dot' => 'bg-gray-400',    'badge' => 'bg-gray-50 text-gray-600 border-gray-100'],
                        ];
                        $estado = strtolower($item->estado ?? 'registrado');
                        $color  = $colores[$estado] ?? $colores['registrado'];
                    @endphp
                    <li class="relative pl-7 pb-6 last:pb-0">
                        <span class="absolute -left-[5px] top-1 w-2.5 h-2.5 rounded-full border-2 border-white {{ $color['dot'] }}"></span>
                        <div class="flex items-start justify-between gap-4 flex-wrap">
                            <div>
                                <p class="text-sm font-semibold text-gray-700 leading-tight">{{ $item->descripcion }}</p>
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

        <div class="text-center pb-4">
            <p class="text-[9px] font-bold text-gray-400 uppercase tracking-[0.25em]">
                Universidad Tecnológica del Centro &copy; 2026
            </p>
        </div>

    </div>
</div>

@push('scripts')
<script>
    // Abrir/cerrar modal inline
    document.getElementById('btnAbrirModal').addEventListener('click', function() {
        const modal = document.getElementById('modalAvatares');
        modal.classList.remove('hidden');
        modal.scrollIntoView({ behavior: 'smooth', block: 'start' });
    });

    document.getElementById('btnCerrarModal').addEventListener('click', function() {
        document.getElementById('modalAvatares').classList.add('hidden');
    });

    document.getElementById('btnCancelar').addEventListener('click', function() {
        document.getElementById('modalAvatares').classList.add('hidden');
    });

    // Seleccionar avatar
    function seleccionarAvatar(archivo) {
        document.getElementById('avatarSeleccionado').value = archivo;

        document.querySelectorAll('.avatar-option').forEach(card => {
            card.classList.remove('border-emerald-500', 'bg-emerald-50');
            card.classList.add('border-gray-100');
        });

        const id = 'card-' + archivo.replace(/\./g, '-');
        const card = document.getElementById(id);
        if (card) {
            card.classList.remove('border-gray-100');
            card.classList.add('border-emerald-500', 'bg-emerald-50');
        }

        document.getElementById('avatarPreview').src = '/images/avatares/' + archivo;
    }

    // Debug submit
    document.getElementById('avatarForm').addEventListener('submit', function(e) {
        const val = document.getElementById('avatarSeleccionado').value;
        console.log('Enviando avatar:', val);
    });

    @if(session('success'))
        Swal.fire({
            toast: true, position: 'top-end', icon: 'success',
            title: "{{ session('success') }}",
            showConfirmButton: false, timer: 3000, timerProgressBar: true
        });
    @endif
</script>
@endpush

@endsection