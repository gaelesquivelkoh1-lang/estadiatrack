@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-8 text-center">Explorar por Carrera</h1>

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
        
        <div class="lg:col-span-1 space-y-2">
            <h2 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-4">Selecciona una Carrera</h2>
            @foreach($carrerasDisponibles as $item)
                <a href="{{ route('carreras.index', $item) }}" 
                   class="block px-4 py-3 rounded-xl transition duration-200 {{ $carrera == $item ? 'bg-blue-600 text-white shadow-lg' : 'bg-white text-gray-700 hover:bg-blue-50 border border-gray-100' }}">
                    <span class="text-sm font-medium">{{ $item }}</span>
                </a>
            @endforeach
        </div>

        <div class="lg:col-span-3">
            @if(!$carrera)
                <div class="bg-blue-50 border-2 border-dashed border-blue-200 rounded-2xl p-12 text-center text-blue-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto mb-4 opacity-50" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <p class="text-xl font-medium">Selecciona una carrera de la izquierda para ver a los alumnos registrados.</p>
                </div>
            @else
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="bg-gray-50 px-6 py-4 border-b border-gray-100">
                        <h2 class="text-lg font-bold text-gray-800">{{ $carrera }}</h2>
                        <p class="text-sm text-gray-500">{{ $alumnos->count() }} alumnos encontrados</p>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead class="bg-gray-50 text-xs uppercase text-gray-500 font-semibold">
                                <tr>
                                    <th class="px-6 py-4">Alumno</th>
                                    <th class="px-6 py-4">Matrícula</th>
                                    <th class="px-6 py-4">Empresa</th>
                                    <th class="px-6 py-4">Fecha Registro</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse($alumnos as $alumno)
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="px-6 py-4 font-medium text-gray-900">{{ $alumno->nombre }}</td>
                                        <td class="px-6 py-4 text-gray-600 font-mono text-xs">{{ $alumno->matricula }}</td>
                                        <td class="px-6 py-4">
                                            <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-bold">
                                                {{ $alumno->empresa->nombre ?? 'Sin asignar' }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-gray-500 text-sm">
                                            {{ $alumno->created_at->format('d/m/Y') }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-10 text-center text-gray-400">
                                            No hay alumnos registrados en esta carrera todavía.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection