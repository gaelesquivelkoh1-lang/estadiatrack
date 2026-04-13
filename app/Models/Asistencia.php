<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Asistencia extends Model
{
    protected $fillable = [
        'estancia_id',
        'alumno_id',
        'fecha',
        'estatus',
        'nota',
        'registrado_por',
    ];

    protected $casts = [
        'fecha' => 'date',
    ];

    public function estancia()
    {
        return $this->belongsTo(Estancia::class);
    }

    public function alumno()
    {
        return $this->belongsTo(Alumno::class);
    }

    public function registrador()
    {
        return $this->belongsTo(Admin::class, 'registrado_por');
    }
}