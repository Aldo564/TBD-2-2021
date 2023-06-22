<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class RegionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = \Carbon\Carbon::now();
        
        $regions = [
            [1,'Arica y Parinacota', 1],
            [2,'Tarapacá', 1],
            [3,'Antofagasta', 1],
            [4,'Atacama', 1],
            [5,'Coquimbo', 1],
            [6,'Valparaíso', 1],
            [7,'Libertador General Bernardo O Higgins', 1],
            [8,'Maule', 1],
            [9, 'Ñuble', 1],
            [10,'Biobío', 1],
            [11,'La Araucanía', 1],
            [12,'Los Ríos', 1],
            [13,'Los Lagos', 1],
            [14,'Aysén del General Carlos Ibáñez del Campo', 1],
            [15,'Magallanes y Antártica Chilena', 1],
            [16,'Metropolitana de Santiago', 1]
        ];

        $regions = array_map(function($region) use ($now) {
           return [
               'nombre_region' => $region[1],
               'id_pais' => $region[2],
               'updated_at' => $now,
               'created_at' => $now,
               'deleted' => 'false',
           ];
        }, $regions);

        \DB::table('regions')->insert($regions);
    }
}
