<?php

use Illuminate\Database\Seeder;

class HeaderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('headers')->insert([
            'header_user' => 'go1',
            'header_secret' => Hash::make('g01*-'),
            'created_at' => now(),
            'updated_at' => now()
        ]);
        
        DB::table('headers')->insert([
            'header_user' => 'clubestrella',
            'header_secret' => Hash::make('S0port*2020'),
            'created_at' => now(),
            'updated_at' => now()
        ]);

    }
}
