<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bitacora extends Model
{
    use HasFactory;

    protected $fillable = [
        'estancia_id',
        'fecha',
        'horas',
        'descripcion',
    ];

    public function estancia()
    {
        return $this->belongsTo(Estancia::class);
    }
}