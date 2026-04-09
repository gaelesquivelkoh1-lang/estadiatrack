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

        // ── 1. ¿Es superusuario o vinculación? (tienen usuario + contraseña)
        if ($request->filled('password')) {
            $admin = Admin::where('usuario', $credencial)
                          ->where('activo', true)
                          ->first();

            if ($admin && $admin->verificarPassword($request->password)) {
                session([
                    'admin_sesion' => true,
                    'alumno_nombre' => $admin->nombre,
                    'admin_id'     => $admin->id,
                    'rol'          => $admin->rol,
                ]);
                session()->save();

                return $admin->rol === 'superusuario'
                    ? redirect()->route('superadmin.dashboard')
                    : redirect()->route('vinculacion.dashboard');
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