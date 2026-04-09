<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;

class SuperAdminController extends Controller
{
    public function dashboard()
    {
        $totalVinculacion = Admin::where('rol', 'vinculacion')->count();
        $totalActivos     = Admin::where('rol', 'vinculacion')->where('activo', true)->count();

        return view('superadmin.dashboard', compact('totalVinculacion', 'totalActivos'));
    }

    public function usuarios()
    {
        $usuarios = Admin::where('rol', 'vinculacion')->latest()->get();
        return view('superadmin.usuarios', compact('usuarios'));
    }

    public function crear(Request $request)
    {
        $request->validate([
            'nombre'   => 'required|string|max:255',
            'usuario'  => 'required|string|max:255|unique:admins,usuario',
            'password' => 'required|string|min:8|confirmed',
        ]);

        Admin::create([
            'nombre'     => $request->nombre,
            'usuario'    => $request->usuario,
            'password'   => Hash::make($request->password),
            'rol'        => 'vinculacion',
            'activo'     => true,
            'creado_por' => session('admin_id'),
        ]);

        return back()->with('success', "Usuario {$request->usuario} creado correctamente.");
    }

    public function eliminar(Admin $admin)
    {
        if ($admin->rol === 'superusuario') {
            return back()->with('error', 'No puedes eliminar al superusuario.');
        }

        $admin->delete();
        return back()->with('success', 'Usuario eliminado.');
    }

    public function toggle(Admin $admin)
    {
        $admin->update(['activo' => !$admin->activo]);
        $estado = $admin->activo ? 'activado' : 'desactivado';
        return back()->with('success', "Usuario {$estado} correctamente.");
    }
}