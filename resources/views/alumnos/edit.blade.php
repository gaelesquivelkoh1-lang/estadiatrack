@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto px-6 py-8">
    <div class="bg-white shadow-xl rounded-2xl p-8 border border-gray-100">
        <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center gap-2">
            <span class="bg-yellow-100 text-yellow-600 p-1 rounded">✏️</span>
            Editar Datos del Alumno
        </h2>

        {{-- El ID 'formEditar' es clave para el script de abajo --}}
        <form action="{{ route('alumnos.update', $alumno) }}" method="POST" id="formEditar" class="space-y-5">
            @csrf
            @method('PUT') {{-- ESTO ES LO QUE HACE QUE SE GUARDEN LOS CAMBIOS --}}

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Nombre Completo:</label>
                    <input type="text" name="nombre" value="{{ $alumno->nombre }}" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500/20 outline-none" required>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Matrícula:</label>
                    <input type="text" name="matricula" value="{{ $alumno->matricula }}" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500/20 outline-none" required>
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Carrera:</label>
                <select name="carrera" class="w-full border border-gray-300 rounded-lg px-4 py-2 bg-white outline-none cursor-pointer" required>
                    @foreach(['Licenciatura en Administración', 'Ingeniería en Mantenimiento Industrial', 'Licenciatura en Gastronomía', 'Ingeniería en Tecnologías de la Información e Innovación Digital', 'Licenciatura en Gestión y Desarrollo Turístico'] as $c)
                        <option value="{{ $c }}" {{ $alumno->carrera == $c ? 'selected' : '' }}>{{ $c }}</option>
                    @endforeach
                </select>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Email:</label>
                    <input type="email" name="email" value="{{ $alumno->email }}" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500/20 outline-none" required>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Teléfono:</label>
                    <input type="text" name="telefono" value="{{ $alumno->telefono }}" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500/20 outline-none" required>
                </div>
            </div>

            <div class="flex gap-4 pt-6">
                <a href="{{ route('alumnos.index') }}" class="flex-1 text-center bg-gray-100 text-gray-600 font-bold py-3 rounded-xl hover:bg-gray-200 transition">
                    Cancelar
                </a>
                <button type="submit" class="flex-1 bg-blue-600 text-white font-bold py-3 rounded-xl hover:bg-blue-700 shadow-lg shadow-blue-100 transition active:scale-95">
                    Guardar Cambios
                </button>
            </div>
        </form>
    </div>
</div>

{{-- EL SCRIPT DE CONFIRMACIÓN PARA ESTA VISTA --}}
@push('scripts')
<script>
    document.getElementById('formEditar').addEventListener('submit', function(e) {
        e.preventDefault(); // Detenemos el envío automático
        
        Swal.fire({
            title: '¿Confirmar cambios?',
            text: "Se actualizará la información del alumno.",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#2563eb',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Sí, actualizar',
            cancelButtonText: 'Revisar',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                this.submit(); // Si confirma, enviamos el formulario manualmente
            }
        });
    });
</script>
@endpush
@endsection