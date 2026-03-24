@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto p-6 bg-white shadow-md rounded-lg mt-10">
    <h1 class="text-2xl font-bold mb-6 text-gray-800">Registrar Empresa</h1>

    <form action="{{ route('empresas.store') }}" method="POST" class="space-y-4">
        @csrf
        <div>
            <label class="block text-sm font-medium text-gray-700">Nombre:</label>
            <input type="text" name="nombre" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-blue-500 focus:border-blue-500" required>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Dirección:</label>
            <input type="text" name="direccion" class="w-full border border-gray-300 rounded-lg px-4 py-2" required>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Email:</label>
            <input type="email" name="email" class="w-full border border-gray-300 rounded-lg px-4 py-2" required>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Teléfono:</label>
            <input type="text" name="telefono" class="w-full border border-gray-300 rounded-lg px-4 py-2" required>
        </div>
        <button type="submit" class="w-full bg-green-600 text-white font-bold py-2 px-4 rounded-lg hover:bg-green-700 transition">
            Guardar
        </button>
    </form>
</div>
@endsection