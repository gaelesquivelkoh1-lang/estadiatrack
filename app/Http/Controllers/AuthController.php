<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Alumno;

class AuthController extends Controller
{
    // Muestra la pantalla de login
    public function showLogin() {
        return view('auth.login');
    }

    // Verifica si la matrícula existe
    public function login(Request $request) {
        $request->validate([
            'matricula' => 'required'
        ]);

        $alumno = Alumno::where('matricula', $request->matricula)->first();

        if ($alumno) {
            session([
                'admin_sesion'     => true,
                'alumno_nombre'    => $alumno->nombre,
                'alumno_matricula' => $alumno->matricula, // ← nuevo
            ]);
            session()->save();
            return redirect()->route('empresas.index');
        }

        return back()->with('error', 'La matrícula ingresada no es válida o no está registrada.');
    }

    // Cierra la sesión
    public function logout() {
        session()->forget(['admin_sesion', 'alumno_nombre', 'alumno_matricula']);
        return redirect()->route('login');
    }
}