<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Alumno;
use App\Models\Convenio;

class ConvenioController extends Controller
{
    // Muestra el formulario para llenar el convenio
    public function create()
    {
        if (!session('admin_sesion')) {
            return redirect()->route('login');
        }

        $alumno = Alumno::where('matricula', session('alumno_matricula'))
                        ->orWhere('nombre', session('alumno_nombre'))
                        ->first();

        // Si el alumno ya tiene un convenio pendiente o firmado, lo mostramos
        $convenio = Convenio::where('alumno_id', $alumno->id)
                            ->latest()
                            ->first();

        return view('convenios.create', compact('alumno', 'convenio'));
    }

    // Guarda el convenio llenado por el alumno
    public function store(Request $request)
    {
        if (!session('admin_sesion')) {
            return redirect()->route('login');
        }

        $request->validate([
            'empresa_nombre'       => 'required|string|max:255',
            'empresa_calle'        => 'required|string|max:255',
            'empresa_colonia'      => 'required|string|max:255',
            'empresa_cp'           => 'required|string|max:10',
            'empresa_municipio'    => 'required|string|max:255',
            'empresa_rfc'          => 'required|string|max:20',
            'empresa_representante'=> 'required|string|max:255',
            'empresa_giro'         => 'required|string|max:255',
            'contacto_nombre'      => 'required|string|max:255',
            'contacto_telefono'    => 'required|string|max:20',
            'contacto_email'       => 'required|email|max:255',
        ]);

        $alumno = Alumno::where('matricula', session('alumno_matricula'))
                        ->orWhere('nombre', session('alumno_nombre'))
                        ->first();

        Convenio::create([
            'alumno_id'             => $alumno->id,
            'empresa_nombre'        => $request->empresa_nombre,
            'empresa_calle'         => $request->empresa_calle,
            'empresa_colonia'       => $request->empresa_colonia,
            'empresa_cp'            => $request->empresa_cp,
            'empresa_municipio'     => $request->empresa_municipio,
            'empresa_rfc'           => $request->empresa_rfc,
            'empresa_representante' => $request->empresa_representante,
            'empresa_giro'          => $request->empresa_giro,
            'contacto_nombre'       => $request->contacto_nombre,
            'contacto_telefono'     => $request->contacto_telefono,
            'contacto_email'        => $request->contacto_email,
            'estatus'               => 'pendiente',
        ]);

        return redirect()->route('convenios.preview')
                         ->with('success', 'Convenio guardado. Ya puedes imprimirlo o descargarlo.');
    }

    // Muestra el preview del documento oficial para imprimir/guardar
    public function preview()
    {
        if (!session('admin_sesion')) {
            return redirect()->route('login');
        }

        $alumno   = Alumno::where('matricula', session('alumno_matricula'))
                          ->orWhere('nombre', session('alumno_nombre'))
                          ->first();

        $convenio = Convenio::where('alumno_id', $alumno->id)
                            ->latest()
                            ->firstOrFail();

        return view('convenios.preview', compact('alumno', 'convenio'));
    }
}