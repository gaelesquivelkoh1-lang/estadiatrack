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
        .bg-utc { background-color: #006341; } /* Verde oficial UTC */
        .text-utc { color: #006341; }
        .glass { background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px); }
    </style>
</head>
<body class="bg-utc flex items-center justify-center min-h-screen p-6">

    <div class="glass max-w-md w-full rounded-[2.5rem] shadow-2xl p-10 border border-white/20 transform transition-all">
        
        <div class="flex justify-center mb-8">
            <img src="{{ asset('images/utc-logo.png') }}" alt="Logo UTC" class="h-28 w-auto drop-shadow-md">
        </div>

        <div class="text-center mb-10">
            <h1 class="text-3xl font-extrabold text-gray-800 tracking-tight uppercase mb-2">
                Vinculación
            </h1>
            <div class="h-1 w-16 bg-utc mx-auto rounded-full mb-3"></div>
            <p class="text-xs font-semibold text-gray-500 uppercase tracking-[0.2em]">
                Registro y Solicitud de <br> Estadía Profesional
            </p>
        </div>

        <form action="{{ route('login.post') }}" method="POST" class="space-y-6">
            @csrf
            <div class="group">
                <label class="block text-[10px] font-bold text-gray-400 uppercase ml-4 mb-1 tracking-widest">Credenciales</label>
                <input type="text" name="matricula" placeholder="Ingresa tu matrícula" required
                    class="w-full bg-gray-50 border-2 border-gray-100 rounded-2xl py-4 px-6 text-center text-lg font-bold text-gray-700 outline-none transition-all group-hover:border-emerald-200 focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 placeholder:font-normal placeholder:text-gray-300">
            </div>
            
            <button type="submit" 
                class="w-full bg-utc hover:bg-emerald-800 text-white font-bold py-4 rounded-2xl shadow-xl shadow-emerald-900/20 transition-all active:scale-[0.98] flex items-center justify-center gap-3 uppercase tracking-wider text-sm">
                <span>Ingresar al Sistema</span>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                </svg>
            </button>
        </form>

        @if(session('error'))
            <div class="mt-6 animate-bounce">
                <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-xl flex items-center gap-3">
                    <span class="text-xl">⚠️</span>
                    <p class="text-xs font-bold text-red-700 leading-tight">
                        {{ session('error') }}
                    </p>
                </div>
            </div>
        @endif

        <div class="mt-12 text-center border-t border-gray-100 pt-8">
            <p class="text-[9px] font-bold text-gray-400 uppercase tracking-[0.3em] mb-1">
                Infraestructura Informática
            </p>
            <p class="text-[9px] text-gray-300 font-medium">
                Universidad Tecnológica del Centro &copy; 2026
            </p>
        </div>
    </div>

</body>
</html>