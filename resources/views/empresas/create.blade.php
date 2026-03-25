@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-12 px-6 lg:px-8">
    
    <div class="max-w-xl mx-auto mb-10 text-center">
        <h1 class="text-4xl font-extrabold text-gray-900 tracking-tight">
            Registrar Nueva Empresa
        </h1>
        <p class="mt-3 text-lg text-gray-500 max-w-md mx-auto">
            Completa los datos para dar de alta una nueva empresa en el sistema de estadías.
        </p>
    </div>

    <div class="max-w-xl mx-auto bg-white p-10 rounded-3xl shadow-2xl shadow-gray-200/70 border border-gray-100">
        
        <form action="{{ route('empresas.store') }}" method="POST" class="space-y-7">
            @csrf

            <div class="space-y-6">
                
                <div>
                    <label for="nombre" class="block text-sm font-semibold text-gray-700 mb-2 flex items-center gap-2">
                        <span class="text-lg text-gray-400">🏢</span> Nombre de la Empresa:
                    </label>
                    <input type="text" id="nombre" name="nombre" required 
                        placeholder="Ej: Innova Tech Solutions"
                        class="w-full border-2 border-gray-200 rounded-xl px-5 py-3.5 text-gray-800 outline-none focus:border-green-500 focus:ring-4 focus:ring-green-100 transition duration-150 @error('nombre') border-red-500 @enderror">
                    @error('nombre') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="direccion" class="block text-sm font-semibold text-gray-700 mb-2 flex items-center gap-2">
                        <span class="text-lg text-gray-400">📍</span> Dirección Completa:
                    </label>
                    <input type="text" id="direccion" name="direccion" required 
                        placeholder="Calle, Número, Colonia, C.P."
                        class="w-full border-2 border-gray-200 rounded-xl px-5 py-3.5 text-gray-800 outline-none focus:border-green-500 focus:ring-4 focus:ring-green-100 transition duration-150">
                </div>

            </div>

            <div class="border-t border-gray-100 pt-8 mt-8 space-y-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4">Información de Contacto</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="email" class="block text-sm font-semibold text-gray-700 mb-2 flex items-center gap-2">
                            <span class="text-lg text-gray-400">✉️</span> Email Corporativo:
                        </label>
                        <input type="email" id="email" name="email" required 
                            placeholder="contacto@empresa.com"
                            class="w-full border-2 border-gray-200 rounded-xl px-5 py-3.5 text-gray-800 outline-none focus:border-green-500 focus:ring-4 focus:ring-green-100 transition duration-150">
                    </div>

                    <div>
                        <label for="telefono" class="block text-sm font-semibold text-gray-700 mb-2 flex items-center gap-2">
                            <span class="text-lg text-gray-400">📞</span> Teléfono de Contacto:
                        </label>
                        <input type="tel" id="telefono" name="telefono" required 
                            placeholder="(998) 123-4567"
                            class="w-full border-2 border-gray-200 rounded-xl px-5 py-3.5 text-gray-800 outline-none focus:border-green-500 focus:ring-4 focus:ring-green-100 transition duration-150">
                    </div>
                </div>
            </div>

            <div class="border-t border-gray-100 pt-10 mt-10 flex flex-col sm:flex-row-reverse gap-4">
                
                <button type="submit" 
                    class="w-full sm:w-auto bg-green-600 text-white font-bold px-8 py-4 rounded-xl shadow-lg shadow-green-200 hover:bg-green-700 active:scale-95 transition-all duration-200 flex items-center justify-center gap-2">
                    <span class="text-xl"></span>
                    Guardar Empresa
                </button>

                <a href="{{ route('empresas.index') }}" 
                    class="w-full sm:w-auto text-center bg-gray-100 text-gray-600 font-semibold px-8 py-4 rounded-xl hover:bg-gray-200 transition duration-150">
                    Cancelar
                </a>

            </div>

        </form>
    </div>
</div>
@endsection