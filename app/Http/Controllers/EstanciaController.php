<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Estancia;
use App\Models\Alumno;
use App\Models\Empresa;
use App\Exports\EstanciasExport;

class EstanciaController extends Controller
{
    public function index()
    {
        $estancias = Estancia::with(['alumno', 'empresa'])->get();
        $alumnos   = Alumno::orderBy('nombre')->get();
        $empresas  = Empresa::orderBy('nombre')->get();
        $grupos    = Alumno::whereNotNull('grupo')->where('grupo', '!=', '')->distinct()->orderBy('grupo')->pluck('grupo');

        return view('estancias.index', compact('estancias', 'alumnos', 'empresas', 'grupos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'alumno_id'    => 'required|exists:alumnos,id',
            'empresa_id'   => 'required|exists:empresas,id',
            'fecha_inicio' => 'required|date',
            'fecha_fin'    => 'required|date|after:fecha_inicio',
            'estatus'      => 'required|in:En Proceso,Finalizada',
        ]);

        Estancia::create($request->only(['alumno_id', 'empresa_id', 'fecha_inicio', 'fecha_fin', 'estatus']));

        return back()->with('success', 'Estancia registrada correctamente.');
    }

    public function export(Request $request)
    {
        $query = Estancia::with(['alumno', 'empresa']);

        if ($request->filled('carrera')) {
            $query->whereHas('alumno', fn($q) => $q->where('carrera', $request->carrera));
        }
        if ($request->filled('inicial')) {
            $query->whereHas('alumno', fn($q) => $q->where('nombre', 'like', $request->inicial . '%'));
        }
        if ($request->filled('fecha_inicio')) {
            $query->where('fecha_inicio', '>=', $request->fecha_inicio);
        }
        if ($request->filled('fecha_fin')) {
            $query->where('fecha_fin', '<=', $request->fecha_fin);
        }
        if ($request->filled('grupo')) {
            $query->whereHas('alumno', fn($q) => $q->where('grupo', $request->grupo));
        }

        $estancias = $query->get();
        $titulo    = $request->carrera ?? 'Todas las carreras';

        return (new EstanciasExport($estancias, $titulo))->download();
    }
}