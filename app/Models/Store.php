<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use HasFactory;

    protected $table = 'tiendas';

    protected $fillable = [
        'nombre',
        'direccion',
        'ciudad',
        'telefono',
        'horario',
        'latitud',
        'longitud',
        'activo',
    ];

    public function orders()
    {
        return $this->hasMany(Order::class, 'tienda_id');
    }
}
