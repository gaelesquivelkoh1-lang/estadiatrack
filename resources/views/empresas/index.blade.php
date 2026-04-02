@extends('layouts.app')

@section('content')

<div class="max-w-7xl mx-auto px-6 py-8">

    <div class="flex justify-between items-center mb-8 bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
        <div class="flex items-center gap-6">
            <img src="{{ asset('images/utc-logo.png') }}" alt="Logo UTC" class="h-16 w-auto object-contain">
            
            <div>
                <h1 class="text-4xl font-bold text-gray-800 tracking-tight">Empresas</h1>
                <p class="text-gray-500 mt-1 flex items-center gap-2">
                    <span class="w-2 h-2 bg-green-500 rounded-full"></span>
                    Gestión de convenios y empresas registradas
                </p>
            </div>
        </div>

        <a href="{{ route('empresas.create') }}" 
           class="bg-blue-600 text-white px-6 py-3 rounded-xl shadow-lg shadow-blue-200 hover:bg-blue-700 hover:-translate-y-0.5 transition-all inline-flex items-center gap-2 font-semibold">
            <span class="text-xl">🏢</span>
            <span>Agrega tu empresa</span>
        </a>
    </div>

    <div class="bg-white shadow-xl rounded-2xl overflow-hidden border border-gray-100">

        <div class="px-6 py-5 border-b bg-gray-50/50 flex justify-between items-center">
            <h2 class="font-bold text-gray-700 flex items-center gap-2">
                <span class="text-blue-500">📋</span> Listado de Registros
            </h2>

            <div class="relative">
                <input type="text" id="searchInput" placeholder="Buscar empresa..." 
                    class="border-2 border-gray-200 rounded-xl px-4 py-2 pl-10 focus:outline-none focus:border-blue-400 focus:ring-4 focus:ring-blue-50 transition-all w-64">
                <span class="absolute left-3 top-2.5 text-gray-400">🔍</span>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 text-gray-500 uppercase text-xs font-bold tracking-wider">
                    <tr>
                        <th class="p-4 text-left">ID</th>
                        <th class="p-4 text-left">Nombre</th>
                        <th class="p-4 text-left">Dirección</th>
                        <th class="p-4 text-left">Email</th>
                        <th class="p-4 text-left">Teléfono</th>
                        <th class="p-4 text-center">Acciones</th>
                    </tr>
                </thead>

                <tbody id="empresasTable" class="divide-y divide-gray-100">
                    @forelse($empresas as $empresa)
                    <tr class="hover:bg-blue-50/30 transition-colors">
                        <td class="p-4 text-gray-400 font-mono text-xs">#{{ $empresa->id }}</td>
                        <td class="p-4 font-bold text-gray-800">{{ $empresa->nombre }}</td>
                        <td class="p-4 text-gray-600">{{ $empresa->direccion }}</td>
                        <td class="p-4">
                            <span class="text-blue-600 bg-blue-50 px-2 py-1 rounded-md">{{ $empresa->email }}</span>
                        </td>
                        <td class="p-4 font-medium text-gray-700">{{ $empresa->telefono }}</td>

                        <td class="p-4">
                            <div class="flex justify-center items-center gap-3">
                                <a href="{{ route('empresas.edit', $empresa->id) }}" 
                                   class="text-yellow-600 bg-yellow-50 hover:bg-yellow-100 p-2 rounded-lg transition-colors shadow-sm border border-yellow-100"
                                   title="Editar Empresa">
                                   ✏️ <span class="font-bold ml-1">Editar</span>
                                </a>

                                {{-- MODIFICADO: Se quitó el onsubmit y se agregó class="form-eliminar" y data-nombre --}}
                                {{-- Dentro del @forelse en la tabla --}}
<form action="{{ route('empresas.destroy', $empresa->id) }}" method="POST" class="form-eliminar" data-nombre="{{ $empresa->nombre }}">
    @csrf
    @method('DELETE')
    <button type="submit" class="text-red-600 bg-red-50 hover:bg-red-100 p-2 rounded-lg transition-colors shadow-sm border border-red-100 font-bold">
        🗑️ Eliminar
    </button>
</form>

{{-- Script al final del archivo index --}}
@push('scripts')
<script>
    document.querySelectorAll('.form-eliminar').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            const nombre = this.getAttribute('data-nombre');
            
            Swal.fire({
                title: '¿Eliminar empresa?',
                text: `Estás a punto de borrar a "${nombre}". Esta acción no se puede deshacer.`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit();
                }
            });
        });
    });
</script>
@endpush
                            </div>
                        </td>
                    </tr>

                    @empty
                    <tr id="noDataRow">
                        <td colspan="6" class="text-center py-20">
                            <div class="flex flex-col items-center">
                                <span class="text-6xl mb-4 grayscale">🏢</span>
                                <p class="text-gray-400 text-lg font-medium">No se encontraron empresas registradas.</p>
                                <p class="text-gray-300 text-sm">Comienza agregando una nueva empresa al sistema.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 text-xs text-gray-400 italic">
            Mostrando el listado oficial de la base de datos de vinculación.
        </div>
    </div>
</div>

{{-- AGREGADO: Scripts para SweetAlert2 y búsqueda --}}
@push('scripts')
<script>
    // Buscador en tiempo real
    document.getElementById('searchInput').addEventListener('keyup', function() {
        let texto = this.value.toLowerCase();
        let filas = document.querySelectorAll('#empresasTable tr:not(#noDataRow)');

        filas.forEach(fila => {
            let contenidoFila = fila.textContent.toLowerCase();
            if (contenidoFila.indexOf(texto) > -1) {
                fila.style.display = ""; 
            } else {
                fila.style.display = "none"; 
            }
        });
    });

    // Notificación Toast de éxito para Guardar/Actualizar/Eliminar
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

    // Confirmación con SweetAlert2 para eliminar
    document.querySelectorAll('.form-eliminar').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            // Extraemos el nombre de la empresa desde el atributo data-nombre
            const nombreEmpresa = this.getAttribute('data-nombre');
            
            Swal.fire({
                title: '¿Estás seguro?',
                text: `Estás a punto de eliminar la empresa "${nombreEmpresa}". Esta acción no se puede deshacer.`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit();
                }
            });
        });
    });
</script>
@endpush

@endsection