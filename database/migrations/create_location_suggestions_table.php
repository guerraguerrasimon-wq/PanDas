<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sugerencias_ubicacion', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ciudad', 100);
            $table->string('zona_barrio', 150);
            $table->text('comentario')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sugerencias_ubicacion');
    }
};
