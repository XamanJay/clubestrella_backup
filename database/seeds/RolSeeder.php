<?php

use Illuminate\Database\Seeder;

class RolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
  
        DB::table('roles')->insert([
            'nombre' => 'Administrador',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('roles')->insert([
            'nombre' => 'Supervisor',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        
        DB::table('roles')->insert([
            'nombre' => 'Empleado',
            'created_at' => now(),
            'updated_at' => now()
        ]);
            
        DB::table('roles')->insert([
            'nombre' => 'Cliente',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
