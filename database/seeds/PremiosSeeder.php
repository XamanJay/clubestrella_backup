<?php

use Illuminate\Database\Seeder;

class PremiosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('regalos')->insert([
            'nombre' => 'Mini Ipod 16GB',
            'puntos' => 156000,
            'imgs' => json_encode(array('http://via.placeholder.com/150x200')),
            'descripcion' => '',
            'categoria_id' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        
        DB::table('regalos')->insert([
            'nombre' => 'Ipod Touch 64GB',
            'puntos' => 140000,
            'imgs' => json_encode(array('img/premios/ipod.png')),
            'descripcion' => '',
            'categoria_id' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('regalos')->insert([
            'nombre' => 'Cafetera Dolce Gusto',
            'puntos' => 32000,
            'imgs' => json_encode(array('img/premios/cafetera.png')),
            'descripcion' => '',
            'categoria_id' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('regalos')->insert([
            'nombre' => 'Noche Habitación Hotel Adhara',
            'puntos' => 13000,
            'imgs' => json_encode(array('img/premios/adhara.png')),
            'descripcion' => '',
            'categoria_id' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('regalos')->insert([
            'nombre' => 'Comida o Cena',
            'puntos' => 3200,
            'imgs' => json_encode(array('img/premios/cena.png')),
            'descripcion' => '',
            'categoria_id' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('regalos')->insert([
            'nombre' => 'Upgrade Habitación',
            'puntos' => 2500,
            'imgs' => json_encode(array('img/premios/upgrade.png')),
            'descripcion' => '',
            'categoria_id' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('regalos')->insert([
            'nombre' => 'Cerveza',
            'puntos' => 900,
            'imgs' => json_encode(array('img/premios/cerveza.png')),
            'descripcion' => '',
            'categoria_id' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('regalos')->insert([
            'nombre' => 'Noche Habitación Hotel Margaritas',
            'puntos' => 9500,
            'imgs' => json_encode(array('img/premios/margaritas.png')),
            'descripcion' => '',
            'categoria_id' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('regalos')->insert([
            'nombre' => 'Cocodrillo',
            'puntos' => 3200,
            'imgs' => json_encode(array('img/premios/cocodrillos.png')),
            'descripcion' => '',
            'categoria_id' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('regalos')->insert([
            'nombre' => 'Ipod Shuffle',
            'puntos' => 32000,
            'imgs' => json_encode(array('img/premios/ipodmini.png')),
            'descripcion' => '',
            'categoria_id' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('regalos')->insert([
            'nombre' => 'Estancia Oktrip',
            'puntos' => 16000,
            'imgs' => json_encode(array('http://via.placeholder.com/150x200')),
            'descripcion' => '',
            'categoria_id' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('regalos')->insert([
            'nombre' => 'Tablet Lenovo',
            'puntos' => 60000,
            'imgs' => json_encode(array('img/premios/tablet.png')),
            'descripcion' => '',
            'categoria_id' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('regalos')->insert([
            'nombre' => 'Audífonos',
            'puntos' => 50000,
            'imgs' => json_encode(array('img/premios/headphones.png')),
            'descripcion' => '',
            'categoria_id' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('regalos')->insert([
            'nombre' => 'DayPass',
            'puntos' => 7000,
            'imgs' => json_encode(array('img/premios/daypass.png')),
            'descripcion' => '',
            'categoria_id' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('regalos')->insert([
            'nombre' => 'Renta de Salón (Vénus)',
            'puntos' => 57000,
            'imgs' => json_encode(array('img/premios/salon.png')),
            'descripcion' => '',
            'categoria_id' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('regalos')->insert([
            'nombre' => 'Coffe Break',
            'puntos' => 5000,
            'imgs' => json_encode(array('img/premios/cafe.png')),
            'descripcion' => '',
            'categoria_id' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('regalos')->insert([
            'nombre' => 'Desayunos Servidos',
            'puntos' => 2950,
            'imgs' => json_encode(array('img/premios/desayuno.png')),
            'descripcion' => '',
            'categoria_id' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('regalos')->insert([
            'nombre' => 'Box Lunch',
            'puntos' => 3700,
            'imgs' => json_encode(array('img/premios/lunch.png')),
            'descripcion' => '',
            'categoria_id' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('regalos')->insert([
            'nombre' => 'Café Termo',
            'puntos' => 19000,
            'imgs' => json_encode(array('img/premios/thermo.png')),
            'descripcion' => '',
            'categoria_id' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('regalos')->insert([
            'nombre' => 'Canasta de Pan',
            'puntos' => 17500,
            'imgs' => json_encode(array('img/premios/pan.png')),
            'descripcion' => '',
            'categoria_id' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('regalos')->insert([
            'nombre' => 'Sala de Juntas',
            'puntos' => 60000,
            'imgs' => json_encode(array('img/premios/junta.png')),
            'descripcion' => '',
            'categoria_id' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('regalos')->insert([
            'nombre' => 'Micrófono (Diadema)',
            'puntos' => 18000,
            'imgs' => json_encode(array('img/premios/diadema.png')),
            'descripcion' => '',
            'categoria_id' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('regalos')->insert([
            'nombre' => 'Proyector',
            'puntos' => 22000,
            'imgs' => json_encode(array('img/premios/proyector.png')),
            'descripcion' => '',
            'categoria_id' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('regalos')->insert([
            'nombre' => 'Micrófono',
            'puntos' => 10000,
            'imgs' => json_encode(array('img/premios/microfono.png')),
            'descripcion' => '',
            'categoria_id' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('regalos')->insert([
            'nombre' => 'Pantalla',
            'puntos' => 9000,
            'imgs' => json_encode(array('img/premios/pantalla.png')),
            'descripcion' => '',
            'categoria_id' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);







        DB::table('regalos')->insert([
            'nombre' => 'Coffe Break',
            'puntos' => 5000,
            'imgs' => json_encode(array('img/premios/eventos.png')),
            'descripcion' => '',
            'categoria_id' => 1,
            'custom' => 1,
            'tag' => json_encode(array('eventos')),
            'created_at' => now(),
            'updated_at' => now()
        ]);
        
        DB::table('regalos')->insert([
            'nombre' => 'Desayunos Servidos',
            'puntos' => 2950,
            'imgs' => json_encode(array('img/premios/desayuno.png')),
            'descripcion' => '',
            'categoria_id' => 1,
            'custom' => 1,
            'tag' => json_encode(array('eventos')),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('regalos')->insert([
            'nombre' => 'Canasta de Pan',
            'puntos' => 17500,
            'imgs' => json_encode(array('img/premios/pan.png')),
            'descripcion' => '',
            'categoria_id' => 1,
            'custom' => 1,
            'tag' => json_encode(array('eventos')),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('regalos')->insert([
            'nombre' => 'Renta de Salón',
            'puntos' => 7000,
            'imgs' => json_encode(array('img/premios/salon.png')),
            'descripcion' => '',
            'categoria_id' => 1,
            'custom' => 1,
            'tag' => json_encode(array('eventos')),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('regalos')->insert([
            'nombre' => 'Café Thermo',
            'puntos' => 3200,
            'imgs' => json_encode(array('img/premios/cafetera.png')),
            'descripcion' => 'Incluye 35 tazas',
            'categoria_id' => 1,
            'custom' => 1,
            'tag' => json_encode(array('eventos')),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('regalos')->insert([
            'nombre' => 'Proyector',
            'puntos' => 22000,
            'imgs' => json_encode(array('img/premios/proyector.png')),
            'descripcion' => '',
            'categoria_id' => 1,
            'custom' => 1,
            'tag' => json_encode(array('eventos')),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('regalos')->insert([
            'nombre' => 'Micrófono',
            'puntos' => 10000,
            'imgs' => json_encode(array('img/premios/microfono.png')),
            'descripcion' => '',
            'categoria_id' => 1,
            'custom' => 1,
            'tag' => json_encode(array('eventos')),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('regalos')->insert([
            'nombre' => 'Micrófono (Diadema, Solapa)',
            'puntos' => 9500,
            'imgs' => json_encode(array('img/premios/diadema.png')),
            'descripcion' => '',
            'categoria_id' => 1,
            'custom' => 1,
            'tag' => json_encode(array('eventos')),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('regalos')->insert([
            'nombre' => 'Cocodrillo',
            'puntos' => 3200,
            'imgs' => json_encode(array('img/premios/cocodrillos.png')),
            'descripcion' => 'Válido solo en Adhara Grill y Cocodrillos.',
            'categoria_id' => 1,
            'custom' => 1,
            'tag' => json_encode(array('adhara')),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('regalos')->insert([
            'nombre' => 'Daypass',
            'puntos' => 7000,
            'imgs' => json_encode(array('img/premios/daypass.png')),
            'descripcion' => 'Incluye $250 MXN en alimentos y bebidas en el Hotel Adhara Cancún.',
            'categoria_id' => 1,
            'custom' => 1,
            'tag' => json_encode(array('adhara')),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('regalos')->insert([
            'nombre' => 'Habitación Adhara Cancún',
            'puntos' => 13000,
            'imgs' => json_encode(array('img/premios/habitacion.png')),
            'descripcion' => 'Habitación estandar para 2 personas (solo habitación).',
            'categoria_id' => 1,
            'custom' => 1,
            'tag' => json_encode(array('adhara','room')),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('regalos')->insert([
            'nombre' => 'Upgrade Habitación',
            'puntos' => 2500,
            'imgs' => json_encode(array('img/premios/upgrade.png')),
            'descripcion' => 'Válido solo en el Hotel Adhara Cancún',
            'categoria_id' => 1,
            'custom' => 1,
            'tag' => json_encode(array('adhara')),
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('regalos')->insert([
            'nombre' => 'Cerveza',
            'puntos' => 900,
            'imgs' => json_encode(array('img/premios/cerveza.png')),
            'descripcion' => 'Cerveza de barril 12 Oz. Valido en Restaurante Adhara Grill y en Hotel Adhara Cancún.',
            'categoria_id' => 1,
            'custom' => 1,
            'tag' => json_encode(array('adhara')),
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('regalos')->insert([
            'nombre' => 'Desayuno Buffet o Menú Ejecutivo',
            'puntos' => 900,
            'imgs' => json_encode(array('img/premios/barra.png')),
            'descripcion' => 'Válido en Adhara Grill y en el Hotel Adhara Cancún.',
            'categoria_id' => 1,
            'custom' => 1,
            'tag' => json_encode(array('adhara')),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('regalos')->insert([
            'nombre' => 'Cafetera Dolce Gusto',
            'puntos' => 60000,
            'imgs' => json_encode(array('img/premios/cafetera_2.png')),
            'descripcion' => 'Modelo sujeto a disponibilidad.',
            'categoria_id' => 1,
            'custom' => 1,
            'tag' => json_encode(array('clubestrella')),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('regalos')->insert([
            'nombre' => 'Tablet Lenovo',
            'puntos' => 60000,
            'imgs' => json_encode(array('img/premios/tablet.png')),
            'descripcion' => 'Modelo sujeto a disponibilidad.',
            'categoria_id' => 1,
            'custom' => 1,
            'tag' => json_encode(array('clubestrella')),
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('regalos')->insert([
            'nombre' => 'Audífonos Sony',
            'puntos' => 50000,
            'imgs' => json_encode(array('img/premios/audifonos.png')),
            'descripcion' => 'Modelo sujeto a disponibilidad.',
            'categoria_id' => 1,
            'custom' => 1,
            'tag' => json_encode(array('clubestrella')),
            'created_at' => now(),
            'updated_at' => now()
        ]);

       
    }
}
