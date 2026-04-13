<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Alumno;
use App\Models\Admin;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate(['matricula' => 'required']);

        $credencial = trim($request->matricula);

        // ── 1. ¿Es superusuario, vinculación o empresa? (tienen usuario + contraseña)
        if ($request->filled('password')) {
            $admin = Admin::where('usuario', $credencial)
                          ->where('activo', true)
                          ->first();

            // Integración del nuevo bloque de validación y sesión
            if ($admin && $admin->verificarPassword($request->password)) {
                session([
                    'admin_sesion'  => true,
                    'alumno_nombre' => $admin->nombre,
                    'admin_id'      => $admin->id,
                    'rol'           => $admin->rol,
                    'empresa_id'    => $admin->empresa_id, // Nuevo dato en sesión
                ]);
                session()->save();

                // Redirección dinámica según el rol
                return match($admin->rol) {
                    'superusuario' => redirect()->route('superadmin.dashboard'),
                    'empresa'      => redirect()->route('empresa.dashboard'),
                    default        => redirect()->route('vinculacion.dashboard'),
                };
            }

            return back()->with('error', 'Credenciales incorrectas.');
        }

        // ── 2. ¿Es alumno? (solo matrícula)
        $alumno = Alumno::where('matricula', $credencial)->first();

        if ($alumno) {
            session([
                'admin_sesion'     => true,
                'alumno_nombre'    => $alumno->nombre,
                'alumno_matricula' => $alumno->matricula,
                'alumno_id'        => $alumno->id,
                'rol'              => 'alumno',
            ]);
            session()->save();
            return redirect()->route('empresas.index');
        }

        return back()->with('error', 'La matrícula ingresada no es válida o no está registrada.');
    }

    public function logout(Request $request)
    {
        session()->flush();
        return redirect()->route('login');
    }
}