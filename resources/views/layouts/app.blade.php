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

            <div class="flex items-center gap-6">
                <a href="{{ route('empresas.index') }}" class="hover:text-blue-400">Empresas</a>
                <a href="{{ route('alumnos.index') }}" class="hover:text-blue-400">Alumnos</a>
                <a href="{{ route('estancias.index') }}" class="hover:text-blue-400">Estancias</a>
                 <a href="{{ route('convenios.create') }}" class="hover:text-blue-400">Documentos</a>
                {{-- ── Dropdown de perfil ── --}}
                {{-- DEBUG TEMPORAL --}}
<span style="color:red">{{ session('admin_sesion') ? 'SESION OK' : 'SIN SESION' }}</span>
                @if(session('admin_sesion'))
                <div class="relative" id="profileWrapper">

                    {{-- Botón disparador --}}
                    <button onclick="toggleDropdown()"
                        class="flex items-center gap-2 px-3 py-1.5 rounded-xl bg-gray-800
                               hover:bg-gray-700 border border-gray-700 hover:border-gray-500
                               transition-all duration-150 focus:outline-none">

                        {{-- Avatar con inicial --}}
                        <div class="w-7 h-7 rounded-full bg-emerald-600 flex items-center justify-center
                                    text-white text-xs font-bold select-none">
                            {{ strtoupper(substr(session('alumno_nombre'), 0, 1)) }}
                        </div>

                        <span class="text-sm font-semibold text-gray-200 hidden sm:block max-w-[120px] truncate">
                            {{ session('alumno_nombre') }}
                        </span>

                        <svg id="profileChevron"
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-3 w-3 text-gray-400 transition-transform duration-200"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    {{-- Panel desplegable --}}
                    <div id="profileDropdown"
                        class="hidden absolute right-0 mt-2 w-56 bg-white rounded-2xl shadow-xl
                               border border-gray-100 py-2 z-50">

                        {{-- Encabezado --}}
                        <div class="px-4 pb-3 pt-1 border-b border-gray-100">
                            <p class="text-xs font-bold text-gray-800 truncate">{{ session('alumno_nombre') }}</p>
                            <p class="text-[10px] text-gray-400 mt-0.5">Estudiante · Estadía Profesional</p>
                        </div>

                        {{-- Ir a perfil --}}
                        <a href="{{ route('perfil') }}"
                           class="flex items-center gap-3 mx-2 mt-1 px-3 py-2.5 rounded-xl
                                  text-xs font-semibold text-gray-600
                                  hover:bg-emerald-50 hover:text-emerald-700 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                 viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            Mi perfil
                        </a>

                        <div class="my-1 border-t border-gray-100"></div>

                        {{-- Cerrar sesión --}}
                        <form action="{{ route('logout') }}" method="POST" class="mx-2">
                            @csrf
                            <button type="submit"
                                class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl
                                       text-xs font-semibold text-red-500
                                       hover:bg-red-50 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                     viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>
                                Cerrar sesión
                            </button>
                        </form>

                    </div>
                </div>
                @endif
                {{-- ── Fin dropdown ── --}}

            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto px-6 py-6">
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- Toggle del dropdown --}}
    <script>
        function toggleDropdown() {
            const panel   = document.getElementById('profileDropdown');
            const chevron = document.getElementById('profileChevron');
            panel.classList.toggle('hidden');
            chevron.classList.toggle('rotate-180');
        }

        // Cierra el dropdown al hacer clic fuera
        document.addEventListener('click', function (e) {
            const wrapper = document.getElementById('profileWrapper');
            if (wrapper && !wrapper.contains(e.target)) {
                document.getElementById('profileDropdown').classList.add('hidden');
                document.getElementById('profileChevron').classList.remove('rotate-180');
            }
        });
    </script>

    @stack('scripts')

</body>
</html>