@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-10">
    
    <div class="max-w-3xl mx-auto bg-white p-8 rounded-2xl shadow-xl mb-12">
        <div class="flex items-center gap-3 mb-6 border-b pb-4">
            <div class="p-2 bg-green-100 text-green-600 rounded-lg">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <h1 class="text-2xl font-bold text-gray-800">Registrar Estancia</h1>
        </div>

        @if ($errors->any())
            <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded mb-6">
                <p class="font-bold">Por favor corrige los siguientes errores:</p>
                <ul class="mt-2 ml-4 list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('estancias.store') }}" method="POST" class="space-y-5">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Alumno:</label>
                    <select name="alumno_id" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 bg-white focus:ring-2 focus:ring-green-100 focus:border-green-500 transition outline-none cursor-pointer" required>
                        <option value="" disabled selected>Selecciona un alumno</option>
                        @forelse($alumnos ?? [] as $alumno)
                            <option value="{{ $alumno->id }}">{{ $alumno->nombre }}</option>
                        @empty
                            <option value="" disabled>No hay alumnos registrados</option>
                        @endforelse
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Empresa:</label>
                    <select name="empresa_id" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 bg-white focus:ring-2 focus:ring-green-100 focus:border-green-500 transition outline-none cursor-pointer" required>
                        <option value="" disabled selected>Selecciona una empresa</option>
                        @forelse($empresas ?? [] as $empresa)
                            <option value="{{ $empresa->id }}">{{ $empresa->nombre }}</option>
                        @empty
                            <option value="" disabled>No hay empresas registradas</option>
                        @endforelse
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Fecha de Inicio:</label>
                    <input type="date" name="fecha_inicio" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-100 focus:border-green-500 outline-none" required>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Fecha de Fin:</label>
                    <input type="date" name="fecha_fin" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-100 focus:border-green-500 outline-none" required>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Estatus:</label>
                    <select name="estatus" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 bg-white focus:ring-2 focus:ring-green-100 focus:border-green-500 outline-none" required>
                        <option value="En Proceso">En Proceso</option>
                        <option value="Finalizada">Finalizada</option>
                        <option value="Pendiente">Pendiente</option>
                    </select>
                </div>
            </div>

            <div class="pt-4 border-t border-gray-100">
                <button type="submit" class="w-full bg-green-600 text-white font-bold py-3 px-6 rounded-lg hover:bg-green-700 shadow-lg shadow-green-100 transition transform active:scale-95">
                    Guardar Registro de Estancia
                </button>
            </div>
        </form>
    </div>

    <hr class="border-gray-200 mb-12">

    <div class="max-w-5xl mx-auto">
        <div class="flex items-center gap-3 mb-8">
            <span class="flex h-3 w-3">
                <span class="animate-ping absolute inline-flex h-3 w-3 rounded-full bg-blue-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-3 w-3 bg-blue-500"></span>
            </span>
            <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">Estadías en Proceso</h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @php
                $carreras = [
                    'Licenciatura en Administración' => '📊',
                    'Ingeniería en Mantenimiento Industrial' => '🛠️',
                    'Licenciatura en Gastronomía' => '🍳',
                    'Ingeniería en Tecnologías de la Información e Innovación Digital' => '💻',
                    'Licenciatura en Gestión y Desarrollo Turístico' => '🏨'
                ];
            @endphp

            @foreach($carreras as $nombreCarrera => $icono)
                @php
                    // Filtro que ignora mayúsculas/minúsculas y espacios extras para encontrar al alumno
                    $alumnosEnEstaCarrera = $estancias->filter(function($e) use ($nombreCarrera) {
                        return trim(strtolower(optional($e->alumno)->carrera)) === trim(strtolower($nombreCarrera));
                    });
                    $conteo = $alumnosEnEstaCarrera->count();
                @endphp

                <div x-data="{ open: false }" class="bg-white border border-gray-200 rounded-2xl shadow-sm hover:shadow-md transition-all duration-300 overflow-hidden">
                    <button @click="open = !open" class="w-full flex items-center justify-between p-5 hover:bg-gray-50 transition text-left">
                        <div class="flex items-center gap-4">
                            <span class="text-3xl bg-gray-100 p-2 rounded-xl">{{ $icono }}</span>
                            <div>
                                <h3 class="font-bold text-gray-800 leading-tight">{{ $nombreCarrera }}</h3>
                                <span class="text-sm {{ $conteo > 0 ? 'text-green-600 font-bold' : 'text-blue-500' }}">
                                    {{ $conteo }} {{ $conteo == 1 ? 'Alumno activo' : 'Alumnos activos' }}
                                </span>
                            </div>
                        </div>
                        <svg :class="open ? 'rotate-180' : ''" class="w-6 h-6 text-gray-400 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>

                    <div x-show="open" x-cloak x-collapse class="bg-gray-50 border-t border-gray-100 p-5">
                        <div class="space-y-3">
                            @forelse($alumnosEnEstaCarrera as $estancia)
                                <div class="flex items-center justify-between bg-white p-4 rounded-xl border border-gray-200 shadow-sm">
                                    <div>
                                        <p class="font-bold text-gray-900">{{ $estancia->alumno->nombre }}</p>
                                        <div class="flex items-center gap-2 mt-1">
                                            <span class="text-xs font-semibold px-2 py-0.5 bg-blue-50 text-blue-700 rounded-md">
                                                {{ $estancia->empresa->nombre }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-[10px] uppercase font-bold text-gray-400 tracking-wider">Finaliza</p>
                                        <p class="text-sm font-mono font-bold text-gray-700">
                                            {{ \Carbon\Carbon::parse($estancia->fecha_fin)->format('d/m/Y') }}
                                        </p>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-6 bg-white rounded-xl border border-dashed border-gray-300">
                                    <p class="text-gray-400 text-sm italic">No hay registros exactos para esta carrera.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection