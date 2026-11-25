<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pedidos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('codigo_orden', 40)->unique();
            $table->unsignedInteger('usuario_id');
            $table->unsignedInteger('tienda_id')->nullable();
            $table->decimal('total', 14, 2)->default(0);
            $table->enum('estado', ['PENDIENTE', 'CONFIRMADO', 'PREPARANDO', 'LISTO', 'ENTREGADO', 'CANCELADO'])->default('PENDIENTE');
            $table->string('metodo_pago', 40)->default('EFECTIVO');
            $table->enum('tipo_entrega', ['RECOGIDA_TIENDA', 'DOMICILIO'])->default('RECOGIDA_TIENDA');
            $table->string('direccion_entrega', 255)->nullable();
            $table->text('observaciones')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pedidos');
    }
};
