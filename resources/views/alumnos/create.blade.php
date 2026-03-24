@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto p-6 bg-white shadow-md rounded-lg mt-10">
    <div class="flex items-center gap-3 mb-6 border-b pb-4">
        <div class="p-2 bg-blue-100 text-blue-600 rounded-lg">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147L12 15l7.74-4.853a4.833 4.833 0 012.26 3.933v4.33a4.833 4.833 0 01-4.833 4.833H6.833A4.833 4.833 0 012 18.413v-4.33a4.833 4.833 0 012.26-3.933z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 3L2 9l10 6 10-6-10-6z" />
            </svg>
        </div>
        <h1 class="text-2xl font-bold text-gray-800">Registrar Alumno</h1>
    </div>

    <form action="{{ route('alumnos.store') }}" method="POST" class="space-y-5">
        @csrf
        
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Nombre Completo:</label>
            <input type="text" name="nombre" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-blue-100 focus:border-blue-500 outline-none transition" placeholder="Ej. Juan Pérez" required>
        </div>

        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Matrícula:</label>
            <input type="text" name="matricula" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-blue-100 focus:border-blue-500 outline-none transition" placeholder="20240001" required>
        </div>

        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Carrera:</label>
            <select name="carrera" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 bg-white focus:ring-2 focus:ring-blue-100 focus:border-blue-500 outline-none transition cursor-pointer" required>
                <option value="" disabled selected>Selecciona una carrera...</option>
                <option value="Licenciatura en Administración">Licenciatura en Administración</option>
                <option value="Ingeniería en Mantenimiento Industrial">Ingeniería en Mantenimiento Industrial</option>
                <option value="Licenciatura en Gastronomía">Licenciatura en Gastronomía</option>
                <option value="Ingeniería en Tecnologías de la Información e Innovación Digital">Ingeniería en Tecnologías de la Información e Innovación Digital</option>
                <option value="Licenciatura en Gestión y Desarrollo Turístico">Licenciatura en Gestión y Desarrollo Turístico</option>
            </select>
        </div>

        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Asignar Empresa:</label>
            <select name="empresa_id" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 bg-white focus:ring-2 focus:ring-blue-100 focus:border-blue-500 outline-none transition cursor-pointer" required>
                <option value="" disabled selected>Selecciona la empresa donde estará...</option>
                @foreach($empresas as $empresa)
                    <option value="{{ $empresa->id }}">{{ $empresa->nombre }}</option>
                @endforeach
            </select>
            <p class="text-xs text-gray-500 mt-1 italic">* Si la empresa no aparece, regístrala primero en el apartado de Empresas.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Correo Electrónico:</label>
                <input type="email" name="email" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-blue-100 focus:border-blue-500 outline-none transition" placeholder="alumno@universidad.edu" required>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Teléfono:</label>
                <input type="text" name="telefono" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-blue-100 focus:border-blue-500 outline-none transition" placeholder="999 000 0000" required>
            </div>
        </div>

        <div class="pt-4 border-t border-gray-100 flex gap-3">
            <a href="{{ route('alumnos.index') }}" class="w-1/3 text-center bg-gray-100 text-gray-700 font-semibold py-3 px-4 rounded-lg hover:bg-gray-200 transition">
                Cancelar
            </a>
            <button type="submit" class="w-2/3 bg-blue-600 text-white font-bold py-3 px-4 rounded-lg hover:bg-blue-700 shadow-lg shadow-blue-200 transition transform active:scale-95">
                Guardar Alumno
            </button>
        </div>
    </form>
</div>
@endsection