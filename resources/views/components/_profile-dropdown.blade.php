{{-- 
    Componente: Dropdown de perfil de usuario
    Uso: @include('components._profile-dropdown')
    Requiere: Auth::user() con campos: nombre, matricula, carrera, cuatrimestre
--}}

@php
    $user    = Auth::user();
    $initials = collect(explode(' ', $user->nombre))->map(fn($w) => strtoupper($w[0]))->take(2)->implode('');
@endphp

<div class="relative" x-data="{ open: false }" @click.outside="open = false">

    {{-- Botón disparador --}}
    <button @click="open = !open"
        class="flex items-center gap-2 px-3 py-1.5 rounded-xl border border-gray-100 bg-gray-50
               hover:bg-emerald-50 hover:border-emerald-200 transition-all duration-150 focus:outline-none">

        {{-- Avatar iniciales --}}
        <div class="w-8 h-8 rounded-full bg-utc flex items-center justify-center text-white text-xs font-bold select-none">
            {{ $initials }}
        </div>

        <div class="text-left hidden sm:block">
            <p class="text-xs font-semibold text-gray-700 leading-tight">{{ $user->nombre }}</p>
            <p class="text-[10px] text-gray-400 leading-tight">Estudiante</p>
        </div>

        {{-- Chevron animado --}}
        <svg xmlns="http://www.w3.org/2000/svg"
            class="h-3 w-3 text-gray-400 transition-transform duration-200"
            :class="{ 'rotate-180': open }"
            fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
        </svg>
    </button>

    {{-- Panel desplegable --}}
    <div x-show="open"
         x-transition:enter="transition ease-out duration-150"
         x-transition:enter-start="opacity-0 -translate-y-1"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-100"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-1"
         class="absolute right-0 mt-2 w-60 bg-white rounded-2xl shadow-xl border border-gray-100 py-2 z-50"
         style="display: none;">

        {{-- Encabezado con datos del usuario --}}
        <div class="flex items-center gap-3 px-4 pb-3 border-b border-gray-50">
            <div class="w-10 h-10 rounded-full bg-utc flex items-center justify-center text-white text-sm font-bold">
                {{ $initials }}
            </div>
            <div>
                <p class="text-xs font-bold text-gray-800 leading-tight">{{ $user->nombre }}</p>
                <p class="text-[10px] text-gray-400 leading-none mt-0.5">
                    {{ $user->matricula }} · {{ $user->carrera ?? 'Sin carrera' }}
                </p>
            </div>
        </div>

        {{-- Opciones de menú --}}
        <div class="mt-1 px-2 space-y-0.5">

            <a href="{{ route('perfil') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold text-gray-600
                      hover:bg-emerald-50 hover:text-utc transition-colors duration-100">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
                Mi perfil
            </a>

            <a href="{{ route('documentos.index') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold text-gray-600
                      hover:bg-emerald-50 hover:text-utc transition-colors duration-100">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                </svg>
                Mis documentos
            </a>

        </div>

        {{-- Separador --}}
        <div class="my-2 border-t border-gray-50"></div>

        {{-- Cerrar sesión --}}
        <div class="px-2">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit"
                    class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold
                           text-red-500 hover:bg-red-50 transition-colors duration-100">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                    Cerrar sesión
                </button>
            </form>
        </div>

    </div>
</div>