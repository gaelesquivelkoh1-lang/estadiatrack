@extends('layouts.app')

@section('title', 'Solicitud de Convenio · Vinculación UTC')

@section('content')

@php $hoy = now()->locale('es')->isoFormat('D [de] MMMM [de] YYYY'); @endphp

<div class="max-w-3xl mx-auto px-4 py-8">

    {{-- Encabezado --}}
    <div class="bg-white rounded-[1.75rem] border border-gray-100 shadow-sm p-8 mb-6">
        <div class="flex items-center gap-4 mb-2">
            <div class="w-10 h-10 rounded-xl bg-emerald-50 flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
            </div>
            <div>
                <h1 class="text-xl font-extrabold text-gray-800 tracking-tight">Convenio de Colaboración</h1>
                <p class="text-xs text-gray-400 font-medium">Llena los datos de la empresa donde realizarás tu estadía</p>
            </div>
        </div>

        @if($convenio)
        <div class="mt-4 bg-amber-50 border border-amber-100 rounded-2xl px-5 py-3 flex items-center gap-3">
            <span class="text-amber-500">⚠️</span>
            <p class="text-xs font-semibold text-amber-700">
                Ya tienes un convenio registrado con estatus <strong>{{ ucfirst($convenio->estatus) }}</strong>.
                Puedes generar uno nuevo o
                <a href="{{ route('convenios.preview') }}" class="underline">ver el actual</a>.
            </p>
        </div>
        @endif
    </div>

    {{-- Formulario --}}
    <form action="{{ route('convenios.store') }}" method="POST" class="space-y-6">
        @csrf

        {{-- Datos de la empresa --}}
        <div class="bg-white rounded-[1.75rem] border border-gray-100 shadow-sm p-8">
            <h2 class="text-xs font-bold text-gray-400 uppercase tracking-[0.2em] mb-5 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>
                Datos de la empresa
            </h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                <div class="sm:col-span-2">
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1.5">Nombre de la empresa *</label>
                    <input type="text" name="empresa_nombre" value="{{ old('empresa_nombre') }}" required
                        class="w-full bg-gray-50 border-2 border-gray-100 rounded-xl py-3 px-4 text-sm font-semibold text-gray-700
                               focus:border-emerald-400 focus:ring-4 focus:ring-emerald-500/10 outline-none transition-all"
                        placeholder="Ej. Empresa Ejemplo S.A. de C.V.">
                    @error('empresa_nombre') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1.5">Calle y número *</label>
                    <input type="text" name="empresa_calle" value="{{ old('empresa_calle') }}" required
                        class="w-full bg-gray-50 border-2 border-gray-100 rounded-xl py-3 px-4 text-sm font-semibold text-gray-700
                               focus:border-emerald-400 focus:ring-4 focus:ring-emerald-500/10 outline-none transition-all"
                        placeholder="Calle 20 #123">
                    @error('empresa_calle') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1.5">Colonia *</label>
                    <input type="text" name="empresa_colonia" value="{{ old('empresa_colonia') }}" required
                        class="w-full bg-gray-50 border-2 border-gray-100 rounded-xl py-3 px-4 text-sm font-semibold text-gray-700
                               focus:border-emerald-400 focus:ring-4 focus:ring-emerald-500/10 outline-none transition-all"
                        placeholder="Centro">
                    @error('empresa_colonia') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1.5">Código postal *</label>
                    <input type="text" name="empresa_cp" value="{{ old('empresa_cp') }}" required maxlength="10"
                        class="w-full bg-gray-50 border-2 border-gray-100 rounded-xl py-3 px-4 text-sm font-semibold text-gray-700
                               focus:border-emerald-400 focus:ring-4 focus:ring-emerald-500/10 outline-none transition-all"
                        placeholder="97000">
                    @error('empresa_cp') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1.5">Municipio *</label>
                    <input type="text" name="empresa_municipio" value="{{ old('empresa_municipio') }}" required
                        class="w-full bg-gray-50 border-2 border-gray-100 rounded-xl py-3 px-4 text-sm font-semibold text-gray-700
                               focus:border-emerald-400 focus:ring-4 focus:ring-emerald-500/10 outline-none transition-all"
                        placeholder="Mérida">
                    @error('empresa_municipio') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1.5">RFC *</label>
                    <input type="text" name="empresa_rfc" value="{{ old('empresa_rfc') }}" required maxlength="20"
                        class="w-full bg-gray-50 border-2 border-gray-100 rounded-xl py-3 px-4 text-sm font-semibold text-gray-700
                               focus:border-emerald-400 focus:ring-4 focus:ring-emerald-500/10 outline-none transition-all"
                        placeholder="EEJ900101ABC">
                    @error('empresa_rfc') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1.5">Giro comercial *</label>
                    <input type="text" name="empresa_giro" value="{{ old('empresa_giro') }}" required
                        class="w-full bg-gray-50 border-2 border-gray-100 rounded-xl py-3 px-4 text-sm font-semibold text-gray-700
                               focus:border-emerald-400 focus:ring-4 focus:ring-emerald-500/10 outline-none transition-all"
                        placeholder="Tecnología y Sistemas">
                    @error('empresa_giro') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="sm:col-span-2">
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1.5">Nombre del representante legal *</label>
                    <input type="text" name="empresa_representante" value="{{ old('empresa_representante') }}" required
                        class="w-full bg-gray-50 border-2 border-gray-100 rounded-xl py-3 px-4 text-sm font-semibold text-gray-700
                               focus:border-emerald-400 focus:ring-4 focus:ring-emerald-500/10 outline-none transition-all"
                        placeholder="Lic. Juan Pérez García">
                    @error('empresa_representante') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

            </div>
        </div>

        {{-- Contacto de la empresa --}}
        <div class="bg-white rounded-[1.75rem] border border-gray-100 shadow-sm p-8">
            <h2 class="text-xs font-bold text-gray-400 uppercase tracking-[0.2em] mb-5 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
                Contacto de la empresa
            </h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                <div class="sm:col-span-2">
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1.5">Nombre del contacto *</label>
                    <input type="text" name="contacto_nombre" value="{{ old('contacto_nombre') }}" required
                        class="w-full bg-gray-50 border-2 border-gray-100 rounded-xl py-3 px-4 text-sm font-semibold text-gray-700
                               focus:border-emerald-400 focus:ring-4 focus:ring-emerald-500/10 outline-none transition-all"
                        placeholder="C. María López">
                    @error('contacto_nombre') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1.5">Teléfono *</label>
                    <input type="text" name="contacto_telefono" value="{{ old('contacto_telefono') }}" required
                        class="w-full bg-gray-50 border-2 border-gray-100 rounded-xl py-3 px-4 text-sm font-semibold text-gray-700
                               focus:border-emerald-400 focus:ring-4 focus:ring-emerald-500/10 outline-none transition-all"
                        placeholder="9991234567">
                    @error('contacto_telefono') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1.5">Correo electrónico *</label>
                    <input type="email" name="contacto_email" value="{{ old('contacto_email') }}" required
                        class="w-full bg-gray-50 border-2 border-gray-100 rounded-xl py-3 px-4 text-sm font-semibold text-gray-700
                               focus:border-emerald-400 focus:ring-4 focus:ring-emerald-500/10 outline-none transition-all"
                        placeholder="contacto@empresa.com">
                    @error('contacto_email') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

            </div>
        </div>

        {{-- Botón enviar --}}
        <div class="flex justify-end gap-3">
            <a href="{{ route('empresas.index') }}"
               class="px-6 py-3 rounded-xl text-sm font-semibold text-gray-500 bg-white border border-gray-200 hover:bg-gray-50 transition-all">
                Cancelar
            </a>
            <button type="submit"
    class="px-8 py-3 rounded-xl text-sm font-bold text-white bg-emerald-700
           hover:bg-emerald-800 border-2 border-emerald-900
           shadow-lg shadow-emerald-900/30 transition-all active:scale-[0.98] 
           flex items-center gap-2 ring-2 ring-emerald-500 ring-offset-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Guardar y generar documento
            </button>
        </div>

    </form>
</div>

@endsection