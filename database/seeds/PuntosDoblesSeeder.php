<?php

use Illuminate\Database\Seeder;

class PuntosDoblesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('puntos_dobles')->insert([
            'puntos_dobles' => FALSE,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
