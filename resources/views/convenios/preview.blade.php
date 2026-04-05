@extends('layouts.app')

@section('title', 'Convenio · Vista previa')

@section('content')

@php
    $hoy = \Carbon\Carbon::parse($convenio->created_at)->locale('es')->isoFormat('D [de] MMMM [de] YYYY');
@endphp

{{-- Barra de acciones (no se imprime) --}}
<div class="max-w-4xl mx-auto px-4 pt-6 pb-2 flex items-center justify-between print:hidden">
    <a href="{{ route('convenios.create') }}"
       class="flex items-center gap-2 text-sm font-semibold text-gray-500 hover:text-gray-800 transition-colors">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
        </svg>
        Volver al formulario
    </a>

    <div class="flex items-center gap-3">
        {{-- Estatus badge --}}
        @php
            $badgeColor = match($convenio->estatus) {
                'firmado'   => 'bg-emerald-50 text-emerald-700 border-emerald-100',
                'rechazado' => 'bg-red-50 text-red-600 border-red-100',
                default     => 'bg-amber-50 text-amber-700 border-amber-100',
            };
        @endphp
        <span class="text-[10px] font-bold px-3 py-1.5 rounded-full border {{ $badgeColor }} uppercase tracking-wider">
            {{ ucfirst($convenio->estatus) }}
        </span>

        {{-- Imprimir --}}
<button onclick="window.print()"
    class="flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-bold text-white bg-emerald-700
           hover:bg-emerald-800 border-2 border-emerald-900
           shadow-lg shadow-emerald-900/30 transition-all active:scale-[0.98]
           ring-2 ring-emerald-500 ring-offset-2">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
    </svg>
    Imprimir / Guardar PDF
</button>
    </div>
</div>

