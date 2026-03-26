@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto py-12 px-6">
    <div class="bg-white p-10 rounded-3xl shadow-2xl border border-gray-100">
        <h2 class="text-3xl font-bold text-gray-800 mb-8 flex items-center gap-2">
            <span>✏️</span> Editar Empresa
        </h2>

        <form action="{{ route('empresas.update', $empresa->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Nombre de la Empresa:</label>
                <input type="text" name="nombre" value="{{ $empresa->nombre }}" required 
                    class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 outline-none focus:border-blue-500 transition">
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Dirección:</label>
                <input type="text" name="direccion" value="{{ $empresa->direccion }}" required 
                    class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 outline-none focus:border-blue-500 transition">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Email:</label>
                    <input type="email" name="email" value="{{ $empresa->email }}" required 
                        class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 outline-none focus:border-blue-500 transition">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Teléfono:</label>
                    <input type="text" name="telefono" value="{{ $empresa->telefono }}" required 
                        class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 outline-none focus:border-blue-500 transition">
                </div>
            </div>

            <div class="pt-6 flex gap-3">
                <button type="submit" class="flex-1 bg-yellow-500 text-white font-bold py-4 rounded-xl shadow-lg hover:bg-yellow-600 transition">
                    Guardar Cambios
                </button>
                <a href="{{ route('empresas.index') }}" class="bg-gray-100 text-gray-600 px-6 py-4 rounded-xl hover:bg-gray-200 transition">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</div>
@endsection