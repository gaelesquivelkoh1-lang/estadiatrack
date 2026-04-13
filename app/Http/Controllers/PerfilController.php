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
                      ->with(['estancias.empresa']) // ← carga estancias con empresa para el botón de asistencias
                      ->first();

        $historial = collect();

        if ($user) {
            $estancias = Estancia::with(['empresa', 'bitacoras'])
                                 ->where('alumno_id', $user->id)
                                 ->latest()
                                 ->get();

            foreach ($estancias as $estancia) {
                $historial->push((object)[
                    'descripcion' => 'Estancia en ' . ($estancia->empresa->nombre ?? 'Empresa'),
                    'detalle'     => $estancia->fecha_inicio . ' → ' . $estancia->fecha_fin,
                    'estado'      => $estancia->estatus,
                    'fecha'       => $estancia->created_at,
                ]);

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

    public function actualizarAvatar(Request $request)
    {
        $avataresValidos = [
            'avatar_admin.svg', 'avatar_industrial.svg', 'avatar_gastronomia.svg',
            'avatar_tecnologias.svg', 'avatar_turismo.svg', 'avatar_astronauta.svg',
            'avatar_artista.svg', 'avatar_cientifico.svg', 'avatar_musico.svg',
        ];

        $request->validate([
            'avatar' => 'required|in:' . implode(',', $avataresValidos),
        ]);

        $alumno = Alumno::where('matricula', session('alumno_matricula'))
                        ->orWhere('nombre', session('alumno_nombre'))
                        ->first();

        if (!$alumno) {
            return redirect()->route('perfil')->with('error', 'No se encontró el alumno.');
        }

        $alumno->update(['avatar' => $request->avatar]);

        return redirect()->route('perfil')->with('success', '¡Avatar actualizado correctamente!');
    }
}