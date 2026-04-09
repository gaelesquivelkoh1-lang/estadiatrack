<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vinculación UTC - Acceso</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .bg-utc { background-color: #006341; }
        .text-utc { color: #006341; }
        .glass { background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px); }

        .campo-password {
            display: grid;
            grid-template-rows: 0fr;
            opacity: 0;
            transition: grid-template-rows 0.3s ease, opacity 0.3s ease, margin 0.3s ease;
            margin-top: 0;
        }
        .campo-password.visible {
            grid-template-rows: 1fr;
            opacity: 1;
            margin-top: 1.5rem;
        }
        .campo-password > div { overflow: hidden; }
    </style>
</head>
<body class="bg-utc flex items-center justify-center min-h-screen p-6">

    <div class="glass max-w-md w-full rounded-[2.5rem] shadow-2xl p-10 border border-white/20">

        <div class="flex justify-center mb-8">
            <img src="{{ asset('images/utc-logo.png') }}" alt="Logo UTC" class="h-28 w-auto drop-shadow-md">
        </div>

        <div class="text-center mb-10">
            <h1 class="text-3xl font-extrabold text-gray-800 tracking-tight uppercase mb-2">Vinculación</h1>
            <div class="h-1 w-16 bg-utc mx-auto rounded-full mb-3"></div>
            <p class="text-xs font-semibold text-gray-500 uppercase tracking-[0.2em]">
                Registro y Solicitud de <br> Estadía Profesional
            </p>
        </div>

        <form action="{{ route('login.post') }}" method="POST" autocomplete="off">
            @csrf

            {{-- Campo usuario / matrícula --}}
            <div class="group">
                <label class="block text-[10px] font-bold text-gray-400 uppercase ml-4 mb-1 tracking-widest">
                    Credenciales
                </label>
                <input type="text" name="matricula" id="credencialInput"
                    placeholder="Matrícula o usuario" required
                    autocomplete="off"
                    class="w-full bg-gray-50 border-2 border-gray-100 rounded-2xl py-4 px-6 text-center
                           text-lg font-bold text-gray-700 outline-none transition-all
                           group-hover:border-emerald-200 focus:border-emerald-500
                           focus:ring-4 focus:ring-emerald-500/10
                           placeholder:font-normal placeholder:text-gray-300">
            </div>

            {{-- Campo contraseña animado --}}
            <div class="campo-password" id="passwordWrapper">
                <div>
                    <div class="group">
                        <label class="block text-[10px] font-bold text-gray-400 uppercase ml-4 mb-1 tracking-widest">
                            Contraseña
                        </label>
                        <div class="relative">
                            <input type="password" name="password" id="passwordInput"
                                placeholder="Ingresa tu contraseña"
                                autocomplete="new-password"
                                class="w-full bg-gray-50 border-2 border-gray-100 rounded-2xl py-4 px-6 pr-14
                                       text-center text-lg font-bold text-gray-700 outline-none transition-all
                                       group-hover:border-emerald-200 focus:border-emerald-500
                                       focus:ring-4 focus:ring-emerald-500/10
                                       placeholder:font-normal placeholder:text-gray-300">

                            {{-- Botón ojo --}}
                            <button type="button" id="togglePassword"
                                class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400
                                       hover:text-gray-700 transition-colors focus:outline-none"
                                aria-label="Mostrar contraseña">
                                <svg id="iconoOjo" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <svg id="iconoOjoTachado" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-6">
                <button type="submit"
                    class="w-full bg-emerald-700 hover:bg-emerald-800 border-2 border-emerald-900
                           text-white font-bold py-4 rounded-2xl shadow-xl shadow-emerald-900/30
                           ring-2 ring-emerald-500 ring-offset-2 transition-all active:scale-[0.98]
                           flex items-center justify-center gap-3 uppercase tracking-wider text-sm">
                    <span>Ingresar al Sistema</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                    </svg>
                </button>
            </div>
        </form>

        @if(session('error'))
        <div class="mt-6">
            <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-xl flex items-center gap-3">
                <span class="text-xl">⚠️</span>
                <p class="text-xs font-bold text-red-700 leading-tight">{{ session('error') }}</p>
            </div>
        </div>
        @endif

        <div class="mt-12 text-center border-t border-gray-100 pt-8">
            <p class="text-[9px] font-bold text-gray-400 uppercase tracking-[0.3em] mb-1">Infraestructura Informática</p>
            <p class="text-[9px] text-gray-300 font-medium">Universidad Tecnológica del Centro &copy; 2026</p>
        </div>
    </div>

    <script>
        const credencialInput = document.getElementById('credencialInput');
        const passwordWrapper = document.getElementById('passwordWrapper');
        const passwordInput   = document.getElementById('passwordInput');
        const togglePassword  = document.getElementById('togglePassword');
        const iconoOjo        = document.getElementById('iconoOjo');
        const iconoOjoTachado = document.getElementById('iconoOjoTachado');

        // Mostrar/ocultar campo contraseña con animación suave
        credencialInput.addEventListener('input', function () {
            const esAdmin = this.value.trim().length > 0 && !/^\d+$/.test(this.value.trim());
            passwordWrapper.classList.toggle('visible', esAdmin);
            passwordInput.required = esAdmin;
            if (!esAdmin) passwordInput.value = '';
        });

        // Ojo: alternar visibilidad de contraseña
        togglePassword.addEventListener('click', function () {
            const visible = passwordInput.type === 'text';
            passwordInput.type = visible ? 'password' : 'text';
            iconoOjo.classList.toggle('hidden', !visible);
            iconoOjoTachado.classList.toggle('hidden', visible);
        });
    </script>

</body>
</html>