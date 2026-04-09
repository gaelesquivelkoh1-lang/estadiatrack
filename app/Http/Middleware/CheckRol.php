<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRol
{
    public function handle(Request $request, Closure $next, string ...$roles): mixed
    {
        $rolSesion = session('rol');

        // Sin sesión → al login
        if (!$rolSesion) {
            return redirect()->route('login');
        }

        // Tiene sesión pero no el rol requerido
        if (!in_array($rolSesion, $roles)) {
            return match($rolSesion) {
                'alumno'       => redirect()->route('perfil')
                                           ->with('error', 'No tienes permiso para acceder a esa sección.'),
                'vinculacion'  => redirect()->route('vinculacion.dashboard')
                                           ->with('error', 'No tienes permiso para acceder a esa sección.'),
                'superusuario' => redirect()->route('superadmin.dashboard')
                                           ->with('error', 'No tienes permiso para acceder a esa sección.'),
                default        => redirect()->route('login'),
            };
        }

        return $next($request);
    }
}