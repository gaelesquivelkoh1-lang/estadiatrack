<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>EstadiaTrack</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100">

    <nav class="bg-gray-900 text-white shadow">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
            <h1 class="text-xl font-bold">EstadiaTrack</h1>
            <div class="flex gap-6">
                <a href="{{ route('empresas.index') }}" class="hover:text-blue-400">Empresas</a>
                <a href="{{ route('alumnos.index') }}" class="hover:text-blue-400">Alumnos</a>
                <a href="{{ route('estancias.index') }}" class="hover:text-blue-400">Estancias</a>
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto px-6 py-6">
        {{-- Quitamos el div de success normal porque ahora usaremos los Toasts de SweetAlert --}}
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    {{-- Esta línea es CRÍTICA: Permite que el JS de tus vistas aparezca aquí --}}
    @stack('scripts')

</body>
</html>