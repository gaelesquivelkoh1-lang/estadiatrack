<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Estancia;
use App\Models\Asistencia;
use Carbon\Carbon;

class EmpresaAdminController extends Controller
{
    // ── Dashboard empresa: carreras con alumnos inscritos ──
    public function dashboard()
    {
        $empresaId = session('empresa_id');
        $rol       = session('rol');

        $query = Estancia::with(['alumno', 'empresa']);

        if ($rol === 'empresa') {
            $query->where('empresa_id', $empresaId);
        }

        $estancias  = $query->get();
        $porCarrera = $estancias->groupBy(fn($e) => $e->alumno->carrera ?? 'Sin carrera');

        return view('empresa.dashboard', compact('estancias', 'porCarrera'));
    }

    // ── Calendario de asistencias de un alumno ──
    public function calendario(Request $request, Estancia $estancia)
    {
        $rol       = session('rol');
        $empresaId = session('empresa_id');
        $alumnoId  = session('alumno_id');

        // Empresa solo ve sus propios alumnos
        if ($rol === 'empresa' && $estancia->empresa_id != $empresaId) {
            return redirect()->route('empresa.dashboard')
                             ->with('error', 'No tienes acceso a esta estancia.');
        }

        // Alumno solo ve su propia estancia
        if ($rol === 'alumno' && $estancia->alumno_id != $alumnoId) {
            return redirect()->route('perfil')
                             ->with('error', 'No tienes acceso a esta estancia.');
        }

        $alumno   = $estancia->alumno;
        $mes      = $request->get('mes', now()->format('Y-m'));
        $fechaMes = Carbon::parse($mes . '-01');
        $inicio   = Carbon::parse($estancia->fecha_inicio);
        $fin      = Carbon::parse($estancia->fecha_fin);
        $diasMes  = [];

        $dia    = $fechaMes->copy()->startOfMonth();
        $finMes = $fechaMes->copy()->endOfMonth();

        while ($dia->lte($finMes)) {
            if ($dia->isWeekday() && $dia->between($inicio, $fin)) {
                $diasMes[] = $dia->copy();
            }
            $dia->addDay();
        }

        $asistencias = Asistencia::where('estancia_id', $estancia->id)
            ->whereYear('fecha', $fechaMes->year)
            ->whereMonth('fecha', $fechaMes->month)
            ->get()
            ->keyBy(fn($a) => $a->fecha->format('Y-m-d'));

        $mesAnterior  = $fechaMes->copy()->subMonth()->format('Y-m');
        $mesSiguiente = $fechaMes->copy()->addMonth()->format('Y-m');

        // Empresa, vinculación y superadmin pueden registrar asistencias
        $puedeEditar = in_array($rol, ['empresa', 'vinculacion', 'superusuario']);

        // Alumno NO ve las notas, solo el estatus
        $puedeVerNotas = in_array($rol, ['empresa', 'vinculacion', 'superusuario']);

        return view('empresa.calendario', compact(
            'estancia', 'alumno', 'diasMes', 'asistencias',
            'fechaMes', 'mesAnterior', 'mesSiguiente',
            'puedeEditar', 'puedeVerNotas'
        ));
    }

    // ── Guardar o actualizar asistencia ──
    public function guardarAsistencia(Request $request, Estancia $estancia)
    {
        $rol = session('rol');

        if (!in_array($rol, ['empresa', 'vinculacion', 'superusuario'])) {
            return response()->json(['error' => 'Sin permiso'], 403);
        }

        $request->validate([
            'fecha'   => 'required|date',
            'estatus' => 'required|in:asistencia,falta,justificada,retardo',
            'nota'    => 'nullable|string|max:500',
        ]);

        Asistencia::updateOrCreate(
            [
                'estancia_id' => $estancia->id,
                'alumno_id'   => $estancia->alumno_id,
                'fecha'       => $request->fecha,
            ],
            [
                'estatus'        => $request->estatus,
                'nota'           => $request->nota,
                'registrado_por' => session('admin_id'),
            ]
        );

        return response()->json(['success' => true]);
    }
}