<?php

namespace App\Http\Controllers;

use App\Models\Estancia;
use App\Models\Alumno;
use App\Models\Empresa;
use Illuminate\Http\Request;

class EstanciaController extends Controller
{
    // Mostrar la página principal de estancias (Lista + Formulario)
    public function index()
    {
        // 1. Necesitamos los alumnos y empresas para el formulario de arriba
        $alumnos = Alumno::all();
        $empresas = Empresa::all();

        // 2. Necesitamos las estancias con sus relaciones para el apartado de abajo
        $estancias = Estancia::with('alumno', 'empresa')->get();

        // 3. ENVIAMOS LAS TRES VARIABLES A LA VISTA
        return view('estancias.index', compact('estancias', 'alumnos', 'empresas'));
    }

    // Si decides usar una página aparte para el formulario
    public function create()
    {
        $alumnos = Alumno::all();
        $empresas = Empresa::all();
        return view('estancias.create', compact('alumnos', 'empresas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'alumno_id' => 'required|exists:alumnos,id',
            'empresa_id' => 'required|exists:empresas,id',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
            'estatus' => 'required|string|max:50',
        ]);

        Estancia::create($request->all());

        return redirect()->route('estancias.index')
            ->with('success', 'Estancia registrada correctamente');
    }
}