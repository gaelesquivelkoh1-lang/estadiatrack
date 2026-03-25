@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-10">
    <div class="max-w-2xl mx-auto bg-white p-8 rounded-2xl shadow-xl border border-gray-100">
        <div class="flex items-center gap-3 mb-6 border-b pb-4">
            <div class="p-2 bg-yellow-100 text-yellow-600 rounded-lg">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
            </div>
            <h1 class="text-2xl font-bold text-gray-800">Editar Perfil del Alumno</h1>
        </div>

        <form action="{{ route('alumnos.update', $alumno) }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT') <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Nombre Completo:</label>
                <input type="text" name="nombre" value="{{ $alumno->nombre }}" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-yellow-100 outline-none" required>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Matrícula:</label>
                    <input type="text" name="matricula" value="{{ $alumno->matricula }}" class="w-full border border-gray-300 rounded-lg px-4 py-2 outline-none bg-gray-50" required>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Teléfono:</label>
                    <input type="text" name="telefono" value="{{ $alumno->telefono }}" class="w-full border border-gray-300 rounded-lg px-4 py-2 outline-none" required>
                </div>
            </div>

            <div>
    <label class="block text-sm font-semibold text-gray-700 mb-1">Carrera:</label>
    <select name="carrera" class="w-full border border-gray-300 rounded-lg px-4 py-2 outline-none cursor-pointer focus:ring-2 focus:ring-yellow-100" required>
        <optgroup label="Ingenierías">
            <option value="Ingeniería en Mantenimiento Industrial" {{ $alumno->carrera == 'Ingeniería en Mantenimiento Industrial' ? 'selected' : '' }}>
                Ingeniería en Mantenimiento Industrial
            </option>
            <option value="Ingeniería en Tecnologías de la Información e Innovación Digital" {{ $alumno->carrera == 'Ingeniería en Tecnologías de la Información e Innovación Digital' ? 'selected' : '' }}>
                Ingeniería en Tecnologías de la Información e Innovación Digital
            </option>
        </optgroup>

        <optgroup label="Licenciaturas">
            <option value="Licenciatura en Administración" {{ $alumno->carrera == 'Licenciatura en Administración' ? 'selected' : '' }}>
                Licenciatura en Administración
            </option>
            <option value="Licenciatura en Gastronomía" {{ $alumno->carrera == 'Licenciatura en Gastronomía' ? 'selected' : '' }}>
                Licenciatura en Gastronomía
            </option>
            <option value="Licenciatura en Gestión y Desarrollo Turístico" {{ $alumno->carrera == 'Licenciatura en Gestión y Desarrollo Turístico' ? 'selected' : '' }}>
                Licenciatura en Gestión y Desarrollo Turístico
            </option>
        </optgroup>
    </select>
</div>

            <div class="pt-4 flex gap-3">
                <a href="{{ route('alumnos.index') }}" class="w-1/3 text-center bg-gray-100 text-gray-600 font-bold py-3 rounded-lg hover:bg-gray-200 transition">
                    Cancelar
                </a>
                <button type="submit" class="w-2/3 bg-yellow-500 text-white font-bold py-3 rounded-lg hover:bg-yellow-600 shadow-lg shadow-yellow-100 transition">
                    Guardar Cambios
                </button>
            </div>
        </form>
    </div>
</div>
@endsection