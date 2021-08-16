<?php

use Illuminate\Database\Seeder;

class HotelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('hoteles_gph')->insert([
            'nombre' => 'Hotel Adhara Cancún',
            'pais' => 'México',
            'ciudad' => 'Cancún',
            'direccion' => 'Av Nader',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('hoteles_gph')->insert([
            'nombre' => 'Hotel Ramada Cancún',
            'pais' => 'México',
            'ciudad' => 'Cancún',
            'direccion' => 'Av Yaxchilan',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