{{-- ═══════════════════════════════════════════
     DOCUMENTO OFICIAL (se imprime tal cual)
═══════════════════════════════════════════ --}}
<div id="documento"
     class="max-w-4xl mx-auto px-4 pb-12 print:px-0 print:max-w-none">

    <div class="bg-white rounded-[1.75rem] shadow-sm border border-gray-100 p-12
                print:rounded-none print:shadow-none print:border-none print:p-8">

        {{-- Encabezado oficial --}}
        <div class="text-center mb-8">
            <p class="text-xs font-bold tracking-widest text-gray-500 uppercase mb-1">Universidad Tecnológica del Centro</p>
            <h1 class="text-2xl font-extrabold text-gray-900 tracking-tight uppercase">Convenio de Colaboración</h1>
            <div class="h-0.5 w-20 bg-gray-800 mx-auto mt-3"></div>
        </div>

        {{-- Cuerpo del convenio --}}
        <div class="text-sm text-gray-800 leading-relaxed space-y-4 text-justify">

            <p>
                LA UNIVERSIDAD TECNOLÓGICA DEL CENTRO CELEBRA EL CONVENIO DE ESTADÍAS PARA ALUMNOS DE ESTA
                INSTITUCIÓN, CELEBRADO EN LA CIUDAD DE <strong>IZAMAL</strong>, YUCATÁN CON
                <strong>LA EMPRESA {{ strtoupper($convenio->empresa_nombre) }}</strong>
                CON DOMICILIO EN LA CALLE <strong>{{ strtoupper($convenio->empresa_calle) }}</strong>,
                COLONIA <strong>{{ strtoupper($convenio->empresa_colonia) }}</strong>
                CP. <strong>{{ $convenio->empresa_cp }}</strong>
                EN <strong>{{ strtoupper($convenio->empresa_municipio) }}</strong>, YUCATÁN
                Y RFC: <strong>{{ strtoupper($convenio->empresa_rfc) }}</strong>
                REPRESENTADA POR <strong>{{ strtoupper($convenio->empresa_representante) }}</strong>
                EN SU CALIDAD DE REPRESENTANTE LEGAL, QUE EN LO SUCESIVO SE DENOMINARÁ <strong>"LA EMPRESA"</strong>,
                Y POR OTRA PARTE LA UNIVERSIDAD TECNOLÓGICA DEL CENTRO, REPRESENTADO POR EL
                <strong>L.E.M. NOÉ RAMÓN MARTÍNEZ BOBADILLA</strong>, DIRECTOR DE VINCULACIÓN DE LA
                UNIVERSIDAD TECNOLÓGICA DEL CENTRO, Y REPRESENTANTE PARA ACTOS DE ADMINISTRACIÓN DEL MISMO,
                A QUIEN EN LO SUCESIVO SE LE DENOMINARÁ PARA LOS EFECTOS DEL PRESENTE CONVENIO COMO
                <strong>"LA UNIVERSIDAD"</strong> Y CON DOMICILIO EN KM 1.5 DE LA CARRETERA HOCTÚN – IZAMAL,
                ACORDANDO QUE A SU VEZ SE DENOMINARÁ <strong>"LAS PARTES"</strong> COMPROMETIÉNDOSE A LO SIGUIENTE:
            </p>

            <p class="font-bold text-center pt-2">C L Á U S U L A S</p>

            <p><strong>PRIMERA.-</strong> "La Universidad" extenderá una carta de presentación al alumno que acuerda
            realizar su estadía, indicando las áreas de práctica y las horas a realizar.</p>

            <p><strong>SEGUNDA.-</strong> "La Universidad" proporcionará a "La empresa" copia simple la Identificación
            oficial y carta de presentación del estudiante como alumno regular de la Universidad Tecnológica del Centro,
            el cual contiene: los datos personales del alumno y el número de seguridad social, para protegerlo de los
            accidentes que pueda sufrir durante su estancia en "La Empresa", deslindando de responsabilidades.</p>

            <p><strong>TERCERA.-</strong> "La Universidad" reconoce y acepta que no existe ninguna relación laboral entre
            "La Empresa" y el practicante.</p>

            <p><strong>CUARTA.-</strong> Las Estadías estarán sujetas al común acuerdo de "La Empresa" y "La Universidad",
            dichos acuerdos serán sobre la base de los reglamentos que rigen a cada una de "Las Partes".</p>

            <p><strong>QUINTA.-</strong> De acuerdo a la ocupación y operación de "La Empresa" se permitirá que los alumnos
            realicen su Estancia / Estadía, según el perfil de egreso de cada programa educativo.</p>

            <p><strong>SEXTA.-</strong> De acuerdo a sus posibilidades, "La Empresa" permitirá que los alumnos realicen su
            ESTADÍA, que tendrán un período máximo de quince semanas, durante el cual los alumnos desarrollarán un proyecto
            y contarán con un Asesor Académico y otro Empresarial que supervisarán todas las actividades del alumno.</p>

            <p><strong>SÉPTIMA.-</strong> "La Empresa" se compromete a ubicar a los estudiantes en áreas y actividades que
            correspondan a las carreras que cursan, así como notificar por escrito a "La Universidad" las anomalías en que
            los estudiantes incurran.</p>

            <p><strong>OCTAVA.-</strong> "La Empresa" con Giro Comercial <strong>{{ $convenio->empresa_giro }}</strong>,
            proporciona como contacto de la misma al <strong>C. {{ $convenio->contacto_nombre }}</strong> con número de
            teléfono <strong>{{ $convenio->contacto_telefono }}</strong> y correo electrónico
            <strong>{{ $convenio->contacto_email }}</strong>, esto con el fin de mantener una comunicación asertiva con
            la Institución y fortalecer el seguimiento de actividades entre ambas.</p>

            <p><strong>NOVENA.-</strong> El presente Convenio tendrá una vigencia indefinida a partir de la fecha de su
            firma, cualquiera de "Las Partes" podrá darlo por terminado con una simple notificación que se haga por
            escrito a la otra parte con al menos treinta días de anticipación de la fecha en que se pretenda darlo por
            concluido; sin embargo, se comprometen a cumplir con todas las obligaciones convenidas que estuvieran
            pendientes de realización o que se encuentren en desarrollo.</p>

            <p class="pt-2">
                Leído que fue el presente instrumento y enteradas "Las Partes" de su contenido y alcances, lo firman en
                Izamal, Yuc. al <strong>{{ $hoy }}</strong>.
            </p>

        </div>

        {{-- Firmas --}}
        <div class="grid grid-cols-2 gap-16 mt-16 pt-8">

            <div class="text-center">
                <div class="border-t-2 border-gray-800 pt-4">
                    <p class="text-xs font-bold text-gray-800 uppercase">Por "La Universidad"</p>
                    <p class="text-sm font-extrabold text-gray-900 mt-2">L.E.M. NOÉ RAMÓN MARTÍNEZ BOBADILLA</p>
                    <p class="text-xs text-gray-500 mt-1">Director de Vinculación</p>
                    <p class="text-xs text-gray-500">Universidad Tecnológica del Centro</p>
                </div>
            </div>

            <div class="text-center">
                <div class="border-t-2 border-gray-800 pt-4">
                    <p class="text-xs font-bold text-gray-800 uppercase">Por "La Empresa"</p>
                    <p class="text-sm font-extrabold text-gray-900 mt-2">{{ strtoupper($convenio->empresa_representante) }}</p>
                    <p class="text-xs text-gray-500 mt-1">Apoderado Legal</p>
                    <p class="text-xs text-gray-500">{{ $convenio->empresa_nombre }}</p>
                </div>
            </div>

        </div>

    </div>
</div>

{{-- Estilos de impresión --}}
@push('scripts')
<style>
    @media print {
        nav, .print\:hidden { display: none !important; }
        body { background: white !important; }
        #documento { margin: 0; padding: 0; }
    }
</style>
@endpush

@endsection