<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('usuarios')->insertOrIgnore([
            [
                'nombre_usuario' => 'admin',
                'nombres' => 'Administrador',
                'apellidos' => 'DAS Panadería',
                'correo' => 'admin@daspanaderia.com',
                'password_hash' => Hash::make('Admin123*'),
                'rol_id' => 1,
                'activo' => 1,
                'creado_en' => now(),
                'actualizado_en' => now(),
            ],
            [
                'nombre_usuario' => 'cliente_demo',
                'nombres' => 'Camila',
                'apellidos' => 'Torres',
                'correo' => 'camila@correo.com',
                'password_hash' => Hash::make('Cliente123*'),
                'rol_id' => 2,
                'activo' => 1,
                'creado_en' => now(),
                'actualizado_en' => now(),
            ],
        ]);
    }
}
