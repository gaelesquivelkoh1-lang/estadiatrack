<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'direccion',
        'email',
        'telefono',
    ];

    // Relación con estancias
    public function estancias()
    {
        return $this->hasMany(Estancia::class);
    }
}