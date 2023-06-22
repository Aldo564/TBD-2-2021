<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = \Carbon\Carbon::now();

        $countries = [
            [1, 'Chile']
        ];

        $countries = array_map(function($country) use ($now) {
            return [
                'nombre_pais' => $country[1],
                'updated_at' => $now,
                'created_at' => $now,
                'deleted' => 'false',
            ];
        }, $countries);

        \DB::table('countries')->insert($countries);
    }
}
