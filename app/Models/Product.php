<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'productos';

    const CREATED_AT = 'creado_en';
    const UPDATED_AT = 'actualizado_en';

    protected $fillable = [
        'codigo',
        'nombre',
        'descripcion',
        'categoria_id',
        'unidad_id',
        'precio_base',
        'precio_venta',
        'stock_actual',
        'stock_minimo',
        'imagen_url',
        'activo',
    ];

    public function favorites()
    {
        return $this->hasMany(Favorite::class, 'producto_id');
    }

    public function cartItems()
    {
        return $this->hasMany(Cart::class, 'producto_id');
    }
}
