<?php

use Illuminate\Database\Seeder;

class NeedSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('regalos')->insert([
            'nombre' => 'Oktrip',
            'puntos' => 10000,
            'imgs' => json_encode(array('img/premios/audifonos.png')),
            'descripcion' => 'Modelo sujeto a disponibilidad.',
            'categoria_id' => 1,
            'custom' => 1,
            'tag' => json_encode(array('oktrip')),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('divisas')->insert([
            'currency' => 'MXN',
            'valor' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('divisas')->insert([
            'currency' => 'USD',
            'valor' => 20,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
