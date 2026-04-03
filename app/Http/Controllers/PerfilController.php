<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Alumno;
use App\Models\Estancia;

class PerfilController extends Controller
{
    public function index()
    {
        if (!session('admin_sesion')) {
            return redirect()->route('login');
        }

        $user = Alumno::where('matricula', session('alumno_matricula'))
                      ->orWhere('nombre', session('alumno_nombre'))
                      ->first();

        // Estancias del alumno con empresa y bitácoras
        $historial = collect();

        if ($user) {
            $estancias = Estancia::with(['empresa', 'bitacoras'])
                                 ->where('alumno_id', $user->id)
                                 ->latest()
                                 ->get();

            // Convertimos todo a un historial unificado
            foreach ($estancias as $estancia) {
                // Entrada por la estancia
                $historial->push((object)[
                    'descripcion' => 'Estancia en ' . ($estancia->empresa->nombre ?? 'Empresa'),
                    'detalle'     => $estancia->fecha_inicio . ' → ' . $estancia->fecha_fin,
                    'estado'      => $estancia->estatus,
                    'fecha'       => $estancia->created_at,
                ]);

                // Entradas por cada bitácora
                foreach ($estancia->bitacoras as $bitacora) {
                    $historial->push((object)[
                        'descripcion' => 'Bitácora registrada',
                        'detalle'     => $bitacora->descripcion . ' · ' . $bitacora->horas . ' hrs',
                        'estado'      => 'registrado',
                        'fecha'       => $bitacora->fecha,
                    ]);
                }
            }

            $historial = $historial->sortByDesc('fecha')->values();
        }

        return view('perfil', compact('user', 'historial'));
    }
}