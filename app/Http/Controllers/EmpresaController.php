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

    // --- NUEVOS MÉTODOS PARA EDITAR Y ELIMINAR ---

    // 1. Mostrar el formulario con los datos de la empresa a editar
    public function edit($id)
    {
        $empresa = Empresa::findOrFail($id);
        return view('empresas.edit', compact('empresa'));
    }

    // 2. Procesar la actualización de los datos
    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'direccion' => 'required|string|max:255',
            'email' => 'required|email|unique:empresas,email,' . $id,
            'telefono' => 'required|string|max:20',
        ]);

        $empresa = Empresa::findOrFail($id);
        $empresa->update($request->all());

        return redirect()->route('empresas.index')->with('success', 'Empresa actualizada correctamente.');
    }

    // 3. Eliminar la empresa de la base de datos
    public function destroy($id)
    {
        $empresa = Empresa::findOrFail($id);
        $empresa->delete();

        return redirect()->route('empresas.index')->with('success', 'Empresa eliminada con éxito.');
    }
}