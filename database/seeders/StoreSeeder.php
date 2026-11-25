<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StoreSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('tiendas')->insertOrIgnore([
            [
                'nombre' => 'Sede Chapinero',
                'direccion' => 'Calle 67 # 7-35',
                'ciudad' => 'Bogotá',
                'telefono' => '+57 310 123 4567',
                'horario' => 'Lun - Sáb: 7:00 AM - 8:00 PM | Dom: 8:00 AM - 5:00 PM',
                'latitud' => 4.6533,
                'longitud' => -74.0588,
                'activo' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Sede Usaquén',
                'direccion' => 'Carrera 6 # 119-24',
                'ciudad' => 'Bogotá',
                'telefono' => '+57 312 987 6543',
                'horario' => 'Mar - Dom: 7:30 AM - 7:30 PM',
                'latitud' => 4.6958,
                'longitud' => -74.0305,
                'activo' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
