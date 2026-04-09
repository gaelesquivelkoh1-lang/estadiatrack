<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Convenio;
use App\Models\Alumno;

class VinculacionController extends Controller
{
    public function dashboard()
    {
        $pendientes  = Convenio::where('estatus', 'pendiente')->count();
        $firmados    = Convenio::where('estatus', 'firmado')->count();
        $totalAlumnos = Alumno::count();

        return view('vinculacion.dashboard', compact('pendientes', 'firmados', 'totalAlumnos'));
    }

    public function convenios()
    {
        $convenios = Convenio::with('alumno')
                             ->orderByRaw("CASE estatus WHEN 'pendiente' THEN 0 ELSE 1 END")
                             ->latest()
                             ->get();

        return view('vinculacion.convenios', compact('convenios'));
    }

    public function firmar(Request $request, Convenio $convenio)
    {
        $request->validate([
            'firma' => 'required|string', // base64 del canvas
        ]);

        // Guardar firma en sesión (se borra al cerrar sesión)
        session(['firma_vinculacion' => $request->firma]);

        // Actualizar estatus del convenio
        $convenio->update([
            'estatus'    => 'firmado',
            'fecha_firma' => now(),
        ]);

        // TODO: enviar correo al alumno cuando se configure SMTP

        return back()->with('success', '¡Convenio firmado y aprobado correctamente!');
    }

    public function guardarFirma(Request $request)
   {
    session(['firma_vinculacion' => $request->firma]);
    return back()->with('success', 'Firma registrada correctamente.');
   }
}