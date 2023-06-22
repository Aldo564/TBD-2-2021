<?php

namespace Database\Factories;

use App\Models\Historial_User_Synopsis;
use App\Models\User;
use App\Models\Synopsis;
use Illuminate\Database\Eloquent\Factories\Factory;

class Historial_User_SynopsisFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Historial_User_Synopsis::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'fecha' => $this->faker->date($format = 'Y-m-d', $max = 'now'),
            'hora' => $this->faker->time($format = 'H:i:s', $max = 'now'),
            'id_usuario' => User::all()->random()->id,
            'id_sinopsis' => Synopsis::all()->random()->id,
            'deleted' => false
        ];
    }
}
