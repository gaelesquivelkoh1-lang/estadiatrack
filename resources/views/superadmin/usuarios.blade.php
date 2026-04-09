@extends('layouts.app')

@section('title', 'Usuarios · Super Admin')

@section('content')

<div class="max-w-5xl mx-auto px-4 py-8 space-y-6">

    {{-- Encabezado --}}
    <div class="bg-white rounded-[1.75rem] border border-gray-100 shadow-sm p-8">
        <div class="flex items-center justify-between flex-wrap gap-4">
            <div>
                <h1 class="text-2xl font-extrabold text-gray-800 tracking-tight">Usuarios de Vinculación</h1>
                <p class="text-xs text-gray-400 font-medium mt-1">Crea y administra los accesos del departamento</p>
            </div>
            <a href="{{ route('superadmin.dashboard') }}"
               class="text-sm font-semibold text-gray-500 hover:text-gray-800 flex items-center gap-1 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Volver al panel
            </a>
        </div>
    </div>

    {{-- Formulario crear usuario --}}
    <div class="bg-white rounded-[1.75rem] border border-gray-100 shadow-sm p-8">
        <h2 class="text-xs font-bold text-gray-400 uppercase tracking-[0.2em] mb-5 flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Crear nuevo usuario
        </h2>

        <form action="{{ route('superadmin.crear') }}" method="POST">
            @csrf
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                <div>
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1.5">Nombre completo *</label>
                    <input type="text" name="nombre" value="{{ old('nombre') }}" required
                        class="w-full bg-gray-50 border-2 border-gray-100 rounded-xl py-3 px-4 text-sm font-semibold text-gray-700
                               focus:border-emerald-400 focus:ring-4 focus:ring-emerald-500/10 outline-none transition-all"
                        placeholder="Lic. María García">
                    @error('nombre') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1.5">Usuario *</label>
                    <input type="text" name="usuario" value="{{ old('usuario') }}" required
                        class="w-full bg-gray-50 border-2 border-gray-100 rounded-xl py-3 px-4 text-sm font-semibold text-gray-700
                               focus:border-emerald-400 focus:ring-4 focus:ring-emerald-500/10 outline-none transition-all"
                        placeholder="mgarcia.vinculacion">
                    @error('usuario') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1.5">Contraseña *</label>
                    <input type="password" name="password" required minlength="8"
                        class="w-full bg-gray-50 border-2 border-gray-100 rounded-xl py-3 px-4 text-sm font-semibold text-gray-700
                               focus:border-emerald-400 focus:ring-4 focus:ring-emerald-500/10 outline-none transition-all"
                        placeholder="Mínimo 8 caracteres">
                    @error('password') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1.5">Confirmar contraseña *</label>
                    <input type="password" name="password_confirmation" required
                        class="w-full bg-gray-50 border-2 border-gray-100 rounded-xl py-3 px-4 text-sm font-semibold text-gray-700
                               focus:border-emerald-400 focus:ring-4 focus:ring-emerald-500/10 outline-none transition-all"
                        placeholder="Repite la contraseña">
                </div>

            </div>

            <div class="flex justify-end mt-6">
                <button type="submit"
                    class="px-8 py-3 rounded-xl text-sm font-bold text-white
                           bg-emerald-700 hover:bg-emerald-800 border-2 border-emerald-900
                           ring-2 ring-emerald-500 ring-offset-2 shadow-lg transition-all active:scale-[0.98]
                           flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Crear usuario
                </button>
            </div>
        </form>
    </div>

    {{-- Lista de usuarios --}}
    <div class="bg-white rounded-[1.75rem] border border-gray-100 shadow-sm overflow-hidden">
        <div class="px-8 py-5 border-b border-gray-50">
            <h2 class="text-xs font-bold text-gray-400 uppercase tracking-[0.2em]">Usuarios registrados</h2>
        </div>

        @if($usuarios->isEmpty())
        <div class="text-center py-16">
            <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Sin usuarios de vinculación</p>
        </div>
        @else
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-gray-500 uppercase text-xs font-bold tracking-wider">
                <tr>
                    <th class="p-4 text-left">Nombre</th>
                    <th class="p-4 text-left">Usuario</th>
                    <th class="p-4 text-center">Estatus</th>
                    <th class="p-4 text-center">Creado</th>
                    <th class="p-4 text-center">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @foreach($usuarios as $admin)
                <tr class="hover:bg-gray-50/50 transition-colors">
                    <td class="p-4 font-bold text-gray-800">{{ $admin->nombre }}</td>
                    <td class="p-4 text-gray-500 font-mono text-xs">{{ $admin->usuario }}</td>
                    <td class="p-4 text-center">
                        @if($admin->activo)
                            <span class="text-[10px] font-bold px-3 py-1 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-100">Activo</span>
                        @else
                            <span class="text-[10px] font-bold px-3 py-1 rounded-full bg-gray-100 text-gray-500 border border-gray-200">Inactivo</span>
                        @endif
                    </td>
                    <td class="p-4 text-center text-xs text-gray-400 font-medium">
                        {{ \Carbon\Carbon::parse($admin->created_at)->format('d M Y') }}
                    </td>
                    <td class="p-4">
                        <div class="flex items-center justify-center gap-2">

                            {{-- Activar / Desactivar --}}
                            <form action="{{ route('superadmin.toggle', $admin->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit"
                                    class="px-3 py-1.5 rounded-lg text-xs font-bold transition-all
                                           {{ $admin->activo
                                              ? 'bg-amber-50 text-amber-700 hover:bg-amber-100 border border-amber-100'
                                              : 'bg-emerald-50 text-emerald-700 hover:bg-emerald-100 border border-emerald-100' }}">
                                    {{ $admin->activo ? 'Desactivar' : 'Activar' }}
                                </button>
                            </form>

                            {{-- Eliminar --}}
                            <form action="{{ route('superadmin.eliminar', $admin->id) }}" method="POST"
                                  class="form-eliminar-admin" data-nombre="{{ $admin->nombre }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="px-3 py-1.5 rounded-lg text-xs font-bold
                                           bg-red-50 text-red-600 hover:bg-red-100 border border-red-100 transition-all">
                                    Eliminar
                                </button>
                            </form>

                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>

</div>

@push('scripts')
<script>
    document.querySelectorAll('.form-eliminar-admin').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            const nombre = this.getAttribute('data-nombre');
            Swal.fire({
                title: '¿Eliminar usuario?',
                text: `Se eliminará el acceso de "${nombre}". Esta acción no se puede deshacer.`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar',
                reverseButtons: true
            }).then(result => {
                if (result.isConfirmed) this.submit();
            });
        });
    });

    @if(session('success'))
        Swal.fire({
            toast: true, position: 'top-end', icon: 'success',
            title: "{{ session('success') }}",
            showConfirmButton: false, timer: 3000, timerProgressBar: true
        });
    @endif

    @if(session('error'))
        Swal.fire({
            toast: true, position: 'top-end', icon: 'error',
            title: "{{ session('error') }}",
            showConfirmButton: false, timer: 3000, timerProgressBar: true
        });
    @endif
</script>
@endpush

@endsection