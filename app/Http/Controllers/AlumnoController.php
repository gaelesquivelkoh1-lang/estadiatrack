<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use App\Models\Empresa; 
use Illuminate\Http\Request;

class AlumnoController extends Controller
{
    // 1. Mostrar todos los alumnos
    public function index()
    {
        // Usamos paginate para que la tabla no sea infinita
        // Cargamos 'empresa' para evitar el problema de N+1 consultas
        $alumnos = Alumno::with('empresa')->paginate(10); 
        return view('alumnos.index', compact('alumnos'));
    }

    // 2. Mostrar formulario para crear (Si usas el modal en el index, este puede ser opcional)
    public function create()
    {
        $empresas = Empresa::all();
        return view('alumnos.create', compact('empresas'));
    }

    // 3. Guardar un nuevo alumno
    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre'    => 'required|string|max:255',
            'matricula' => 'required|string|max:50|unique:alumnos,matricula',
            'carrera'   => 'required|string|max:255',
            'email'     => 'required|email|unique:alumnos,email',
            'telefono'  => 'required|string|max:20',
            'empresa_id' => 'nullable|exists:empresas,id', // Validamos que la empresa exista
        ]);

        Alumno::create($data);
        return redirect()->route('alumnos.index')->with('success', 'Alumno registrado correctamente.');
    }

    // 4. Mostrar el formulario de edición
    public function edit(Alumno $alumno)
    {
        $empresas = Empresa::all(); // Por si necesitas cambiar la empresa asignada
        return view('alumnos.edit', compact('alumno', 'empresas'));
    }

    // 5. Procesar la actualización en la base de datos
    public function update(Request $request, Alumno $alumno)
    {
        $data = $request->validate([
            'nombre'    => 'required|string|max:255',
            // Importante: ignoramos el ID actual del alumno para las reglas 'unique'
            'matricula' => 'required|string|max:50|unique:alumnos,matricula,' . $alumno->id,
            'carrera'   => 'required|string|max:255',
            'email'     => 'required|email|unique:alumnos,email,' . $alumno->id,
            'telefono'  => 'required|string|max:20',
            'empresa_id' => 'nullable|exists:empresas,id',
        ]);

        $alumno->update($data);
        
        // Redirigimos al index para cumplir con tu requerimiento de UX
      return redirect()->route('alumnos.index')->with('success', '¡Alumno actualizado con éxito!');
    }

    // 6. Eliminar un alumno
    public function destroy(Alumno $alumno)
    {
        $alumno->delete();
        return redirect()->route('alumnos.index')->with('success', 'Alumno eliminado del sistema.');
    }

    // 7. Filtrar por Carrera
    public function porCarrera(Request $request, $carrera = null)
    {
        $carrerasDisponibles = [
            'Licenciatura en Administración',
            'Ingeniería en Mantenimiento Industrial',
            'Licenciatura en Gastronomía',
            'Ingeniería en Tecnologías de la Información e Innovación Digital',
            'Licenciatura en Gestión y Desarrollo Turístico'
        ];

        // Si hay carrera, filtramos; si no, enviamos colección vacía
        $alumnos = $carrera 
            ? Alumno::where('carrera', $carrera)->with('empresa')->get() 
            : collect();

        return view('alumnos.carreras', compact('carrerasDisponibles', 'alumnos', 'carrera'));
    }
}