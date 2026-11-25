<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'pedidos';

    protected $fillable = [
        'codigo_orden',
        'usuario_id',
        'tienda_id',
        'total',
        'estado',
        'metodo_pago',
        'tipo_entrega',
        'direccion_entrega',
        'observaciones',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function store()
    {
        return $this->belongsTo(Store::class, 'tienda_id');
    }

    public function details()
    {
        return $this->hasMany(OrderDetail::class, 'pedido_id');
    }
}
