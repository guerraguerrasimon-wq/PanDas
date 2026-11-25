<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('productos')->insertOrIgnore([
            [
                'codigo' => 'PAN-MASA-MADRE',
                'nombre' => 'Pan Campesino de Masa Madre',
                'descripcion' => 'Pan artesanal fermentado 24h, corteza crocante y miga aireada.',
                'categoria_id' => 1,
                'precio_base' => 9000,
                'precio_venta' => 12000,
                'stock_actual' => 50,
                'stock_minimo' => 10,
                'imagen_url' => 'assets/images/products/pan-campesino.jpg',
                'activo' => 1,
                'creado_en' => now(),
                'actualizado_en' => now(),
            ],
            [
                'codigo' => 'CROISSANT-MANTEQUILLA',
                'nombre' => 'Croissant Clásico de Mantequilla',
                'descripcion' => 'Hojaldre 100% mantequilla pura, capas doradas y textura ligera.',
                'categoria_id' => 2,
                'precio_base' => 5000,
                'precio_venta' => 7500,
                'stock_actual' => 40,
                'stock_minimo' => 8,
                'imagen_url' => 'assets/images/products/croissant.jpg',
                'activo' => 1,
                'creado_en' => now(),
                'actualizado_en' => now(),
            ],
            [
                'codigo' => 'BAGUETTE-TRADICIONAL',
                'nombre' => 'Baguette Rústica',
                'descripcion' => 'Baguette tradicional francesa con masa de fermentación lenta.',
                'categoria_id' => 1,
                'precio_base' => 4000,
                'precio_venta' => 6000,
                'stock_actual' => 35,
                'stock_minimo' => 5,
                'imagen_url' => 'assets/images/products/baguette.jpg',
                'activo' => 1,
                'creado_en' => now(),
                'actualizado_en' => now(),
            ],
        ]);
    }
}
