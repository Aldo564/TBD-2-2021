<?php

namespace Database\Factories;

use App\Models\Like_User_Synopsis;
use App\Models\User;
use App\Models\Synopsis;
use Illuminate\Database\Eloquent\Factories\Factory;

class Like_User_SynopsisFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Like_User_Synopsis::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
          'estado' => $this->faker->numberBetween($min = 0, $max = 1),
          'id_usuario' => User::all()->random()->id,
          'id_sinopsis' => Synopsis::all()->random()->id,
          'deleted' => false,
        ];
    }
}
