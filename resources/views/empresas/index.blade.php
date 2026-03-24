@extends('layouts.app')

@section('content')

<div class="max-w-7xl mx-auto px-6 py-8">

    <!-- HEADER -->
    <div class="flex justify-between items-center mb-8">

        <!-- Texto -->
        <div>
            <h1 class="text-4xl font-bold text-gray-800">Empresas</h1>
            <p class="text-gray-500 mt-1">Gestión de empresas registradas</p>
        </div>

        <!-- Botón -->
        <a href="{{ route('empresas.create') }}" 
           class="bg-blue-600 text-white px-6 py-2 rounded-lg shadow hover:bg-blue-700 transition inline-flex items-center gap-2">
            
            <span>➕</span>
            <span>Agrega tu empresa</span>

        </a>

    </div>

    <!-- TARJETA -->
    <div class="bg-white shadow-xl rounded-2xl overflow-hidden border border-gray-100">

        <!-- ENCABEZADO -->
        <div class="px-6 py-4 border-b bg-gray-50 flex justify-between items-center">
            <h2 class="font-semibold text-gray-700">Listado</h2>

            <input type="text" placeholder="Buscar..." 
                class="border rounded-lg px-3 py-1 focus:outline-none focus:ring-2 focus:ring-blue-400">
        </div>

        <!-- TABLA -->
        <div class="overflow-x-auto">
            <table class="w-full text-sm">

                <thead class="bg-gray-100 text-gray-600 uppercase text-xs">
                    <tr>
                        <th class="p-4 text-left">ID</th>
                        <th class="p-4 text-left">Nombre</th>
                        <th class="p-4 text-left">Dirección</th>
                        <th class="p-4 text-left">Email</th>
                        <th class="p-4 text-left">Teléfono</th>
                        <th class="p-4 text-center">Acciones</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($empresas as $empresa)
                    <tr class="border-b hover:bg-gray-50 transition">
                        <td class="p-4 text-gray-500">{{ $empresa->id }}</td>
                        <td class="p-4 font-medium text-gray-800">{{ $empresa->nombre }}</td>
                        <td class="p-4">{{ $empresa->direccion }}</td>
                        <td class="p-4 text-blue-600">{{ $empresa->email }}</td>
                        <td class="p-4">{{ $empresa->telefono }}</td>

                        <td class="p-4 text-center space-x-2">
                            <button class="bg-yellow-400 text-white px-3 py-1 rounded-md hover:bg-yellow-500 transition text-sm">
                                Editar
                            </button>

                            <button class="bg-red-500 text-white px-3 py-1 rounded-md hover:bg-red-600 transition text-sm">
                                Eliminar
                            </button>
                        </td>
                    </tr>

                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-10 text-gray-400">
                            No hay empresas registradas
                        </td>
                    </tr>
                    @endforelse
                </tbody>

            </table>
        </div>

    </div>

</div>

@endsection