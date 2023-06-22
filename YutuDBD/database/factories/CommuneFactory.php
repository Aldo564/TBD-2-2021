<?php

namespace Database\Factories;

use App\Models\Commune;
use App\Models\Region;
use App\Models\Country;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommuneFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Commune::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            //
        ];
    }
}
