<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EstadiaTrack · Acceso</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Rajdhani:wght@500;600;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; }

        body {
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
            background: linear-gradient(160deg, #f59e0b 0%, #fbbf24 25%, #fde68a 55%, #fef3c7 75%, #fffbeb 100%);
            position: relative;
            overflow: hidden;
        }

        body::before {
            content: '';
            position: absolute;
            width: 600px; height: 600px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(255,255,255,0.2) 0%, transparent 70%);
            top: -200px; right: -150px;
            pointer-events: none;
        }
        body::after {
            content: '';
            position: absolute;
            width: 400px; height: 400px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(255,255,255,0.15) 0%, transparent 70%);
            bottom: -100px; left: -100px;
            pointer-events: none;
        }

        .geo-line {
            position: absolute; background: rgba(255,255,255,0.1); pointer-events: none;
        }

        .card {
            position: relative; z-index: 10;
            width: 100%; max-width: 440px;
            background: rgba(255, 255, 255, 0.93);
            backdrop-filter: blur(20px);
            border-radius: 28px;
            padding: 44px 40px;
            box-shadow:
                0 32px 64px rgba(180, 83, 9, 0.15),
                0 0 0 1px rgba(255,255,255,0.6),
                inset 0 1px 0 rgba(255,255,255,0.9);
            animation: slideUp 0.5s ease both;
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(20px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .app-logo-box {
            width: 52px; height: 52px;
            background: linear-gradient(135deg, #f59e0b, #fbbf24);
            border-radius: 14px;
            display: flex; align-items: center; justify-content: center;
            box-shadow: 0 4px 16px rgba(251, 191, 36, 0.4);
            flex-shrink: 0;
            overflow: hidden;
        }

        .app-name {
            font-family: 'Rajdhani', sans-serif;
            font-size: 26px; font-weight: 700;
            color: #b45309;
            letter-spacing: 0.05em;
            margin-bottom: 4px;
        }

        .app-tagline {
            font-size: 10px; font-weight: 500;
            color: #64748b;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            line-height: 1.7;
        }

        .divider {
            height: 1px; margin-bottom: 28px;
            background: linear-gradient(90deg, transparent, #fef3c7, transparent);
        }

        .field-label {
            display: block;
            font-size: 9px; font-weight: 700;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: 0.18em;
            margin-bottom: 6px;
            margin-left: 4px;
        }

        .field-input {
            width: 100%;
            background: #f8fafc;
            border: 2px solid #e2e8f0;
            border-radius: 14px;
            padding: 14px 20px;
            font-family: 'Inter', sans-serif;
            font-size: 15px; font-weight: 600;
            color: #1e293b;
            text-align: center;
            outline: none;
            transition: all 0.2s;
        }
        .field-input:hover { border-color: #fde68a; }
        .field-input:focus { border-color: #fbbf24; box-shadow: 0 0 0 4px rgba(251,191,36,0.1); }
        .field-input::placeholder { font-weight: 400; color: #cbd5e1; font-size: 14px; }

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
            margin-top: 20px;
        }
        .campo-password > div { overflow: hidden; }

        .eye-btn {
            position: absolute; right: 16px; top: 50%; transform: translateY(-50%);
            background: none; border: none; cursor: pointer;
            color: #94a3b8; transition: color 0.15s;
        }
        .eye-btn:hover { color: #f59e0b; }

        .btn-submit {
            width: 100%; margin-top: 24px;
            background: linear-gradient(135deg, #f59e0b 0%, #fbbf24 100%);
            color: white;
            border: none; border-radius: 14px;
            padding: 16px;
            font-family: 'Rajdhani', sans-serif;
            font-size: 15px; font-weight: 700;
            letter-spacing: 0.1em; text-transform: uppercase;
            cursor: pointer;
            display: flex; align-items: center; justify-content: center; gap: 10px;
            transition: all 0.2s;
            box-shadow: 0 8px 24px rgba(251, 191, 36, 0.35);
        }
        .btn-submit:hover {
            background: linear-gradient(135deg, #d97706 0%, #f59e0b 100%);
            box-shadow: 0 12px 32px rgba(251, 191, 36, 0.45);
            transform: translateY(-1px);
        }
        .btn-submit:active { transform: scale(0.98); }

        .footer-badge {
            display: inline-flex; align-items: center; gap: 6px;
            background: linear-gradient(135deg, #fffbeb, #fef3c7);
            border: 1px solid #fef3c7;
            border-radius: 20px;
            padding: 6px 14px;
        }
        .footer-badge-text {
            font-size: 9px; font-weight: 700;
            color: #b45309; letter-spacing: 0.08em; text-transform: uppercase;
        }
    </style>
</head>

<body>
    <div class="geo-line" style="height:1px; width:100%; top:22%; left:0;"></div>
    <div class="geo-line" style="height:1px; width:100%; top:70%; left:0;"></div>
    <div class="geo-line" style="width:1px; height:100%; left:12%; top:0;"></div>
    <div class="geo-line" style="width:1px; height:100%; right:18%; top:0;"></div>

    <div class="card">
        {{-- Logo UTC --}}
        <div class="flex justify-center mb-5">
            <img src="{{ asset('images/utc-logo.png') }}" alt="Logo UTC" class="h-16 w-auto object-contain drop-shadow-sm">
        </div>

        {{-- Separador con logo de la app --}}
        <div class="flex items-center gap-4 mb-5">
            <div style="height:1px; flex:1; background: linear-gradient(to right, transparent, #fef3c7);"></div>
            <div class="app-logo-box">
                <img src="{{ asset('images/estadiatrack-logo.png') }}" alt="EstadiaTrack Logo"
                     class="w-full h-full object-cover"
                     onerror="this.style.display='none'; this.nextElementSibling.style.display='block'">
                
                <svg style="display:none; width:30px; height:30px;" viewBox="0 0 100 120" fill="none">
                    <path d="M78 8 L18 8 L3 55 L38 55 L18 112 L97 43 L53 43 Z" fill="white" opacity="0.95"/>
                </svg>
            </div>
            <div style="height:1px; flex:1; background: linear-gradient(to left, transparent, #fef3c7);"></div>
        </div>

        {{-- Nombre y tagline --}}
        <div class="text-center mb-6">
            <div class="app-name">EstadiaTrack</div>
            <p class="app-tagline">
                Un software desarrollado para la<br>
                <span style="color:#f59e0b; font-weight:600;">Universidad Tecnológica del Centro</span>
            </p>
        </div>

        <div class="divider"></div>

        <form action="{{ route('login.post') }}" method="POST" autocomplete="off">
            @csrf

            <div>
                <label class="field-label">Credenciales de acceso</label>
                <div class="relative">
                    <input type="text" name="matricula" id="credencialInput"
                        placeholder="Matrícula o usuario" required autocomplete="off"
                        class="field-input">
                </div>
            </div>

            <div class="campo-password" id="passwordWrapper">
                <div>
                    <div style="padding-top:2px;">
                        <label class="field-label">Contraseña</label>
                        <div class="relative">
                            <input type="password" name="password" id="passwordInput"
                                placeholder="Ingresa tu contraseña"
                                autocomplete="new-password"
                                class="field-input" style="padding-right:48px;">
                            <button type="button" id="togglePassword" class="eye-btn">
                                <svg id="iconoOjo" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                <svg id="iconoOjoTachado" class="hidden" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn-submit">
                <span>Ingresar al sistema</span>
                <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                </svg>
            </button>
        </form>

        @if(session('error'))
        <div class="mt-5 bg-red-50 border-l-4 border-red-500 rounded-xl p-4 flex items-center gap-3">
            <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="#ef4444" style="flex-shrink:0">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
            </svg>
            <p class="text-xs font-bold text-red-700 leading-tight">{{ session('error') }}</p>
        </div>
        @endif

        <div class="mt-7 pt-5 border-t border-gray-100 text-center">
            <div class="flex justify-center mb-2">
                <div class="footer-badge">
                    <svg width="10" height="10" fill="none" viewBox="0 0 24 24" stroke="#b45309">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                    <span class="footer-badge-text">Acceso seguro · Infraestructura informática</span>
                </div>
            </div>
            <p style="font-size:9px; color:#cbd5e1; font-weight:500;">Universidad Tecnológica del Centro &copy; 2026</p>
        </div>
    </div>

    <script>
        const credencialInput = document.getElementById('credencialInput');
        const passwordWrapper = document.getElementById('passwordWrapper');
        const passwordInput   = document.getElementById('passwordInput');
        const togglePassword  = document.getElementById('togglePassword');
        const iconoOjo        = document.getElementById('iconoOjo');
        const iconoOjoTachado = document.getElementById('iconoOjoTachado');

        credencialInput.addEventListener('input', function () {
            const esAdmin = this.value.trim().length > 0 && !/^\d+$/.test(this.value.trim());
            passwordWrapper.classList.toggle('visible', esAdmin);
            passwordInput.required = esAdmin;
            if (!esAdmin) passwordInput.value = '';
        });

        togglePassword.addEventListener('click', function () {
            const visible = passwordInput.type === 'text';
            passwordInput.type = visible ? 'password' : 'text';
            iconoOjo.classList.toggle('hidden', !visible);
            iconoOjoTachado.classList.toggle('hidden', visible);
        });
    </script>
</body>
</html>