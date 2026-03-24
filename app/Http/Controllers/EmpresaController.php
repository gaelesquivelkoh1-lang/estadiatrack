<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use Illuminate\Http\Request;

class EmpresaController extends Controller
{
    // Mostrar todas las empresas
    public function index()
    {
        $empresas = Empresa::all();
        return view('empresas.index', compact('empresas'));
    }

    // Mostrar formulario para crear empresa
    public function create()
    {
        return view('empresas.create');
    }

    // Guardar nueva empresa
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'direccion' => 'required|string|max:255',
            'email' => 'required|email|unique:empresas,email',
            'telefono' => 'required|string|max:20',
        ]);

        Empresa::create($request->all());

        return redirect()->route('empresas.index')->with('success', 'Empresa registrada correctamente.');
    }
}