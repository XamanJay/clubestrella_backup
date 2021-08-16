<?php

use Illuminate\Database\Seeder;

class CategoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('categorias')->insert([
            'nombre' => 'plata',
            'puntos_limite' => 0,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('categorias')->insert([
            'nombre' => 'golden',
            'puntos_limite' => 150000,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
