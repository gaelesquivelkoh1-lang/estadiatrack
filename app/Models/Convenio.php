<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Convenio extends Model
{
    protected $fillable = [
        'alumno_id',
        'empresa_nombre',
        'empresa_calle',
        'empresa_colonia',
        'empresa_cp',
        'empresa_municipio',
        'empresa_rfc',
        'empresa_representante',
        'empresa_giro',
        'contacto_nombre',
        'contacto_telefono',
        'contacto_email',
        'estatus',
        'fecha_firma',
    ];

    protected $casts = [
        'fecha_firma' => 'date',
    ];

    public function alumno()
    {
        return $this->belongsTo(Alumno::class);
    }
}