<?php

use Illuminate\Database\Seeder;

class DivisaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
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
