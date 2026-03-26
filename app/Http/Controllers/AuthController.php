<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Alumno; // Importante para buscar en la tabla de alumnos

class AuthController extends Controller
{
    // Muestra la pantalla de login (el diseño verde que quieres)
    public function showLogin() {
        return view('auth.login');
    }

    // Verifica si la matrícula existe
    public function login(Request $request) {
        $request->validate([
            'matricula' => 'required'
        ]);

        // Buscamos al alumno por su matrícula
        $alumno = Alumno::where('matricula', $request->matricula)->first();

        if ($alumno) {
            // Si existe, creamos una sesión manual
            session(['admin_sesion' => true, 'alumno_nombre' => $alumno->nombre]);
            return redirect()->route('empresas.index');
        }

        // Si no existe, regresamos con error
        return back()->with('error', 'La matrícula ingresada no es válida o no está registrada.');
    }

    // Cierra la sesión
    public function logout() {
        session()->forget(['admin_sesion', 'alumno_nombre']);
        return redirect()->route('login');
    }
}