<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'usuarios';

    const CREATED_AT = 'creado_en';
    const UPDATED_AT = 'actualizado_en';

    protected $fillable = [
        'nombre_usuario',
        'nombres',
        'apellidos',
        'correo',
        'password_hash',
        'rol_id',
        'activo',
        'ultimo_acceso',
    ];

    protected $hidden = [
        'password_hash',
        'remember_token',
    ];

    public function getAuthPassword()
    {
        return $this->password_hash;
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class, 'usuario_id');
    }

    public function cartItems()
    {
        return $this->hasMany(Cart::class, 'usuario_id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'usuario_id');
    }
}
