<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //$this->call(UserSeeder::class);
        $this->call(RolSeeder::class);
        $this->call(CategoriaSeeder::class);
        $this->call(PremiosSeeder::class);
        $this->call(PuntosDoblesSeeder::class);
        $this->call(HeaderSeeder::class);
        $this->call(DivisaSeeder::class);
    }
}

