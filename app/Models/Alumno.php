<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alumno extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'matricula',
        'carrera',
        'grupo', 
        'email',
        'telefono',
        'empresa_id', 
    ];

    /**
     * Relación con la Empresa (Directa)
     */
    public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }

    /**
     * Relación con las Estancias (NUEVO: Importante para la vista de Estancias)
     */
    public function estancias()
    {
        return $this->hasMany(Estancia::class);
    }
    public function actividades()
    {
    return $this->hasMany(Estancia::class);
    }
}