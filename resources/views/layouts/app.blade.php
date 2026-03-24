<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>EstadiaTrack</title>

    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100">

    <!-- NAVBAR -->
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

    <!-- CONTENIDO -->
    <div class="max-w-7xl mx-auto px-6 py-6">

        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @yield('content')

    </div>

</body>
</html>