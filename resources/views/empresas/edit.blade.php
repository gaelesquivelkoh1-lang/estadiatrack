@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto py-12 px-6">
    <div class="bg-white p-10 rounded-3xl shadow-2xl border border-gray-100">
        <h2 class="text-3xl font-bold text-gray-800 mb-8 flex items-center gap-2">
            <span>✏️</span> Editar Empresa
        </h2>

        {{-- Se agregó el id="formActualizarEmpresa" --}}
        <form action="{{ route('empresas.update', $empresa->id) }}" method="POST" id="formActualizarEmpresa" class="space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Nombre de la Empresa:</label>
                <input type="text" name="nombre" value="{{ $empresa->nombre }}" required 
                    pattern="^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s\.]+$"
                    oninput="this.value = this.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s\.]/g, '')"
                    class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 outline-none focus:border-green-500 focus:ring-2 focus:ring-green-500/20 transition-all">
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Dirección:</label>
                <input type="text" name="direccion" value="{{ $empresa->direccion }}" required 
                    class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 outline-none focus:border-green-500 focus:ring-2 focus:ring-green-500/20 transition-all">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Email:</label>
                    <input type="email" name="email" value="{{ $empresa->email }}" required 
                        class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 outline-none focus:border-green-500 focus:ring-2 focus:ring-green-500/20 transition-all">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Teléfono:</label>
                    <input type="text" name="telefono" value="{{ $empresa->telefono }}" required 
                        maxlength="10"
                        oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                        class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 outline-none focus:border-green-500 focus:ring-2 focus:ring-green-500/20 transition-all">
                </div>
            </div>

            <div class="pt-6 flex gap-3">
                <button type="submit" class="flex-1 bg-yellow-500 text-white font-bold py-4 rounded-xl shadow-lg hover:bg-yellow-600 transition active:scale-95">
                    Guardar Cambios
                </button>
                <a href="{{ route('empresas.index') }}" class="bg-gray-100 text-gray-600 px-6 py-4 rounded-xl hover:bg-gray-200 transition font-semibold flex items-center justify-center">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    document.getElementById('formActualizarEmpresa').addEventListener('submit', function(e) {
        e.preventDefault(); // Detenemos el envío automático
        
        Swal.fire({
            title: '¿Confirmar cambios?',
            text: "Se actualizará la información de la empresa en la base de datos.",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#eab308', // Color amarillo para que haga match con tu botón
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Sí, actualizar',
            cancelButtonText: 'Revisar',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                // Si el usuario acepta, enviamos el formulario
                this.submit();
            }
        });
    });
</script>
@endpush
@endsection