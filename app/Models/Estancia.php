<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estancia extends Model
{
    use HasFactory;

    protected $fillable = [
        'alumno_id',
        'empresa_id',
        'fecha_inicio',
        'fecha_fin',
        'estatus',
    ];

    // Relaciones
    public function alumno()
    {
        return $this->belongsTo(Alumno::class);
    }

    public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }

    public function bitacoras()
    {
        return $this->hasMany(Bitacora::class);
    }

    public function evaluaciones()
    {
        return $this->hasMany(Evaluacion::class);
    }
}