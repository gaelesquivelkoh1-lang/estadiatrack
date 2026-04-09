<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class Admin extends Model
{
    protected $table = 'admins';

    protected $fillable = [
        'nombre',
        'usuario',
        'password',
        'rol',
        'activo',
        'creado_por',
    ];

    protected $hidden = ['password'];

    protected $casts = ['activo' => 'boolean'];

    public function verificarPassword(string $password): bool
    {
        return Hash::check($password, $this->password);
    }

    public function creadoPor()
    {
        return $this->belongsTo(Admin::class, 'creado_por');
    }

    public function usuariosCreados()
    {
        return $this->hasMany(Admin::class, 'creado_por');
    }
}