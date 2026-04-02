@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-8">

    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-4xl font-bold text-gray-800 tracking-tight">Alumnos</h1>
            <p class="text-gray-500 mt-1">Gestión de alumnos y sus carreras</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <div class="lg:col-span-1">
            <div class="bg-white shadow-xl rounded-2xl p-6 border border-gray-100 sticky top-8">
                <h2 class="text-xl font-bold text-gray-800 mb-6 flex items-center gap-2">
                    <span class="bg-blue-100 text-blue-600 p-1 rounded">👤</span>
                    Registrar Alumno
                </h2>

               <form action="{{ route('alumnos.store') }}" method="POST" class="space-y-4">
    @csrf
    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-1">Nombre Completo:</label>
        <input type="text" name="nombre" 
            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:border-green-500 focus:ring-2 focus:ring-green-500/20 outline-none transition-all" 
            placeholder="Ej. Juan Pérez" required>
    </div>

    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-1">Matrícula:</label>
        <input type="text" name="matricula" 
            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:border-green-500 focus:ring-2 focus:ring-green-500/20 outline-none transition-all" 
            placeholder="20240001" required>
    </div>

    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-1">Carrera:</label>
        <select name="carrera" 
            class="w-full border border-gray-300 rounded-lg px-4 py-2 bg-white focus:border-green-500 focus:ring-2 focus:ring-green-500/20 outline-none cursor-pointer transition-all" 
            required>
            <option value="" disabled selected>Selecciona una opción</option>
            <option value="Licenciatura en Administración">Licenciatura en Administración</option>
            <option value="Ingeniería en Mantenimiento Industrial">Ingeniería en Mantenimiento Industrial</option>
            <option value="Licenciatura en Gastronomía">Licenciatura en Gastronomía</option>
            <option value="Ingeniería en Tecnologías de la Información e Innovación Digital">Ingeniería en Tecnologías de la Información e Innovación Digital</option>
            <option value="Licenciatura en Gestión y Desarrollo Turístico">Licenciatura en Gestión y Desarrollo Turístico</option>
        </select>
    </div>

    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-1">Email Institucional:</label>
        <input type="email" name="email" 
            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:border-green-500 focus:ring-2 focus:ring-green-500/20 outline-none transition-all" 
            placeholder="alumno@universidad.edu" required>
    </div>

    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-1">Teléfono:</label>
        <input type="text" name="telefono" 
            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:border-green-500 focus:ring-2 focus:ring-green-500/20 outline-none transition-all" 
            placeholder="999 000 0000" required>
    </div>

    <button type="submit" class="w-full bg-blue-600 text-white font-bold py-3 rounded-xl hover:bg-blue-700 shadow-lg shadow-blue-100 transition active:scale-95 mt-4">
        Guardar Alumno
    </button>
</form>
            </div>
        </div>

        <div class="lg:col-span-2">
            <div class="bg-white shadow-xl rounded-2xl overflow-hidden border border-gray-100">
                <div class="px-6 py-4 border-b bg-gray-50 flex justify-between items-center">
                    <h2 class="font-bold text-gray-700 uppercase tracking-wider text-xs">Alumnos en el Sistema</h2>
                    <span class="bg-blue-100 text-blue-700 text-xs font-bold px-2.5 py-0.5 rounded-full">{{ $alumnos->count() }} Total</span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="bg-gray-100 text-gray-600 uppercase text-[10px] font-bold">
                            <tr>
                                <th class="p-4">Matrícula</th>
                                <th class="p-4">Nombre</th>
                                <th class="p-4">Carrera</th>
                                <th class="p-4 text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($alumnos as $alumno)
                            <tr class="hover:bg-blue-50/50 transition-colors">
                                <td class="p-4 font-mono text-gray-500">{{ $alumno->matricula }}</td>
                                
                                {{-- NUEVO DISEÑO: Píldora Verde para el Nombre --}}
                                <td class="p-4">
                                    <div class="inline-flex flex-col bg-green-500 text-white px-4 py-2 rounded-full shadow-md">
                                        <p class="font-bold leading-tight">{{ $alumno->nombre }}</p>
                                        <p class="text-[10px] text-green-100 uppercase tracking-wider font-semibold">
                                            {{ $alumno->email }}
                                        </p>
                                    </div>
                                </td>

                                <td class="p-4 text-xs font-medium text-gray-600">
                                    {{ $alumno->carrera }}
                                </td>
                                <td class="p-4 text-center">
                                    <div class="flex justify-center gap-2">
                                        <a href="{{ route('alumnos.edit', $alumno) }}" class="p-2 text-yellow-600 hover:bg-yellow-50 rounded-lg transition" title="Editar">
                                            ✏️
                                        </a>
                                        <form action="{{ route('alumnos.destroy', $alumno) }}" method="POST" class="form-eliminar">
                                          @csrf 
                                          @method('DELETE')
                                          <button type="submit" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition" title="Eliminar">
                                            🗑️
                                          </button>
                                       </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center py-12">
                                    <div class="text-gray-400">
                                        <p class="text-4xl mb-2">📂</p>
                                        <p class="italic">No hay alumnos registrados aún</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>

@push('scripts')
<script>
    // Notificación Toast de éxito
    @if(session('success'))
        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'success',
            title: "{{ session('success') }}",
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true
        });
    @endif

    // Confirmación de eliminación
    document.querySelectorAll('.form-eliminar').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            Swal.fire({
                title: '¿Estás seguro?',
                text: "Esta acción no se puede deshacer y eliminará permanentemente al alumno.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit();
                }
            });
        });
    });
</script>
@endpush

@endsection